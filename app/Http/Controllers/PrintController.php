<?php

namespace App\Http\Controllers;

use App\Models\APBD;
use App\Models\APBDKasFlow;
use App\Models\APBDPerubahanKasFlow;
use App\Models\ParameterBidang;
use App\Models\ParameterGroupBidang;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PrintController extends Controller
{
    public function printAPBD($id, $mode) {
        $record = APBD::find($id);
        $results = [];
        $submain = [];
        $orientasi = 'potrait';

        switch ($mode) {
            case 'pendapatan':
                $utama = ParameterKas::where('nama', 'PENDAPATAN')->first();
                $results = $this->setPendapatan($id);
                break;
            case 'pembiayaan':
                $utama = ParameterKas::where('nama', 'PEMBIAYAAN')->first();
                $results = $this->setPembiayaan($id);
                break;
            case 'belanja':
                $utama = ParameterKas::where('nama', 'BELANJA')->first();
                $submain = ParameterKas::where('tipe', 'submain')->where('parent_kode', $utama->kode)->get();
                $results = $this->setBelanja($id);
                $orientasi = 'landscape';
                break;
            case 'rangkuman_belanja':
                $utama = ParameterKas::where('nama', 'BELANJA')->first();
                $submain = ParameterKas::where('tipe', 'submain')->where('parent_kode', $utama->kode)->get();
                $results = $this->setRankumanBelanja($id);
                // $orientasi = 'landscape';
                break;
        }


        $pdf = Pdf::loadView('print.apbd', [
            'apbd' => $record,
            'mode' => $mode,
            'results' => $results,
            'utama' => $utama,
            'sub_mains' => $submain
        ]);

        return $pdf->setPaper('a4', $orientasi)->stream(str_replace(' ', '_', $record->judul) . '_' . date('ymdhis') . '.pdf');
    }

    public function setPendapatan($apbd_id) {
        $apbd = null;
        $pendapatan_id = null;

        $pendapatan_id = ParameterKas::where('nama', 'PENDAPATAN')->first()->id;

        $apbd = APBD::find($apbd_id);

        // -----------------------------------------------
        // group by utamas get nama, kode, total
        // -----------------------------------------------
        $mains = DB::table('ep_apbd_kas_flows')
        ->select('utama_id')
        ->where('apbd_id', $apbd_id)
        ->where('utama_id', $pendapatan_id)
        ->where('tipe', 'masuk')
        ->groupBy('utama_id')
        ->get();
        
        $res = [];

        // Dapatkan list perubahan yang terdapat pada APBD
        $perubahans = $apbd->perubahans;

        foreach($mains as $main){
            

            // -----------------------------------------------
            // group by sub utamas get nama, kode, total
            // -----------------------------------------------
            $resSubUtamas = [];
            $sub_utamas = DB::table('ep_apbd_kas_flows')
                ->select('sub_utama_id')
                ->where('apbd_id', $apbd_id)
                ->where('tipe', 'masuk')
                ->where('utama_id', $main->utama_id)
                ->groupBy('sub_utama_id')
                ->get();
            
            $utamaTotal = APBDKasFlow::where('apbd_id', $apbd_id)
            ->where('tipe', 'masuk')
            ->where('utama_id', $main->utama_id)->sum('jumlah');

            foreach($sub_utamas as $sub_utama){

                // -----------------------------------------------
                // group by sub sutamas get nama, kode, total
                // -----------------------------------------------
                $resSubSUtamas = [];
                $sub_sutamas = DB::table('ep_apbd_kas_flows')
                    ->select('sub_sutama_id')
                    ->where('apbd_id', $apbd_id)
                    ->where('tipe', 'masuk')
                    ->where('sub_utama_id', $sub_utama->sub_utama_id)
                    ->groupBy('sub_sutama_id')
                    ->get();

                $subUtamaTotal = APBDKasFlow::where('apbd_id', $apbd_id)
                ->where('tipe', 'masuk')
                ->where('sub_utama_id', $sub_utama->sub_utama_id)->sum('jumlah');

                foreach($sub_sutamas as $sub_sutama){
                    // -----------------------------------------------
                    // group by sub ssutamas get nama, kode, total
                    // -----------------------------------------------
                    $resSubSSUtamas = [];
                    $sub_ssutamas = DB::table('ep_apbd_kas_flows')
                        ->select('sub_ssutama_id')
                        ->where('apbd_id', $apbd_id)
                        ->where('tipe', 'masuk')
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                        ->groupBy('sub_ssutama_id')
                        ->get();

                    $subSUtamaTotal = APBDKasFlow::where('apbd_id', $apbd_id)
                    ->where('tipe', 'masuk')
                    ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)->sum('jumlah');

                    foreach($sub_ssutamas as $sub_ssutama){
                        $queru = APBDKasFlow::query();

                        $datas = $queru->where('apbd_id', $apbd_id)
                        ->where('tipe', 'masuk')
                        ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)
                        ->get();

                        $total = $queru->where('apbd_id', $apbd_id)
                        ->where('tipe', 'masuk')
                        ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)->sum('jumlah');

                        // penghitungan perubahan
                        $perubahanSSSutamaTotalContainer = [];
                        $psssuTotals = [];

                        // loop kasflow awal
                        $kasFlows = $apbd->kasFlows()
                            ->where('tipe', 'masuk')
                            ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)
                            ->get();

                        foreach($kasFlows as $kf){
                        
                            // set default
                            foreach($perubahans as $p){
                                $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                                $perubahanSSSutamaTotalContainer[] = [
                                    'perubahan_id' => $p->id,
                                    'kas_id' => $kf->id,
                                    'total' => $pkf ? $pkf->jumlah : 0
                                ];

                                $psssuTotals[$p->id] = 0;
                            }
                            
                        }

                        if(count($perubahanSSSutamaTotalContainer)){
                            foreach($perubahanSSSutamaTotalContainer as $psssutc){
                                $psssuTotals[$psssutc['perubahan_id']] += $psssutc['total'];
                            }
                        }

                        $subSSUtamaP = ParameterKas::find($sub_ssutama->sub_ssutama_id);
                        $resSubSSUtamas[$sub_ssutama->sub_ssutama_id] = [
                            'kode' => $subSSUtamaP->kode,
                            'nama' => $subSSUtamaP->nama,
                            'perubahans' => $perubahanSSSutamaTotalContainer,
                            'total' => $total,
                            'perubahan_totals' => $psssuTotals,
                            'datas' => $datas
                        ];
                    }

                    // penghitungan perubahan
                    $perubahanSSutamaTotalContainer = [];
                    $pssuTotals = [];

                    // loop kasflow awal
                    $kasFlows = $apbd->kasFlows()
                        ->where('tipe', 'masuk')
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                        ->get();

                    foreach($kasFlows as $kf){
                    
                        // set default
                        foreach($perubahans as $p){
                            $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                            $perubahanSSutamaTotalContainer[] = [
                                'perubahan_id' => $p->id,
                                'kas_id' => $kf->id,
                                'total' => $pkf ? $pkf->jumlah : 0
                            ];

                            $pssuTotals[$p->id] = 0;
                        }
                        
                    }

                    if(count($perubahanSSutamaTotalContainer)){
                        foreach($perubahanSSutamaTotalContainer as $pssutc){
                            $pssuTotals[$pssutc['perubahan_id']] += $pssutc['total'];
                        }
                    }

                    $subSUtamaP = ParameterKas::find($sub_sutama->sub_sutama_id);
                    $resSubSUtamas[$sub_sutama->sub_sutama_id] = [
                        'kode' => $subSUtamaP->kode,
                        'nama' => $subSUtamaP->nama,
                        'total' => $subSUtamaTotal,
                        'perubahans' => $perubahanSSutamaTotalContainer,
                        'perubahan_totals' => $pssuTotals,
                        'sub_ssutamas' => $resSubSSUtamas
                    ];

                    // -----------------------------------------------
                    // end group by sub ssutamas get nama, kode, total
                    // -----------------------------------------------
                }

                // penghitungan perubahan
                $perubahanSutamaTotalContainer = [];
                $psuTotals = [];

                // loop kasflow awal
                $kasFlows = $apbd->kasFlows()
                    ->where('tipe', 'masuk')
                    ->where('sub_utama_id', $sub_utama->sub_utama_id)
                    ->get();

                foreach($kasFlows as $kf){
                
                    // set default
                    foreach($perubahans as $p){
                        $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                        $perubahanSutamaTotalContainer[] = [
                            'perubahan_id' => $p->id,
                            'kas_id' => $kf->id,
                            'total' => $pkf ? $pkf->jumlah : 0
                        ];

                        $psuTotals[$p->id] = 0;
                    }
                    
                }

                if(count($perubahanSutamaTotalContainer)){
                    foreach($perubahanSutamaTotalContainer as $psutc){
                        $psuTotals[$psutc['perubahan_id']] += $psutc['total'];
                    }
                }

                $subUtamaP = ParameterKas::find($sub_utama->sub_utama_id);
                $resSubUtamas[$sub_utama->sub_utama_id] = [
                    'kode' => $subUtamaP->kode,
                    'nama' => $subUtamaP->nama,
                    'total' => $subUtamaTotal,
                    'perubahans' => $perubahanSutamaTotalContainer,
                    'perubahan_totals' => $psuTotals,
                    'sub_sutamas' => $resSubSUtamas
                ];
                // -----------------------------------------------
                // end group by sub sutamas get nama, kode, total
                // -----------------------------------------------
            }

            // penghitungan perubahan
            $perubahanTotalContainer = [];
            $puTotals = [];

            // loop kasflow awal
            $kasFlows = $apbd->kasFlows()
                ->where('tipe', 'masuk')
                ->where('utama_id', $main->utama_id)
                ->get();

            foreach($kasFlows as $kf){
            
                // set default
                foreach($perubahans as $p){
                    $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                    $perubahanTotalContainer[] = [
                        'perubahan_id' => $p->id,
                        'kas_id' => $kf->id,
                        'total' => $pkf ? $pkf->jumlah : 0
                    ];

                    $puTotals[$p->id] = 0;
                }
                
            }

            if(count($perubahanTotalContainer)){
                foreach($perubahanTotalContainer as $putc){
                    $puTotals[$putc['perubahan_id']] += $putc['total'];
                }
            }

            $mainP = ParameterKas::find($main->utama_id);
            $res[$main->utama_id] = [
                'kode' => $mainP->kode,
                'nama' => $mainP->nama,
                'total' => $utamaTotal,
                'perubahans' => $perubahanTotalContainer,
                'perubahan_totals' => $puTotals,
                'sub_utamas' => $resSubUtamas
            ];
            // -----------------------------------------------
            // end group by sub utamas get nama, kode, total
            // -----------------------------------------------
        }

        return $res;
    }

    public function setPembiayaan($apbd_id) {
        $apbd = null;
        $pendapatan_id = null;

        $pendapatan_id = ParameterKas::where('nama', 'PEMBIAYAAN')->first()->id;

        $apbd = APBD::find($apbd_id);

        // -----------------------------------------------
        // group by utamas get nama, kode, total
        // -----------------------------------------------
        $mains = DB::table('ep_apbd_kas_flows')
        ->select('utama_id')
        ->where('apbd_id', $apbd_id)
        ->where('utama_id', $pendapatan_id)
        ->groupBy('utama_id')
        ->get();
        
        $res = [];

        // Dapatkan list perubahan yang terdapat pada APBD
        $perubahans = $apbd->perubahans;

        foreach($mains as $main){
            // -----------------------------------------------
            // group by sub utamas get nama, kode, total
            // -----------------------------------------------
            $resSubUtamas = [];
            $sub_utamas = DB::table('ep_apbd_kas_flows')
                ->select('sub_utama_id')
                ->where('apbd_id', $apbd_id)
                ->where('utama_id', $main->utama_id)
                ->groupBy('sub_utama_id')
                ->get();
            
            $plus = APBDKasFlow::where('apbd_id', $apbd_id)->where('tipe', 'masuk')->where('utama_id', $main->utama_id)->sum('jumlah');
            $minus = APBDKasFlow::where('apbd_id', $apbd_id)->where('tipe', 'keluar')->where('utama_id', $main->utama_id)->sum('jumlah');
            $utamaTotal = $plus - $minus;

            foreach($sub_utamas as $sub_utama){

                // -----------------------------------------------
                // group by sub sutamas get nama, kode, total
                // -----------------------------------------------
                $resSubSUtamas = [];
                $sub_sutamas = DB::table('ep_apbd_kas_flows')
                    ->select('sub_sutama_id')
                    ->where('apbd_id', $apbd_id)
                    ->where('sub_utama_id', $sub_utama->sub_utama_id)
                    ->groupBy('sub_sutama_id')
                    ->get();

                $subUtamaTotal = APBDKasFlow::where('apbd_id', $apbd_id)
                
                ->where('sub_utama_id', $sub_utama->sub_utama_id)->sum('jumlah');

                foreach($sub_sutamas as $sub_sutama){
                    // -----------------------------------------------
                    // group by sub ssutamas get nama, kode, total
                    // -----------------------------------------------
                    $resSubSSUtamas = [];
                    $sub_ssutamas = DB::table('ep_apbd_kas_flows')
                        ->select('sub_ssutama_id')
                        ->where('apbd_id', $apbd_id)
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                        ->groupBy('sub_ssutama_id')
                        ->get();

                    $subSUtamaTotal = APBDKasFlow::where('apbd_id', $apbd_id)
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)->sum('jumlah');

                    foreach($sub_ssutamas as $sub_ssutama){
                        $queru = APBDKasFlow::query();

                        $datas = $queru->where('apbd_id', $apbd_id)
                        ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)
                        ->get();

                        $total = $queru->where('apbd_id', $apbd_id)
                        ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)->sum('jumlah');

                        // penghitungan perubahan
                        $perubahanSSSUTotalContainer = [];
                        $psssuTotals = [];

                        // loop kasflow awal
                        $kasFlows = $apbd->kasFlows()
                            ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                            ->get();

                        foreach($kasFlows as $kf){
                        
                            // set default
                            foreach($perubahans as $p){
                                $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                                $perubahanSSSUTotalContainer[] = [
                                    'perubahan_id' => $p->id,
                                    'kas_id' => $kf->id,
                                    'tipe' => $kf->tipe,
                                    'total' => $pkf ? $pkf->jumlah : 0
                                ];

                                $psssuTotals[$p->id] = 0;
                            }
                            
                        }

                        if(count($perubahanSSSUTotalContainer)){
                            foreach($perubahanSSSUTotalContainer as $putc){
                                if($putc['tipe'] === 'masuk'){
                                    $psssuTotals[$putc['perubahan_id']] += $putc['total'];
                                } else {
                                    $psssuTotals[$putc['perubahan_id']] -= $putc['total'];
                                }
                            }
                        }

                        $subSSUtamaP = ParameterKas::find($sub_ssutama->sub_ssutama_id);
                        $resSubSSUtamas[$sub_ssutama->sub_ssutama_id] = [
                            'kode' => $subSSUtamaP->kode,
                            'nama' => $subSSUtamaP->nama,
                            'perubahans' => $perubahanSSSUTotalContainer,
                            'perubahan_totals' => $psssuTotals,
                            'total' => $total,
                            'datas' => $datas
                        ];
                    }

                    // penghitungan perubahan
                    $perubahanSSUTotalContainer = [];
                    $pssuTotals = [];

                    // loop kasflow awal
                    $kasFlows = $apbd->kasFlows()
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                        ->get();

                    foreach($kasFlows as $kf){
                    
                        // set default
                        foreach($perubahans as $p){
                            $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                            $perubahanSSUTotalContainer[] = [
                                'perubahan_id' => $p->id,
                                'kas_id' => $kf->id,
                                'tipe' => $kf->tipe,
                                'total' => $pkf ? $pkf->jumlah : 0
                            ];

                            $pssuTotals[$p->id] = 0;
                        }
                        
                    }

                    if(count($perubahanSSUTotalContainer)){
                        foreach($perubahanSSUTotalContainer as $putc){
                            if($putc['tipe'] === 'masuk'){
                                $pssuTotals[$putc['perubahan_id']] += $putc['total'];
                            } else {
                                $pssuTotals[$putc['perubahan_id']] -= $putc['total'];
                            }
                        }
                    }

                    $subSUtamaP = ParameterKas::find($sub_sutama->sub_sutama_id);
                    $resSubSUtamas[$sub_sutama->sub_sutama_id] = [
                        'kode' => $subSUtamaP->kode,
                        'nama' => $subSUtamaP->nama,
                        'total' => $subSUtamaTotal,
                        'perubahans' => $perubahanSSUTotalContainer,
                        'perubahan_totals' => $pssuTotals,
                        'sub_ssutamas' => $resSubSSUtamas
                    ];

                    // -----------------------------------------------
                    // end group by sub ssutamas get nama, kode, total
                    // -----------------------------------------------
                }

                // penghitungan perubahan
                $perubahanSUTotalContainer = [];
                $psuTotals = [];

                // loop kasflow awal
                $kasFlows = $apbd->kasFlows()
                    ->where('sub_utama_id', $sub_utama->sub_utama_id)
                    ->get();

                foreach($kasFlows as $kf){
                
                    // set default
                    foreach($perubahans as $p){
                        $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                        $perubahanSUTotalContainer[] = [
                            'perubahan_id' => $p->id,
                            'kas_id' => $kf->id,
                            'tipe' => $kf->tipe,
                            'total' => $pkf ? $pkf->jumlah : 0
                        ];

                        $psuTotals[$p->id] = 0;
                    }
                    
                }

                if(count($perubahanSUTotalContainer)){
                    foreach($perubahanSUTotalContainer as $putc){
                        if($putc['tipe'] === 'masuk'){
                            $psuTotals[$putc['perubahan_id']] += $putc['total'];
                        } else {
                            $psuTotals[$putc['perubahan_id']] -= $putc['total'];
                        }
                    }
                }

                $subUtamaP = ParameterKas::find($sub_utama->sub_utama_id);
                $resSubUtamas[$sub_utama->sub_utama_id] = [
                    'kode' => $subUtamaP->kode,
                    'nama' => $subUtamaP->nama,
                    'total' => $subUtamaTotal,
                    'perubahans' => $perubahanSUTotalContainer,
                    'perubahan_totals' => $psuTotals,
                    'sub_sutamas' => $resSubSUtamas
                ];
                // -----------------------------------------------
                // end group by sub sutamas get nama, kode, total
                // -----------------------------------------------
            }

            // penghitungan perubahan
            $perubahanTotalContainer = [];
            $puTotals = [];

            // loop kasflow awal
            $kasFlows = $apbd->kasFlows()
                ->where('utama_id', $main->utama_id)
                ->get();

            foreach($kasFlows as $kf){
            
                // set default
                foreach($perubahans as $p){
                    $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                    $perubahanTotalContainer[] = [
                        'perubahan_id' => $p->id,
                        'kas_id' => $kf->id,
                        'tipe' => $kf->tipe,
                        'total' => $pkf ? $pkf->jumlah : 0
                    ];

                    $puTotals[$p->id] = 0;
                }
                
            }

            if(count($perubahanTotalContainer)){
                foreach($perubahanTotalContainer as $putc){
                    if($putc['tipe'] === 'masuk'){
                        $puTotals[$putc['perubahan_id']] += $putc['total'];
                    } else {
                        $puTotals[$putc['perubahan_id']] -= $putc['total'];
                    }
                }
            }

            $mainP = ParameterKas::find($main->utama_id);
            $res[$main->utama_id] = [
                'kode' => $mainP->kode,
                'nama' => $mainP->nama,
                'total' => $utamaTotal,
                'perubahans' => $perubahanTotalContainer,
                'perubahan_totals' => $puTotals,
                'sub_utamas' => $resSubUtamas
            ];
            // -----------------------------------------------
            // end group by sub utamas get nama, kode, total
            // -----------------------------------------------
        }

        return $res;
    }

    public function setBelanja($apbd_id) {
        $belanja = ParameterKas::where('nama', 'BELANJA')->first();
        $belanja_id = $belanja->id;

        $res = [];

        // grup by bidang
        $bidangs = DB::table('ep_apbd_kas_flows')
        ->select('bidang_id')
        ->where('utama_id', $belanja_id)
        ->where('apbd_id', $apbd_id)
        ->whereNotNull('bidang_id')
        ->groupBy('bidang_id')
        ->get();

        foreach($bidangs as $bidang){
            // group by sub bidang
            $cont_sub_bidangs = [];
            $sub_bidangs = DB::table('ep_apbd_kas_flows')
            ->select('sub_bidang_id')
            ->where('utama_id', $belanja_id)
            ->where('apbd_id', $apbd_id)
            ->where('bidang_id', $bidang->bidang_id)
            ->whereNotNull('sub_bidang_id')
            ->groupBy('sub_bidang_id')
            ->get();

            foreach($sub_bidangs as $sub_bidang){
                // grup by kegiatan
                $cont_kegiatans = [];
                $kegiatans = DB::table('ep_apbd_kas_flows')
                ->select('kegiatan_id')
                ->where('utama_id', $belanja_id)
                ->where('apbd_id', $apbd_id)
                ->where('sub_bidang_id', $sub_bidang->sub_bidang_id)
                ->whereNotNull('kegiatan_id')
                ->groupBy('kegiatan_id')
                ->get();

                foreach($kegiatans as $kegiatan){
                    $cont_sub_kegiatans = [];
                    $sub_kegiatans = DB::table('ep_apbd_kas_flows')
                    ->select('sub_kegiatan_id')
                    ->where('utama_id', $belanja_id)
                    ->where('apbd_id', $apbd_id)
                    ->where('kegiatan_id', $kegiatan->kegiatan_id)
                    ->whereNotNull('sub_kegiatan_id')
                    ->groupBy('sub_kegiatan_id')
                    ->get();

                    foreach($sub_kegiatans as $sub_kegiatan){
                        $cont_groups = [];
                        $groups = DB::table('ep_apbd_kas_flows')
                        ->select('group_id')
                        ->where('utama_id', $belanja_id)
                        ->where('apbd_id', $apbd_id)
                        ->where('sub_kegiatan_id', $sub_kegiatan->sub_kegiatan_id)
                        ->whereNotNull('sub_kegiatan_id')
                        ->groupBy('group_id')
                        ->get();

                        $sub_kegiatanP = ParameterKegiatan::find($sub_kegiatan->sub_kegiatan_id);

                        foreach($groups as $group){
                            $gp = ParameterGroupBidang::find($group->group_id);

                            // result by kas belanja
                            $sub_bidang_belanja = ParameterKas::where('parent_kode', $belanja->kode)->where('tipe', 'submain')->get();
                            $rincian_per_sbms = [];
                            $totalKeseluruhanRPS = 0;

                            foreach($sub_bidang_belanja as $sbb){
                                $trps = APBDKasFlow::where('apbd_id', $apbd_id)->where('sub_kegiatan_id', $sub_kegiatan->sub_kegiatan_id)->where('sub_utama_id', $sbb->id)->where('group_id', $group->group_id)->where('tipe', 'keluar')->sum('jumlah');

                                $totalKeseluruhanRPS += $trps;

                                $rincian_per_sbms[$sbb->id] = [
                                    'kode' => $sbb->kode,
                                    'nama' => $sbb->nama,
                                    'total' => $trps
                                ];
                            }

                            $cont_groups[$gp->id] = [
                                'kode' => '-',
                                'nama' => $gp->nama,
                                'total' => $totalKeseluruhanRPS,
                                'rincian_per_submain' => $rincian_per_sbms,
                            ];
                        }

                        $totalsub_kegiatan = APBDKasFlow::where('utama_id', $belanja_id)
                        ->where('apbd_id', $apbd_id)
                        ->where('sub_kegiatan_id', $sub_kegiatan->sub_kegiatan_id)
                        ->whereNotNull('bidang_id')
                        ->sum('jumlah');

                        $cont_sub_kegiatans[$sub_kegiatanP->id] = [
                            'kode' => $sub_kegiatanP->kode_singkat,
                            'nama' => $sub_kegiatanP->uraian_output,
                            'total' => $totalsub_kegiatan,
                            'groups' => $cont_groups,
                        ];
                    }

                    $totalKegiatan = APBDKasFlow::where('utama_id', $belanja_id)
                    ->where('apbd_id', $apbd_id)
                    ->where('kegiatan_id', $kegiatan->kegiatan_id)
                    ->whereNotNull('bidang_id')
                    ->sum('jumlah');

                    $kegiatanP = ParameterBidang::find($kegiatan->kegiatan_id);
                    $cont_kegiatans[$kegiatanP->id] = [
                        'kode' => $kegiatanP->kode,
                        'nama' => $kegiatanP->nama,
                        'total' => $totalKegiatan,
                        'sub_kegiatans' => $cont_sub_kegiatans
                    ];
                }

                $totalSubBidang = APBDKasFlow::where('utama_id', $belanja_id)
                ->where('apbd_id', $apbd_id)
                ->where('sub_bidang_id', $sub_bidang->sub_bidang_id)
                ->whereNotNull('bidang_id')
                ->sum('jumlah');

                $sub_bidangP = ParameterBidang::find($sub_bidang->sub_bidang_id);
                $cont_sub_bidangs[$sub_bidangP->id] = [
                    'kode' => $sub_bidangP->kode,
                    'nama' => $sub_bidangP->nama,
                    'total' => $totalSubBidang,
                    'kegiatans' => $cont_kegiatans
                ];
            }

            $totalBidang = APBDKasFlow::where('utama_id', $belanja_id)
                ->where('apbd_id', $apbd_id)
                ->where('bidang_id', $bidang->bidang_id)
                ->whereNotNull('bidang_id')
                ->sum('jumlah');

            $bidangP = ParameterBidang::find($bidang->bidang_id);
            $res[$bidangP->id] = [
                'kode' => $bidangP->kode,
                'nama' => $bidangP->nama,
                'total' => $totalBidang,
                'sub_bidangs' => $cont_sub_bidangs
            ];
        }
        
        // tampilkan data sub kegiatan

       return $res;
    }

    public function setRankumanBelanja($apbd_id) {
        $apbd = APBD::find($apbd_id);
        $belanja = ParameterKas::where('nama', 'BELANJA')->first();
        $belanja_id = $belanja->id;

        $res = [];

        // Dapatkan list perubahan yang terdapat pada APBD
        $perubahans = $apbd->perubahans;

        $kegiatans = DB::table('ep_apbd_kas_flows')
        ->select('kegiatan_id')
        ->where('apbd_id', $apbd_id)
        ->where('utama_id', $belanja_id)
        ->where('tipe', 'keluar')
        ->groupBy('kegiatan_id')
        ->get();

        foreach($kegiatans as $kegiatan){
            // -----------------------------------------------
            // group by utamas get nama, kode, total
            // -----------------------------------------------
            $resMains = [];
            $mains = DB::table('ep_apbd_kas_flows')
            ->select('utama_id')
            ->where('apbd_id', $apbd_id)
            ->where('utama_id', $belanja_id)
            ->where('kegiatan_id', $kegiatan->kegiatan_id)
            ->where('tipe', 'keluar')
            ->groupBy('utama_id')
            ->get();
        

            foreach($mains as $main){
                // -----------------------------------------------
                // group by sub utamas get nama, kode, total
                // -----------------------------------------------
                $resSubUtamas = [];
                $sub_utamas = DB::table('ep_apbd_kas_flows')
                    ->select('sub_utama_id')
                    ->where('apbd_id', $apbd_id)
                    ->where('tipe', 'keluar')
                    ->where('utama_id', $main->utama_id)
                    ->where('kegiatan_id', $kegiatan->kegiatan_id)
                    ->groupBy('sub_utama_id')
                    ->get();
                
                $utamaTotal = APBDKasFlow::where('apbd_id', $apbd_id)
                ->where('tipe', 'keluar')
                ->where('kegiatan_id', $kegiatan->kegiatan_id)
                ->where('utama_id', $main->utama_id)->sum('jumlah');

                foreach($sub_utamas as $sub_utama){

                    // -----------------------------------------------
                    // group by sub sutamas get nama, kode, total
                    // -----------------------------------------------
                    $resSubSUtamas = [];
                    $sub_sutamas = DB::table('ep_apbd_kas_flows')
                        ->select('sub_sutama_id')
                        ->where('apbd_id', $apbd_id)
                        ->where('tipe', 'keluar')
                        ->where('sub_utama_id', $sub_utama->sub_utama_id)
                        ->where('kegiatan_id', $kegiatan->kegiatan_id)
                        ->groupBy('sub_sutama_id')
                        ->get();

                    $subUtamaTotal = APBDKasFlow::where('apbd_id', $apbd_id)
                    ->where('tipe', 'keluar')
                    ->where('kegiatan_id', $kegiatan->kegiatan_id)
                    ->where('sub_utama_id', $sub_utama->sub_utama_id)->sum('jumlah');

                    foreach($sub_sutamas as $sub_sutama){
                        // -----------------------------------------------
                        // group by sub ssutamas get nama, kode, total
                        // -----------------------------------------------
                        $resSubSSUtamas = [];
                        $sub_ssutamas = DB::table('ep_apbd_kas_flows')
                            ->select('sub_ssutama_id')
                            ->where('apbd_id', $apbd_id)
                            ->where('tipe', 'keluar')
                            ->where('kegiatan_id', $kegiatan->kegiatan_id)
                            ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                            ->groupBy('sub_ssutama_id')
                            ->get();

                        $subSUtamaTotal = APBDKasFlow::where('apbd_id', $apbd_id)
                        ->where('tipe', 'keluar')
                        ->where('kegiatan_id', $kegiatan->kegiatan_id)
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)->sum('jumlah');

                        foreach($sub_ssutamas as $sub_ssutama){
                            $queru = APBDKasFlow::query();

                            $datas = $queru->where('apbd_id', $apbd_id)
                            ->where('tipe', 'keluar')
                            ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)
                            ->get();

                            $total = $queru->where('apbd_id', $apbd_id)
                            ->where('tipe', 'keluar')
                            ->where('kegiatan_id', $kegiatan->kegiatan_id)
                            ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)->sum('jumlah');

                            // penghitungan perubahan
                            $perubahanSSSUTotalContainer = [];
                            $psssuTotals = [];

                            // loop kasflow awal
                            $kasFlows = $apbd->kasFlows()
                                ->where('tipe', 'keluar')
                                ->where('kegiatan_id', $kegiatan->kegiatan_id)
                                ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)
                                ->get();

                            foreach($kasFlows as $kf){
                            
                                // set default
                                foreach($perubahans as $p){
                                    $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                                    $perubahanSSSUTotalContainer[] = [
                                        'perubahan_id' => $p->id,
                                        'kas_id' => $kf->id,
                                        'tipe' => $kf->tipe,
                                        'total' => $pkf ? $pkf->jumlah : 0
                                    ];

                                    $psssuTotals[$p->id] = 0;
                                }
                                
                            }

                            if(count($perubahanSSSUTotalContainer)){
                                foreach($perubahanSSSUTotalContainer as $putc){
                                    $psssuTotals[$putc['perubahan_id']] += $putc['total'];
                                }
                            }

                            $subSSUtamaP = ParameterKas::find($sub_ssutama->sub_ssutama_id);
                            $resSubSSUtamas[$sub_ssutama->sub_ssutama_id] = [
                                'kode' => $subSSUtamaP->kode,
                                'nama' => $subSSUtamaP->nama,
                                'total' => $total,
                                'perubahans' => $perubahanSSSUTotalContainer,
                                'perubahan_totals' => $psssuTotals,
                                'datas' => $datas
                            ];
                        }

                        // penghitungan perubahan
                        $perubahanSSUTotalContainer = [];
                        $pssuTotals = [];

                        // loop kasflow awal
                        $kasFlows = $apbd->kasFlows()
                            ->where('tipe', 'keluar')
                            ->where('kegiatan_id', $kegiatan->kegiatan_id)
                            ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                            ->get();

                        foreach($kasFlows as $kf){
                        
                            // set default
                            foreach($perubahans as $p){
                                $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                                $perubahanSSUTotalContainer[] = [
                                    'perubahan_id' => $p->id,
                                    'kas_id' => $kf->id,
                                    'tipe' => $kf->tipe,
                                    'total' => $pkf ? $pkf->jumlah : 0
                                ];

                                $pssuTotals[$p->id] = 0;
                            }
                            
                        }

                        if(count($perubahanSSUTotalContainer)){
                            foreach($perubahanSSUTotalContainer as $putc){
                                $pssuTotals[$putc['perubahan_id']] += $putc['total'];
                            }
                        }

                        $subSUtamaP = ParameterKas::find($sub_sutama->sub_sutama_id);
                        $resSubSUtamas[$sub_sutama->sub_sutama_id] = [
                            'kode' => $subSUtamaP->kode,
                            'nama' => $subSUtamaP->nama,
                            'total' => $subSUtamaTotal,
                            'perubahans' => $perubahanSSUTotalContainer,
                            'perubahan_totals' => $pssuTotals,
                            'sub_ssutamas' => $resSubSSUtamas
                        ];

                        // -----------------------------------------------
                        // end group by sub ssutamas get nama, kode, total
                        // -----------------------------------------------
                    }

                    // penghitungan perubahan
                    $perubahanSUTotalContainer = [];
                    $psuTotals = [];

                    // loop kasflow awal
                    $kasFlows = $apbd->kasFlows()
                        ->where('tipe', 'keluar')
                        ->where('sub_utama_id', $sub_utama->sub_utama_id)
                        ->where('kegiatan_id', $kegiatan->kegiatan_id)
                        ->get();

                    foreach($kasFlows as $kf){
                    
                        // set default
                        foreach($perubahans as $p){
                            $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                            $perubahanSUTotalContainer[] = [
                                'perubahan_id' => $p->id,
                                'kas_id' => $kf->id,
                                'tipe' => $kf->tipe,
                                'total' => $pkf ? $pkf->jumlah : 0
                            ];

                            $psuTotals[$p->id] = 0;
                        }
                        
                    }

                    if(count($perubahanSUTotalContainer)){
                        foreach($perubahanSUTotalContainer as $putc){
                            $psuTotals[$putc['perubahan_id']] += $putc['total'];
                        }
                    }

                    $subUtamaP = ParameterKas::find($sub_utama->sub_utama_id);
                    $resSubUtamas[$sub_utama->sub_utama_id] = [
                        'kode' => $subUtamaP->kode,
                        'nama' => $subUtamaP->nama,
                        'total' => $subUtamaTotal,
                        'perubahans' => $perubahanSUTotalContainer,
                        'perubahan_totals' => $psuTotals,
                        'sub_sutamas' => $resSubSUtamas
                    ];
                    // -----------------------------------------------
                    // end group by sub sutamas get nama, kode, total
                    // -----------------------------------------------
                }

                // penghitungan perubahan
                $perubahanTotalContainer = [];
                $puTotals = [];

                // loop kasflow awal
                $kasFlows = $apbd->kasFlows()
                    ->where('tipe', 'keluar')
                    ->where('kegiatan_id', $kegiatan->kegiatan_id)
                    ->where('utama_id', $main->utama_id)
                    ->get();

                foreach($kasFlows as $kf){
                
                    // set default
                    foreach($perubahans as $p){
                        $pkf = APBDPerubahanKasFlow::where('kas_flow_id', $kf->id)->where('perubahan_id', $p->id)->first();

                        $perubahanTotalContainer[] = [
                            'perubahan_id' => $p->id,
                            'kas_id' => $kf->id,
                            'tipe' => $kf->tipe,
                            'total' => $pkf ? $pkf->jumlah : 0
                        ];

                        $puTotals[$p->id] = 0;
                    }
                    
                }

                if(count($perubahanTotalContainer)){
                    foreach($perubahanTotalContainer as $putc){
                        $puTotals[$putc['perubahan_id']] += $putc['total'];
                    }
                }

                $mainP = ParameterKas::find($main->utama_id);
                $resMains[$main->utama_id] = [
                    'kode' => $mainP->kode,
                    'nama' => $mainP->nama,
                    'total' => $utamaTotal,
                    'perubahans' => $perubahanTotalContainer,
                    'perubahan_totals' => $puTotals,
                    'sub_utamas' => $resSubUtamas
                ];
                // -----------------------------------------------
                // end group by sub utamas get nama, kode, total
                // -----------------------------------------------
            }

            $kegiatanP = ParameterBidang::find($kegiatan->kegiatan_id);
            $sub_bidang = $kegiatanP->getParent();
            $bidang = $sub_bidang->getParent();

            $subs_kegiatans = DB::table('ep_apbd_kas_flows')
                ->select('sub_kegiatan_id')
                ->where('apbd_id', $apbd_id)
                ->where('utama_id', $belanja_id)
                ->where('kegiatan_id', $kegiatan->kegiatan_id)
                ->where('tipe', 'keluar')
                ->groupBy('sub_kegiatan_id')
                ->get();
            
            $subkg_string = [];

            foreach($subs_kegiatans as $sk){
                $sk_data = ParameterKegiatan::find($sk->sub_kegiatan_id);
                $subkg_string[] = $sk_data->uraian_output;
            }

            $getFirstData = APBDKasFlow::where('apbd_id', $apbd_id)
                            ->where('utama_id', $belanja_id)
                            ->where('kegiatan_id', $kegiatan->kegiatan_id)
                            ->where('tipe', 'keluar')
                            ->first();
                            

            $res[$kegiatan->kegiatan_id] = [
                'kode' => $kegiatanP->kode,
                'nama' => $kegiatanP->nama,
                'total' => 0,
                'durasi' => dateDiffCarbon($getFirstData->tanggal_mulai, $getFirstData->tanggal_selesai, 'month'),
                'output' => $getFirstData->keluaran,
                'data' => [
                    'bidang' => [
                        'kode' => $bidang->kode,
                        'nama' => $bidang->nama,
                    ],
                    'sub_bidang' => [
                        'kode' => $sub_bidang->kode,
                        'nama' => $sub_bidang->nama,
                    ],
                    'sub_kegiatan' => implode(', ', $subkg_string),
                ],
                'utamas' => $resMains
            ];
        }

        return $res;
    }
}
