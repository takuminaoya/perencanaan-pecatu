<?php

namespace App\Filament\Pages;

use App\Models\APBD;
use App\Models\APBDKasFlow;
use App\Models\APBDPerubahanKasFlow;
use App\Models\ParameterKas;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class APBDRangkumanPembiayaan extends Page
{
    protected string $view = 'filament.pages.a-p-b-d-rangkuman-pembiayaan';
    protected static string|UnitEnum|null $navigationGroup = 'Laporan APBDes';
    protected static ?string $navigationLabel = 'Rangkuman Pembiayaan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowTrendingUp;
    protected static ?int $navigationSort = 0;
    protected ?string $heading = '';

    public array $results;
    public mixed $apbd_id;
    public mixed $daftarApbd;
    public mixed $apbd = null;

    public array $statistic;

    public int $pendapatan_id;

    public function mount() {
        $this->apbd_id = APBD::latest()->first()->id;
        $this->daftarApbd = APBD::orderBy('created_at', 'desc')->get();
        $this->pendapatan_id = ParameterKas::where('nama', 'PEMBIAYAAN')->first()->id;

        $this->setAPBD();
    }

    public function setAPBD() {
        $this->apbd = APBD::find($this->apbd_id);

        // -----------------------------------------------
        // statistic
        // -----------------------------------------------
        $awal = APBDKasFlow::where('apbd_id', $this->apbd_id)->where('utama_id', $this->pendapatan_id)->where('tipe', 'masuk')->sum('jumlah');
        $ubah = APBDKasFlow::where('apbd_id', $this->apbd_id)->where('utama_id', $this->pendapatan_id)->where('tipe', 'keluar')->sum('jumlah');
        $sisa = $awal - $ubah;
        
        $this->statistic = [
            'jumlah_awal' => $awal,
            'jumlah_perubahan' => $ubah,
            'jumlah_sisa' => $sisa,
        ];

        // -----------------------------------------------
        // group by utamas get nama, kode, total
        // -----------------------------------------------
        $mains = DB::table('ep_apbd_kas_flows')
        ->select('utama_id')
        ->where('apbd_id', $this->apbd_id)
        ->where('utama_id', $this->pendapatan_id)
        ->groupBy('utama_id')
        ->get();
        
        $res = [];

        // Dapatkan list perubahan yang terdapat pada APBD
        $perubahans = $this->apbd->perubahans;

        foreach($mains as $main){
            // -----------------------------------------------
            // group by sub utamas get nama, kode, total
            // -----------------------------------------------
            $resSubUtamas = [];
            $sub_utamas = DB::table('ep_apbd_kas_flows')
                ->select('sub_utama_id')
                ->where('apbd_id', $this->apbd_id)
                ->where('utama_id', $main->utama_id)
                ->groupBy('sub_utama_id')
                ->get();
            
            $plus = APBDKasFlow::where('apbd_id', $this->apbd_id)->where('tipe', 'masuk')->where('utama_id', $main->utama_id)->sum('jumlah');
            $minus = APBDKasFlow::where('apbd_id', $this->apbd_id)->where('tipe', 'keluar')->where('utama_id', $main->utama_id)->sum('jumlah');
            $utamaTotal = $plus - $minus;

            foreach($sub_utamas as $sub_utama){

                // -----------------------------------------------
                // group by sub sutamas get nama, kode, total
                // -----------------------------------------------
                $resSubSUtamas = [];
                $sub_sutamas = DB::table('ep_apbd_kas_flows')
                    ->select('sub_sutama_id')
                    ->where('apbd_id', $this->apbd_id)
                    ->where('sub_utama_id', $sub_utama->sub_utama_id)
                    ->groupBy('sub_sutama_id')
                    ->get();

                $subUtamaTotal = APBDKasFlow::where('apbd_id', $this->apbd_id)
                
                ->where('sub_utama_id', $sub_utama->sub_utama_id)->sum('jumlah');

                foreach($sub_sutamas as $sub_sutama){
                    // -----------------------------------------------
                    // group by sub ssutamas get nama, kode, total
                    // -----------------------------------------------
                    $resSubSSUtamas = [];
                    $sub_ssutamas = DB::table('ep_apbd_kas_flows')
                        ->select('sub_ssutama_id')
                        ->where('apbd_id', $this->apbd_id)
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)
                        ->groupBy('sub_ssutama_id')
                        ->get();

                    $subSUtamaTotal = APBDKasFlow::where('apbd_id', $this->apbd_id)
                        ->where('sub_sutama_id', $sub_sutama->sub_sutama_id)->sum('jumlah');

                    foreach($sub_ssutamas as $sub_ssutama){
                        $queru = APBDKasFlow::query();

                        $datas = $queru->where('apbd_id', $this->apbd_id)
                        ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)
                        ->get();

                        $total = $queru->where('apbd_id', $this->apbd_id)
                        ->where('sub_ssutama_id', $sub_ssutama->sub_ssutama_id)->sum('jumlah');

                        // penghitungan perubahan
                        $perubahanSSSUTotalContainer = [];
                        $psssuTotals = [];

                        // loop kasflow awal
                        $kasFlows = $this->apbd->kasFlows()
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
                    $kasFlows = $this->apbd->kasFlows()
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
                $kasFlows = $this->apbd->kasFlows()
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
            $kasFlows = $this->apbd->kasFlows()
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

        $this->results = $res;
        
        // dd($res);
    }
}
