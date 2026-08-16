<?php

namespace App\Filament\Resources\RencanaKerjaKegiatans\Pages;

use App\Filament\Resources\RencanaKerjaKegiatans\RencanaKerjaKegiatanResource;
use App\Models\ParameterBidang;
use App\Models\RencanaKerjaKegiatanBidang;
use App\Models\RencanaKerjaKegiatanBidangDetail;
use Carbon\Carbon;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Override;

class LihatRKP extends Page
{
    use InteractsWithRecord;

    protected static string $resource = RencanaKerjaKegiatanResource::class;

    protected ?string $heading = "";

    protected string $view = 'filament.resources.rencana-kerja-kegiatans.pages.lihat-r-k-p';

    public $total_anggaran = 0;
    public $total_sasaran = 0;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        
        $record = $this->record;
        foreach ($record->bidangs as $b){
            foreach($b->kegiatans as $kg){
                $j = ($kg->laki_laki + $kg->perempuan + $kg->artm);
                $this->total_anggaran += $kg->sumber_biaya;
                $this->total_sasaran += $j;
            }
        }
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            Action::make('tambah_bidang')
                ->label('Tambah Bidang')
                ->schema([
                    Select::make('bidang_id')
                        ->label('Kamus Usulan')
                        ->columnSpan(2)
                        ->allowHtml()
                        ->live()
                        ->options(
                            function () : array {
                                $res = [];
                                
                                $kus = ParameterBidang::where('tipe', 'main')->get();

                                foreach($kus as $k){
                                    $res[$k->id] = '<span class="font-bold">Kode : 0'.$k->kode.'</span><div class="text-sm">Nama : '.$k->nama.'</div>'; 
                                }

                                return $res;
                            }
                        )
                        ->required(),
                ])
                ->action(
                    function($data) {
                        try {
                            $bidang = ParameterBidang::find($data['bidang_id']);
                            $check = RencanaKerjaKegiatanBidang::where('rkp_id', $this->record->id)->where('bidang_id', $bidang->id)->first();

                            if(!$check){
                                RencanaKerjaKegiatanBidang::create([
                                    'rkp_id' => $this->record->id,
                                    'bidang_id' => $bidang->id,
                                    'nama_bidang' => strtolower($bidang->nama)
                                ]);

                                notif('Notifikasi RKP', 'Bidang Dengan nama '. $bidang->nama .' Telah Berhasil di registrasi ke RKP.');
                            } else {
                                notif('Notifikasi RKP', 'Bidang Dengan nama '. $bidang->nama .' Telah teregistrasi ke RKP.');
                            }
                            
                        } catch (Exception $e) {
                            notif();
                        } 
                    }
                )
        ];
    }

    public function tambahKegiatan() : Action {
        return Action::make('tambahKegiatan')
            ->label('Tambah Kegiatan')
            ->extraAttributes([
                'class' => 'btn btn-gold'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('kegiatan_id')
                            ->allowHtml()
                            ->options(
                                function () : array {
                                    $res = [];
                                    $kus = ParameterBidang::where('tipe', 'child')->get();

                                    foreach($kus as $k){
                                        $res[$k->id] = '<span class="font-bold">Kode : 0'.$k->kode.'</span><div class="text-sm">Nama : '.$k->nama.'</div>'; 
                                    }

                                    return $res;
                                }
                            )
                            ->searchable()
                            ->columnSpan(3)
                            ->required(),
                        TextInput::make('lokasi')
                            ->required()
                            ->default('Desa Pecatu'),
                        TextInput::make('volume')
                            ->required()
                            ->numeric(),
                        Select::make('satuan')
                            ->options([
                                'OB' => 'Org/Bln',
                                'bulan' => 'Bulan',
                                'paket' => 'Paket',
                                'dokumen' => 'Dokumen',
                            ]),
                        TextInput::make('sumber_biaya')
                            ->required()
                            ->prefix('Rp.')
                            ->columnSpan(2)
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->default('Desa Pecatu'),
                        Select::make('sumber_kode')
                            ->required()
                            ->options([
                                'PBH' => 'PBH',
                                'ADD' => 'ADD',
                            ]),
                        Section::make('Sasaran')
                            ->description('Sasaran target berupa jumlah masyarakat per jenis kelamin, untuk jumlah akan ditotalkan berdasarkan yang diinput dibawah.')
                            ->columnSpanFull()
                            ->columns(3)
                            ->schema([
                                TextInput::make('laki_laki')
                                    ->required()
                                    ->numeric(),
                                TextInput::make('perempuan')
                                    ->required()
                                    ->numeric(),
                                TextInput::make('artm')
                                    ->required()
                                    ->numeric(),
                            ]),
                        Section::make('Waktu Pelaksanaan')
                            ->description('Inputkan mulai dan akhir, untuk durasi akan dikalkulasi berdasarkan mulai dan akhir')
                            ->columnSpanFull()
                            ->columns(3)
                            ->schema([
                                DatePicker::make('mulai')
                                    ->live(onBlur:true)
                                    ->required(),
                                DatePicker::make('selesai')
                                    ->live(onBlur:true)
                                    ->afterStateUpdated(
                                        function ($get, $set, $state) {
                                            $m = $get('mulai');
                                            $s = $state;
                                            $h = "";

                                            if($m){
                                                $h = dateDiffCarbon($m, $s, 'month');
                                            }

                                            $r = explode(' ', $h);
                                        
                                            $set('durasi_t', $h);
                                            $set('durasi', $r[0]);
                                            $set('satuan_durasi', $r[1]);
                                        }
                                    )
                                    ->required(),
                                TextInput::make('durasi_t')
                                    ->live(onBlur:true)
                                    ->required()
                                    ->readOnly(),
                                Hidden::make('durasi')
                                    ->required(),
                                Hidden::make('satuan_durasi')
                                    ->required(),
                            ]),
                        TextInput::make('pelaksana_kegiatan')
                            ->required()
                            ->columnSpanFull(),
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $kegiatan = ParameterBidang::find($data['kegiatan_id']);
                        $rkp = $this->record->id;
                        $bidang_id = $arguments['id'];

                        $data['rkp_id'] = $rkp;
                        $data['bidang_id'] = $bidang_id;
                        $data['nama_sub'] = $kegiatan->getParent()->nama;
                        $data['nama_kegiatan'] = $kegiatan->nama;
                        
                        RencanaKerjaKegiatanBidangDetail::create($data);

                        notif('Notifikasi RPK', 'Kegiatan telah berhasil ditambah');
                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }

    
    public function editKegiatan() : Action {
        return Action::make('editKegiatan')
            ->icon(Heroicon::PencilSquare)
            ->badge()
            ->iconButton()
            ->closeModalByClickingAway(false)
            ->record(
                function (array $arguments) {
                    return RencanaKerjaKegiatanBidangDetail::find($arguments['kegiatan_id']);
                }
            )
            ->fillForm(
                function (array $arguments) : array {
                    $res = [];

                    $data = RencanaKerjaKegiatanBidangDetail::find($arguments['kegiatan_id']);

                    if($data){
                        $res = [
                            'bidang_id' => $data->bidang_id,
                            'rkp_id' => $data->rkp_id,
                            'kegiatan_id' => $data->kegiatan_id,
                            'nama_sub' => $data->nama_sub,
                            'nama_kegiatan' => $data->nama_kegiatan,
                            'lokasi' => $data->lokasi,
                            'volume' => $data->volume,
                            'satuan' => $data->satuan,
                            'sumber_biaya' => $data->sumber_biaya,
                            'sumber_kode' => $data->sumber_kode,
                            'laki_laki' => $data->laki_laki,
                            'perempuan' => $data->perempuan,
                            'artm' => $data->artm,
                            'durasi' => $data->durasi,
                            'satuan_durasi' => $data->satuan_durasi,
                            'mulai' => $data->mulai,
                            'selesai' => $data->selesai,
                            'pelaksana_kegiatan' => $data->pelaksana_kegiatan,
                            'durasi_t' => dateDiffCarbon($data->mulai, $data->selesai, 'month')
                        ];
                    }

                    return $res;
                }
            )
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('kegiatan_id')
                            ->options(ParameterBidang::query()->where('tipe', 'child')->pluck('nama', 'id'))
                            ->searchable()
                            ->columnSpan(3)
                            ->required(),
                        TextInput::make('lokasi')
                            ->required()
                            ->default('Desa Pecatu'),
                        TextInput::make('volume')
                            ->required()
                            ->numeric(),
                        Select::make('satuan')
                            ->options([
                                'bulan' => 'Bulan',
                                'paket' => 'Paket',
                                'dokumen' => 'Dokumen',
                            ]),
                        TextInput::make('sumber_biaya')
                            ->required()
                            ->prefix('Rp.')
                            ->columnSpan(2)
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->default('Desa Pecatu'),
                        Select::make('sumber_kode')
                            ->options([
                                'PBH' => 'PBH'
                            ]),
                        Section::make('Sasaran')
                            ->description('Sasaran target berupa jumlah masyarakat per jenis kelamin, untuk jumlah akan ditotalkan berdasarkan yang diinput dibawah.')
                            ->columnSpanFull()
                            ->columns(3)
                            ->schema([
                                TextInput::make('laki_laki')
                                    ->required()
                                    ->numeric(),
                                TextInput::make('perempuan')
                                    ->required()
                                    ->numeric(),
                                TextInput::make('artm')
                                    ->required()
                                    ->numeric(),
                            ]),
                        Section::make('Waktu Pelaksanaan')
                            ->description('Inputkan mulai dan akhir, untuk durasi akan dikalkulasi berdasarkan mulai dan akhir')
                            ->columnSpanFull()
                            ->columns(3)
                            ->schema([
                                DatePicker::make('mulai')
                                    ->live(onBlur:true)
                                    ->required(),
                                DatePicker::make('selesai')
                                    ->live(onBlur:true)
                                    ->afterStateUpdated(
                                        function ($get, $set, $state) {
                                            $m = $get('mulai');
                                            $s = $state;
                                            $h = "";

                                            if($m){
                                                $h = dateDiffCarbon($m, $s, 'month');
                                            }

                                            $r = explode(' ', $h);
                                        
                                            $set('durasi_t', $h);
                                            $set('durasi', $r[0]);
                                            $set('satuan_durasi', $r[1]);
                                        }
                                    )
                                    ->required(),
                                TextInput::make('durasi_t')
                                    ->live(onBlur:true)
                                    ->required()
                                    ->readOnly(),
                                Hidden::make('durasi')
                                    ->required(),
                                Hidden::make('satuan_durasi')
                                    ->required(),
                            ]),
                        TextInput::make('pelaksana_kegiatan')
                            ->required()
                            ->columnSpanFull(),
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $kegiatan = ParameterBidang::find($data['kegiatan_id']);

                        $rec = RencanaKerjaKegiatanBidangDetail::find($arguments['kegiatan_id']);

                        if($rec){
                            $rec->kegiatan_id = $data['kegiatan_id'];
                            $rec->nama_sub = $kegiatan->getParent()->nama;
                            $rec->nama_kegiatan = $kegiatan->nama;
                            $rec->lokasi = $data['lokasi'];
                            $rec->volume = $data['volume'];
                            $rec->satuan = $data['satuan'];
                            $rec->sumber_biaya = $data['sumber_biaya'];
                            $rec->sumber_kode = $data['sumber_kode'];
                            $rec->laki_laki = $data['laki_laki'];
                            $rec->perempuan = $data['perempuan'];
                            $rec->artm = $data['artm'];
                            $rec->durasi = $data['durasi'];
                            $rec->satuan_durasi = $data['satuan_durasi'];
                            $rec->mulai = $data['mulai'];
                            $rec->selesai = $data['selesai'];
                            $rec->pelaksana_kegiatan = $data['pelaksana_kegiatan'];
                            $rec->save();
                        }

                        notif('Notifikasi RKP', 'Kegiatan telah berhasil diperbarui');
                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }

    public function deleteKegiatan() : Action {
        return Action::make('deleteKegiatan')
            ->icon(Heroicon::XMark)
            ->color('danger')
            ->badge()
            ->iconButton()
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    $c = RencanaKerjaKegiatanBidangDetail::find($arguments['kegiatan_id']);

                    if($c){
                        $c->delete();

                        notif('Notifikasi RKP', 'Kegiatan telah berhasil dihapus');
                    }
                }
            );
    }

    public function deleteBidang() : Action {
        return Action::make('deleteBidang')
            ->label('hapus bidang')
            ->icon(Heroicon::XMark)
            ->color('danger')
            ->badge()
            ->extraAttributes([
                'class' => 'rounded-none hover:bg-red-500 hover:text-white capitalize'
            ])
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    $c = RencanaKerjaKegiatanBidang::find($arguments['id']);

                    if($c){
                        $c->delete();

                        notif('Notifikasi RKP', 'Bidang telah berhasil dihapus');
                    }
                }
            );
    }
}
