<?php

namespace App\Filament\Pages;

use App\Models\APBD;
use App\Models\APBDKasFlow;
use App\Models\ParameterBidang;
use App\Models\ParameterGroupBidang;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class APBDRekapitulasiRAB extends Page
{
    protected string $view = 'filament.pages.a-p-b-d-rekapitulasi-r-a-b';
    protected static string|UnitEnum|null $navigationGroup = 'Laporan APBDes';
    protected static ?string $navigationLabel = 'Rekapitulasi RAB';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowTrendingDown;
    protected static ?int $navigationSort = 0;
    protected ?string $heading = '';

    public array $results;
    public mixed $apbd_id;
    public mixed $daftarApbd;
    public mixed $apbd = null;

    public int $belanja_id;
    public mixed $sub_mains;
    public mixed $belanja;

    public array $statistic;

    public function mount() {
        $this->apbd_id = APBD::latest()->first()->id;
        $this->daftarApbd = APBD::orderBy('created_at', 'desc')->get();

        $this->belanja = ParameterKas::where('nama', 'BELANJA')->first();

        $this->belanja_id = $this->belanja->id;
        $this->sub_mains = ParameterKas::where('tipe', 'submain')->where('parent_kode', $this->belanja->kode)->get();

        $this->setAPBD();
    }

    public function setAPBD() {
        $this->apbd = APBD::find($this->apbd_id);

        // -----------------------------------------------
        // statistic
        // -----------------------------------------------
        $awal = APBDKasFlow::where('utama_id', $this->belanja_id)
                ->where('apbd_id', $this->apbd_id)
                ->whereNotNull('bidang_id')
                ->sum('jumlah');
        $ubah = 0;
        $sisa = $awal - $ubah;
        
        $this->statistic = [
            'jumlah_awal' => $awal,
            'jumlah_perubahan' => $ubah,
            'jumlah_sisa' => $sisa,
        ];

        $res = [];

        // grup by bidang
        $bidangs = DB::table('ep_apbd_kas_flows')
        ->select('bidang_id')
        ->where('utama_id', $this->belanja_id)
        ->where('apbd_id', $this->apbd_id)
        ->whereNotNull('bidang_id')
        ->groupBy('bidang_id')
        ->get();

        foreach($bidangs as $bidang){
            // group by sub bidang
            $cont_sub_bidangs = [];
            $sub_bidangs = DB::table('ep_apbd_kas_flows')
            ->select('sub_bidang_id')
            ->where('utama_id', $this->belanja_id)
            ->where('apbd_id', $this->apbd_id)
            ->where('bidang_id', $bidang->bidang_id)
            ->whereNotNull('sub_bidang_id')
            ->groupBy('sub_bidang_id')
            ->get();

            foreach($sub_bidangs as $sub_bidang){
                // grup by kegiatan
                $cont_kegiatans = [];
                $kegiatans = DB::table('ep_apbd_kas_flows')
                ->select('kegiatan_id')
                ->where('utama_id', $this->belanja_id)
                ->where('apbd_id', $this->apbd_id)
                ->where('sub_bidang_id', $sub_bidang->sub_bidang_id)
                ->whereNotNull('kegiatan_id')
                ->groupBy('kegiatan_id')
                ->get();

                foreach($kegiatans as $kegiatan){
                    $cont_sub_kegiatans = [];
                    $sub_kegiatans = DB::table('ep_apbd_kas_flows')
                    ->select('sub_kegiatan_id')
                    ->where('utama_id', $this->belanja_id)
                    ->where('apbd_id', $this->apbd_id)
                    ->where('kegiatan_id', $kegiatan->kegiatan_id)
                    ->whereNotNull('sub_kegiatan_id')
                    ->groupBy('sub_kegiatan_id')
                    ->get();

                    foreach($sub_kegiatans as $sub_kegiatan){
                        $cont_groups = [];
                        $groups = DB::table('ep_apbd_kas_flows')
                        ->select('group_id')
                        ->where('utama_id', $this->belanja_id)
                        ->where('apbd_id', $this->apbd_id)
                        ->where('sub_kegiatan_id', $sub_kegiatan->sub_kegiatan_id)
                        ->whereNotNull('sub_kegiatan_id')
                        ->groupBy('group_id')
                        ->get();

                        $sub_kegiatanP = ParameterKegiatan::find($sub_kegiatan->sub_kegiatan_id);

                        foreach($groups as $group){
                            $gp = ParameterGroupBidang::find($group->group_id);

                            // result by kas belanja
                            $sub_bidang_belanja = ParameterKas::where('parent_kode', $this->belanja->kode)->where('tipe', 'submain')->get();
                            $rincian_per_sbms = [];
                            $totalKeseluruhanRPS = 0;

                            foreach($sub_bidang_belanja as $sbb){
                                $trps = APBDKasFlow::where('apbd_id', $this->apbd_id)->where('sub_kegiatan_id', $sub_kegiatan->sub_kegiatan_id)->where('sub_utama_id', $sbb->id)->where('group_id', $group->group_id)->where('tipe', 'keluar')->sum('jumlah');

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

                        $totalsub_kegiatan = APBDKasFlow::where('utama_id', $this->belanja_id)
                        ->where('apbd_id', $this->apbd_id)
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

                    $totalKegiatan = APBDKasFlow::where('utama_id', $this->belanja_id)
                    ->where('apbd_id', $this->apbd_id)
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

                $totalSubBidang = APBDKasFlow::where('utama_id', $this->belanja_id)
                ->where('apbd_id', $this->apbd_id)
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

            $totalBidang = APBDKasFlow::where('utama_id', $this->belanja_id)
                ->where('apbd_id', $this->apbd_id)
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

        $this->results = $res;

        // dd($res);
    }
}
