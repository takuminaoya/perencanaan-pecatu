<?php

namespace App\Filament\Resources\APBDS\RelationManagers;

use App\Enum\TipeKasFlow;
use App\Models\APBDPerubahan;
use App\Models\APBDPerubahanKasFlow;
use App\Models\MasterJabatan;
use App\Models\ParameterBidang;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use App\Models\ParameterStandarSatuanHarga;
use App\Models\ParameterSumberDana;
use BackedEnum;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\FusedGroup;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KasFlowsRelationManager extends RelationManager
{
    protected static string $relationship = 'kasFlows';
    protected static ?string $title = 'Kas Flow APBD';
    protected static string|BackedEnum|null $icon = Heroicon::DocumentChartBar;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                /**
                 * Bagian utama
                 * data yang harus diisi sebelum mengisi dibawahnya
                 */
                Group::make([
                    Select::make('sub_ssutama_id')
                        ->label('Kaitkan dengan Parameter Kas')
                        ->columnSpanFull()
                        ->searchable()
                        ->required()
                        ->allowHtml()
                        ->options(
                            function () {
                                $res = [];
                                
                                $params = ParameterKas::query()->where('tipe', 'child')->get();

                                foreach ($params as $p) {
                                    $sub = $p->getParent();
                                    $sbmain = $sub->getParent();
                                    $main = $sbmain->getParent();
                                    
                                    $res[$p->id] = '<div class="text-sm font-extrabold">'.$main->kode.' '. $main->nama .'</div>
                                    <div class="text-sm font-bold">'.$sbmain->kode.' '. $sbmain->nama .'</div>
                                    <div class="text-sm font-semibold">'.$sub->kode.' '. $sub->nama .'</div>
                                    <div class="text-sm font-light">'.$p->kode.' '. $p->nama .'</div>'; 
                                }

                                return $res;
                            }
                        )
                        ->live()
                        ->afterStateUpdated(
                            function ($state, $set) {
                                $data = ParameterKas::find($state);

                                $ssu = $data->getParent();
                                $su = $ssu->getParent();
                                $u = $su->getParent();

                                $set('utama_id', $u->id);
                                $set('sub_utama_id', $su->id);
                                $set('sub_sutama_id', $ssu->id);
                                $set('judul', $data->nama);
                            }
                        ),
                    Select::make('tipe')
                        ->live()
                        ->required()
                        ->default('masuk')
                        ->options(TipeKasFlow::class),
                    Section::make('Detail Parameter Kas yang Dipilih')
                        ->description('Informasi berdasarkan kparameter kas yang dipilih diatas')
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextEntry::make('pku')
                                        ->live()
                                        ->default(
                                            function ($get) {
                                                $kas_id = $get('sub_ssutama_id');
                                                $res = getFamilyKas($kas_id);

                                                return $res[4]['kode'] . ' ' . $res[4]['nama'];
                                            }
                                        )
                                        ->label('Parameter Kas Utama'),
                                    TextEntry::make('pksu')
                                        ->live()
                                        ->default(
                                            function ($get) {
                                                $kas_id = $get('sub_ssutama_id');
                                                $res = getFamilyKas($kas_id);

                                                return $res[3]['kode'] . ' ' . $res[3]['nama'];
                                            }
                                        )
                                        ->label('Parameter Kas Sub Utama'),
                                    TextEntry::make('pkssu')
                                        ->live()
                                        ->default(
                                            function ($get) {
                                                $kas_id = $get('sub_ssutama_id');
                                                $res = getFamilyKas($kas_id);

                                                return $res[2]['kode'] . ' ' . $res[2]['nama'];
                                            }
                                        )
                                        ->label('Parameter Kas Sub S. Utama'),
                                    TextEntry::make('pksssu')
                                        ->live()
                                        ->default(
                                            function ($get) {
                                                $kas_id = $get('sub_ssutama_id');
                                                $res = getFamilyKas($kas_id);

                                                return $res[1]['kode'] . ' ' . $res[1]['nama'];
                                            }
                                        )
                                        ->label('Parameter Kas Sub S. S. Utama'),
                                ])
                        ])
                        ->visible(fn ($get) => $get('sub_ssutama_id') ? true : false),
                    Hidden::make('utama_id')
                        ->live()
                        ->nullable(),
                    Hidden::make('sub_utama_id')
                        ->live()
                        ->nullable(),
                    Hidden::make('sub_sutama_id')
                        ->live()
                        ->nullable(),
                ])
                ->columnSpanFull()
                ->columns(2),
                

                /**
                 * Bagian pengeluaran
                 * dimana ini muncul hanya pada saat tipe RAB adalah pengeluaran atau belanja
                 */
                Group::make([
                    Select::make('sub_kegiatan_id')
                        ->label('Kaitkan Pengeluaran dengan Sub Kegiatan yang ada.')
                        ->belowContent('Pilihan ini bersifat optional. namun ini harus diisi jika belanja/pengeluaran bukan berjenis pembiayaan')
                        ->searchable()
                        ->allowHtml()
                        ->live()
                        ->options(
                            function () {
                                $res = [];

                                $datas = ParameterKegiatan::all();
                                foreach($datas as $data){
                                    // $res[$data->id] = '<span class="font-bold">'.$data->kode_singkat.'</span><div class="text-sm">'. $data->uraian_output .'</div>';
                                    $bidang_child = ParameterBidang::where('kode', $data->kode)->first();
                                    $sub = $bidang_child->getParent();
                                    $main = $sub->getParent();

                                    $res[$data->id] = '<div class="text-sm font-extrabold">'.$main->kode.' '. $main->nama .'</div>
                                    <div class="text-sm font-bold">'.$sub->kode.' '. $sub->nama .'</div>
                                    <div class="text-sm font-semibold">'.$bidang_child->kode.' '. $bidang_child->nama .'</div>
                                    <div class="text-sm font-light">'.$data->kode_singkat.' '. $data->uraian_output .'</div>'; 
                                }

                                return $res;
                            }
                        )
                        ->afterStateUpdated(
                            function ($state, $set) {
                                $data = getFamilyBidangBySubKegiatan($state);

                                $set('bidang_id', $data[1]['id']);
                                $set('sub_bidang_id', $data[2]['id']);
                                $set('kegiatan_id', $data[3]['id']);
                            }
                        ),

                    Select::make('template_ssh')
                        ->label('Daftar Standar Satuan Harga')
                        ->belowContent('Kosongkan jika tidak menggunakan template, ini hanya digunakan untuk automisasi pengisian data dibawah.')
                        ->columnSpanFull()
                        ->searchable()
                        ->allowHtml()
                        ->options(
                                function () {
                                    $res = [];

                                    $datas = ParameterStandarSatuanHarga::limit(100)->get();

                                    foreach ($datas as $data){
                                        $res[$data->id] = '<span class="font-bold">'.$data->uraian_barang.'</span><div class="text-sm">'. $data->spesifikasi .'</div><div class="text-xs">Rp. '. number_format($data->harga_satuan) .' Per '. $data->satuan .'</div>'; 
                                    }

                                    return $res;
                                }
                            )
                            ->getSearchResultsUsing(
                                function (string $search) : array {
                                    $res = [];

                                    $datas = ParameterStandarSatuanHarga::where('uraian_barang', 'like', "%{$search}%")->limit(100)->get();

                                    foreach ($datas as $data){
                                        $res[$data->id] = '<span class="font-bold">'.$data->uraian_barang.'</span><div class="text-sm">'. $data->spesifikasi .'</div><div class="text-xs">Rp. '. number_format($data->harga_satuan) .' Per '. $data->satuan .'</div>'; 
                                    }

                                    return $res;
                                })
                            ->getOptionLabelUsing(fn ($value): ?string => ParameterStandarSatuanHarga::find($value)?->uraian_barang)
                            ->live()
                            ->afterStateUpdated(
                                function ($state, $set) {
                                    $d = ParameterStandarSatuanHarga::find($state);

                                    if($d){
                                        // dd($d);
                                        
                                        $set('judul', $d->spesifikasi);
                                        $set('volume', 1);
                                        $set('indikator_volume', $d->satuan);
                                        $set('satuan', $d->harga_satuan);
                                        $set('jumlah', $d->harga_satuan);
                                    }
                                }
                            ),
                    
                    Hidden::make('bidang_id')
                        ->live()
                        ->default(fn($get) => $get('sub_kegiatan_id') ? getFamilyBidangBySubKegiatan($get('sub_kegiatan_id'))[1]['id'] : ''),
                    Hidden::make('sub_bidang_id')
                        ->live()
                        ->default(fn($get) => $get('sub_kegiatan_id') ? getFamilyBidangBySubKegiatan($get('sub_kegiatan_id'))[2]['id'] : ''),
                    Hidden::make('kegiatan_id')
                        ->live()
                        ->default(fn($get) => $get('sub_kegiatan_id') ? getFamilyBidangBySubKegiatan($get('sub_kegiatan_id'))[3]['id'] : ''),

                    Section::make('Detail Parameter Kegiatan yang Dipilih')
                        ->description('Informasi berdasarkan parameter kegiatan yang dipilih diatas')
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextEntry::make('bidang')
                                        ->live()
                                        ->default(
                                            function ($get) {
                                                $sub_kegiatan_id = $get('sub_kegiatan_id');
                                                $sk = getFamilyBidangBySubKegiatan($sub_kegiatan_id);

                                                return $sk[1]['kode'] . '  ' . $sk[1]['nama'];
                                            }
                                        )
                                        ->label('Bidang'),
                                    TextEntry::make('sub_bidang')
                                        ->live()
                                        ->default(
                                            function ($get) {
                                                $sub_kegiatan_id = $get('sub_kegiatan_id');
                                                $sk = getFamilyBidangBySubKegiatan($sub_kegiatan_id);

                                                return $sk[2]['kode'] . '  ' . $sk[2]['nama'];
                                            }
                                        )
                                        ->label('Sub Bidang'),
                                    TextEntry::make('kegiatan')
                                        ->live()
                                        ->default(
                                            function ($get) {
                                                $sub_kegiatan_id = $get('sub_kegiatan_id');
                                                $sk = getFamilyBidangBySubKegiatan($sub_kegiatan_id);

                                                return $sk[3]['kode'] . '  ' . $sk[3]['nama'];
                                            }
                                        )
                                        ->label('Kegiatan'),
                                    TextEntry::make('sub_kegiatan')
                                        ->live()
                                        ->default(
                                            function ($get) {
                                                $sub_kegiatan_id = $get('sub_kegiatan_id');
                                                $sk = getFamilyBidangBySubKegiatan($sub_kegiatan_id);

                                                return $sk[4]['kode'] . '  ' . $sk[4]['nama'];
                                            }
                                        )
                                        ->label('Sub Kegiatan'),
                                ])
                        ])
                        ->visible(fn ($get) => $get('sub_kegiatan_id') ? true : false),
                ])
                ->live()
                ->visible(
                    function ($get) {
                        if ($get('tipe') && $get('tipe')->value === 'keluar'){
                            return true;
                        }

                        return false;
                    }
                )
                ->columnSpanFull()
                ->columns(2),
                
                /**
                 * Bagian pengeluaran dan pendapatan
                 * dimana ini muncul hanya pada saat tipe RAB adalah belanja maupun keluar
                 */
                Group::make([
                    TextInput::make('judul')
                        ->required(),
                    FusedGroup::make([
                        TextInput::make('volume')
                            ->placeholder('Jumlah barang/jasa')
                            ->numeric()
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(
                                function($state, $set, $get) {
                                    $volume = $state;
                                    $satuan = $get('satuan');
                                    $total = $volume * $satuan;

                                    $set('jumlah', $total);
                                }
                            )
                            ->required(),
                        Select::make('indikator_volume')
                            ->searchable()
                            ->live()
                            ->options(
                                function () : array {
                                    $res = [];

                                    $indks = DB::table('ep_parameter_standar_satuan_hargas')->select('satuan')->whereNotNull('satuan')->groupBy('satuan')->get();

                                    foreach ($indks as $ind) {
                                        $res[$ind->satuan] = $ind->satuan;
                                    }

                                    $res['Tahun'] = 'Tahun';
                                    $res['Org/Bln'] = 'Org/Bln';

                                    return $res;
                                }
                            )
                            ->required()
                            ->default('Tahun'),
                    ])
                    ->columns(2)
                    ->label('Volume'),

                    /**
                     * Grup dimana jika indikator volume berupa paket
                     * jadi jika berbentuk paket pengguna hrs menambahkan detail rincian isi dari paket tersebut
                     */
                    Group::make([
                        Repeater::make('detail_paket')
                            ->table([
                                TableColumn::make('template'),
                                TableColumn::make('judul'),
                                TableColumn::make('volume'),
                                TableColumn::make('satuan'),
                                TableColumn::make('jumlah'),
                            ])
                            ->schema([
                                Select::make('detail_template_ssh')
                                    ->label('Daftar Standar Satuan Harga')
                                    ->columnSpanFull()
                                    ->searchable()
                                    ->allowHtml()
                                    ->options(
                                            function () {
                                                $res = [];

                                                $datas = ParameterStandarSatuanHarga::limit(100)->get();

                                                foreach ($datas as $data){
                                                    $res[$data->id] = '<span class="font-bold">'.$data->uraian_barang.'</span><div class="text-sm">'. $data->spesifikasi .'</div><div class="text-xs">Rp. '. number_format($data->harga_satuan) .' Per '. $data->satuan .'</div>'; 
                                                }

                                                return $res;
                                            }
                                        )
                                    ->getSearchResultsUsing(
                                        function (string $search) : array {
                                            $res = [];

                                            $datas = ParameterStandarSatuanHarga::where('uraian_barang', 'like', "%{$search}%")->limit(100)->get();

                                            foreach ($datas as $data){
                                                $res[$data->id] = '<span class="font-bold">'.$data->uraian_barang.'</span><div class="text-sm">'. $data->spesifikasi .'</div><div class="text-xs">Rp. '. number_format($data->harga_satuan) .' Per '. $data->satuan .'</div>'; 
                                            }

                                            return $res;
                                        })
                                    ->getOptionLabelUsing(fn ($value): ?string => ParameterStandarSatuanHarga::find($value)?->uraian_barang)
                                    ->live()
                                    ->afterStateUpdated(
                                        function ($state, $set) {
                                            $d = ParameterStandarSatuanHarga::find($state);

                                            if($d){
                                                // dd($d);
                                                
                                                $set('detail_judul', $d->spesifikasi);
                                                $set('detail_volume', 1);
                                                $set('detail_indikator_volume', $d->satuan);
                                                $set('detail_satuan', $d->harga_satuan);
                                                $set('detail_jumlah', $d->harga_satuan);
                                            }
                                        }
                                    ),
                                TextInput::make('detail_judul')
                                    ->required(),
                                FusedGroup::make([
                                    TextInput::make('detail_volume')
                                        ->placeholder('Jumlah barang/jasa')
                                        ->numeric()
                                        ->default(1)
                                        ->live()
                                        ->afterStateUpdated(
                                            function($state, $set, $get) {
                                                $volume = $state;
                                                $satuan = $get('detail_satuan');
                                                $total = $volume * $satuan;

                                                $set('detail_jumlah', $total);
                                            }
                                        )
                                        ->required(),
                                    Select::make('detail_indikator_volume')
                                        ->searchable()
                                        ->options(
                                            function () : array {
                                                $res = [];

                                                $indks = DB::table('ep_parameter_standar_satuan_hargas')->select('satuan')->whereNotNull('satuan')->groupBy('satuan')->get();

                                                foreach ($indks as $ind) {
                                                    $res[$ind->satuan] = $ind->satuan;
                                                }

                                                $res['Tahun'] = 'Tahun';
                                                $res['Org/Bln'] = 'Org/Bln';

                                                return $res;
                                            }
                                        )
                                        ->required()
                                        ->default('Tahun'),
                                ])
                                ->columns(2)
                                ->label('Volume'),
                                TextInput::make('detail_satuan')
                                    ->label('Harga Satuan')
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->default(0)
                                    ->live()
                                    ->afterStateUpdated(
                                        function($state, $set, $get) {
                                            $volume = $get('detail_volume');
                                            $satuan = $state;
                                            $total = $volume * $satuan;

                                            $set('detail_jumlah', $total);
                                        }
                                    )
                                    ->required(),
                                TextInput::make('detail_jumlah')
                                    ->required()
                                    ->readOnly()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->default(0),
                            ])
                            ->cloneable()
                            ->afterStateUpdated(
                                function ($state, $set) {
                                    $dps = $state;
                                    $total = 0;

                                    foreach($dps as $dp){
                                        $j = str_replace(',', '', $dp['detail_jumlah']);
                                        $total += (int)$j;
                                    }
                                    
                                    $set('satuan', 1);
                                    $set('jumlah', $total);
                                }
                            )
                        ])
                    ->live()
                    ->visible(fn ($get) => $get('indikator_volume') and $get('indikator_volume') == 'Paket' ? true : false)
                    ->columnSpanFull(),

                    TextInput::make('satuan')
                        ->label('Harga Satuan')
                        ->prefix('Rp.')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->default(0)
                        ->live()
                        ->afterStateUpdated(
                            function($state, $set, $get) {
                                $volume = $get('volume');
                                $satuan = $state;
                                $total = $volume * $satuan;

                                if ($get('indikator_volume') != 'Paket'){
                                    $set('jumlah', $total);
                                }
                            }
                        )
                        ->required(),
                    TextInput::make('jumlah')
                        ->required()
                        ->readOnly()
                        ->prefix('Rp.')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->live()
                        ->default(0),

                    // Ini muncul jika tipenya keluar aja
                    Group::make([
                        FusedGroup::make([
                            DatePicker::make('tanggal_mulai')
                                ->placeholder('Tanggal Mulai')
                                ->live()
                                ->default(Carbon::createFromFormat('d/m/Y',  '01/01/' . date('Y')))
                                ->afterStateUpdated(
                                    function ($get, $state, $set) {
                                        $m = $state;
                                        $s = $get('tanggal_selesai');
                                        if($m and $s){
                                            $set('duration', dateDiffCarbon($m, $s, 'month'));
                                        }
                                    }
                                ),
                            DatePicker::make('tanggal_selesai')
                                ->placeholder('Tanggal Selesai')
                                ->live()
                                ->default(Carbon::createFromFormat('d/m/Y',  '01/01/' . date('Y'))->addMonths(11, 31))
                                ->afterStateUpdated(
                                    function ($get, $state, $set) {
                                        $m = $get('tanggal_mulai');
                                        $s = $state;
                                        if($m and $s){
                                            $set('duration', dateDiffCarbon($m, $s, 'month'));
                                        }
                                    }
                                ),
                        ])
                        ->live()  
                        ->columns(2)
                        ->label('Durasi'),

                        Select::make('pelaksana_id')
                            ->label('Tim / Pelaksana')
                            ->searchable()
                            ->options(MasterJabatan::query()->pluck('nama', 'id')),

                        TextEntry::make('duration')
                            ->live()
                            ->badge()
                            ->icon(Heroicon::CalendarDateRange)
                            ->default(
                                function ($get) {
                                    $m = $get('tanggal_mulai');
                                    $s = $get('tanggal_selesai');

                                    if($m and $s){
                                        return dateDiffCarbon($m, $s, 'month');
                                    }
                                }
                            ),
                        
                        TextInput::make('keluaran')
                            ->placeholder('Output/Keluaran')
                            ->columnSpanFull()
                            ->nullable(),
                    ])
                    ->visible(
                        function ($get) {
                            if ($get('tipe') && $get('tipe')->value === 'keluar'){
                                return true;
                            }

                            return false;
                        }
                    )
                    ->columns(2)
                    ->columnSpanFull()
                ])
                ->columns(2)
                ->columnSpanFull(),

                // muncul di semua tipe
                Select::make('sumber_id')
                    ->label('Sumber Dana')
                    ->required()
                    ->searchable()
                    ->options(ParameterSumberDana::query()->pluck('kode', 'id')),

                Hidden::make('dibuat_oleh')
                    ->default(whois()->id)
                
            ]);
    }

    /**
     * Aksi untuk membuat perubahan berdasarkan record kas flow
     */
    public function createPerubahanKasFlow() : Action {
        return Action::make('createPerubahanKasFlow')
            ->modalWidth('8xl')
            ->closeModalByClickingAway(false)
            ->modalHeading('Perubahan')
            ->modalDescription('Proses untuk menambah data perubahan yang terjadi pada setiap kas flow.')
            ->modalIcon(Heroicon::ArrowPathRoundedSquare)
            ->label('Perubahan')
            ->color(Color::Blue)
            ->icon(Heroicon::ArrowRight)
            ->fillForm(
                function ($record) : array {
                    $res = [];

                    $res = [
                        'judul' => $record->judul,
                        'volume' => $record->volume,
                        'indikator_volume' => $record->indikator_volume,
                        'satuan' => $record->satuan,
                        'jumlah' => $record->jumlah,
                        'detail_paket' => $record->detail_paket,
                        'kas_flow_id' => $record->id
                    ];

                    return $res;
                }
            )
            ->schema([
                // Pilih perubahan yang dikaitkan terlebih dahulu
                // jika tidak ada buat baru dengan tanda plus
                Select::make('perubahan_id')
                    ->label('Daftar Perubahan APBD')
                    ->belowContent('Sebelum mengisi data perubahan mohon pilih periode perubahan berdasarkan perubahan yang dibuat pada halaman detail APBD. atau gunakan tanda plus disebelah untuk membuat baru.')
                    ->columnSpanFull()
                    ->allowHtml()
                    ->searchable()
                    ->required()
                    ->live()
                    ->createOptionForm([
                        TextInput::make('judul')
                            ->columnSpanFull()
                            ->required()
                            ->default('Perubahan Anggaran Pendapatan Dan Belanja Desa Pecatu'),
                        DatePicker::make('tanggal_mulai'),
                        DatePicker::make('tanggal_selesai'),
                    ])
                    ->createOptionUsing(
                        function ($data, $record) {
                            $validations = $data;
                            $validations['apbd_id'] = $record->apbd_id;

                            APBDPerubahan::create($validations);

                            notif('Notifikasi Perubahan', 'Penambahan APBD Perubahan telah berhasil dilakukan');
                        }
                    )
                    ->options(
                        function ($livewire) {
                            // dd($livewire);
                            $res = [];

                            $params = $livewire->ownerRecord->perubahans;

                            foreach ($params as $p) {
                                $mulai = toCarbon($p->tanggal_mulai);
                                $selesai = toCarbon($p->tanggal_selesai);
                                $res[$p->id] = '<span class="font-bold">'.$p->judul.'</span><div class="text-sm">'. $mulai .' Hingga '. $selesai .'</div>'; 
                            }

                            return $res;
                        }
                    ),

                /**
                 * Bagian dimana untuk menapilkan detail record awal
                 * agar user dapat membandingkan jumlah awal dan perubahan
                 */
                Section::make('Detail Kas Flow Awal Sebelum perubahan')
                    ->description('Detail input kas awal, sebagai penuntun')
                    ->columns(5)
                    ->schema([
                        TextEntry::make('tjudul')
                            ->label('Judul')
                            ->default(fn ($record) => $record->judul),
                        TextEntry::make('volume_kas')
                            ->label('Volume')
                            ->default(fn ($record) => $record->volume . ' ' .$record->indikator_volume),
                        TextEntry::make('tsatuan')
                            ->label('Satuan')
                            ->default(fn ($record) => $record->satuan)
                            ->numeric(),
                        TextEntry::make('jumlah_keseluruhan')
                            ->label('Jumlah')
                            ->default(fn ($record) => $record->jumlah)
                            ->money('idr'),
                        RepeatableEntry::make('tdetail_paket')
                            ->label('Daftar Isian Dalam Paket')
                            ->state(fn ($record) => $record->detail_paket)
                            ->visible(fn($record) => $record->indikator_volume === 'Paket' ? true : false)
                            ->columnSpanFull()
                            ->grid(3)
                            ->schema([
                                TextEntry::make('detail_judul'),
                                TextEntry::make('detail_volume'),
                                TextEntry::make('detail_indikator_volume'),
                                TextEntry::make('detail_satuan')
                                    ->money('idr'),
                                TextEntry::make('detail_jumlah')
                                    ->money('idr'),
                            ])
                            ->columns(2)
                    ])
                    ->visible(fn ($get) => $get('perubahan_id') ? true : false),

                /**
                 * Bagian pengeluaran dan pendapatan
                 * dimana ini muncul hanya pada saat tipe RAB adalah belanja maupun keluar
                 */
                Group::make([
                    Hidden::make('kas_flow_id'),
                    TextInput::make('judul')
                        ->required(),
                    FusedGroup::make([
                        TextInput::make('volume')
                            ->placeholder('Jumlah barang/jasa')
                            ->numeric()
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(
                                function($state, $set, $get) {
                                    $volume = $state;
                                    $satuan = $get('satuan');
                                    $total = $volume * $satuan;

                                    $set('jumlah', $total);
                                }
                            )
                            ->required(),
                        Select::make('indikator_volume')
                            ->searchable()
                            ->live()
                            ->options(
                                function () : array {
                                    $res = [];

                                    $indks = DB::table('ep_parameter_standar_satuan_hargas')->select('satuan')->whereNotNull('satuan')->groupBy('satuan')->get();

                                    foreach ($indks as $ind) {
                                        $res[$ind->satuan] = $ind->satuan;
                                    }

                                    $res['Tahun'] = 'Tahun';
                                    $res['Org/Bln'] = 'Org/Bln';

                                    return $res;
                                }
                            )
                            ->required()
                            ->default('Tahun'),
                    ])
                    ->columns(2)
                    ->label('Volume'),

                    /**
                     * Grup dimana jika indikator volume berupa paket
                     * jadi jika berbentuk paket pengguna hrs menambahkan detail rincian isi dari paket tersebut
                     */
                    Group::make([
                        Repeater::make('detail_paket')
                            ->addable(false)
                            ->deletable(false)
                            ->table([
                                TableColumn::make('template'),
                                TableColumn::make('judul'),
                                TableColumn::make('volume'),
                                TableColumn::make('satuan'),
                                TableColumn::make('jumlah'),
                            ])
                            ->schema([
                                Select::make('detail_template_ssh')
                                    ->label('Daftar Standar Satuan Harga')
                                    ->columnSpanFull()
                                    ->searchable()
                                    ->allowHtml()
                                    ->options(
                                            function () {
                                                $res = [];

                                                $datas = ParameterStandarSatuanHarga::limit(100)->get();

                                                foreach ($datas as $data){
                                                    $res[$data->id] = '<span class="font-bold">'.$data->uraian_barang.'</span><div class="text-sm">'. $data->spesifikasi .'</div><div class="text-xs">Rp. '. number_format($data->harga_satuan) .' Per '. $data->satuan .'</div>'; 
                                                }

                                                return $res;
                                            }
                                        )
                                    ->getSearchResultsUsing(
                                        function (string $search) : array {
                                            $res = [];

                                            $datas = ParameterStandarSatuanHarga::where('uraian_barang', 'like', "%{$search}%")->limit(100)->get();

                                            foreach ($datas as $data){
                                                $res[$data->id] = '<span class="font-bold">'.$data->uraian_barang.'</span><div class="text-sm">'. $data->spesifikasi .'</div><div class="text-xs">Rp. '. number_format($data->harga_satuan) .' Per '. $data->satuan .'</div>'; 
                                            }

                                            return $res;
                                        })
                                    ->getOptionLabelUsing(fn ($value): ?string => ParameterStandarSatuanHarga::find($value)?->uraian_barang)
                                    ->live()
                                    ->afterStateUpdated(
                                        function ($state, $set) {
                                            $d = ParameterStandarSatuanHarga::find($state);

                                            if($d){
                                                // dd($d);
                                                $set('detail_judul', $d->spesifikasi);
                                                $set('detail_volume', 1);
                                                $set('detail_indikator_volume', $d->satuan);
                                                $set('detail_satuan', $d->harga_satuan);
                                                $set('detail_jumlah', $d->harga_satuan);
                                            }
                                        }
                                    ),
                                Hidden::make('kas_flow_id'),
                                Textarea::make('detail_judul')
                                    ->rows(2)
                                    ->required(),
                                FusedGroup::make([
                                    TextInput::make('detail_volume')
                                        ->placeholder('Jumlah barang/jasa')
                                        ->numeric()
                                        ->default(1)
                                        ->live()
                                        ->afterStateUpdated(
                                            function($state, $set, $get) {
                                                $volume = $state;
                                                $satuan = $get('detail_satuan');
                                                $total = $volume * $satuan;

                                                $set('detail_jumlah', $total);
                                            }
                                        )
                                        ->required(),
                                    Select::make('detail_indikator_volume')
                                        ->searchable()
                                        ->options(
                                            function () : array {
                                                $res = [];

                                                $indks = DB::table('ep_parameter_standar_satuan_hargas')->select('satuan')->whereNotNull('satuan')->groupBy('satuan')->get();

                                                foreach ($indks as $ind) {
                                                    $res[$ind->satuan] = $ind->satuan;
                                                }

                                                $res['Tahun'] = 'Tahun';
                                                $res['Org/Bln'] = 'Org/Bln';

                                                return $res;
                                            }
                                        )
                                        ->required()
                                        ->default('Tahun'),
                                ])
                                ->columns(2)
                                ->label('Volume'),
                                TextInput::make('detail_satuan')
                                    ->label('Harga Satuan')
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->default(0)
                                    ->live()
                                    ->afterStateUpdated(
                                        function($state, $set, $get) {
                                            $volume = $get('detail_volume');
                                            $satuan = $state;
                                            $total = $volume * $satuan;

                                            $set('detail_jumlah', $total);
                                        }
                                    )
                                    ->required(),
                                TextInput::make('detail_jumlah')
                                    ->required()
                                    ->readOnly()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->default(0),
                            ])
                            ->afterStateUpdated(
                                function ($state, $set) {
                                    $dps = $state;
                                    $total = 0;

                                    foreach($dps as $dp){
                                        $j = str_replace(',', '', $dp['detail_jumlah']);
                                        $total += (int)$j;
                                    }
                                    
                                    $set('satuan', 1);
                                    $set('jumlah', $total);
                                }
                            )
                    ])
                    ->live()
                    ->visible(fn ($get) => $get('indikator_volume') and $get('indikator_volume') == 'Paket' ? true : false)
                    ->columnSpanFull(),

                    TextInput::make('satuan')
                        ->label('Harga Satuan')
                        ->prefix('Rp.')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->default(0)
                        ->live()
                        ->required()
                        ->afterStateUpdated(
                            function($state, $set, $get, $record) {
                                $volume = $get('volume');
                                $satuan = $state;
                                $total = $volume * $satuan;

                                if($record->indikator_volume != 'Paket'){
                                    $set('jumlah', $total);
                                }
                            }
                        ),
                    TextInput::make('jumlah')
                        ->required()
                        ->readOnly()
                        ->prefix('Rp.')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->live()
                        ->default(
                            function($record) {
                                return $record->jumlah;
                            }
                        ),

                ])
                ->visible(fn ($get) => $get('perubahan_id') ? true : false)
                ->columns(2)
                ->columnSpanFull(),
            ])
            ->action(
                function ($data, $record) {
                    try {
                        // Cehck jika sudah ada
                        $ck = APBDPerubahanKasFlow::where('kas_flow_id', $record->id)->where('perubahan_id', $data['perubahan_id'])->first();

                        if($ck){
                            $ck->update($data);
                            notif('Notifikasi Perubahan', 'Perubahan pada kas dengan judul ' . $record->judul . ' telah berhasil diperbarui', Heroicon::CheckBadge);
                        } else {
                            APBDPerubahanKasFlow::create($data);
                            notif('Notifikasi Perubahan', 'Perubahan pada kas dengan judul ' . $record->judul . ' telah berhasil dilakukan', Heroicon::CheckBadge);
                        }

                        
                    } catch (Exception $e) {
                        notif();
                    }
                }
            );
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul')
            ->description('Laporan yang menunjukkan pergerakan uang masuk dan uang keluar dalam suatu periode.')
            ->columns([
                TextColumn::make('utama.nama')
                    ->wrap()
                    ->label('Kas Utama')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('subUtama.nama')
                    ->wrap()
                    ->label('Kas Sub Utama')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('subSutama.nama')
                    ->wrap()
                    ->label('Kas Sub S. Utama')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('subSSutama.nama')
                    ->wrap()
                    ->label('Kas Sub S.S. Utama')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                TextColumn::make('judul')
                    ->wrap()
                    ->searchable(),
                ColumnGroup::make('Anggaran', [
                    TextColumn::make('volumes')
                        ->label('Volume')
                        ->default(fn ($record) => $record->volume . ' ' .$record->indikator_volume),
                    TextColumn::make('satuan')
                        ->summarize([
                            Sum::make()
                                ->money('idr')
                        ])
                        ->money('idr'),
                    TextColumn::make('jumlah')
                        ->summarize([
                            Sum::make()
                                ->money('idr')
                        ])
                        ->money('idr')
                        ->sortable(),
                ]),
                
                TextColumn::make('sumberDana.kode')
                    ->label('Sumber')
                    ->badge()
                    ->sortable(),
                TextColumn::make('perubahans.perubahan.judul')
                    ->bulleted()
                    ->action(
                        Action::make('update')
                            ->modalWidth('6xl')
                            ->modalHeading('Daftar Perubahan')
                            ->modalDescription('Disini hanya bisa menghapus recordnya saja. untuk edit silahkan gunakan tombol perubahan dengan memilih perubahan apbd yang sama.')
                            ->closeModalByClickingAway(false)
                            ->schema([
                                RepeatableEntry::make('daftar_perubahan')
                                    ->grid(2)
                                    ->columns(2)
                                    ->state(
                                        function ($record) : array {
                                            $prbhs = $record->perubahans;
                                            $res = [];

                                            foreach($prbhs as $pb){
                                                $res[] = [
                                                    'kas_flow_id' => $pb->id,
                                                    'judul' => $pb->perubahan->judul,
                                                    'kas_flow' => $pb->kas_flow->judul,
                                                    'volume' => $pb->volume,
                                                    'indikator_volume' => $pb->indikator_volume,
                                                    'satuan' => $pb->satuan,
                                                    'jumlah' => $pb->jumlah,
                                                ];
                                            }

                                            return $res;
                                        }
                                    )
                                    ->schema([
                                        TextEntry::make('kas_flow_id')
                                            ->columnSpanFull()
                                            ->label('ID Kas'),
                                        TextEntry::make('judul')
                                            ->columnSpanFull(),
                                        TextEntry::make('kas_flow')
                                            ->columnSpanFull(),
                                        TextEntry::make('volume'),
                                        TextEntry::make('indikator_volume'),
                                        TextEntry::make('satuan')
                                            ->money('idr'),
                                        TextEntry::make('jumlah')
                                            ->money('idr'),
                                        TextEntry::make('Aksi')
                                            ->hiddenLabel(true)
                                            ->belowContent([
                                                Action::make('hapus')
                                                    ->label('Hapus Perubahan')
                                                    ->button()
                                                    ->icon(Heroicon::XMark)
                                                    ->color('danger')
                                                    ->requiresConfirmation()
                                                    ->action(
                                                        function ($get){
                                                            if($get('kas_flow_id')){
                                                                $d = APBDPerubahanKasFlow::find($get('kas_flow_id'));

                                                                $d->delete();
                                                            }
                                                        }
                                                    )
                                            ]),

                                    ]),
                                    
                            ])
                    )
                    ->searchable(),
                TextColumn::make('tipe_kas')
                    ->label('Tipe Kas Flow')
                    ->badge()
                    ->default(fn ($record) => tipeKasFlow($record->tipe))
                    ->color(fn ($record) => tipeKasFlow($record->tipe)->getColor())
                    ->icon(fn ($record) => tipeKasFlow($record->tipe)->getIcon())
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Terkahir Diupdate Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tipe')
                    ->options(TipeKasFlow::class),
                SelectFilter::make('sumber_id')
                    ->options(ParameterSumberDana::query()->pluck('kode','id'))
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalWidth('8xl')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Pembuatan Kas Flow Baru')
                    ->modalDescription('Proses membuat pencatatan arus kas baru, yang mencatat uang masuk dan/atau uang keluar dalam suatu periode.')
                    ->modalIcon(Heroicon::ArrowPathRoundedSquare)
                    ->label('Kas Flow Baru')
                    ->icon(Heroicon::Plus),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('8xl')
                    ->closeModalByClickingAway(false)
                    ->modalHeading('Pembaharuan Kas Flow')
                    ->modalDescription('Proses membuat pencatatan arus kas baru, yang mencatat uang masuk dan/atau uang keluar dalam suatu periode.')
                    ->modalIcon(Heroicon::ArrowPathRoundedSquare),
                $this->createPerubahanKasFlow()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
