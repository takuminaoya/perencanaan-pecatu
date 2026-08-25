<x-filament-panels::page>
    <x-css.rkpcss />

    <div class="page">

        <header class="doc-header">
            <div class="eyebrow">Rencana Kerja Pemerintah Desa</div>
            <h1 class="capitalize">{{ $record->judul }}<br>Tahun {{ $record->tahun }}</h1>
            <div class="sub">Rincian bidang, jenis kegiatan, lokasi, volume, biaya, sasaran, dan jadwal pelaksanaan
            </div>

            <div class="head-meta">
                <div class="field">
                    <div class="label">Desa</div>
                    <div class="value">Pemerintah Desa Pecatu</div>
                </div>
                <div class="field">
                    <div class="label">Kecamatan</div>
                    <div class="value">Kecamatan Kuta Selatan</div>
                </div>
                <div class="field">
                    <div class="label">Kabupaten / Kota</div>
                    <div class="value">Kabupaten Badung</div>
                </div>
                <div class="field">
                    <div class="label">Provinsi</div>
                    <div class="value">Provinsi Bali</div>
                </div>
            </div>
        </header>

        <div class="content-card">
            <div class="card-title">
                <h2>1. Bidang Penyelenggaraan Pemerintahan Desa</h2>
                <span class="hint">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                    Geser tabel untuk melihat kolom lainnya
                </span>
            </div>

            <div class="table-scroll">
                <table class="rkp">
                    <thead>
                        <tr>
                            <th rowspan="3" style="width:44px">KD</th>
                            <th colspan="2" rowspan="2">Bidang / Sub Bidang / Jenis Kegiatan</th>
                            <th rowspan="3" style="width:110px">Lokasi</th>
                            <th rowspan="3" style="width:64px">Volume</th>
                            <th rowspan="3" style="width:70px">Satuan</th>
                            <th rowspan="3" style="width:140px">Biaya dan Sumber Dana</th>
                            <th colspan="4">Sasaran</th>
                            <th colspan="3">Waktu Pelaksanaan</th>
                            <th rowspan="3" style="width:150px">Pelaksana Kegiatan Anggaran</th>
                            <th rowspan="3" style="width:110px">Tim yang Melaksanakan</th>
                        </tr>
                        <tr class="subrow">
                            <th style="width:56px">Jumlah</th>
                            <th style="width:56px">Laki Laki</th>
                            <th style="width:66px">Perempuan</th>
                            <th style="width:56px">A-RTM</th>
                            <th style="width:64px">Durasi</th>
                            <th style="width:64px">Mulai</th>
                            <th style="width:64px">Selesai</th>
                        </tr>
                        <tr class="numrow">
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rab = $record->rab;
                            $jumlah_total = 0;

                            $goupBidangs = $rab->groupOfMainBidang();
                        @endphp
                        @foreach ($goupBidangs as $gb)
                            @php
                                $bid = getBidang($gb->main_bidang_id);
                                $bidangs = getRabBidang($rab->id, $gb->main_bidang_id);
                            @endphp
                            <tr class="grp">
                                <td class="kd">{{ $bid->kode }}</td>
                                <td colspan="15">{{ $bid->nama }}</td>
                            </tr>

                            @foreach ($bidangs as $bidang)
                                @foreach ($bidang->uraian_details as $urd)
                                    @php
                                        $jumlah_total += $urd->jumlah;
                                    @endphp
                                    <tr>
                                        <td class="kd"></td>
                                        <td colspan="2">
                                            <div>{{ $bidang->ssub->nama }}</div>
                                            <div style="color:var(--text-soft); font-style:italic; margin-top:3px;">
                                                {{ $bidang->skegiatan->nama }}</div>
                                        </td>
                                        <td>Desa Pecatu</td>
                                        <td class="num">{{ $urd->volume }}</td>
                                        <td class="center">{{ $urd->indikator }}</td>
                                        <td class="num">{{ number_format($urd->jumlah) }}<span
                                                class="sumber-dana uppercase">{{ $urd->kode_satuan }}</span></td>
                                        <td class="sasaran">1</td>
                                        <td class="sasaran">1</td>
                                        <td class="sasaran">0</td>
                                        <td class="sasaran">0</td>
                                        <td class="center">{{ $bidang->waktu }} {{ $bidang->indikator_waktu }}</td>
                                        <td class="center">-</td>
                                        <td class="center">-</td>
                                        <td>Kepala Seksi Pemerintahan</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:700; color:var(--pecatu-navy);">
                                Jumlah Total Biaya</td>
                            <td class="num" style="font-weight:700; font-size:12.5px; color:var(--pecatu-navy);">
                                {{ number_format($jumlah_total) }}</td>
                            <td colspan="9"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <!-- ===== FLOATING MENU CETAK ===== -->
    <div class="fab-backdrop" id="fabBackdrop"></div>
    <div class="fab-container" id="fabContainer">
        <div class="fab-menu" id="fabMenu">
            <span class="fab-menu-label">Menu Cetak</span>
            <a class="fab-item fab-open" href="{{ route('print.rkk', ['id' => $record->id]) }}" target="_blank"
                rel="noopener">
                <span class="fab-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <path d="M14 2v6h6" />
                    </svg>
                </span>
                Buka Halaman Cetak
            </a>
            <a href="{{ route('download.rkk', ['id' => $record->id]) }}" download class="fab-item fab-quick" id="btnQuickPrint" type="button">
                <span class="fab-item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9V2h12v7" />
                        <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" />
                        <path d="M6 14h12v8H6z" />
                    </svg>
                </span>
                Cetak Halaman Ini
            </a>
        </div>
        <button class="fab-main" id="fabMain" type="button" aria-expanded="false" aria-label="Buka menu cetak">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9V2h12v7" />
                <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" />
                <path d="M6 14h12v8H6z" />
            </svg>
        </button>
    </div>

    <script>
        // Seluruh JS di halaman ini murni untuk efek tampilan — tidak ada data yang digenerate.
        var fabContainer = document.getElementById('fabContainer');
        var fabMain = document.getElementById('fabMain');
        var fabBackdrop = document.getElementById('fabBackdrop');
        var btnQuickPrint = document.getElementById('btnQuickPrint');

        function setFabOpen(open) {
            fabContainer.classList.toggle('is-open', open);
            fabBackdrop.classList.toggle('is-visible', open);
            fabMain.setAttribute('aria-expanded', String(open));
        }

        fabMain.addEventListener('click', function() {
            setFabOpen(!fabContainer.classList.contains('is-open'));
        });
        fabBackdrop.addEventListener('click', function() {
            setFabOpen(false);
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') setFabOpen(false);
        });
    </script>
</x-filament-panels::page>
