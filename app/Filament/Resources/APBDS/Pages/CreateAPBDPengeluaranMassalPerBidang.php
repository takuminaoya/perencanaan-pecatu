<?php

namespace App\Filament\Resources\APBDS\Pages;

use App\Filament\Resources\APBDS\APBDResource;
use App\Models\APBDKasFlow;
use App\Models\MasterJabatan;
use App\Models\ParameterBidang;
use App\Models\ParameterGroupBidang;
use App\Models\ParameterKas;
use App\Models\ParameterKegiatan;
use App\Models\ParameterStandarSatuanHarga;
use App\Models\ParameterSumberDana;
use Carbon\Carbon;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\FusedGroup;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\DB;

class CreateAPBDPengeluaranMassalPerBidang extends Page
{
    use InteractsWithRecord;

    protected static string $resource = APBDResource::class;

    protected string $view = 'filament.resources.a-p-b-d-s.pages.create-a-p-b-d-pengeluaran-massal-per-bidang';

    public mixed $sub_kegiatan_id, $bidang_id, $sub_bidang_id, $kegiatan_id, $group_id, $sub_kegiatan_nama;
    public mixed $tanggal_mulai, $tanggal_selesai, $sumber_id, $pelaksana_id, $keluaran; 

    public array $contents;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function form(Schema $schema) : Schema {
        return $schema
            ->components([
                Select::make('kegiatan_id')
                    ->required()
                    ->label('Kaitkan Pengeluaran dengan Sub Kegiatan yang ada.')
                    ->belowContent('Pilihan ini bersifat optional. namun ini harus diisi jika belanja/pengeluaran bukan berjenis pembiayaan')
                    ->searchable()
                    ->allowHtml()
                    ->live(onBlur:true)
                    ->options(
                        function () {
                            $res = [];

                            $datas = ParameterBidang::where('tipe', 'child')->get();
                            foreach($datas as $data){
                                // $res[$data->id] = '<span class="font-bold">'.$data->kode_singkat.'</span><div class="text-sm">'. $data->uraian_output .'</div>';
                                $sub = $data->getParent();
                                $main = $sub->getParent();

                                $res[$data->id] = '<div class="text-sm font-extrabold">'.$main->kode.' '. $main->nama .'</div>
                                <div class="text-sm font-bold">'.$sub->kode.' '. $sub->nama .'</div>
                                <div class="text-sm font-light">'.$data->kode.' '. $data->nama .'</div>'; 
                            }

                            return $res;
                        }
                    )
                    ->afterStateUpdated(
                        function ($state, $set) {
                            $data = ParameterBidang::find($state);

                            $sub = $data->getParent();
                            $bidang = $sub->getParent();

                            $set('sub_bidang_id', $sub->id);
                            $set('bidang_id', $bidang->id);
                        }
                    ),

                Select::make('group_id')
                    ->required()
                    ->label('Sub Dari Kegiatan')
                    ->belowContent('Pilihan ini tidak bersifat optional. Detail ini dapat ditemukan pada dokumen penginputan bidang di bagian sub kegiatan. jika tidak ada silahkan tambahkan dengan menggunakan tombol +')
                    ->searchable()
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->required()
                    ])
                    ->createOptionUsing(
                        function ($data) {
                            $check = ParameterGroupBidang::where('nama', 'like', '%'.$data['nama'].'%')->first();
                            if(!$check){
                                $res = ParameterGroupBidang::create($data);
                                return $res->id;
                            }
                        }
                    )
                    ->options(ParameterGroupBidang::query()->pluck('nama', 'id')),

                Hidden::make('sub_kegiatan_nama'),
                Hidden::make('bidang_id'),
                Hidden::make('sub_bidang_id'),
                
                // keliatan jika kegiatan diatas ada
                Group::make([
                    FusedGroup::make([
                        DatePicker::make('tanggal_mulai')
                            ->placeholder('Tanggal Mulai'),
                        DatePicker::make('tanggal_selesai')
                            ->placeholder('Tanggal Selesai'),
                    ])
                    ->columns(2)
                    ->label('Durasi'),

                    Select::make('pelaksana_id')
                        ->label('Tim / Pelaksana')
                        ->searchable()
                        ->options(MasterJabatan::query()->pluck('nama', 'id')),

                    TextEntry::make('duration')
                        ->live(onBlur:true)
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
                ->live(onBlur:true)
                ->visible(fn ($get) => $get('kegiatan_id') ? true : false)
                ->columns(3),

                Repeater::make('contents')
                    ->label('Daftar Detail dari pengeluaran')
                    ->belowLabel('Isian dari detail pengeluaran massal yang akan dibuat, minimal adalah satu untuk menambahkan silahkan tekan tombol tamahkan.')
                    ->columnSpanFull()
                    ->grid(1)
                    ->minItems(1)
                    ->defaultItems(1)
                    ->columns(2)
                    ->collapsible()
                    ->cloneable()
                    ->itemLabel(fn (array $state): ?string => $state['judul'] ?? null)
                    ->visible(fn ($get) => $get('kegiatan_id') ? true : false)
                    ->schema([
                        Select::make('sub_ssutama_id')
                            ->label('Kaitkan dengan Parameter Kas')
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
                        Select::make('sub_kegiatan_id')
                            ->label('Kaitkan Pengeluaran dengan Sub Kegiatan yang ada.')
                            ->searchable()
                            ->allowHtml()
                            ->options(
                                function ($get, $livewire) {
                                    $res = [];

                                    $kegiatan_id = $livewire->kegiatan_id;
                                    $kegiatan = ParameterBidang::find($kegiatan_id);

                                    $datas = ParameterKegiatan::where('kode', $kegiatan->kode)->get();
                                    foreach($datas as $data){
                                        // $res[$data->id] = '<span class="font-bold">'.$data->kode_singkat.'</span><div class="text-sm">'. $data->uraian_output .'</div>';
                                        $bidang_child = ParameterBidang::where('kode', $data->kode)->first();

                                        $res[$data->id] = '<div class="text-sm font-semibold">'.$bidang_child->kode.' '. $bidang_child->nama .'</div>
                                        <div class="text-sm font-light">'.$data->kode_singkat.' '. $data->uraian_output .'</div>'; 
                                    }

                                    return $res;
                                }
                            ),
                        Hidden::make('tipe')
                            ->default('masuk'),
                        Hidden::make('utama_id')
                            ->nullable(),
                        Hidden::make('sub_utama_id')
                            ->nullable(),
                        Hidden::make('sub_sutama_id')
                            ->nullable(),
                        Group::make([
                            TextInput::make('judul')
                                ->columnSpanFull()
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
                                                ->required()
                                                ->afterStateUpdated(
                                                    function($state, $set, $get) {
                                                        $volume = $state;
                                                        $satuan = $get('detail_satuan');
                                                        $total = $volume * $satuan;

                                                        $set('detail_jumlah', $total);
                                                    }
                                                ),
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
                                            ->required()
                                            ->afterStateUpdated(
                                                function($state, $set, $get) {
                                                    $volume = $get('detail_volume');
                                                    $satuan = $state;
                                                    $total = $volume * $satuan;

                                                    $set('detail_jumlah', $total);
                                                }
                                            ),
                                        TextInput::make('detail_jumlah')
                                            ->required()
                                            ->readOnly()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(','),
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
                            ->live(onBlur:true)
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
                        ->columnSpanFull(),
                        Select::make('sumber_id')
                            ->label('Sumber Dana')
                            ->required()
                            ->searchable()
                            ->options(ParameterSumberDana::query()->pluck('kode', 'id')),
                    ])
            ]);
        }

    public function create(): void
    {
        $data = $this->form->getState();
        $inputs = [];

        // dd($data);
        
        try {
            if(count($data['contents']) > 0) {
                foreach($data['contents'] as $d){
                    $inputs = [
                        // corenya
                        'apbd_id' => $this->record->id,
                        'sub_ssutama_id' => $d['sub_ssutama_id'],
                        'tipe' => 'keluar',
                        'utama_id' => $d['utama_id'],
                        'sub_utama_id' => $d['sub_utama_id'],
                        'sub_sutama_id' => $d['sub_sutama_id'],
                        'dibuat_oleh' => whois()->id,

                        // loopnya
                        'judul' => $d['judul'],
                        'volume' => $d['volume'],
                        'indikator_volume' => $d['indikator_volume'],
                        'satuan' => $d['satuan'],
                        'jumlah' => $d['jumlah'],
                        'sumber_id' => $d['sumber_id'],
                        'tanggal_mulai' => $data['tanggal_mulai'],
                        'tanggal_selesai' => $data['tanggal_selesai'],
                        'pelaksana_id' => $data['pelaksana_id'],
                        'keluaran' => $data['keluaran'],

                        // kegiatan
                        'kegiatan_id' => $data['kegiatan_id'],
                        'sub_bidang_id' => $data['sub_bidang_id'],
                        'bidang_id' => $data['bidang_id'],
                        'sub_kegiatan_id' => $d['sub_kegiatan_id'],
                        'group_id' => $data['group_id'],
                        'sub_kegiatan_nama' => $data['sub_kegiatan_nama'],

                    ];

                    $this->form->fill();

                    if (array_key_exists('detail_paket', $d)){
                        $inputs['detail_paket'] = $d['detail_paket'];
                    }

                    APBDKasFlow::create($inputs);
                }
            }
                
            notif('Notifikasi Sistem', 'Pengeluaran Masal telah disimpan.', Heroicon::CheckBadge);
        } catch (Exception $e) {
            dd($e);
            notif();
        }
    }
}
