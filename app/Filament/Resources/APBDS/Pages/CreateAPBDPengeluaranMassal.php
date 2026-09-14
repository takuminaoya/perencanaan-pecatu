<?php

namespace App\Filament\Resources\APBDS\Pages;

use App\Filament\Resources\APBDS\APBDResource;
use App\Models\APBDKasFlow;
use App\Models\MasterJabatan;
use App\Models\ParameterBidang;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use App\Models\ParameterStandarSatuanHarga;
use App\Models\ParameterSumberDana;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\FusedGroup;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CreateAPBDPengeluaranMassal extends Page
{
    use InteractsWithRecord;

    protected static string $resource = APBDResource::class;

    protected string $view = 'filament.resources.a-p-b-d-s.pages.create-a-p-b-d-pengeluaran-massal';

    // Utama
    public mixed $sub_ssutama_id;
    public mixed $tipe = 'keluar';
    public mixed $utama_id;
    public mixed $sub_utama_id;
    public mixed $sub_sutama_id;
    public mixed $sumber_id;

    public mixed $tanggal_mulai;
    public mixed $tanggal_selesai;
    public mixed $pelaksana_id;
    public mixed $keluaran;


    // repeatable
    public mixed $contents = [];
 
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function form(Schema $schema) : Schema {
        return $schema
            ->components([
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
                    Hidden::make('tipe')
                        ->default('masuk'),
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

                // Repeatable inputs
                Repeater::make('contents')
                    ->label('Daftar Detail dari pendapatan')
                    ->belowLabel('Isian dari detail pendapatan massal yang akan dibuat, minimal adalah satu untuk menambahkan silahkan tekan tombol tamahkan.')
                    ->columnSpanFull()
                    ->grid(1)
                    ->live(onBlur:true)
                    ->minItems(1)
                    ->defaultItems(1)
                    ->collapsible()
                    ->cloneable()
                    ->itemLabel(fn (array $state): ?string => $state['judul'] ?? null)
                    ->schema([
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

                        ])
                        ->live()
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
                                ->live(onBlur:true)
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
                        ])
                        ->columns(2)
                    ]),

                // Global Pengeluaran
                // muncul di semua tipe
                Select::make('sumber_id')
                    ->label('Sumber Dana')
                    ->required()
                    ->searchable()
                    ->options(ParameterSumberDana::query()->pluck('kode', 'id')),
                
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
                ->columns(3)
                ->columnSpanFull()
            ]);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $inputs = [];
        
        try {
            // dd($this->record);
            if(count($data['contents']) > 0) {
                foreach($data['contents'] as $d){
                    $inputs = [
                        // corenya
                        'apbd_id' => $this->record->id,
                        'sub_ssutama_id' => $data['sub_ssutama_id'],
                        'tipe' => $data['tipe'],
                        'utama_id' => $data['utama_id'],
                        'sub_utama_id' => $data['sub_utama_id'],
                        'sub_sutama_id' => $data['sub_sutama_id'],
                        'dibuat_oleh' => whois()->id,

                        // loopnya
                        'judul' => $d['judul'],
                        'volume' => $d['volume'],
                        'indikator_volume' => $d['indikator_volume'],
                        'satuan' => $d['satuan'],
                        'jumlah' => $d['jumlah'],
                        'sumber_id' => $data['sumber_id'],
                        'tanggal_mulai' => $data['tanggal_mulai'],
                        'tanggal_selesai' => $data['tanggal_selesai'],
                        'pelaksana_id' => $data['pelaksana_id'],
                        'keluaran' => $data['keluaran'],

                        // kegiatan
                        'kegiatan_id' => $d['kegiatan_id'],
                        'sub_bidang_id' => $d['sub_bidang_id'],
                        'bidang_id' => $d['bidang_id'],
                        'sub_kegiatan_id' => $d['sub_kegiatan_id'],

                    ];

                    // dd($data);

                    if (array_key_exists('detail_paket', $d)){
                        $inputs['detail_paket'] = $d['detail_paket'];
                    }

                    APBDKasFlow::create($inputs);
                }

                notif('Notifikasi Sistem', 'Pengeluaran Masal telah disimpan.', Heroicon::CheckBadge);
            }
        } catch (Exception $e) {
            dd($e);
            notif();
        }
    }
}
