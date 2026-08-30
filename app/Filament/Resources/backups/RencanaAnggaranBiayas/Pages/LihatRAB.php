<?php

namespace App\Filament\Resources\RencanaAnggaranBiayas\Pages;

use App\Filament\Resources\RencanaAnggaranBiayas\RencanaAnggaranBiayaResource;
use App\Models\APBDRincianSubUtama;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use App\Models\RencanaAnggaranBiayaBidang;
use App\Models\RencanaAnggaranBiayaUraian;
use App\Models\RencanaAnggaranBiayaUraianDetail;
use App\Models\RencanaKerjaKegiatanBidangDetail;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
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
            $this->tambahBidang()
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
                        Select::make('apbdrsu_id')
                            ->label('Nama Kegiatan')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $apbd = $this->record->apbd;

                                    $kegiatans = $apbd->rincianSubUtamas()->whereNotNull('bidang_id')->get();

                                    foreach ($kegiatans as $keg) {
                                        $res[$keg->id] = '<span class="font-bold">'.$keg->bidang->nama.'</span><div class="text-sm">Rp. '. number_format($keg->menjadi) .'</div>'; 
                                    }

                                    return $res;
                                }
                            )->afterStateUpdated(
                                function ($set, $state) {
                                    $apbdrsu = APBDRincianSubUtama::find($state);
                                    $sub = $apbdrsu->bidang->getParent();
                                    $main = $sub->getParent();

                                    if($apbdrsu){
                                        $set('bidang', $main->kode . ' ' .$main->nama);
                                        $set('sub', $sub->kode .' '. $sub->nama);
                                        $set('kegiatan', $apbdrsu->bidang->kode .' ' . $apbdrsu->bidang->nama);
                                        $set('kode_kegiatan', $apbdrsu->bidang->kode);
                                        $set('main_bidang_id', $main->id);
                                        $set('sub_bidang_id', $sub->id);
                                        $set('bidang_id', $apbdrsu->bidang->id);

                                    }
                                }
                            ),
                        Hidden::make('main_bidang_id'),
                        Hidden::make('sub_bidang_id'),
                        Hidden::make('bidang_id'),
                        Hidden::make('kode_kegiatan'),
                        TextInput::make('bidang')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('sub')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('kegiatan')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('waktu')
                            ->required(),
                        TextInput::make('indikator_waktu')
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
                        $data['apbd_id'] = $this->record->apbd_id;

                        $check = RencanaAnggaranBiayaBidang::where('apbdrsu_id', $data['apbdrsu_id'])
                            ->where('rab_id', $this->record->id)
                            ->first();

                        if($check) {
                            notif('Notifikasi RAB', 'Bidang RKK sudah ada pada RAB ini.');
                        } else {
                            RencanaAnggaranBiayaBidang::create($data);

                            notif('Notifikasi RAB', 'Bidang RKK telah berhasil ditambahkan.');
                        }
                    } catch (Exception $e) {
                        dd($e);
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
                        Select::make('kegiatan_id')
                            ->label('Daftar Kegiatan Berdasarkan Bidang')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function ($livewire) : array {
                                    $res = [];
                                    $arguments = $livewire->mountedActions[0]['arguments'];

                                    $rabb = RencanaAnggaranBiayaBidang::find($arguments['rabb_id']);
                                    $kas = ParameterKegiatan::where('kode', $rabb->kode_kegiatan)->get();

                                    foreach ($kas as $k) {
                                        $res[$k->id] = '<span class="font-bold">'.$k->kode.'</span><div class="text-sm">'.$k->uraian_output.'</div>'; 
                                    }

                                    return $res;
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
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(','),
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
                            ->where('kegiatan_id', $data['kegiatan_id'])
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
                                function ($livewire) : array {
                                    $res = [];
                                    $arguments = $livewire->mountedActions[0]['arguments'];
                                    $rabu = RencanaAnggaranBiayaUraian::find($arguments['rabu_id']);

                                    $kas = ParameterKas::where('parent_kode', $rabu->kode_kas)->get();

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
                            ->default(
                                function ($livewire) {
                                    $arguments = $livewire->mountedActions[0]['arguments'];
                                    $rabu_id = $arguments['rabu_id'];

                                    $data = RencanaAnggaranBiayaUraian::find($rabu_id);

                                    if($data){
                                        return $data->kegiatan->satuan_output;
                                    }
                                }
                            )
                            ->required(),
                        TextInput::make('kode_satuan')
                            ->placeholder('ADD, PBH, DLL')
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
                            'apbdrsu_id' => $data->apbdrsu_id,
                            'bidang' => $data->bidang,
                            'sub' => $data->sub,
                            'kegiatan' => $data->kegiatan,
                            'durasi' => $data->waktu . ' ' . $data->indikator_waktu,
                            'waktu' => $data->waktu,
                            'indikator_waktu' => $data->indikator_waktu,
                            'keluaran' => $data->keluaran,
                            'main_bidang_id' => $data->main_bidang_id,
                            'sub_bidang_id' => $data->sub_bidang_id,
                            'bidang_id' => $data->bidang_id,
                            'kode_kegiatan' => $data->kode_kegiatan,
                        ];
                    }

                    return $res;
                }
            )
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('apbdrsu_id')
                            ->label('Nama Kegiatan')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function () : array {
                                    $res = [];
                                    $apbd = $this->record->apbd;

                                    $kegiatans = $apbd->rincianSubUtamas()->whereNotNull('bidang_id')->get();

                                    foreach ($kegiatans as $keg) {
                                        $res[$keg->id] = '<span class="font-bold">'.$keg->bidang->nama.'</span><div class="text-sm">Rp. '. number_format($keg->menjadi) .'</div>'; 
                                    }

                                    return $res;
                                }
                            )->afterStateUpdated(
                                function ($set, $state) {
                                    $apbdrsu = APBDRincianSubUtama::find($state);
                                    $sub = $apbdrsu->bidang->getParent();
                                    $main = $sub->getParent();

                                    if($apbdrsu){
                                        $set('bidang', $main->kode . ' ' .$main->nama);
                                        $set('sub', $sub->kode .' '. $sub->nama);
                                        $set('kegiatan', $apbdrsu->bidang->kode .' ' . $apbdrsu->bidang->nama);
                                        $set('kode_kegiatan', $apbdrsu->bidang->kode);
                                        $set('main_bidang_id', $main->id);
                                        $set('sub_bidang_id', $sub->id);
                                        $set('bidang_id', $apbdrsu->bidang->id);

                                    }
                                }
                            ),
                        Hidden::make('main_bidang_id'),
                        Hidden::make('sub_bidang_id'),
                        Hidden::make('bidang_id'),
                        Hidden::make('kode_kegiatan'),
                        TextInput::make('bidang')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('sub')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('kegiatan')
                            ->columnSpanFull()
                            ->readOnly(),
                        TextInput::make('waktu')
                            ->required(),
                        TextInput::make('indikator_waktu')
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

    
    public function tambahDetailMassal() : Action {
        return Action::make('tambahDetailMassal')
            ->label('Tambah Detail Massal')
            ->extraAttributes([
                'class' => 'btn-add-detail'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('kas_id')
                            ->label('Jenis Kas')
                            ->allowHtml()
                            ->required()
                            ->searchable()
                            ->columnSpanFull()
                            ->live(onBlur:true)
                            ->options(
                                function ($livewire) : array {
                                    $res = [];
                                    $arguments = $livewire->mountedActions[0]['arguments'];
                                    $rabu = RencanaAnggaranBiayaUraian::find($arguments['rabu_id']);

                                    $kas = ParameterKas::where('parent_kode', $rabu->kode_kas)->get();

                                    foreach ($kas as $k) {
                                        $res[$k->id] = '<span class="font-bold">'.$k->kode.'</span><div class="text-sm">'.$k->nama.'</div>'; 
                                    }

                                    return $res;
                                }
                            ),
                        Repeater::make('details')
                            ->collapsible()
                            ->columnSpanFull()
                            ->required()
                            ->minItems(1)
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('judul')
                                            ->columnSpan(3)
                                            ->required(),
                                        TextInput::make('volume')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('indikator')
                                            ->placeholder('Org/Buah, Kotak, Rim dll')
                                            ->default(
                                                function ($livewire) {
                                                    $arguments = $livewire->mountedActions[0]['arguments'];
                                                    $rabu_id = $arguments['rabu_id'];

                                                    $data = RencanaAnggaranBiayaUraian::find($rabu_id);

                                                    if($data){
                                                        return $data->kegiatan->satuan_output;
                                                    }
                                                }
                                            )
                                            ->required(),
                                        TextInput::make('kode_satuan')
                                            ->placeholder('ADD, PBH, DLL')
                                            ->required(),
                                        TextInput::make('harga_satuan')
                                            ->columnSpan(3)
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->required(),
                                    ])
                            ])
                        
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        foreach($data['details'] as $d){
                            $kas = ParameterKas::find($data['kas_id']);
                            
                            $data['rab_id'] = $this->record->id;
                            $data['rabb_id'] = $arguments['rabb_id'];
                            $data['rabu_id'] = $arguments['rabu_id'];

                            $data['kode_kas'] = $kas->kode;
                            $data['nama_kas'] = $kas->nama;
                            
                            $data['judul'] = $d['judul'];
                            $data['volume'] = $d['volume'];
                            $data['indikator'] = $d['indikator'];
                            $data['harga_satuan'] = $d['harga_satuan'];
                            $data['jumlah'] = $data['volume'] * $data['harga_satuan'];

                            RencanaAnggaranBiayaUraianDetail::create($data);
                        }

                        notif('Notifikasi RAB', 'Detai Uraian telah berhasil ditambahkan.');
                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }
}
