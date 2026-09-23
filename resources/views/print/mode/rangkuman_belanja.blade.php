@foreach ($results as $res)
    <article class="rab-item" style="margin-bottom: 50px;">

        <!-- ---- Info Header Kegiatan/Sub Kegiatan ---- -->
        <table class="info-kegiatan">
            <tr>
                <td class="info-label">Bidang</td>
                <td class="info-titik">:</td>
                <td>{{ $res['data']['bidang']['kode'] }} {{ $res['data']['bidang']['nama'] }}</td>
            </tr>
            <tr>
                <td class="info-label">Sub Bidang</td>
                <td class="info-titik">:</td>
                <td>
                    {{ $res['data']['sub_bidang']['kode'] }} {{ $res['data']['sub_bidang']['nama'] }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Kegiatan</td>
                <td class="info-titik">:</td>
                <td>
                    {{ $res['kode'] }}. {{ $res['nama'] }}
                </td>
            </tr>
            <tr>
                <td class="info-label">Sub Kegiatan</td>
                <td class="info-titik">:</td>
                <td>
                    <strong>{{ $res['data']['sub_kegiatan'] }}</strong>
                </td>
            </tr>
            <tr>
                <td class="info-label">Waktu Pelaksanaan</td>
                <td class="info-titik">:</td>
                <td>{{ $res['durasi'] }}</td>
            </tr>
            <tr>
                <td class="info-label">Output / Keluaran</td>
                <td class="info-titik">:</td>
                <td>{{ $res['output'] }}</td>
            </tr>
        </table>

        <!-- ---- Tabel Rincian Anggaran ---- -->
        <div class="table-wrap">
            @php
                $apbd_perubahan = $apbd->perubahans;
            @endphp
            <table class="ledger ledger--rab">
                <thead>
                    <tr>
                        <th rowspan="2" class="kode">Kode Rekening</th>
                        <th rowspan="2" class="uraian-col">Uraian</th>
                        <th colspan="3" class="">Anggaran Induk</th>
                        @foreach ($apbd_perubahan as $ap)
                            <th colspan="3" class="">{{ $ap->judul }}</th>
                            <th rowspan="2">{{ $ap->judul }} (Lebih/Kurang)</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="">Volume</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        @foreach ($apbd_perubahan as $ap)
                            <th class="">Volume</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                        @endforeach
                    </tr>

                </thead>

                <tbody>
                    @php
                        $totalan = 0;
                        $totalan_pbd = [];

                        foreach ($apbd_perubahan as $value) {
                            $totalan_pbd[$value->id] = 0;
                        }

                        $additional_colspan = count($apbd_perubahan) > 0 ? count($apbd_perubahan) + 3 : 0;
                    @endphp
                    @foreach ($res['utamas'] as $utama)
                        {{-- Utama --}}
                        <tr class="lvl-0">
                            <td class="kode">{{ $utama['kode'] }}</td>
                            <td colspan="3" class="">{{ $utama['nama'] }}</td>
                            <td class="num varian is-flat">{{ number_format($utama['total']) }}</td>
                            @foreach ($apbd_perubahan as $ap)
                                <td colspan="2" class=""></td>
                                <td class="num">{{ number_format($utama['perubahan_totals'][$ap->id]) }}</td>
                                <td class="num">
                                    <span class="varian is-up">{{ number_format($utama['total'] - $utama['perubahan_totals'][$ap->id]) }}</span>
                                </td>
                            @endforeach
                            
                        </tr>
                        @foreach ($utama['sub_utamas'] as $su)
                            @php
                                $totalan += $su['total'];
                            @endphp
                            {{-- Sub Utama --}}
                            <tr class="lvl-1">
                                <td class="kode">{{ $su['kode'] }}</td>
                                <td colspan="3" style="padding-left: 28px">{{ $su['nama'] }}</td>
                                <td class="num varian is-flat">{{ number_format($su['total']) }}</td>
                                @foreach ($apbd_perubahan as $ap)
                                    <td colspan="2" class=""></td>
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
                                    <td style="padding-left: 44px">{{ $ssu['nama'] }}</td>
                                    <td class="vol"></td>
                                    <td class="harga"></td>
                                    <td class="num">{{ number_format($ssu['total']) }}</td>
                                    @foreach ($apbd_perubahan as $ap)
                                        <td colspan="2" class=""></td>
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
                                        <td style="padding-left: 60px">{{ $sssu['nama'] }}</td>
                                        <td class="vol"></td>
                                        <td class="harga"></td>
                                        <td class="num">{{ number_format($sssu['total']) }}</td>
                                        @foreach ($apbd_perubahan as $ap)
                                            <td colspan="2" class=""></td>
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
                                        {{-- Rincian --}}
                                        <tr class="lvl-4">
                                            <td class="kode"></td>
                                            <td style="padding-left: 76px">{{ $rno++ }}.&nbsp;&nbsp;{{ $data->judul }}</td>
                                            <td class="vol">{{ $data->volume }} {{ $data->indikator_volume }}</td>
                                            <td class="harga">{{ number_format($data->satuan) }}</td>
                                            <td class="num">{{ number_format($data->jumlah) }}</td>
                                            @foreach ($apbd_perubahan as $ap)
                                                @php
                                                    $dpbopID = $data->getPerubahanBasedOnPerubahanID($ap->id);
                                                    $jumlah_perubahan = $dpbopID ? $dpbopID->jumlah : 0;
                                                    $total = $data->jumlah - $jumlah_perubahan;
                                                    $volume = $dpbopID ? $dpbopID->volume . ' ' . $dpbopID->indikator_volume : 0;
                                                    $satuan = $dpbopID ? $dpbopID->satuan : 0;
                                                    $totalan_pbd[$ap->id] += $jumlah_perubahan;
                                                @endphp

                                                <td style="text-align: right;">{{ $volume }}</td>
                                                <td style="text-align: right;">{{ number_format($satuan) }}</td>
                                                <td style="text-align: right;">{{ number_format($jumlah_perubahan) }}</td>
                                                <td style="text-align: right;">{{ number_format($total) }}</td>
                                            @endforeach
                                        </tr>

                                        {{-- jika detail paket tidak kosong --}}
                                        @php
                                            $dpno = 1;
                                        @endphp
                                        @if ($data->detail_paket)
                                            @foreach ($data->detail_paket as $key => $dp)
                                                <tr class="lvl-4">
                                                    <td class="kode"></td>
                                                    <td style="padding-left: 96px">{{ $dpno++ }}.&nbsp;&nbsp;{{ $dp['detail_judul'] }}</td>
                                                    <td class="vol">{{ $dp['detail_volume'] }} {{ $dp['detail_indikator_volume'] }}</td>
                                                    <td class="harga">{{ number_format($dp['detail_satuan']) }}</td>
                                                    <td class="num">{{ number_format($dp['detail_jumlah']) }}</td>

                                                    @foreach ($apbd_perubahan as $ap)
                                                        @php
                                                            $pdpbopID = $data->getPerubahanBasedOnPerubahanID($ap->id);
                                                            $pdp = $pdpbopID ? $pdpbopID->detail_paket : null;
                                                        @endphp
                                                        <td style="text-align: right;">{{ $pdp ? $pdp[$key]['detail_volume'] . '  ' . $pdp[$key]['detail_indikator_volume'] : '-' }}</td>
                                                        <td style="text-align: right;">{{ $pdp ? number_format($pdp[$key]['detail_satuan']) : '-' }}</td>
                                                        <td style="text-align: right;">{{ $pdp ? number_format($pdp[$key]['detail_jumlah']) : '-' }}</td>
                                                        <td style="text-align: right;">
                                                            {{ $pdp ? number_format($dp['detail_jumlah'] - $pdp[$key]['detail_jumlah']) : '-' }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Jumlah Belanja</td>
                        <td class="num" style="text-align:right;">{{ number_format($totalan) }}</td>
                        @foreach ($apbd_perubahan as $ap)
                            <td colspan="3" style="text-align: right;">{{ number_format($totalan_pbd[$ap->id]) }}</td>
                            <td style="text-align: right;">{{ number_format($totalan - $totalan_pbd[$ap->id]) }}</td>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>

    </article>
@endforeach