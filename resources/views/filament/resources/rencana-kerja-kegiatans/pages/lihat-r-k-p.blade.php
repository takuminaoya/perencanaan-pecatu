<x-filament-panels::page>
    <x-css.rkpcss />

    <div class="page">

        <!-- ===== HEADER PANEL ===== -->
        <div class="header-panel">
            <div class="header-inner">
                <div class="header-left">
                    <div class="seal"><span>RKK</span></div>
                    <div>
                        <p class="header-eyebrow">Pemerintah Desa Pecatu &middot; Kecamatan Kuta Selatan</p>
                        <h1 class="header-title font-display">Rencana Kerja Kegiatan</h1>
                        <p class="header-sub">Tahun Anggaran {{ $record->tahun }} &nbsp;&middot;&nbsp; Sumber Dana: Dana Desa &amp; PADes
                        </p>
                    </div>
                </div>
                <div class="header-right">
                    <span class="status-pill"><span class="status-dot"></span>Sedang Berjalan</span>
                    <p class="updated-line">Terakhir diupdate&nbsp;&middot;&nbsp;<span class="updated-value capitalize">{{ toCarbon($record->updated_at, 'Y-m-d H:i:s', 'D, d F Y H:i A') }}</span></p>
                </div>
            </div>
        </div>

        <!-- ===== SUMMARY STATS (statis) ===== -->
        <div class="stats-grid">
            <div class="stat-card">
                <p class="stat-label">Total Bidang</p>
                <p class="stat-value">{{ $record->bidangs()->count() }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Kegiatan</p>
                <p class="stat-value">{{ $record->kegiatans()->count(); }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Anggaran</p>
                <p class="stat-value mono">Rp {{ number_format($total_anggaran) }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Total Sasaran Penerima</p>
                <p class="stat-value">{{ number_format($total_sasaran) }} orang</p>
            </div>
        </div>

        @php
            $nomor = 0;
        @endphp
        @foreach ($record->bidangs as $bidang)
            @php
                $nomor++;
            @endphp
            <!-- ===== BIDANG 1 (diulang berurutan ke bawah untuk setiap bidang) ===== -->
            <div class="bidang-section">
                <div class="bidang-heading-row">
                    <div class="bidang-heading-left">
                        {{ $this->deleteBidang()(['id' => $bidang->id]) }}
                        <span class="bidang-index">{{ $nomor }}</span>
                        <span class="bidang-title">{{ $bidang->bidang->kode }} &mdash; Daftar Kegiatan<span class="bidang-desc capitalize">{{ $bidang->nama_bidang }}</span></span>
                    </div>
                    {{-- <button class="btn btn-gold"><span class="btn-icon">＋</span> Tambah Kegiatan</button> --}}
                    {{ $this->tambahKegiatan($bidang->id)(['id' => $bidang->id]) }}
                </div>
                <div class="panel table-panel">
                    <div class="table-panel-head">
                        <p class="table-hint">Gulir ke samping untuk melihat kolom lainnya &rarr;</p>
                    </div>
                    <div class="table-scroll">
                        <table class="rkk-table">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="width:56px;">KD</th>
                                    <th colspan="2" class="grp-end">Bidang/Sub Bidang/Jenis Kegiatan</th>
                                    <th rowspan="2" style="width:150px;">Lokasi</th>
                                    <th rowspan="2" style="width:70px;">Volume</th>
                                    <th rowspan="2" style="width:80px;">Satuan</th>
                                    <th rowspan="2" style="width:170px;" class="grp-end">Biaya dan<br>Sumber Dana</th>
                                    <th colspan="4" class="grp-end">Sasaran</th>
                                    <th colspan="3" class="grp-end">Waktu Pelaksanaan</th>
                                    <th rowspan="2" style="width:150px;">Pelaksana<br>Kegiatan Anggaran</th>
                                    <th rowspan="2" style="width:150px;">Tim yang<br>Melaksanakan</th>
                                </tr>
                                <tr>
                                    <th style="width:170px;">Bidang/Sub Bidang</th>
                                    <th style="width:210px;" class="grp-end">Jenis Kegiatan</th>
                                    <th style="width:70px;">Jumlah</th>
                                    <th style="width:72px;">Laki laki</th>
                                    <th style="width:78px;">Perempuan</th>
                                    <th style="width:64px;" class="grp-end">A-RTM</th>
                                    <th style="width:80px;">Durasi</th>
                                    <th style="width:88px;">Mulai</th>
                                    <th style="width:88px;">Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($bidang->kegiatans as $kg)
                                    @php
                                        $kkg = $kg->kegiatan;
                                        $j = ($kg->laki_laki + $kg->perempuan + $kg->artm);
                                        $total += $kg->sumber_biaya;
                                        $total_sasaran += $j;
                                    @endphp
                                    <tr>
                                        <td class="cell-kd">
                                            {{ $kkg->kode }}

                                            <div class="di mt-2 flex flex-row items-center justify-center">
                                                {{ $this->editKegiatan()(['kegiatan_id' => $kg->id]) }}
                                                {{ $this->deleteKegiatan()(['kegiatan_id' => $kg->id]) }}
                                            </div>
                                        </td>
                                        <td>{{ $kg->nama_sub }}</td>
                                        <td>{{ $kg->nama_kegiatan }}</td>
                                        <td>{{ $kg->lokasi }}</td>
                                        <td class="cell-center">{{ $kg->volume }}</td>
                                        <td class="cell-center"><span class="badge-satuan">{{ $kg->satuan }}</span></td>
                                        <td class="cell-num">Rp {{ number_format($kg->sumber_biaya) }} ({{ $kg->sumber_kode }})</td>
                                        <td class="cell-center">{{ $j }}</td>
                                        <td class="cell-center">{{ $kg->laki_laki }}</td>
                                        <td class="cell-center">{{ $kg->perempuan }}</td>
                                        <td class="cell-center">{{ $kg->artm }}</td>
                                        <td class="cell-center">{{ $kg->durasi }} {{ $kg->satuan_durasi }}</td>
                                        <td class="cell-center">{{ toCarbon($kg->mulai, 'Y-m-d', 'F Y') }}</td>
                                        <td class="cell-center">{{ toCarbon($kg->selesai, 'Y-m-d', 'F Y') }}</td>
                                        <td>{{ $kg->pelaksana_kegiatan }}</td>
                                        <td>-</td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                @php
                    $total_anggaran += $total;
                @endphp
                <div class="total-row">
                    <span class="total-label">Jumlah Anggaran &mdash; Bidang {{ $bidang->bidang->kode }} &mdash; Daftar Kegiatan<span class="bidang-desc capitalize">{{ $bidang->nama_bidang }}</span></span>
                    <span class="total-value">Rp {{ number_format($total) }}</span>
                </div>
            </div>
        @endforeach

    </div>
</x-filament-panels::page>
