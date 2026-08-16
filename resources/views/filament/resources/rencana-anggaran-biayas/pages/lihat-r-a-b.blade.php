<x-filament-panels::page>
    <x-css.rabcss />

    <div class="document">

        <!-- ================= HEADER / LETTERHEAD ================= -->
        <header class="letterhead">
            <div class="eyebrow">Rencana Anggaran Biaya</div>
            <h1>Pemerintah Desa Pecatu<br>Kecamatan Kuta Selatan</h1>
            <div class="sub">Dokumen rincian anggaran belanja tingkat kegiatan desa</div>

            <div class="head-meta">
                <div class="field">
                    <div class="label">Tahun Anggaran</div>
                    <div class="value">{{ $record->tahun }}</div>
                </div>
                <div class="field">
                    <div class="label">Jenis APBDes</div>
                    <div class="value">{{ $record->jenis }}</div>
                </div>
                <div class="field">
                    <div class="label">Terakhir Diperbarui</div>
                    <div class="value updated">{{ toCarbon($record->updated_at, 'Y-m-d H:i:s', 'D, d F Y H:i A') }}
                    </div>
                </div>
                <div class="seal">
                    <div class="seal-text">Berlaku<br>{{ $record->tahun }}</div>
                </div>
            </div>
        </header>

        <!-- ================= CONTENT ================= -->
        <main class="content-wrap" id="mainContent">

            @if (count($record->rabBidangs) > 0)
                @php
                    $no = 1;
                @endphp
                @foreach ($record->rabBidangs as $rabb)
                    @php
                        $jumlah_total = $rabb->uraians->sum('jumlah_kas');
                    @endphp
                    <!-- ===== BIDANG BLOCK (berulang per bidang) ===== -->
                    <section class="bidang-block" id="bidangList_{{ $rabb->id }}">

                        <div class="bidang-header-bar" data-toggle-target="bidangList_{{ $rabb->id }}">
                            <div class="bidang-header-left">
                                <span class="bidang-header-tag">{{ $no++ }}.</span>
                                <span class="bidang-header-title capitalize">{{ $rabb->keluaran }}</span>
                            </div>
                            <div class="bidang-header-right">
                                <span class="bidang-header-total">Rp {{ number_format($jumlah_total) }}</span>
                                <div class="bidang-header-actions">
                                    <button wire:click="mountAction('editBidang', { id: {{ $rabb->id }} })" class="icon-btn icon-edit" type="button" title="Edit bidang">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20L4.6 16.7L16.4 4.9C16.9 4.4 17.7 4.4 18.2 4.9L19.1 5.8C19.6 6.3 19.6 7.1 19.1 7.6L7.3 19.4L4 20Z" stroke="#14536A" stroke-width="1.4" stroke-linejoin="round"/></svg>
                                    </button>
                                    <button wire:click="mountAction('deleteBidang', { id: {{ $rabb->id }} })" class="icon-btn icon-delete" type="button" title="Hapus bidang">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7H19M9.5 7V4.8C9.5 4.4 9.8 4 10.3 4H13.7C14.2 4 14.5 4.4 14.5 4.8V7M17.5 7L16.9 18.5C16.9 19 16.4 19.5 15.9 19.5H8.1C7.6 19.5 7.1 19 7.1 18.5L6.5 7" stroke="#DC2626" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                    <button class="toggle-collapse" type="button" aria-expanded="true" title="Sembunyikan / tampilkan bidang">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9L12 15L18 9" stroke="#072A38" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bidang-collapsible">
                            <div class="bidang-collapsible-inner">

                                <div class="bidang-meta">
                                    <div class="m-label">Bidang</div>
                                    <div class="m-value strong capitalize">{{ $rabb->bidang }}</div>

                                    <div class="m-label">Sub Bidang</div>
                                    <div class="m-value capitalize">{{ $rabb->sub }}</div>

                                    <div class="m-label">Kegiatan</div>
                                    <div class="m-value capitalize">{{ $rabb->kegiatan }}</div>

                                    <div class="m-label">Waktu Pelaksanaan</div>
                                    <div class="m-value capitalize">{{ $rabb->waktu }} {{ $rabb->indikator_waktu }}</div>

                                    <div class="m-label">Output / Keluaran</div>
                                    <div class="m-value capitalize">{{ $rabb->keluaran }}</div>

                                    <div class="meta-actions">
                                        {{-- <button class="btn-add-sm" id="btnAddUraian" type="button">
                                            <span class="plus">+</span> Tambah Uraian
                                        </button> --}}
                                        {{ $this->tambahUraian()(['rabb_id' => $rabb->id]) }}
                                    </div>
                                </div>

                                <div class="table-scroll">
                                    <table class="rab-table">
                                        <thead>
                                            <tr>
                                                <th class="col-kode" rowspan="2">Kode</th>
                                                <th rowspan="2">Uraian</th>
                                                <th colspan="3">Anggaran</th>
                                            </tr>
                                            <tr class="subrow">
                                                <th class="col-num">Volume</th>
                                                <th class="col-num">Harga Satuan</th>
                                                <th class="col-num">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($rabb->uraians) > 0)
                                                @php
                                                    $current_jumlah = 0;
                                                @endphp

                                                <tr class="row-belanja">
                                                    <td class="col-kode">5.</td>
                                                    <td class="col-uraian">Belanja</td>
                                                    <td class="col-num"></td>
                                                    <td class="col-num"></td>
                                                    <td class="col-num">{{ number_format($jumlah_total) }}</td>
                                                </tr>

                                                @foreach ($rabb->uraians as $u)
                                                    <tr class="row-item-head data-row">
                                                        <td class="col-kode">{{ $u->rabb->rkkbd->kegiatan->kode }}</td>
                                                        <td class="col-uraian">
                                                            <div class="item-uraian-row">
                                                                <span>{{ $u->judul }}</span>
                                                                <span class="row-actions">
                                                                    <button wire:click="mountAction('editUraian', { id: {{ $u->id }}})" class="icon-btn icon-edit" type="button"
                                                                        title="Edit uraian">
                                                                        <svg viewBox="0 0 24 24" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M4 20L4.6 16.7L16.4 4.9C16.9 4.4 17.7 4.4 18.2 4.9L19.1 5.8C19.6 6.3 19.6 7.1 19.1 7.6L7.3 19.4L4 20Z"
                                                                                stroke="#14536A" stroke-width="1.4"
                                                                                stroke-linejoin="round" />
                                                                        </svg>
                                                                    </button>
                                                                    <button wire:click="mountAction('deleteUraian', { id: {{ $u->id }} })" class="icon-btn icon-delete" type="button"
                                                                        title="Hapus uraian">
                                                                        <svg viewBox="0 0 24 24" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M5 7H19M9.5 7V4.8C9.5 4.4 9.8 4 10.3 4H13.7C14.2 4 14.5 4.4 14.5 4.8V7M17.5 7L16.9 18.5C16.9 19 16.4 19.5 15.9 19.5H8.1C7.6 19.5 7.1 19 7.1 18.5L6.5 7"
                                                                                stroke="#DC2626" stroke-width="1.4"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                        </svg>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="col-num"></td>
                                                        <td class="col-num"></td>
                                                        <td class="col-num">{{ number_format($u->jumlah_kas) }}</td>
                                                    </tr>

                                                    @foreach ($u->rabud as $ud)
                                                        @php
                                                            $current_jumlah += $ud->jumlah;
                                                        @endphp
                                                        <tr class="row-item data-row">
                                                            <td class="col-kode">{{ $ud->kode_kas }}</td>
                                                            <td class="col-uraian">
                                                                <div class="item-uraian-row">
                                                                    <span>{{ $ud->judul }} <span
                                                                            class="satuan-tag">ADD</span></span>
                                                                    <span class="row-actions">
                                                                        <button wire:click="mountAction('editDetail', { id: {{ $ud->id }} })" class="icon-btn icon-edit" type="button"
                                                                            title="Edit uraian">
                                                                            <svg viewBox="0 0 24 24" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M4 20L4.6 16.7L16.4 4.9C16.9 4.4 17.7 4.4 18.2 4.9L19.1 5.8C19.6 6.3 19.6 7.1 19.1 7.6L7.3 19.4L4 20Z"
                                                                                    stroke="#14536A" stroke-width="1.4"
                                                                                    stroke-linejoin="round" />
                                                                            </svg>
                                                                        </button>
                                                                        <button
                                                                            wire:click="mountAction('deleteDetail', { id: {{ $ud->id }} })"
                                                                            class="icon-btn icon-delete" type="button"
                                                                            title="Hapus uraian">
                                                                            <svg viewBox="0 0 24 24" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M5 7H19M9.5 7V4.8C9.5 4.4 9.8 4 10.3 4H13.7C14.2 4 14.5 4.4 14.5 4.8V7M17.5 7L16.9 18.5C16.9 19 16.4 19.5 15.9 19.5H8.1C7.6 19.5 7.1 19 7.1 18.5L6.5 7"
                                                                                    stroke="#DC2626" stroke-width="1.4"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round" />
                                                                            </svg>
                                                                        </button>
                                                                    </span>
                                                                </div>

                                                            </td>
                                                            <td class="col-num">{{ $ud->volume }} {{ $ud->indikator }}</td>
                                                            <td class="col-num">{{ number_format($ud->harga_satuan) }}</td>
                                                            <td class="col-num">{{ number_format($ud->jumlah) }}</td>
                                                        </tr>
                                                    @endforeach

                                                    <tr class="row-add-detail data-row">
                                                        <td colspan="5">
                                                            {{-- <button class="btn-add-detail" type="button">
                                                                <span class="plus">+</span> Tambah Detail Uraian
                                                            </button> --}}
                                                            {{ $this->tambahDetail()(['rabu_id' => $u->id, 'rabb_id' => $rabb->id]) }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="4">Jumlah (Rp)</td>
                                                    <td class="col-num">{{ number_format($current_jumlah) }}</td>
                                                </tr>
                                            @else
                                                <!-- ===== ROW KOSONG (tampil bila belum ada uraian) ===== -->
                                                <tr class="row-empty" id="tableEmptyRow">
                                                    <td colspan="5">
                                                        <div class="empty-row-inner">
                                                            <div class="empty-row-icon">
                                                                <svg viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4 12H20" stroke="#C9A25A" stroke-width="1.6"
                                                                        stroke-linecap="round" />
                                                                </svg>
                                                            </div>
                                                            <div class="empty-row-text">Belum ada uraian pada bidang ini.
                                                                Gunakan
                                                                tombol "Tambah Uraian" di atas.</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif



                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </section>
                @endforeach
            @else
                <!-- ===== EMPTY STATE (tampil bila belum ada bidang) ===== -->
                <div class="empty-state" id="emptyState">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 3.5H14.5L19 8V20.5H6V3.5Z" stroke="#C9A25A" stroke-width="1.4"
                                stroke-linejoin="round" />
                            <path d="M14.5 3.5V8H19" stroke="#C9A25A" stroke-width="1.4" stroke-linejoin="round" />
                            <path d="M9.5 13H15.5M9.5 16.5H13" stroke="#C9A25A" stroke-width="1.4"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="eyebrow-tag">Rincian Anggaran</div>
                    <h2>Belum ada bidang yang ditambahkan</h2>
                    <p>Rincian anggaran biaya akan tampil di sini setelah bidang ditambahkan. Silahkan tambahkan
                        menggunakan
                        tombol di bawah ini, atau tombol <span class="ref-link">Tambah Bidang</span> di pojok kanan
                        atas.
                    </p>

                    {{ $this->tambahBidang() }}

                    {{-- <button class="btn-add-outline" id="btnAddEmpty" type="button">
                        <span class="plus">+</span> Tambah Bidang
                    </button> --}}
                </div>
            @endif

        </main>
    </div>

    <script>
        // Collapse / expand tiap bidang-block (murni efek tampilan)
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.bidang-header-bar').forEach(function (bar) {
                var block = bar.closest('.bidang-block');
                var btn = bar.querySelector('.toggle-collapse');

                function toggleCollapse() {
                    var collapsed = block.classList.toggle('is-collapsed');
                    btn.setAttribute('aria-expanded', String(!collapsed));
                }

                bar.addEventListener('click', toggleCollapse);
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    toggleCollapse();
                });
            });
        });
    </script>
</x-filament-panels::page>
