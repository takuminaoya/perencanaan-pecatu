<?php

namespace App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages;

use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\AnggaranPendapatanBelanjaDesaResource;
use App\Models\APBDDetailMain;
use App\Models\APBDDetailSub;
use App\Models\APBDDetailSubMain;
use App\Models\APBDRincianSubUtama;
use App\Models\APBDRincianUtama;
use App\Models\ParameterBidang;
use App\Models\ParameterKas;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                            ->default('masuk'),
                        // ini tampil jika tipe = masuk
                        Repeater::make('daftar_submain')
                            ->label('Daftar Sub Utama Untuk Pemasukan / Pendapatan')
                            ->columnSpanFull()
                            ->hidden(fn ($get) : bool => $get('tipe') == 'masuk' ? false : true)
                            ->collapsible()
                            ->columns(3)
                            ->required()
                            ->live()
                            ->schema([
                                Select::make('kas_id')
                                    ->required()
                                    ->searchable()
                                    ->live()
                                    ->allowHtml()
                                    ->columnSpanFull()
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
                                TextInput::make('semula')
                                    ->required()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(','),
                                TextInput::make('menjadi')
                                    ->required()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(','),
                                TextInput::make('sumber_dana')
                                    ->nullable()
                            ]),
                        Select::make('parent_bidang_id')
                            ->required()
                            ->hidden(fn ($get) : bool => $get('tipe') == 'keluar' ? false : true)
                            ->searchable()
                            ->live()
                            ->allowHtml()
                            ->columnSpanFull()
                            ->options(
                                function () : array {
                                    $res = [];

                                    $datas = ParameterBidang::query()->where('tipe', 'sub')->get();

                                    foreach ($datas as $d){
                                        $res[$d->id] = '<span class="font-bold">'.$d->kode.'</span><div class="text-sm">'. $d->nama .'</div>';
                                    }

                                    return $res;
                                }
                            )
                            ->afterStateUpdated(fn ($state) => $this->parent_bidang_id = $state),
                        // ini tampil jika tipe = keluar
                        Repeater::make('daftar_submain')
                            ->label('Daftar Sub Utama Untuk Belanja / Pengeluaran')
                            ->columnSpanFull()
                            ->hidden(fn ($get) : bool => $get('tipe') == 'keluar' ? false : true)
                            ->collapsible()
                            ->columns(3)
                            ->required()
                            ->live()
                            ->schema([
                                Select::make('bidang_id')
                                    ->required()
                                    ->searchable()
                                    ->live()
                                    ->allowHtml()
                                    ->columnSpanFull()
                                    ->options(
                                        function ($get) : array {
                                            $res = [];
                                            $parent_bidang_id = $this->parent_bidang_id;

                                            if ($parent_bidang_id) {
                                                $pk = ParameterBidang::find($parent_bidang_id);
                                                $datas = ParameterBidang::where('parent_kode', $pk->kode)->get();

                                                foreach ($datas as $d){
                                                    $res[$d->id] = '<span class="font-bold">'.$d->kode.'</span><div class="text-sm">'. $d->nama .'</div>';
                                                }
                                            }

                                            return $res;
                                        }
                                    ),
                                TextInput::make('semula')
                                    ->required()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(','),
                                TextInput::make('menjadi')
                                    ->required()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(','),
                                TextInput::make('sumber_dana')
                                    ->nullable()
                            ]),
                    ])
            ])
            ->action(
                function ($data) {
                    try {
                        $apbd_id = $this->record->id;

                        // dd($data);

                        if($data['tipe'] == 'masuk'){
                            $sm = APBDDetailSubMain::find($data['apbdsm_id']);

                            $check = APBDRincianUtama::where('apbd_id', $apbd_id)
                                ->where('apbdm_id', $sm->apbdm_id)
                                ->where('apbdsm_id', $data['apbdsm_id'])
                                ->where('kas_id', $sm->parameter_kas_id)
                                ->where('tipe', $data['tipe'])
                                ->first();

                            if($check){
                                $detail = $check;
                            } else {
                                $detail = APBDRincianUtama::create([
                                    'apbd_id' => $apbd_id,
                                    'apbdm_id' => $sm->apbdm_id,
                                    'apbdsm_id' => $data['apbdsm_id'],
                                    'kas_id' => $sm->parameter_kas_id,
                                    'tipe' => $data['tipe'],
                                ]);
                            }

                            foreach ($data['daftar_submain'] as $dsu){
                                APBDRincianSubUtama::create([
                                    'apbd_id' => $apbd_id,
                                    'apbdru_id' => $detail->id,
                                    'apbdsm_id' => $data['apbdsm_id'],
                                    'kas_id' => $dsu['kas_id'],
                                    'semula' => $dsu['semula'],
                                    'menjadi' => $dsu['menjadi'],
                                    'sumber_dana' => $dsu['sumber_dana'],
                                ]);
                            }
                        }

                        if($data['tipe'] == 'keluar'){
                            $sm = APBDDetailSubMain::find($data['apbdsm_id']);

                            $check = APBDRincianUtama::where('apbd_id', $apbd_id)
                                ->where('apbdm_id', $sm->apbdm_id)
                                ->where('apbdsm_id', $data['apbdsm_id'])
                                ->where('kas_id', $sm->parameter_kas_id)
                                ->where('tipe', $data['tipe'])
                                ->first();

                            if($check){
                                $detail = $check;
                            } else {
                                $detail = APBDRincianUtama::create([
                                    'apbd_id' => $apbd_id,
                                    'apbdm_id' => $sm->apbdm_id,
                                    'apbdsm_id' => $data['apbdsm_id'],
                                    'kas_id' => $sm->parameter_kas_id,
                                    'tipe' => $data['tipe'],
                                ]);
                            }

                            foreach ($data['daftar_submain'] as $dsu){
                                APBDRincianSubUtama::create([
                                    'apbd_id' => $apbd_id,
                                    'apbdru_id' => $detail->id,
                                    'apbdsm_id' => $data['apbdsm_id'],

                                    'parent_bidang_id' => $data['parent_bidang_id'],
                                    'bidang_id' => $dsu['bidang_id'],
                                    'semula' => $dsu['semula'],
                                    'menjadi' => $dsu['menjadi'],
                                    'sumber_dana' => $dsu['sumber_dana'],
                                ]);
                            }
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
    
}
