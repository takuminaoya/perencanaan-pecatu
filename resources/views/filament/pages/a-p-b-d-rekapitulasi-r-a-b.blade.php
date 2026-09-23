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
        <a href="{{ route('print.apbd', ['id' => $apbd->id, 'mode' => 'belanja']) }}" target="_BLANK" class="selector-bar__action">Print</a>
    </div>

    @if ($apbd)
        <header class="masthead">
            <div class="masthead__inner">
                <div>
                    <p class="masthead__agency">PEMERINTAH DESA PECATU
                        <span>Kecamatan Kuta Selatan, Kabupaten Badung, Bali</span>
                    </p>
                    <h1 class="masthead__title">Rekapitulasi <em>Anggaran Belanja</em> Desa</h1>
                    <div class="masthead__rule"></div>
                    <div class="masthead__meta">
                        <div><strong>Tahun Anggaran 2026</strong>APBDes</div>
                        <div><strong>Perubahan Pertama</strong>Rincian Penjabaran</div>
                        <div><strong>Kode Rekening 01</strong>Bidang Pemerintahan Desa</div>
                    </div>
                </div>
                <div class="masthead__badge">
                    Dokumen anggaran resmi desa
                    <br><span class="status">Disahkan — Perubahan I</span>
                </div>
            </div>
        </header>

        <main class="page">
            <section class="panel state-report" id="stateReport">

                <div class="stat-strip">
                    <div class="stat">
                        <div class="stat__label">Anggaran Induk</div>
                        <div class="stat__value"><small>Rp</small>{{ number_format($statistic['jumlah_awal']) }}</div>
                        <div class="stat__delta is-flat">Sebelum Perubahan Pertama</div>
                    </div>
                    <div class="stat">
                        <div class="stat__label">Perubahan I</div>
                        <div class="stat__value"><small>Rp</small>{{ number_format($statistic['jumlah_perubahan']) }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat__label">Bertambah / (Berkurang)</div>
                        <div class="stat__value"><small>Rp</small>{{ number_format($statistic['jumlah_sisa']) }}</div>
                    </div>
                </div>

                <div class="section-head">
                    <div>
                        <h2>Rekapitulasi Rincian Anggaran Belanja Desa</h2>
                        <p>Perbandingan Anggaran Induk, rincian penjabaran per jenis belanja, dan Perubahan I — Tahun
                            Anggaran 2026.</p>
                    </div>
                    <div class="legend">
                        <span><i class="dot dot--navy"></i>Bidang</span>
                        <span><i class="dot" style="background:var(--success)"></i>Sub Bidang</span>
                        <span><i class="dot"></i>Kegiatan</span>
                        <span><i class="dot dot--muted"></i>Rincian Objek</span>
                    </div>
                </div>

                <!-- ================================================================
                REKAP TABLE — satu tabel utuh untuk Bidang 01. Struktur ini bisa
                diulang (loop) per Bidang bila dokumen memiliki lebih dari satu
                Bidang Penyelenggaraan; salin blok <div class="table-wrap ...">
                ini beserta isinya untuk Bidang berikutnya.
                ================================================================ -->
                <div class="table-wrap table-wrap--full">
                    <table class="ledger ledger--rekap">
                        <colgroup>
                            <col style="width:120px">
                            <col style="width:300px">
                            <col style="width:70px">
                            <col style="width:90px">
                            <col style="width:140px">
                            <col style="width:130px">
                            <col style="width:130px">
                            <col style="width:120px">
                            <col style="width:130px">
                            {{-- <col style="width:140px"> --}}
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="kode" rowspan="2">Kode Rekening</th>
                                <th class="uraian-col" rowspan="2">Uraian</th>
                                <th rowspan="2">Output</th>
                                <th rowspan="2">Sumber<br>Dana</th>
                                <th colspan="4" class="group-divider">Rincian Penjabaran APBDesa Awal</th>
                                <th rowspan="2" class="group-divider">Awal (Rp)</th>
                                {{-- <th rowspan="2">Bertambah<br>(Berkurang) (Rp)</th> --}}
                            </tr>
                            <tr>
                                @foreach ($sub_mains as $sm)
                                    <th style="
                                        overflow-wrap: break-word;
                                        word-break: break-word;
                                        white-space: normal;
                                    ">{{ $sm->nama }} (Rp)</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($results as $res)
                                <tr class="lvl-0">
                                    <td class="kode">{{ $res['kode'] }}</td>
                                    <td colspan="7"><span class="uraian">{{ $res['nama'] }}</span></td>
                                    <td class="num"><span class="varian is-up">{{ number_format($res['total']) }}</span></td>
                                </tr>
                                @foreach ($res['sub_bidangs'] as $sub_bidang)
                                    <tr class="lvl-1">
                                        <td class="kode">{{ $sub_bidang['kode'] }}</td>
                                        <td style="padding-left:28px" colspan="3"><span class="uraian">{{ $sub_bidang['nama'] }}</span></td>
                                        <td class="num group-divider"></td>
                                        <td class="num"></td>
                                        <td class="num"></td>
                                        <td class="num"></td>
                                        <td class="num group-divider">{{ number_format($sub_bidang['total']) }}</td>
                                        {{-- <td class="num"><span class="varian is-flat">0,00</span></td> --}}
                                    </tr>
                                    @foreach ($sub_bidang['kegiatans'] as $kegiatan)
                                        <tr class="lvl-2">
                                            <td class="kode">{{ $kegiatan['kode'] }}</td>
                                            <td style="padding-left:44px" colspan="3"><span class="uraian">{{ $kegiatan['nama'] }}</span></td>
                                            <td class="num group-divider"></td>
                                            <td class="num"></td>
                                            <td class="num"></td>
                                            <td class="num"></td>
                                            <td class="num group-divider">{{ number_format($kegiatan['total']) }}</td>
                                            {{-- <td class="num"><span class="varian is-flat">0,00</span></td> --}}
                                        </tr>

                                        @foreach ($kegiatan['sub_kegiatans'] as $sub_kegiatan)
                                            <tr class="lvl-2">
                                                <td class="kode">{{ $sub_kegiatan['kode'] }}</td>
                                                <td style="padding-left:60px" colspan="3"><span class="uraian">{{ $sub_kegiatan['nama'] }}</span></td>
                                                <td class="num group-divider"></td>
                                                <td class="num"></td>
                                                <td class="num"></td>
                                                <td class="num"></td>
                                                <td class="num"><span class="varian is-flat">{{ number_format($sub_kegiatan['total']) }}</span></td>
                                            </tr>

                                            @php
                                                $knomor = 1;
                                            @endphp
                                            @foreach ($sub_kegiatan['groups'] as $gp)
                                                <tr class="lvl-2">
                                                    <td class="kode"></td>
                                                    <td style="padding-left:68px" colspan="3"><span class=" font-light">{{ $knomor++ }} &nbsp; {{ $gp['nama'] }}</span></td>
                                                    @if (count($gp['rincian_per_submain']) > 0)
                                                        @foreach ($gp['rincian_per_submain'] as $rps)
                                                            <td class="num group-divider">{{ number_format($rps['total']) }}</td>
                                                        @endforeach
                                                        <td class="num group-divider">{{ number_format($gp['total']) }}</td>
                                                    @else
                                                        <td class="num group-divider"></td>
                                                        <td class="num"></td>
                                                        <td class="num"></td>
                                                        <td class="num"></td>
                                                        <td class="num group-divider">0,00</td>
                                                    @endif
                                                </tr>
                                                
                                            @endforeach

                                            {{-- @php
                                                $knomor = 1;
                                            @endphp
                                            @foreach ($sub_kegiatan['data'] as $data)
                                                <tr class="lvl-3">
                                                    <td class="kode"></td>
                                                    <td class="uraian-cell" style="padding-left:60px">{{ $knomor++ }}&nbsp; {{ $data->judul }}</td>
                                                    <td class="output">-</td>
                                                    <td class="sumber-dana">{{ $data->sumberDana->kode }}</td>
                                                    <td class="num group-divider">-</td>
                                                    <td class="num">–</td>
                                                    <td class="num">–</td>
                                                    <td class="num">–</td>
                                                    <td class="num group-divider">{{ number_format($data->jumlah) }}</td>
                                                    <td class="num"><span class="varian is-flat">0,00</span></td>
                                                </tr>
                                            @endforeach --}}
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach

                            

                            {{-- <tr class="lvl-3">
                                <td class="kode">{{ $sub_kegiatan['kode'] }}</td>
                                <td class="uraian-cell" style="padding-left:60px">{{ $knomor++ }}&nbsp; {{ $sub_kegiatan['nama'] }}</td>
                                <td class="output">-</td>
                                <td class="sumber-dana">-</td>
                                <td class="num group-divider">30.000.000,00</td>
                                <td class="num">–</td>
                                <td class="num">–</td>
                                <td class="num">–</td>
                                <td class="num group-divider">30.000.000,00</td>
                                <td class="num"><span class="varian is-flat">0,00</span></td>
                            </tr> --}}

                            
                            
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    @endif
</x-filament-panels::page>
