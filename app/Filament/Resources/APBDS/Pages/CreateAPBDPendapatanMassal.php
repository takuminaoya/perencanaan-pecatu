<?php

namespace App\Filament\Resources\APBDS\Pages;

use App\Filament\Resources\APBDS\APBDResource;
use App\Models\APBDKasFlow;
use App\Models\ParameterKas;
use App\Models\ParameterSumberDana;
use Exception;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
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
use Illuminate\Support\Facades\DB;

class CreateAPBDPendapatanMassal extends Page
{
    use InteractsWithRecord;

    protected static string $resource = APBDResource::class;

    protected string $view = 'filament.resources.a-p-b-d-s.pages.create-a-p-b-d-pendapatan-massal';

    // Utama
    public mixed $sub_ssutama_id;
    public mixed $tipe = 'masuk';
    public mixed $utama_id;
    public mixed $sub_utama_id;
    public mixed $sub_sutama_id;
    public mixed $sumber_id;

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

                // Repeatable inputs
                Repeater::make('contents')
                    ->label('Daftar Detail dari pendapatan')
                    ->belowLabel('Isian dari detail pendapatan massal yang akan dibuat, minimal adalah satu untuk menambahkan silahkan tekan tombol tamahkan.')
                    ->columnSpanFull()
                    ->grid(3)
                    ->live(onBlur:true)
                    ->minItems(1)
                    ->defaultItems(1)
                    ->collapsible()
                    ->cloneable()
                    ->itemLabel(fn (array $state): ?string => $state['judul'] ?? null)
                    ->schema([
                        /**
                         * Bagian pengeluaran dan pendapatan
                         * dimana ini muncul hanya pada saat tipe RAB adalah belanja maupun keluar
                         */
                        Group::make([
                            Textarea::make('judul')
                                ->rows(2)
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
                            // muncul di semua tipe
                            Select::make('sumber_id')
                                ->label('Sumber Dana')
                                ->required()
                                ->searchable()
                                ->options(ParameterSumberDana::query()->pluck('kode', 'id')),
                                ])
                    ]),
            ]);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $inputs = [];
        
        try {
            if(count($data['contents']) > 0) {
                foreach($data['contents'] as $d){
                    $inputs[] = [
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
                        'sumber_id' => $d['sumber_id'],
                    ];
                }

                APBDKasFlow::insert($inputs);

                $this->form->fill();

                notif('Notifikasi Sistem', 'Pendapatan Masal telah disimpan.', Heroicon::CheckBadge);
            }
        } catch (Exception $e) {
            dd($e);
            notif();
        }
    }
}
