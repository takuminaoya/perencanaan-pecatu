<x-filament-panels::page>
    <x-css.apbdcss />

    <header class="masthead">
        <div class="wrap masthead-inner">
            <div>
                <div class="eyebrow"><span class="dot"></span>{{ $record->judul }}<span class="rule"></span>Pemerintah
                    Desa Pecatu</div>
                <h1>Laporan {{ $record->judul }}</h1>
                <p class="subline">Ringkasan dan rincian anggaran disusun
                    berdasarkan kode rekening APBDes.</p>
            </div>
            <div class="meta-panel">
                <div class="meta-item">
                    <div class="meta-label">Tahun Anggaran</div>
                    <div class="meta-value">{{ $record->tahun }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Status</div>
                    <div class="meta-value"><span class="status-pill">{{ $record->status }}</span></div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Terakhir Diupdate</div>
                    <div class="meta-value mono">{{ toCarbon($record->updated_at, 'Y-m-d H:i:s', 'D, d F Y H:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="wrap">

        <!-- ================= SECTION 1 ================= -->
        <section class="section">
            <div class="section-head">
                <div>
                    <div class="section-kicker"><span class="num">01</span>Ringkasan Perubahan</div>
                    <h2 class="section-title">Ikhtisar Pendapatan, Belanja &amp; Pembiayaan</h2>
                </div>
                <p class="section-desc">Perbandingan anggaran semula terhadap anggaran menjadi, per kelompok rekening.
                </p>
            </div>

            <div class="ledger fade-in">
                @if (count($record->mains) > 0)
                    <table class="apbdes">
                        <thead>
                            <tr>
                                <th style="width:64px">Kode Rek</th>
                                <th>Uraian</th>
                                <th class="num" colspan="2">Anggaran (Rp)</th>
                                <th class="num">Bertambah / (Berkurang)</th>
                                <th>Keterangan</th>
                                <th class="col-aksi">Aksi</th>
                            </tr>
                            <tr class="sub">
                                <th></th>
                                <th></th>
                                <th class="num">Semula</th>
                                <th class="num">Menjadi</th>
                                <th class="num"></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $itotal_semula = 0;
                                $itotal_menjadi = 0;
                            @endphp

                            @foreach ($record->mains as $main)
                                <tr class="grp">
                                    <td class="kode">{{ $main->kas->kode }}</td>
                                    <td class="uraian" colspan="5">{{ $main->kas->nama }}</td>
                                    <td class="aksi">
                                        <span class="row-aksi">
                                            <button
                                                wire:click="mountAction('tambahEditMain', { id: {{ $main->id }} })"
                                                class="icon-only icon-edit" title="Edit kelompok">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path d="M12 20h9" />
                                                    <path d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4L16.5 3.5z" />
                                                </svg>
                                            </button>
                                            <button class="icon-only icon-delete"
                                                wire:click="mountAction('deleteMain', { id: {{ $main->id }} })"
                                                title="Hapus kelompok">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path d="M3 6h18" />
                                                    <path
                                                        d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0l-1 14a2 2 0 01-2 2H7a2 2 0 01-2-2L4 6" />
                                                </svg>
                                            </button>
                                        </span>
                                    </td>
                                </tr>

                                @foreach ($main->subs as $submain)
                                    @php
                                        $itotal_semula += $submain->totalSum();
                                        $itotal_menjadi += $submain->totalSum('menjadi');
                                    @endphp
                                    <tr>
                                        <td class="kode">{{ $submain->kas->kode }}</td>
                                        <td class="uraian indent1">{{ $submain->kas->nama }}</td>
                                        <td class="num">{{ number_format($submain->totalSum()) }}</td>
                                        <td class="num">{{ number_format($submain->totalSum('menjadi')) }}</td>
                                        <td class="num delta-zero">0,00</td>
                                        <td></td>
                                        <td class="aksi">
                                            <span class="row-aksi">
                                                <button
                                                    wire:click="mountAction('deleteSubMain', { id: {{ $submain->id }} })"
                                                    class="icon-only icon-delete" title="Hapus rincian"><svg
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path d="M3 6h18" />
                                                        <path
                                                            d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0l-1 14a2 2 0 01-2 2H7a2 2 0 01-2-2L4 6" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach

                            <tr class="total">
                                <td></td>
                                <td class="label">JUMLAH PENDAPATAN</td>
                                <td class="num">{{ number_format($itotal_semula) }}</td>
                                <td class="num">{{ number_format($itotal_menjadi) }}</td>
                                <td class="num">({{ number_format($itotal_menjadi - $itotal_semula) }})</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <div class="empty-state fade-in" id="emptyState">
                        <div class="empty-icon">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.6">
                                <path d="M9 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-4" />
                                <path d="M18 2l4 4-10 10H8v-4L18 2z" />
                            </svg>
                        </div>
                        <h3>Belum ada rincian untuk bidang ini</h3>
                        <p>Tambahkan bidang belanja beserta kode rekening, anggaran semula, dan anggaran perubahannya
                            untuk
                            melengkapi laporan.</p>
                        <button wire:click="mountAction('tambahDetail')" class="btn-add" id="btnAddBidang">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Tambah Ikhtisar PBP
                        </button>
                    </div>
                @endif

            </div>
        </section>

        <!-- ================= SECTION 2 ================= -->
        <section class="section">
            <div class="section-head">
                <div>
                    <div class="section-kicker"><span class="num">02</span>Rincian per Bidang</div>
                    <h2 class="section-title">Rincian Rekening &amp; Sumber Dana</h2>
                </div>
                <p class="section-desc">Setiap kelompok dapat disembunyikan, diedit, atau dihapus secara terpisah.</p>
            </div>

            @if (count($record->groupOfRincianUtama()) > 0)
                <!-- Pemasukan -->
                {{-- Grup Utama --}}
                @foreach ($record->groupOfRincianUtama() as $r)
                    @php
                        $ru = getAPBDMain($r->apbdm_id);
                    @endphp
                    <article class="bidang-card fade-in" data-bidang="pendapatan">
                        <div class="bidang-head">
                            <div class="bidang-head-left">
                                <span class="bidang-index">{{ $ru->kas->kode }}</span>
                                <div>
                                    <div class="bidang-name">{{ $ru->kas->nama }}</div>
                                </div>
                            </div>
                            <div class="row-actions">
                                <button class="btn btn-toggle" data-action="toggle" aria-expanded="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 15l-6-6-6 6" />
                                    </svg>
                                    <span class="toggle-label"></span>
                                </button>

                                @if (isSuperadmin())
                                    <button wire:click="mountAction('deleteByGroup', { id: {{ $r->apbdm_id }} })"
                                        class="btn btn-delete" data-action="delete">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 6h18" />
                                            <path
                                                d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0l-1 14a2 2 0 01-2 2H7a2 2 0 01-2-2L4 6" />
                                        </svg>
                                        Hapus
                                    </button> 
                                @endif
                                
                            </div>
                        </div>

                        <div class="bidang-body">

                            <table class="rincian">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="width:64px">Kode</th>
                                        <th rowspan="2">Uraian</th>
                                        <th colspan="3" class="num !text-center">Semula</th>
                                        <th colspan="3" class="num !text-center">Menjadi</th>
                                        <th rowspan="2" class="num">Bertambah/(Berkurang)</th>
                                        <th rowspan="2" class="uppercase">Sumber Dana</th>
                                        <th rowspan="2" class="col-aksi">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th class="uppercase">volume</th>
                                        <th class="uppercase">harga satuan</th>
                                        <th class="uppercase">jumlah (Rp)</th>
                                        <th class="uppercase">volume</th>
                                        <th class="uppercase">harga satuan</th>
                                        <th class="uppercase">jumlah (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody class="has-kegiatan-info">
                                    @php
                                        $total_semula = 0;
                                        $total_menjadi = 0;
                                    @endphp

                                    {{-- APBD Rincian Utama --}}
                                    @foreach ($ru->apbdru as $ricu)
                                        @if ($ricu->tipe == 'keluar')
                                            @php
                                                $child = $ricu->bidang;
                                                $sub = $child->getParent();
                                                $main = $sub->getParent();
                                            @endphp

                                            <tr class="kegiatan-info-row">
                                                <td colspan="11" class="kegiatan-info-cell">
                                                    <div class="kegiatan-info-toggle"
                                                        role="button" tabindex="0" aria-expanded="true"
                                                        aria-label="Buka/tutup rincian kegiatan">
                                                        <table class="kegiatan-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="ki-label">Bidang</td>
                                                                    <td class="ki-colon">:</td>
                                                                    <td class="ki-value">
                                                                        {{ $main->kode . " " . $main->nama }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ki-label">Sub Bidang</td>
                                                                    <td class="ki-colon">:</td>
                                                                    <td class="ki-value">
                                                                        {{ $sub->kode . " " . $sub->nama }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ki-label">Kegiatan</td>
                                                                    <td class="ki-colon">:</td>
                                                                    <td class="ki-value">
                                                                        {{ $child->kode . " " . $child->nama }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ki-label">Sub Kegiatan</td>
                                                                    <td class="ki-colon">:</td>
                                                                    <td class="ki-value">
                                                                        @php
                                                                            $sub_kegiatans = [];
                                                                            
                                                                            foreach ($ricu->apbdrsu as $su) {
                                                                                $sub_kegiatans[] = $su->kegiatan->uraian_output;
                                                                            }

                                                                            $res = implode(', ', $sub_kegiatans);
                                                                        @endphp
                                                                        {{ $res }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ki-label">Waktu Pelaksanaan</td>
                                                                    <td class="ki-colon">:</td>
                                                                    <td class="ki-value">{{ dateDiffCarbon($ricu->tanggal_mulai, $ricu->tanggal_selesai, 'month') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ki-label">Output/Keluaran</td>
                                                                    <td class="ki-colon">:</td>
                                                                    <td class="ki-value">
                                                                        {{ $ricu->keluaran }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ki-label">Dibuat Oleh Dan Dapat Dimodifikasi Oleh</td>
                                                                    <td class="ki-colon">:</td>
                                                                    <td class="ki-value capitalize">
                                                                        Administrator & {{ $ricu->dibuatOleh->nama_lengkap }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="kegiatan-summary">
                                                            <span class="ki-label">Kegiatan</span><span
                                                                class="ki-colon">:</span><span
                                                                class="ki-value">{{ $child->kode . " " . $child->nama }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr id="kegiatan_{{ $ricu->id }}">
                                            <td class="kode">{{ $ricu->kas->kode }}</td>
                                            <td class="uraian indent1">{{ $ricu->kas->nama }}</td>

                                            <td class="num"></td>
                                            <td class="num"></td>
                                            <td class="num font-bold">
                                                {{ number_format($ricu->apbdcd->sum('semula_total')) }}</td>

                                            <td class="num"></td>
                                            <td class="num"></td>
                                            <td class="num font-bold">
                                                {{ number_format($ricu->apbdcd->sum('menjadi_total')) }}</td>
                                            <td class="num delta-zero"></td>
                                            <td></td>
                                            <td class="aksi">
                                                @if (isSuperadmin() or isFeatureAvailable($ricu->dibuat_oleh))
                                                    <span class="row-aksi">
                                                        <button
                                                            wire:click="mountAction('deleteRincianUtama', { id: {{ $ricu->id }} })"
                                                            class="icon-only icon-delete" title="Hapus rincian"><svg
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2">
                                                                <path d="M3 6h18" />
                                                                <path
                                                                    d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0l-1 14a2 2 0 01-2 2H7a2 2 0 01-2-2L4 6" />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                @endif
                                                
                                            </td>
                                        </tr>

                                        {{-- APBD Rincian Sub Utama --}}
                                        @foreach ($ricu->apbdrsu as $rsu)
                                            @php
                                                $sm = $rsu->apbdcd->sum('semula_total');
                                                $mj = $rsu->apbdcd->sum('menjadi_total');
                                                $total_semula += $sm;
                                                $total_menjadi += $mj;
                                            @endphp

                                            @if ($rsu->tipe == 'keluar')
                                                <tr>
                                                    <td class="kode">
                                                        {{ $rsu->kegiatan ? $rsu->kegiatan->kode : '-' }}
                                                    </td>
                                                    <td class="uraian indent1">
                                                        {{ $rsu->kegiatan ? $rsu->kegiatan->uraian_output : '-' }}</td>

                                                    <td class="num"></td>
                                                    <td class="num"></td>
                                                    <td class="num">{{ number_format($sm) }}</td>

                                                    <td class="num"></td>
                                                    <td class="num"></td>
                                                    <td class="num">{{ number_format($mj) }}</td>
                                                    <td class="num delta-zero">{{ number_format($mj - $sm) }}</td>
                                                    <td>{{ $rsu->sumber_dana }}</td>
                                                    <td class="aksi">

                                                    </td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td class="kode">{{ $rsu->kas ? $rsu->kas->kode : '-' }}</td>
                                                <td class="uraian indent2">{{ $rsu->kas ? $rsu->kas->nama : '-' }}
                                                </td>

                                                <td class="num"></td>
                                                <td class="num"></td>
                                                <td class="num">{{ number_format($sm) }}</td>

                                                <td class="num"></td>
                                                <td class="num"></td>
                                                <td class="num">{{ number_format($mj) }}</td>
                                                <td class="num delta-zero">{{ number_format($mj - $sm) }}</td>
                                                <td>{{ $rsu->sumber_dana }}</td>
                                                <td class="aksi">
                                                    @if (isSuperadmin() or isFeatureAvailable($ricu->dibuat_oleh))
                                                        <span class="row-aksi">
                                                            <button
                                                                wire:click="mountAction('tambahRincianDetail', { rsu_id: {{ $rsu->id }} })"
                                                                class="icon-only icon-add" title="Tambah rincian"><svg
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2">
                                                                    <path d="M12 5v14M5 12h14" />
                                                                </svg>
                                                            </button>
                                                            <button
                                                                wire:click="mountAction('deleteRincianSubUtama', { id: {{ $rsu->id }} })"
                                                                class="icon-only icon-delete" title="Hapus rincian"><svg
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2">
                                                                    <path d="M3 6h18" />
                                                                    <path
                                                                        d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0l-1 14a2 2 0 01-2 2H7a2 2 0 01-2-2L4 6" />
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    @endif
                                                    
                                                </td>
                                            </tr>

                                            {{-- APBD Rincian Sub Childern --}}
                                            @foreach ($rsu->apbdsc as $sc)
                                                <tr>
                                                    <td class="kode">{{ $sc->kas ? $sc->kas->kode : '-' }}</td>
                                                    <td class="uraian indent2">{{ $sc->kas ? $sc->kas->nama : '-' }}
                                                    </td>

                                                    <td class="num"></td>
                                                    <td class="num"></td>
                                                    <td class="num">
                                                        {{ number_format($sc->apbdcd->sum('semula_total')) }}</td>

                                                    <td class="num"></td>
                                                    <td class="num"></td>
                                                    <td class="num">
                                                        {{ number_format($sc->apbdcd->sum('menjadi_total')) }}</td>
                                                    <td class="num delta-zero"></td>
                                                    <td></td>
                                                    <td class="aksi">
                                                        @if (isSuperadmin() or isFeatureAvailable($ricu->dibuat_oleh))
                                                            <span class="row-aksi">
                                                                <button
                                                                    wire:click="mountAction('deleteRincianSubChild', { id: {{ $sc->id }} })"
                                                                    class="icon-only icon-delete"
                                                                    title="Hapus rincian"><svg viewBox="0 0 24 24"
                                                                        fill="none" stroke="currentColor"
                                                                        stroke-width="2">
                                                                        <path d="M3 6h18" />
                                                                        <path
                                                                            d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0l-1 14a2 2 0 01-2 2H7a2 2 0 01-2-2L4 6" />
                                                                    </svg>
                                                                </button>
                                                            </span>
                                                        @endif
                                                        
                                                    </td>
                                                </tr>

                                                @php
                                                    $sc_numbering = 1;
                                                @endphp

                                                {{-- APBD Rincian Child Detail --}}
                                                @foreach ($sc->apbdcd as $cd)
                                                    <tr>
                                                        <td class="kode"></td>
                                                        <td class="uraian indent3">{{ $sc_numbering++ }}. &nbsp;
                                                            {{ $cd->judul }}
                                                            <span class="sumberdana-tag" style="margin-left:10px;">{{ $cd->sumber->kode }}</span>
                                                        </td>

                                                        <td class="num">
                                                            {{ number_format($cd->semula_volume) . ' ' . $cd->semula_indikator }}
                                                        </td>
                                                        <td class="num">{{ number_format($cd->semula_satuan) }}
                                                        </td>
                                                        <td class="num">{{ number_format($cd->semula_total) }}</td>

                                                        <td class="num">
                                                            {{ number_format($cd->menjadi_volume) . ' ' . $cd->menjadi_indikator }}
                                                        </td>
                                                        <td class="num">{{ number_format($cd->menjadi_satuan) }}
                                                        </td>
                                                        <td class="num">{{ number_format($cd->menjadi_total) }}
                                                        </td>
                                                        <td class="num delta-zero"></td>
                                                        <td></td>
                                                        <td class="aksi">
                                                            @if (isSuperadmin() or isFeatureAvailable($ricu->dibuat_oleh))
                                                                <span class="row-aksi">
                                                                    <button
                                                                        wire:click="mountAction('deleteRincianDetail', { id: {{ $cd->id }} })"
                                                                        class="icon-only icon-delete"
                                                                        title="Hapus rincian"><svg viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2">
                                                                            <path d="M3 6h18" />
                                                                            <path
                                                                                d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0l-1 14a2 2 0 01-2 2H7a2 2 0 01-2-2L4 6" />
                                                                        </svg>
                                                                    </button>
                                                                </span>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach

                                    <tr class="total">
                                        <td colspan="2" class="label">JUMLAH PENDAPATAN</td>
                                        <td class="num">0</td>
                                        <td class="num">0</td>
                                        <td class="num">{{ number_format($total_semula) }}</td>

                                        <td class="num">0</td>
                                        <td class="num">0</td>
                                        <td class="num">{{ number_format($total_menjadi) }}</td>
                                        <td class="num">({{ number_format($total_menjadi - $total_semula) }})</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </article>
                @endforeach
            @else
                <div class="empty-state fade-in" id="emptyState">
                    <div class="empty-icon">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.6">
                            <path d="M9 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-4" />
                            <path d="M18 2l4 4-10 10H8v-4L18 2z" />
                        </svg>
                    </div>
                    <h3>Belum ada rincian untuk bidang ini</h3>
                    <p>Tambahkan bidang belanja beserta kode rekening, anggaran semula, dan anggaran perubahannya
                        untuk
                        melengkapi laporan.</p>
                    <button wire:click="mountAction('tambahRincianUtama')" class="btn-add" id="btnAddBidang">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Tambah Bidang Baru
                    </button>
                </div>
            @endif
        </section>

        <!-- ===== FLOATING MENU ===== -->
        <div class="fab-backdrop" id="fabBackdrop"></div>
        <div class="fab-container" id="fabContainer">
            <div class="fab-menu" id="fabMenu">
                <button class="fab-item fab-docs" id="fabDocs" type="button">
                    <span class="fab-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                        </svg>
                    </span>
                    <span class="fab-item-label">Tata Cara / Dokumentasi</span>
                </button>
                <button wire:click="mountAction('tambahDetail')" class="fab-item fab-add" id="fabAddRincian"
                    type="button">
                    <span class="fab-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </span>
                    <span class="fab-item-label">Tambah Detail</span>
                </button>
                <button wire:click="mountAction('tambahRincianUtama')" class="fab-item fab-add" id="fabAddRincian"
                    type="button">
                    <span class="fab-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </span>
                    <span class="fab-item-label">Tambah Rincian</span>
                </button>
            </div>
            <button class="fab-main" id="fabMain" type="button" aria-expanded="false"
                aria-label="Buka menu aksi cepat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" />
                </svg>
            </button>
        </div>
    </main>

    <script>
        // Effects only — no data generation.

        // Staggered fade-in for elements already in the DOM
        document.querySelectorAll('.fade-in').forEach((el, i) => {
            el.style.animationDelay = (i * 90) + 'ms';
        });

        // ===== FLOATING MENU: buka / tutup =====
        var fabContainer = document.getElementById('fabContainer');
        var fabMain = document.getElementById('fabMain');
        var fabBackdrop = document.getElementById('fabBackdrop');
        var fabDocs = document.getElementById('fabDocs');
        var fabAddRincian = document.getElementById('fabAddRincian');

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

        // "Tambah Rincian" dari floating menu — arahkan ke tombol yang sama di section 1
        fabAddRincian.addEventListener('click', function() {
            setFabOpen(false);
            var target = document.getElementById('btnAddRincian');
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            setTimeout(function() {
                target.style.transform = 'scale(0.97)';
                setTimeout(function() {
                    target.style.transform = '';
                }, 140);
            }, 300);
        });

        // "Tata Cara / Dokumentasi" — placeholder, belum ada halaman dokumentasi
        fabDocs.addEventListener('click', function() {
            setFabOpen(false);
            this.style.transform = '';
        });

        // Kegiatan-info row — buka/tutup baris rincian lain di dalam tbody yang sama
        function toggleKegiatan(kegiatan_id) {
            const kegiatan_cont = document.getElementById('kegiatan_' + kegiatan_id);
            
            kegiatan_cont.classList.toggle('is-collapsed');
        }
    </script>
</x-filament-panels::page>
