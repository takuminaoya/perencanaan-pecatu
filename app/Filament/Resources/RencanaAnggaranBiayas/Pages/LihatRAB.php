<?php

namespace App\Filament\Resources\RencanaAnggaranBiayas\Pages;

use App\Filament\Resources\RencanaAnggaranBiayas\RencanaAnggaranBiayaResource;
use App\Models\ParameterKas;
use App\Models\RencanaAnggaranBiayaBidang;
use App\Models\RencanaAnggaranBiayaUraian;
use App\Models\RencanaAnggaranBiayaUraianDetail;
use App\Models\RencanaKerjaKegiatanBidangDetail;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Override;

class LihatRAB extends Page
{
    use InteractsWithRecord;

    protected static string $resource = RencanaAnggaranBiayaResource::class;

    protected string $view = 'filament.resources.rencana-anggaran-biayas.pages.lihat-r-a-b';

    protected ?string $heading = '';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            Action::make('head_tambahBidang')
                ->label('Tambah Bidang')
                ->extraAttributes([
                    'class' => 'btn-add'
                ])
                ->icon(Heroicon::Plus)
                ->closeModalByClickingAway(false)
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Select::make('rkkbd_id')
                                ->label('Nama Kegiatan')
                                ->allowHtml()
                                ->required()
                                ->searchable()
                                ->columnSpanFull()
                                ->live(onBlur:true)
                                ->options(
                                    function () : array {
                                        $res = [];
                                        $rkk = $this->record->rkk;

                                        $kegiatans = $rkk->kegiatans;

                                        foreach ($kegiatans as $keg) {
                                            $res[$keg->id] = '<span class="font-bold">'.$keg->nama_sub.'</span><div class="text-sm">'. $keg->kegiatan->kode .' : '.$keg->nama_kegiatan.'</div>'; 
                                        }

                                        return $res;
                                    }
                                )
                                ->afterStateUpdated(
                                    function ($set, $state) {
                                        $kegiatan = RencanaKerjaKegiatanBidangDetail::find($state);

                                        $sub = $kegiatan->kegiatan->getParent();

                                        $set('bidang', $kegiatan->bidang->bidang->kode . ' ' .$kegiatan->bidang->nama_bidang);
                                        $set('sub', $sub->kode .' '. $sub->nama);
                                        $set('kegiatan', $kegiatan->kegiatan->kode .' ' . $kegiatan->kegiatan->nama);
                                        $set('waktu', $kegiatan->durasi);
                                        $set('indikator_waktu', $kegiatan->satuan_durasi);
                                        $set('durasi', $kegiatan->durasi . ' ' . $kegiatan->satuan_durasi);
                                    }
                                ),
                            TextInput::make('bidang')
                                ->columnSpanFull()
                                ->readOnly(),
                            TextInput::make('sub')
                                ->columnSpanFull()
                                ->readOnly(),
                            TextInput::make('kegiatan')
                                ->columnSpanFull()
                                ->readOnly(),
                            TextInput::make('durasi')
                                ->disabled(),
                            Hidden::make('waktu')
                                ->required(),
                            Hidden::make('indikator_waktu')
                                ->required(),
                            Textarea::make('keluaran')
                                ->columnSpanFull()
                                ->rows(3)
                                ->required()
                        ])
                ])
                ->action(
                    function ($data) {
                        try {
                            $data['rab_id'] = $this->record->id;

                            $check = RencanaAnggaranBiayaBidang::where('rkkbd_id', $data['rkkbd_id'])
                                ->where('rab_id', $this->record->id)
                                ->first();

                            if($check) {
                                notif('Notifikasi RAB', 'Bidang RKK sudah ada pada RAB ini.');
                            } else {
                                RencanaAnggaranBiayaBidang::create($data);

                                notif('Notifikasi RAB', 'Bidang RKK telah berhasil ditambahkan.');
                            }
                        } catch (Exception $e) {
                            notif();
                        }
                    }
                )
        ];
    }

    public function tambahBidang() : Action {
        return Action::make('tambahBidang')
            ->label('Tambah Bidang')
            ->extraAttributes([
                'class' => 'btn-add-outline'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('rkkbd_id')
                            ->label('Nama Kegiatan')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $rkk = $this->record->rkk;

                                    $kegiatans = $rkk->kegiatans;

                                    foreach ($kegiatans as $keg) {
                                        $res[$keg->id] = '<span class="font-bold">'.$keg->nama_sub.'</span><div class="text-sm">'. $keg->kegiatan->kode .' : '.$keg->nama_kegiatan.'</div>'; 
                                    }

                                    return $res;
                                }
                            )
                            ->afterStateUpdated(
                                function ($set, $state) {
                                    $kegiatan = RencanaKerjaKegiatanBidangDetail::find($state);

                                    $sub = $kegiatan->kegiatan->getParent();

                                    $set('bidang', $kegiatan->bidang->bidang->kode . ' ' .$kegiatan->bidang->nama_bidang);
                                    $set('sub', $sub->kode .' '. $sub->nama);
                                    $set('kegiatan', $kegiatan->kegiatan->kode .' ' . $kegiatan->kegiatan->nama);
                                    $set('waktu', $kegiatan->durasi);
                                    $set('indikator_waktu', $kegiatan->satuan_durasi);
                                    $set('durasi', $kegiatan->durasi . ' ' . $kegiatan->satuan_durasi);
                                }
                            ),
                        TextInput::make('bidang')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('sub')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('kegiatan')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('durasi')
                            ->disabled(),
                        Hidden::make('waktu')
                            ->required(),
                        Hidden::make('indikator_waktu')
                            ->required(),
                        Textarea::make('keluaran')
                            ->columnSpanFull()
                            ->rows(3)
                            ->required()
                    ])
            ])
            ->action(
                function ($data) {
                    try {
                        $data['rab_id'] = $this->record->id;

                        $check = RencanaAnggaranBiayaBidang::where('rkkbd_id', $data['rkkbd_id'])
                            ->where('rab_id', $this->record->id)
                            ->first();

                        if($check) {
                            notif('Notifikasi RAB', 'Bidang RKK sudah ada pada RAB ini.');
                        } else {
                            RencanaAnggaranBiayaBidang::create($data);

                            notif('Notifikasi RAB', 'Bidang RKK telah berhasil ditambahkan.');
                        }
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function tambahUraian() : Action {
        return Action::make('tambahUraian')
            ->label('Tambah Uraian')
            ->extraAttributes([
                'class' => 'btn-add-sm'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(3)
                    ->schema([
                        TextInput::make('judul')
                            ->columnSpan(3)
                            ->required(),
                        Select::make('rkkbd_id')
                            ->label('Nama Kegiatan')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $rkk = $this->record->rkk;

                                    $kegiatans = $rkk->kegiatans;

                                    foreach ($kegiatans as $keg) {
                                        $res[$keg->id] = '<span class="font-bold">'.$keg->nama_kegiatan.'</span><div class="text-sm">Rp. '. number_format($keg->sumber_biaya) .'</div>'; 
                                    }

                                    return $res;
                                }
                            )->afterStateUpdated(
                                function ($set, $state) {
                                    $rkkbd = RencanaKerjaKegiatanBidangDetail::find($state);

                                    if($rkkbd){
                                        $set('jumlah_kas', $rkkbd->sumber_biaya);
                                    }
                                }
                            ),
                        Select::make('kas_id')
                            ->label('Jenis Kas')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $kas = ParameterKas::all();

                                    foreach ($kas as $k) {
                                        $res[$k->id] = '<span class="font-bold">'.$k->kode.'</span><div class="text-sm">'.$k->nama.'</div>'; 
                                    }

                                    return $res;
                                }
                            ),
                        TextInput::make('jumlah_kas')
                            ->required()
                            ->numeric()
                            ->prefix('Rp.')
                            ->readOnly(),
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $kas = ParameterKas::find($data['kas_id']);
                        $data['rab_id'] = $this->record->id;
                        $data['rabb_id'] = $arguments['rabb_id'];

                        $data['kode_kas'] = $kas->kode;
                        $data['nama_kas'] = $kas->nama;

                        $check = RencanaAnggaranBiayaUraian::where('rabb_id', $data['rabb_id'])
                            ->where('rab_id', $this->record->id)
                            ->where('rkkbd_id', $data['rkkbd_id'])
                            ->first();

                        if($check) {
                            notif('Notifikasi RAB', 'Bidang RKK sudah ada pada RAB ini.');
                        } else {
                            RencanaAnggaranBiayaUraian::create($data);

                            notif('Notifikasi RAB', 'Bidang RKK telah berhasil ditambahkan.');
                        }
                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }

    public function tambahDetail() : Action {
        return Action::make('tambahDetail')
            ->label('Tambah Detail Uraian')
            ->extraAttributes([
                'class' => 'btn-add-detail'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(3)
                    ->schema([
                        TextInput::make('judul')
                            ->columnSpanFull()
                            ->required(),
                        Select::make('kas_id')
                            ->label('Jenis Kas')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $kas = ParameterKas::where('tipe', 'child')->get();

                                    foreach ($kas as $k) {
                                        $res[$k->id] = '<span class="font-bold">'.$k->kode.'</span><div class="text-sm">'.$k->nama.'</div>'; 
                                    }

                                    return $res;
                                }
                            ),
                        TextInput::make('volume')
                            ->numeric()
                            ->required(),
                        TextInput::make('indikator')
                            ->placeholder('Org/Buah, Kotak, Rim dll')
                            ->required(),
                        TextInput::make('harga_satuan')
                            ->columnSpan(2)
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->required(),
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $kas = ParameterKas::find($data['kas_id']);
                        $data['rab_id'] = $this->record->id;
                        $data['rabb_id'] = $arguments['rabb_id'];
                        $data['rabu_id'] = $arguments['rabu_id'];

                        $data['kode_kas'] = $kas->kode;
                        $data['nama_kas'] = $kas->nama;
                        $data['jumlah'] = $data['volume'] * $data['harga_satuan'];

                        RencanaAnggaranBiayaUraianDetail::create($data);

                        notif('Notifikasi RAB', 'Detai Uraian telah berhasil ditambahkan.');
                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }

    public function editBidang() : Action {
        return Action::make('editBidang')
            ->label('Perbarui Bidang')
            ->extraAttributes([
                'class' => 'btn-add-outline'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->fillForm(
                function ($arguments) : array {
                    $res = [];

                    $data = RencanaAnggaranBiayaBidang::find($arguments['id']);

                    if($data){
                        $res = [
                            'rkkbd_id' => $data->rkkbd_id,
                            'bidang' => $data->bidang,
                            'sub' => $data->sub,
                            'kegiatan' => $data->kegiatan,
                            'durasi' => $data->waktu . ' ' . $data->indikator_waktu,
                            'waktu' => $data->waktu,
                            'indikator_waktu' => $data->indikator_waktu,
                            'keluaran' => $data->keluaran,
                        ];
                    }

                    return $res;
                }
            )
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('rkkbd_id')
                            ->label('Nama Kegiatan')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $rkk = $this->record->rkk;

                                    $kegiatans = $rkk->kegiatans;

                                    foreach ($kegiatans as $keg) {
                                        $res[$keg->id] = '<span class="font-bold">'.$keg->nama_sub.'</span><div class="text-sm">'. $keg->kegiatan->kode .' : '.$keg->nama_kegiatan.'</div>'; 
                                    }

                                    return $res;
                                }
                            )
                            ->afterStateUpdated(
                                function ($set, $state) {
                                    $kegiatan = RencanaKerjaKegiatanBidangDetail::find($state);

                                    $sub = $kegiatan->kegiatan->getParent();

                                    $set('bidang', $kegiatan->bidang->bidang->kode . ' ' .$kegiatan->bidang->nama_bidang);
                                    $set('sub', $sub->kode .' '. $sub->nama);
                                    $set('kegiatan', $kegiatan->kegiatan->kode .' ' . $kegiatan->kegiatan->nama);
                                    $set('waktu', $kegiatan->durasi);
                                    $set('indikator_waktu', $kegiatan->satuan_durasi);
                                    $set('durasi', $kegiatan->durasi . ' ' . $kegiatan->satuan_durasi);
                                }
                            ),
                        TextInput::make('bidang')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('sub')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('kegiatan')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('durasi')
                            ->disabled(),
                        Hidden::make('waktu')
                            ->required(),
                        Hidden::make('indikator_waktu')
                            ->required(),
                        Textarea::make('keluaran')
                            ->columnSpanFull()
                            ->rows(3)
                            ->required()
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $check = RencanaAnggaranBiayaBidang::find($arguments['id']);

                        if($check) {
                            $check->update($data);

                            notif('Notifikasi RAB', 'Bidang RKK telah berhasil diperbarui.');
                        }
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function editUraian() : Action {
        return Action::make('editUraian')
            ->label('Edit Uraian')
            ->extraAttributes([
                'class' => 'btn-add-sm'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->fillForm(
                function ($arguments) : array {
                    $res = [];

                    $data = RencanaAnggaranBiayaUraian::find($arguments['id']);

                    if($data){
                        $res = [
                            'judul' => $data->judul,
                            'rkkbd_id' => $data->rkkbd_id,
                            'kas_id' => $data->kas_id,
                            'jumlah_kas' => $data->jumlah_kas,
                        ];
                    }

                    return $res;
                }
            )
            ->schema([
                Grid::make(3)
                    ->schema([
                        TextInput::make('judul')
                            ->columnSpan(3)
                            ->required(),
                        Select::make('rkkbd_id')
                            ->label('Nama Kegiatan')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $rkk = $this->record->rkk;

                                    $kegiatans = $rkk->kegiatans;

                                    foreach ($kegiatans as $keg) {
                                        $res[$keg->id] = '<span class="font-bold">'.$keg->nama_kegiatan.'</span><div class="text-sm">Rp. '. number_format($keg->sumber_biaya) .'</div>'; 
                                    }

                                    return $res;
                                }
                            )->afterStateUpdated(
                                function ($set, $state) {
                                    $rkkbd = RencanaKerjaKegiatanBidangDetail::find($state);

                                    if($rkkbd){
                                        $set('jumlah_kas', $rkkbd->sumber_biaya);
                                    }
                                }
                            ),
                        Select::make('kas_id')
                            ->label('Jenis Kas')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $kas = ParameterKas::all();

                                    foreach ($kas as $k) {
                                        $res[$k->id] = '<span class="font-bold">'.$k->kode.'</span><div class="text-sm">'.$k->nama.'</div>'; 
                                    }

                                    return $res;
                                }
                            ),
                        TextInput::make('jumlah_kas')
                            ->required()
                            ->numeric()
                            ->prefix('Rp.')
                            ->readOnly(),
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $kas = ParameterKas::find($data['kas_id']);
                        $data['rab_id'] = $this->record->id;

                        $data['kode_kas'] = $kas->kode;
                        $data['nama_kas'] = $kas->nama;

                        $check = RencanaAnggaranBiayaUraian::find($arguments['id']);

                        if($check) {
                            $check->update($data);

                            notif('Notifikasi RAB', 'Bidang RKK telah berhasil diperbarui.');
                        } else {
                            notif('Notifikasi RAB', 'Data tidak ditemukan.');
                        }
                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }

    public function editDetail() : Action {
        return Action::make('editDetail')
            ->label('Perbarui Detail Uraian')
            ->extraAttributes([
                'class' => 'btn-add-detail'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->fillForm(
                function ($arguments) : array {
                    $res = [];

                    $data = RencanaAnggaranBiayaUraianDetail::find($arguments['id']);

                    if($data){
                        $res = [
                            'judul' => $data->judul,
                            'kas_id' => $data->kas_id,
                            'volume' => $data->volume,
                            'indikator' => $data->indikator,
                            'harga_satuan' => $data->harga_satuan,
                        ];
                    }

                    return $res;
                }
            )
            ->schema([
                Grid::make(3)
                    ->schema([
                        TextInput::make('judul')
                            ->columnSpanFull()
                            ->required(),
                        Select::make('kas_id')
                            ->label('Jenis Kas')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $kas = ParameterKas::where('tipe', 'child')->get();

                                    foreach ($kas as $k) {
                                        $res[$k->id] = '<span class="font-bold">'.$k->kode.'</span><div class="text-sm">'.$k->nama.'</div>'; 
                                    }

                                    return $res;
                                }
                            ),
                        TextInput::make('volume')
                            ->numeric()
                            ->required(),
                        TextInput::make('indikator')
                            ->placeholder('Org/Buah, Kotak, Rim dll')
                            ->required(),
                        TextInput::make('harga_satuan')
                            ->columnSpan(2)
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->required(),
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $kas = ParameterKas::find($data['kas_id']);
                        $data['kode_kas'] = $kas->kode;
                        $data['nama_kas'] = $kas->nama;
                        $data['jumlah'] = $data['volume'] * $data['harga_satuan'];

                        $rabud = RencanaAnggaranBiayaUraianDetail::find($arguments['id']);
                        $rabud->update($data);

                        notif('Notifikasi RAB', 'Detai Uraian telah berhasil diperbarui.');
                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }

    public function deleteBidang() : Action {
        return Action::make('deleteBidang')
            ->requiresConfirmation()
            ->iconButton()
            ->icon(Heroicon::XMark)
            ->color('danger')
            ->action(
                function ($arguments) {
                    $ck = RencanaAnggaranBiayaBidang::find($arguments['id']);

                    if($ck) {
                        $ck->delete();
                    }

                    notif('Notifikasi RAB', 'Detail bidang telah berhasil dihapus.');
                }
            );
    }

    public function deleteUraian() : Action {
        return Action::make('deleteUraian')
            ->requiresConfirmation()
            ->iconButton()
            ->icon(Heroicon::XMark)
            ->color('danger')
            ->action(
                function ($arguments) {
                    $ck = RencanaAnggaranBiayaUraian::find($arguments['id']);

                    if($ck) {
                        $ck->delete();
                    }

                    notif('Notifikasi RAB', 'Uraian telah berhasil dihapus.');
                }
            );
    }

    public function deleteDetail() : Action {
        return Action::make('deleteDetail')
            ->requiresConfirmation()
            ->iconButton()
            ->icon(Heroicon::XMark)
            ->color('danger')
            ->action(
                function ($arguments) {
                    $ck = RencanaAnggaranBiayaUraianDetail::find($arguments['id']);

                    if($ck) {
                        $ck->delete();
                    }

                    notif('Notifikasi RAB', 'Detail uraian telah berhasil dihapus.');
                }
            );
    }
}
