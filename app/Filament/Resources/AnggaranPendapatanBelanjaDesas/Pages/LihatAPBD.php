<?php

namespace App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages;

use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\AnggaranPendapatanBelanjaDesaResource;
use App\Models\APBDDetailMain;
use App\Models\APBDDetailSub;
use App\Models\APBDDetailSubMain;
use App\Models\APBDRicianChildDetail;
use App\Models\APBDRicianSubChild;
use App\Models\APBDRincianSubUtama;
use App\Models\APBDRincianUtama;
use App\Models\ParameterBidang;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use App\Models\ParameterSumberDana;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Override;

class LihatAPBD extends Page
{
    use InteractsWithRecord;

    protected static string $resource = AnggaranPendapatanBelanjaDesaResource::class;

    protected string $view = 'filament.resources.anggaran-pendapatan-belanja-desas.pages.lihat-a-p-b-d';

    protected ?string $heading = '';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            $this->tambahDetail(),
            $this->tambahRincianUtama()
        ];
    }

    public function tambahDetail() : Action {
        return Action::make('tambahDetail')
            ->label('Tambah Detail')
            ->extraAttributes([
                'class' => 'btn-add'
            ])
            ->modalWidth('5xl')
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('kas_id')
                            ->label('Daftar Kas Utama')
                            ->columnSpanFull()
                            ->searchable()
                            ->required()
                            ->live()
                            ->options(
                                ParameterKas::query()->where('tipe', 'main')->pluck('nama', 'id')
                            ),
                        CheckboxList::make('daftar_submain')
                            ->label('Daftar Sub Utama')
                            ->columnSpanFull()
                            ->columns(3)
                            ->live()
                            ->minItems(1)
                            ->required()
                            ->bulkToggleable()
                            ->options(
                                function ($get) : array {
                                    $res = [];

                                    if ($get('kas_id')) {
                                        $main = ParameterKas::find($get('kas_id'));
                                        $datas = ParameterKas::query()->where('parent_kode', $main->kode)->where('tipe', 'submain')->get();

                                        foreach ($datas as $d){
                                            $res[$d->id] = $d->nama;
                                        }
                                    }

                                    return $res;
                                }
                            ) 
                    ])
            ])
            ->action(
                function ($data) {
                    try {
                        $apbd_id = $this->record->id;

                        $detail = APBDDetailMain::create([
                            'apbd_id' => $apbd_id,
                            'kas_id' => $data['kas_id'],
                        ]);

                        foreach ($data['daftar_submain'] as $dsu){
                            APBDDetailSubMain::create([
                                'apbd_id' => $apbd_id,
                                'apbdm_id' => $detail->id,
                                'parameter_kas_id' => $dsu,
                            ]);
                        }

                        notif('Notifikasi APBDes', 'Detail Telah Berhasil diinputkan.');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    /**
     * Kelompok Aksi Ikthisar atau detail
     */
    public function tambahSub() : Action {
        return Action::make('tambahSub')
            ->label('Tambah Sub Pada Sub Utama')
            ->schema([
                Select::make('kas_id')
                    ->required()
                    ->searchable()
                    ->allowHtml()
                    ->options(
                        function () : array {
                            $res = [];
                            
                            $params = ParameterKas::query()->where('tipe', 'child')->get();

                            foreach ($params as $p) {
                                $res[$p->id] = '<span class="font-bold">'.$p->kode.'</span><div class="text-sm">'. $p->nama .'</div>'; 
                            }

                            return $res;
                        }
                    )
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $apbd_id = $this->record->id;

                        APBDDetailSub::create([
                            'apbd_id' => $apbd_id,
                            'apbdsm_id' => $arguments['id'],
                            'kas_id' => $data['kas_id'],
                        ]);

                        notif('Notifikasi APBDes', 'Sub Telah Berhasil diinputkan pada sub utama.');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function tambahEditMain() : Action {
        return Action::make('tambahEditMain')
            ->label('Tambah Detail')
            ->extraAttributes([
                'class' => 'btn-add'
            ])
            ->fillForm(
                function ($arguments) {
                    $res = [];
                    if ($arguments) {
                        $data = APBDDetailMain::find($arguments['id']);

                        $res = [
                            'kas_id' => $data->kas_id,
                        ];
                    }

                    return $res;
                }
            )
            ->modalWidth('5xl')
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('kas_id')
                            ->label('Daftar Kas Utama')
                            ->columnSpanFull()
                            ->searchable()
                            ->required()
                            ->live()
                            ->options(
                                ParameterKas::query()->where('tipe', 'main')->pluck('nama', 'id')
                            ),
                        CheckboxList::make('daftar_submain')
                            ->label('Daftar Sub Utama')
                            ->columnSpanFull()
                            ->columns(3)
                            ->live()
                            ->minItems(1)
                            ->required()
                            ->bulkToggleable()
                            ->options(
                                function ($get) : array {
                                    $res = [];

                                    if ($get('kas_id')) {
                                        $main = ParameterKas::find($get('kas_id'));
                                        $datas = ParameterKas::query()->where('parent_kode', $main->kode)->where('tipe', 'submain')->get();

                                        foreach ($datas as $d){
                                            $res[$d->id] = $d->nama;
                                        }
                                    }

                                    return $res;
                                }
                            ) 
                    ])
            ])
            ->action(
                function ($data, $arguments) {
                    try {
                        $apbd_id = $this->record->id;

                        if ($arguments) {
                            $main = APBDDetailMain::find($arguments['id']);
                            $detail = $main;

                            $main->update([
                                'kas_id' => $data['kas_id'],
                            ]);

                            foreach($main->subs as $s){
                                $s->delete();
                            }
                        } else {
                            $detail = APBDDetailMain::create([
                                'apbd_id' => $apbd_id,
                                'kas_id' => $data['kas_id'],
                            ]);
                        }

                        foreach ($data['daftar_submain'] as $dsu){
                            APBDDetailSubMain::create([
                                'apbd_id' => $apbd_id,
                                'apbdm_id' => $detail->id,
                                'parameter_kas_id' => $dsu,
                            ]);
                        }

                        notif('Notifikasi APBDes', 'Detail Telah Berhasil diinputkan.');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function deleteMain() : Action {
        return Action::make('deleteMain')
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    try {
                        $d = APBDDetailMain::find($arguments['id']);

                        if($d){
                            $d->delete();
                        }

                        notif('Notifikasi APBDes', 'Kas Utama telah berhasil dihapus');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function deleteSub() : Action {
        return Action::make('deleteSub')
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    try {
                        $d = APBDDetailSub::find($arguments['id']);

                        if($d){
                            $d->delete();
                        }

                        notif('Notifikasi APBDes', 'Sub telah berhasil dihapus');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function deleteSubMain() : Action {
        return Action::make('deleteSubMain')
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    try {
                        $d = APBDDetailSubMain::find($arguments['id']);

                        if($d){
                            $d->delete();
                        }

                        notif('Notifikasi APBDes', 'Sub Utama telah berhasil dihapus');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    /**
     * Kumpulan Aksi Rincian
     */
    public mixed $apbdsm_id = null;
    public mixed $parent_bidang_id = null;
    public mixed $bidang_id = null;
    public mixed $tipe = 'masuk';

    public function tambahRincianUtama() : Action {
        return Action::make('tambahRincianUtama')
            ->label('Tambah Rincian')
            ->modalWidth('5xl')
            ->extraAttributes([
                'class' => 'btn-add'
            ])
            ->icon(Heroicon::Plus)
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('apbdsm_id')
                            ->label('Daftar APBD Sub Utama')
                            ->columnSpanFull()
                            ->searchable()
                            ->required()
                            ->live()
                            ->allowHtml()
                            ->options(
                                function () : array {
                                    $res = [];

                                    $datas = $this->record->subs;

                                    foreach($datas as $d){
                                        $res[$d->id] = '<span class="font-bold">'.$d->kas->kode.'</span><div class="text-sm">'. $d->kas->nama .'</div>'; 
                                    }

                                    return $res;
                                }
                            )
                            ->afterStateUpdated(fn ($state) => $this->apbdsm_id = $state),
                        Select::make('tipe')
                            ->live()
                            ->options([
                                'masuk' => 'Pemasukan/Pendapatan',
                                'keluar' => 'Pengeluaran/Belanja',
                            ])
                            ->afterStateUpdated(fn ($state) => $this->tipe = $state)
                            ->default('masuk'),
                        Select::make('bidang_id')
                            ->label('Kaitkan dengan Parameter Bidang')
                            ->hidden(fn ($get) : bool => $get('tipe') == 'masuk' ? true : false)
                            ->columnSpanFull()
                            ->searchable()
                            ->required()
                            ->live()
                            ->allowHtml()
                            ->options(
                                function () : array {
                                    $res = [];

                                    $datas = ParameterBidang::where('tipe', 'child')->get();

                                    foreach($datas as $d){
                                        $res[$d->id] = '<span class="font-bold">'.$d->kode.'</span><div class="text-sm">'. $d->nama .'</div>'; 
                                    }

                                    return $res;
                                }
                            )
                            ->afterStateUpdated(fn ($state) => $this->bidang_id = $state),
                        DatePicker::make('tanggal_mulai')
                            ->hidden(fn ($get) : bool => $get('tipe') == 'masuk' ? true : false)    
                            ->required(),
                        DatePicker::make('tanggal_selesai')
                            ->hidden(fn ($get) : bool => $get('tipe') == 'masuk' ? true : false)    
                            ->required()
                            ->live()
                            ->afterStateUpdated(
                                function ($get, $state, $set) {
                                    $m = $get('tanggal_mulai');

                                    if($m){
                                        $s = $state;
                                        $diff = dateDiffCarbon($m, $s, 'month');

                                        $set('durasi', $diff);
                                    }
                                }
                            ),
                        TextInput::make('durasi')
                            ->live()
                            ->hidden(fn ($get) : bool => $get('tipe') == 'masuk' ? true : false)    
                            ->required(),
                        Textarea::make('keluaran')
                            ->columnSpanFull()
                            ->rows(3)
                            ->hidden(fn ($get) : bool => $get('tipe') == 'masuk' ? true : false)
                            ->required(),
                        // ini tampil jika tipe = masuk
                        Repeater::make('daftar_submain')
                            ->label('Daftar Sub Utama Untuk Pemasukan / Pendapatan')
                            ->columnSpanFull()
                            ->collapsible()
                            ->columns(2)
                            ->required()
                            ->live()
                            ->schema([
                                Select::make('kas_id')
                                    ->required()
                                    ->searchable()
                                    ->live()
                                    ->allowHtml()
                                    ->options(
                                        function () : array {
                                            $res = [];
                                            $apbdsm_id = $this->apbdsm_id;

                                            if ($apbdsm_id) {
                                                
                                                $main = APBDDetailSubMain::find($apbdsm_id);
                                                $datas = ParameterKas::query()->where('parent_kode', $main->kas->kode)->where('tipe', 'sub')->get();

                                                foreach ($datas as $d){
                                                    $res[$d->id] = '<span class="font-bold">'.$d->kode.'</span><div class="text-sm">'. $d->nama .'</div>';
                                                }
                                            }

                                            return $res;
                                        }
                                    ),
                                Select::make('kegiatan_id')
                                    ->searchable()
                                    ->live()
                                    ->hidden(fn ($get) : bool => $this->tipe == 'masuk' ? true : false)
                                    ->allowHtml()
                                    ->options(
                                        function () : array {
                                            $res = [];
                                            
                                            if($this->bidang_id){
                                                $bidang = ParameterBidang::find($this->bidang_id);
                                                $datas = ParameterKegiatan::query()->where('kode', $bidang->kode)->get();

                                                foreach ($datas as $d){
                                                    $res[$d->id] = '<span class="font-bold">'.$d->kode.'</span><div class="text-sm">'. $d->uraian_output .'</div>';
                                                }
                                            }

                                            return $res;
                                        }
                                    )
                            ]),
                    ])
            ])
            ->action(
                function ($data) {
                    try {
                        $apbd_id = $this->record->id;

                        // dd($data);

                        $sm = APBDDetailSubMain::find($data['apbdsm_id']);

                        if($data['tipe'] == 'masuk'){
                            $check = APBDRincianUtama::where('apbd_id', $apbd_id)
                                ->where('apbdm_id', $sm->apbdm_id)
                                ->where('apbdsm_id', $data['apbdsm_id'])
                                ->where('kas_id', $sm->parameter_kas_id)
                                ->where('tipe', $data['tipe'])
                                ->first();
                        } else {
                            $check = APBDRincianUtama::where('apbd_id', $apbd_id)
                            ->where('apbdm_id', $sm->apbdm_id)
                            ->where('apbdsm_id', $data['apbdsm_id'])
                            ->where('kas_id', $sm->parameter_kas_id)
                            ->where('tipe', $data['tipe'])
                            ->where('bidang_id', $data['bidang_id'])
                            ->first();
                        }

                        if($check){
                            $detail = $check;
                        } else {
                            $inputs = [];
                            if($data['tipe'] == 'masuk'){
                                $inputs = [
                                    'apbd_id' => $apbd_id,
                                    'apbdm_id' => $sm->apbdm_id,
                                    'apbdsm_id' => $data['apbdsm_id'],
                                    'kas_id' => $sm->parameter_kas_id,
                                    'tipe' => $data['tipe'],
                                ];
                            } else {
                                $inputs = [
                                    'apbd_id' => $apbd_id,
                                    'apbdm_id' => $sm->apbdm_id,
                                    'apbdsm_id' => $data['apbdsm_id'],
                                    'kas_id' => $sm->parameter_kas_id,
                                    'tipe' => $data['tipe'],
                                    'bidang_id' => $data['bidang_id'],
                                    'tanggal_mulai' => $data['tanggal_mulai'],
                                    'tanggal_selesai' => $data['tanggal_selesai'],
                                    'keluaran' => $data['keluaran'],
                                ];
                            }

                            $detail = APBDRincianUtama::create($inputs);
                        }

                        foreach ($data['daftar_submain'] as $dsu){
                            $input_ds = [];

                            if($data['tipe'] == 'masuk'){
                                $input_ds = [
                                    'apbd_id' => $apbd_id,
                                    'apbdru_id' => $detail->id,
                                    'apbdsm_id' => $data['apbdsm_id'],
                                    'kas_id' => $dsu['kas_id'],
                                    'tipe' => $data['tipe'],
                                ];
                            } else {
                                $input_ds = [
                                    'apbd_id' => $apbd_id,
                                    'apbdru_id' => $detail->id,
                                    'apbdsm_id' => $data['apbdsm_id'],
                                    'kas_id' => $dsu['kas_id'],
                                    'tipe' => $data['tipe'],
                                    'kegiatan_id' => $dsu['kegiatan_id'],
                                ];
                            }

                            APBDRincianSubUtama::create($input_ds);
                        }

                        notif('Notifikasi APBDes', 'Detail Telah Berhasil diinputkan.');
                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }

    public function deleteByGroup() : Action {
        return Action::make('deleteByGroup')
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    try {
                        $d = getAPBDMain($arguments['id']);

                        foreach($d->apbdru as $ricu){
                            $ricu->delete();
                        }
                        
                        notif('Notifikasi APBDes', 'Grup Rincian telah berhasil dihapus');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function deleteRincianUtama() : Action {
        return Action::make('deleteRincianUtama')
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    try {
                        $d = APBDRincianUtama::find($arguments['id']);

                        if($d){
                            $d->delete();
                        }

                        notif('Notifikasi APBDes', 'Rincian Sub Utama telah berhasil dihapus');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function deleteRincianSubUtama() : Action {
        return Action::make('deleteRincianSubUtama')
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    try {
                        $d = APBDRincianSubUtama::find($arguments['id']);

                        if($d){
                            $d->delete();
                        }

                        notif('Notifikasi APBDes', 'Rincian Sub Utama telah berhasil dihapus');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    // Aksi Tambah Sub Child And Child Detail
    public function tambahRincianDetail() : Action {
        return Action::make('tambahRincianDetail')
            ->modalWidth('9xl')
            ->closeModalByClickingAway(false)
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('kas_id')
                            ->searchable()
                            ->allowHtml()
                            ->required()
                            ->label('Kaitkan pada Parameter Kas')
                            ->options(
                                function ($livewire) {
                                    $res = [];

                                    $arguments = $livewire->mountedActions[0]['arguments'];
                                    $rsu_id = $arguments['rsu_id'];

                                    $rsu = APBDRincianSubUtama::find($rsu_id);
                                    $datas = ParameterKas::where('parent_kode', $rsu->kas->kode)->get();

                                    foreach($datas as $data){
                                        $res[$data->id] = '<span class="font-bold">'.$data->kode.'</span><div class="text-sm">'. $data->nama .'</div>'; 
                                    }

                                    return $res;
                                }
                            ),
                        Select::make('sumber_id')
                            ->required()
                            ->searchable()
                            ->allowHtml()
                            ->live()
                            ->options(
                                function () {
                                    $res = [];

                                    $datas = ParameterSumberDana::all();

                                    foreach ($datas as $data){
                                        $res[$data->id] = '<span class="font-bold">'.$data->kode.'</span><div class="text-sm">'. $data->nama .'</div>'; 
                                    }

                                    return $res;
                                }
                            ),
                        Section::make('Informasi Saldo Pendapatan')
                            ->columns(2)
                            ->visible(fn ($get) => $get('sumber_id') ? true : false)
                            ->schema([
                                TextEntry::make('saldo_semula')
                                    ->money('idr')
                                    ->default(fn ($get) => $get('sumber_id') ? getSisaSumSumber($get('sumber_id'), $this->record->id) : ''),
                                TextEntry::make('saldo_menjadi')
                                    ->money('idr')
                                    ->default(fn ($get) => $get('sumber_id') ? getSisaSumSumber($get('sumber_id'), $this->record->id, 'menjadi_total') : ''),
                            ]),
                        Repeater::make('details')
                            ->collapsible()
                            ->columnSpanFull()
                            ->grid(2)
                            ->schema([
                                Grid::make('3')
                                    ->schema([
                                        TextInput::make('judul')
                                            ->columnSpan(3)
                                            ->required(),
                                        // Detail Semual
                                        TextInput::make('volume_semula')
                                            ->placeholder('1 Tahun')
                                            ->live(debounce:3)
                                            ->afterStateUpdated(fn ($set, $state) => $set('volume_menjadi', $state))
                                            ->required(),
                                        TextInput::make('semula_satuan')
                                            ->required()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->live()
                                            ->stripCharacters(',')
                                            ->afterStateUpdated(
                                                function ($state, $get, $set) {
                                                    $volume = explode(' ', $get('volume_semula'))[0];
                                                    $satuan = $state;
                                                    $total = $satuan * $volume;

                                                    $set('semula_total', $total);
                                                    $set('menjadi_satuan', $state);
                                                }
                                            ),
                                        TextInput::make('semula_total')
                                            ->live()
                                            ->required()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(','),

                                        // Detail Menjadi
                                        TextInput::make('volume_menjadi')
                                            ->placeholder('1 Tahun')
                                            ->required(),
                                        TextInput::make('menjadi_satuan')
                                            ->required()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->live()
                                            ->stripCharacters(',')
                                            ->afterStateUpdated(
                                                function ($state, $get, $set) {
                                                    $volume = explode(' ', $get('volume_menjadi'))[0];
                                                    $satuan = $state;
                                                    $total = $satuan * $volume;

                                                    $set('menjadi_total', $total);
                                                }
                                            ),
                                        TextInput::make('menjadi_total')
                                            ->live()
                                            ->required()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(','),
                                    ])
                            ])->itemLabel(fn (array $state): ?string => $state['judul'] ?? null),
                    ])
                
            ])
            ->action(
                function ($arguments, $data) {
                    try {
                        $apbd_id = $this->record->id;
                        $apbdsu_id = $arguments['rsu_id'];

                        $apbdsu = APBDRincianSubUtama::find($apbdsu_id);

                        $check_apbdsc = APBDRicianSubChild::where('apbd_id', $apbd_id)
                            ->where('apbdsu_id', $apbdsu_id)
                            ->where('kas_id', $data['kas_id'])
                            ->first();

                        // simpan ke sub child dulu
                        if($check_apbdsc){
                            $apbdsc = $check_apbdsc;
                        } else {
                            $apbdsc = APBDRicianSubChild::create([
                                'apbd_id' => $apbd_id,
                                'apbdsu_id' => $apbdsu_id,
                                'kas_id' => $data['kas_id'],
                            ]);
                        }

                        // simpan child detail
                        $apbdsc_id = $apbdsc->id;
                        $apbdru_id = $apbdsc->apbdsu->apbdru->id; 
                        $apbdrsu_id = $apbdsc->apbdsu->id; 

                        $saldo_semula = getSisaSumSumber($data['sumber_id'], $apbd_id);
                        $saldo_menjadi = getSisaSumSumber($data['sumber_id'], $apbd_id, 'menjadi_total');
                        $current_s = $saldo_semula;
                        $current_m = $saldo_menjadi;

                        foreach($data['details'] as $d){
                            $vss = explode(' ', $d['volume_semula']);
                            $svolume = $vss[0];
                            $sindikator = $vss[1];

                            $vsm = explode(' ', $d['volume_menjadi']);
                            $mvolume = $vsm[0];
                            $mindikator = $vsm[1];

                            if ($d['semula_total'] <= $current_s){
                                $current_s -= $d['semula_total'];

                                if($d['semula_total'] <= $current_s) {
                                    $current_m -= $d['menjadi_total'];

                                    APBDRicianChildDetail::create([
                                        'apbd_id' => $apbd_id,
                                        'apbdsc_id' => $apbdsc_id,
                                        'apbdru_id' => $apbdru_id,
                                        'kas_id' => $data['kas_id'],
                                        'apbdrsu_id' => $apbdrsu_id,

                                        'judul' => $d['judul'],

                                        'semula_volume' => $svolume,
                                        'semula_satuan' => $d['semula_satuan'],
                                        'semula_indikator' => $sindikator,
                                        'semula_total' => $d['semula_total'],

                                        'menjadi_volume' => $mvolume,
                                        'menjadi_satuan' => $d['menjadi_satuan'],
                                        'menjadi_indikator' => $mindikator,
                                        'menjadi_total' => $d['menjadi_total'],

                                        'sumber_id' => $data['sumber_id'],
                                        'tipe' => $apbdsu->tipe,
                                    ]);
                                } else {
                                    notif('Notifikasi Rincian', 'Saldo sumber dana menjadi tidak mencukupi.');
                                    return;
                                }

                            } else {
                                notif('Notifikasi Rincian', 'Saldo sumber dana semula tidak mencukupi.');
                                return;
                            }


                        }

                        notif('Notifikasi Rincian APBD', 'Detail pada rincian APBD telah berhasil dibentuk.');

                    } catch (Exception $e) {
                        dd($e);
                        notif();
                    }
                }
            );
    }

    public function deleteRincianSubChild() : Action {
        return Action::make('deleteRincianSubChild')
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    try {
                        $d = APBDRicianSubChild::find($arguments['id']);

                        if($d){
                            $d->delete();
                        }

                        notif('Notifikasi APBDes', 'Rincian Sub Child telah berhasil dihapus');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function deleteRincianDetail() : Action {
        return Action::make('deleteRincianDetail')
            ->requiresConfirmation()
            ->action(
                function ($arguments) {
                    try {
                        $d = APBDRicianChildDetail::find($arguments['id']);

                        if($d){
                            $d->delete();
                        }

                        notif('Notifikasi APBDes', 'Rincian Child Detail telah berhasil dihapus');
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }
    
}
