<x-filament-panels::page>
    <x-css.rcss />

    <div class="selector-bar__inner">
        <form class="selector-field">
            <label for="pilih-apbd">Pilih Dokumen APBDes</label>
            <select id="pilih-apbd" required wire:model="apbd_id">
                <option value="" selected>Pilih APBD</option>
                
                @foreach ($daftarApbd as $ap)
                    <option value="{{ $ap->id }}">{{ $ap->judul }} Tahun {{ $ap->tahun }}</option>
                @endforeach
            </select>
        </form>
        <button type="button" wire:click="setAPBD" class="selector-bar__action">Terapkan</button>
    </div>

    @if ($apbd)
        <header class="masthead">
            <div class="masthead__inner">
                <div>
                    <p class="masthead__agency">
                        PEMERINTAH DESA PECATU
                        <span>Kecamatan Kuta Selatan, Kabupaten Badung, Bali</span>
                    </p>
                    <h1 class="masthead__title">
                        Rincian Anggaran <em>Pendapatan</em> Desa
                    </h1>
                    <div class="masthead__rule"></div>
                    <div class="masthead__meta">
                        <div><strong>Tahun Anggaran {{ $apbd->tahun }}</strong>{{ $apbd->judul }}</div>
                        {{-- <div><strong>Perubahan Kedua</strong>Tahap penyesuaian</div> --}}
                        {{-- <div><strong>Kode Rekening 4</strong>Kelompok Pendapatan</div> --}}
                    </div>
                </div>
                <div class="masthead__badge">
                    Dokumen anggaran resmi desa
                    <br /><span class="status">{{ $apbd->status }}</span>
                </div>
            </div>
        </header>

        <main class="page">
            <section class="panel">
                <div class="stat-strip">
                    <div class="stat">
                        <div class="stat__label">Total Pendapatan Awal</div>
                        <div class="stat__value"><small>Rp</small>{{ number_format($statistic['jumlah_awal']) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat__label">Total Pendapatan Perubahan</div>
                        <div class="stat__value"><small>Rp</small>{{ number_format($statistic['jumlah_perubahan']) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat__label">Total Pendapatan Varian</div>
                        <div class="stat__value"><small>Rp</small>{{ number_format($statistic['jumlah_sisa']) }}</div>
                    </div>
                </div>

                <div class="section-head">
                    <div>
                        <h2>Rincian Anggaran Pendapatan</h2>
                        <p>
                            Perbandingan anggaran sebelum dan setelah Perubahan Kedua, per
                            kode rekening.
                        </p>
                    </div>
                    <div class="legend">
                        <span><i class="dot dot--navy"></i>Kelompok</span>
                        <span><i class="dot"></i>Jenis / Obyek</span>
                        <span><i class="dot dot--muted"></i>Rincian Obyek</span>
                    </div>
                </div>

                <div class="table-wrap">
                    @php
                        $apbd_perubahan = $apbd->perubahans;
                    @endphp
                    <table class="ledger">
                        <thead>
                            <tr>
                                <th class="kode">Kode Rekening</th>
                                <th>Uraian</th>
                                <th class="num">Awal</th>
                                @foreach ($apbd_perubahan as $ap)
                                    <th class="num">{{ $ap->judul }}</th>
                                    <th class="num">{{ $ap->judul }} (Lebih/Kurang)</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalan = 0;
                            @endphp
                            @foreach ($results as $res)
                                {{-- Utama --}}
                                <tr class="lvl-0">
                                    <td class="kode">{{ $res['kode'] }}</td>
                                    <td><span class="uraian">{{ $res['nama'] }}</span></td>
                                    <td class="num">{{ number_format($res['total']) }}</td>
                                    @foreach ($apbd_perubahan as $ap)
                                        <td class="num">{{ number_format($res['perubahan_totals'][$ap->id]) }}</td>
                                        <td class="num">
                                            <span class="varian is-up">{{ number_format($res['total'] - $res['perubahan_totals'][$ap->id]) }}</span>
                                        </td>
                                    @endforeach
                                </tr>

                                @foreach ($res['sub_utamas'] as $su)
                                    {{-- Sub Utama --}}
                                    <tr class="lvl-1">
                                        <td class="kode">{{ $su['kode'] }}</td>
                                        <td style="padding-left: 28px">
                                            <span class="uraian">{{ $su['nama'] }}</span>
                                        </td>
                                        <td class="num">{{ number_format($su['total']) }}</td>
                                        @foreach ($apbd_perubahan as $ap)
                                            <td class="num">{{ number_format($su['perubahan_totals'][$ap->id]) }}</td>
                                            <td class="num">
                                                <span class="varian is-up">{{ number_format($su['total'] - $su['perubahan_totals'][$ap->id]) }}</span>
                                            </td>
                                        @endforeach
                                        
                                    </tr>
                                    @foreach ($su['sub_sutamas'] as $ssu)
                                        {{-- Sub Sutama --}}
                                        <tr class="lvl-2">
                                            <td class="kode">{{ $ssu['kode'] }}</td>
                                            <td style="padding-left: 44px">
                                                <span class="uraian">{{ $ssu['nama'] }}</span>
                                            </td>
                                            <td class="num">{{ number_format($ssu['total']) }}</td>
                                            @foreach ($apbd_perubahan as $ap)
                                                <td class="num">{{ number_format($ssu['perubahan_totals'][$ap->id]) }}</td>
                                                <td class="num">
                                                    <span class="varian is-up">{{ number_format($ssu['total'] - $ssu['perubahan_totals'][$ap->id]) }}</span>
                                                </td>
                                            @endforeach
                                            
                                        </tr>
                                        @foreach ($ssu['sub_ssutamas'] as $sssu)
                                            {{-- Sub SSutama --}}
                                            <tr class="lvl-3">
                                                <td class="kode">{{ $sssu['kode'] }}</td>
                                                <td style="padding-left: 60px">
                                                    <span class="uraian">{{ $sssu['nama'] }}</span>
                                                </td>
                                                <td class="num">{{ number_format($sssu['total']) }}</td>
                                                @foreach ($apbd_perubahan as $ap)
                                                    <td class="num">{{ number_format($sssu['perubahan_totals'][$ap->id]) }}</td>
                                                    <td class="num">
                                                        <span class="varian is-up">{{ number_format($sssu['total'] - $sssu['perubahan_totals'][$ap->id]) }}</span>
                                                    </td>
                                                @endforeach
                                                
                                            </tr>

                                            @php
                                                $rno = 1;
                                            @endphp
                                            @foreach ($sssu['datas'] as $data)
                                                @php
                                                    $totalan += $data->jumlah;
                                                @endphp
                                                {{-- Rincian --}}
                                                <tr class="lvl-4">
                                                    <td class="kode">&nbsp;</td>
                                                    <td style="padding-left: 76px" class="flex flex-row justify-start items-center gap-2">
                                                        <span class="uraian">{{ $rno++ }}&nbsp; {{ $data->judul }}</span>
                                                        <span class=" border border-red-200 text-xs px-2 bg-amber-50">{{ $data->sumberDana->kode }}</span>
                                                    </td>
                                                    <td class="num"><span class="varian">{{ number_format($data->jumlah) }}</span></td>
                                                    @foreach ($apbd_perubahan as $ap)
                                                        @php
                                                            $dpbopID = $data->getPerubahanBasedOnPerubahanID($ap->id);
                                                            $jumlah_perubahan = $dpbopID ? $dpbopID->jumlah : 0;
                                                            $total = $data->jumlah - $jumlah_perubahan;
                                                        @endphp
                                                        <td class="num">{{ number_format($jumlah_perubahan) }}</td>
                                                        <td class="num">
                                                            <span class="varian {{ $total < 0 ? 'is-down' : 'is-up' }}">{{ number_format($total) }}</span>
                                                        </td>
                                                    @endforeach
                                                    
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Jumlah Belanja</td>
                                <td class="num">{{ number_format($totalan) }}</td>
                                @foreach ($apbd_perubahan as $ap)
                                    <td class="num">{{ number_format($res['perubahan_totals'][$ap->id]) }}</td>
                                    <td class="num">{{ number_format($totalan - $res['perubahan_totals'][$ap->id]) }}</td>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="footnote">
                    <span>Terakhir diupdate oleh sistem APBDes Pecatu pada {{ toCarbon($apbd->updated_at, 'Y-m-d H:i:s', 'D, d F Y H:i A') }}.</span>
                </div>
            </section>
        </main>
    @else
        
    @endif
</x-filament-panels::page>
