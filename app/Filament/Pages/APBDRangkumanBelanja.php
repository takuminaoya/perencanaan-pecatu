<?php

namespace App\Filament\Pages;

use App\Models\APBD;
use App\Models\APBDKasFlow;
use App\Models\APBDPerubahanKasFlow;
use App\Models\ParameterBidang;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class APBDRangkumanBelanja extends Page
{
    protected string $view = 'filament.pages.a-p-b-d-rangkuman-belanja';
    protected static string|UnitEnum|null $navigationGroup = 'Laporan APBDes';
    protected static ?string $navigationLabel = 'Rangkuman Belanja';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowTrendingDown;
    protected static ?int $navigationSort = 0;
    protected ?string $heading = '';

    
    public array $results;
    public mixed $apbd_id;
    public mixed $daftarApbd;
    public mixed $apbd = null;

    public array $statistic;

    public int $belanja_id;

    public function mount() {
        $this->apbd_id = APBD::latest()->first()->id;
        $this->daftarApbd = APBD::orderBy('created_at', 'desc')->get();
        $this->belanja_id = ParameterKas::where('nama', 'BELANJA')->first()->id;

        $this->setAPBD();
    }

    public function setAPBD() {
        $this->apbd = APBD::find($this->apbd_id);

        $res = [];

        // Dapatkan list perubahan yang terdapat pada APBD
        $perubahans = $this->apbd->perubahans;

        $kegiatans = DB::table('ep_apbd_kas_flows')
        ->select('kegiatan_id')
        ->where('apbd_id', $this->apbd_id)
        ->where('utama_id', $this->belanja_id)
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
            ->where('apbd_id', $this->apbd_id)
            ->where('utama_id', $this->belanja_id)
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
                    ->where('apbd_id', $this->apbd_id)
                    ->where('tipe', 'keluar')
                    ->where('utama_id', $main->utama_id)
                    ->where('kegiatan_id', $kegiatan->kegiatan_id)
                    ->groupBy('sub_utama_id')
                    ->get();
                
                $utamaTotal = APBDKasFlow::where('apbd_id', $this->apbd_id)
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
                        ->where('apbd_id', $this->apbd_id)
                        ->where('tipe', 'keluar')
                        ->where('sub_utama_id', $sub_utama->sub_utama_id)
                        ->where('kegiatan_id', $kegiatan->kegiatan_id)
                        ->groupBy('sub_sutama_id')
                        ->get();

                    $subUtamaTotal = APBDKasFlow::where('apbd_id', $this->apbd_id)
                    ->where('tipe', 'keluar')
                    ->where('sub_utama_id', $sub_utama->sub_utama_id)->sum('jumlah');

                    foreach($sub_sutamas as $sub_sutama){
                        // -----------------------------------------------
                        // group by sub ssutamas get nama, kode, total
                        // -----------------------------------------------
                        $resSubSSUtamas = [];
                        $sub_ssutamas = DB::table('ep_apbd_kas_flows')
                            ->select('sub_ssutama_id')
                            ->where('apbd_id', $this->apbd_id)
                            ->where('tipe', 'keluar')
                            ->where('kegiatan_id', $kegiatan->kegiatan_id)
                            ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                            ->groupBy('sub_ssutama_id')
                            ->get();

                        $subSUtamaTotal = APBDKasFlow::where('apbd_id', $this->apbd_id)
                        ->where('tipe', 'keluar')
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)->sum('jumlah');

                        foreach($sub_ssutamas as $sub_ssutama){
                            $queru = APBDKasFlow::query();

                            $datas = $queru->where('apbd_id', $this->apbd_id)
                            ->where('tipe', 'keluar')
                            ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)
                            ->get();

                            $total = $queru->where('apbd_id', $this->apbd_id)
                            ->where('tipe', 'keluar')
                            ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)->sum('jumlah');

                            // penghitungan perubahan
                            $perubahanSSSUTotalContainer = [];
                            $psssuTotals = [];

                            // loop kasflow awal
                            $kasFlows = $this->apbd->kasFlows()
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
                        $kasFlows = $this->apbd->kasFlows()
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
                    $kasFlows = $this->apbd->kasFlows()
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
                $kasFlows = $this->apbd->kasFlows()
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
                ->where('apbd_id', $this->apbd_id)
                ->where('utama_id', $this->belanja_id)
                ->where('kegiatan_id', $kegiatan->kegiatan_id)
                ->where('tipe', 'keluar')
                ->groupBy('sub_kegiatan_id')
                ->get();
            
            $subkg_string = [];

            foreach($subs_kegiatans as $sk){
                $sk_data = ParameterKegiatan::find($sk->sub_kegiatan_id);
                $subkg_string[] = $sk_data->uraian_output;
            }

            $getFirstData = APBDKasFlow::where('apbd_id', $this->apbd_id)
                            ->where('utama_id', $this->belanja_id)
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

        $this->results = $res;
        
        // dd($res);
    }
}
