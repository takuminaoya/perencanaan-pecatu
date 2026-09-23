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
                                <td class="num">{{ number_format($ssu['perubahan_totals'][$ap->id]) }}</td>
                                <td class="num">
                                    <span class="varian is-up">{{ number_format($ssu['total'] - $ssu['perubahan_totals'][$ap->id]) }}</span>
                                </td>
                            @endforeach
                        </tr>

                        @php
                            $rno = 1;
                        @endphp
                        @foreach ($sssu['datas'] as $data) 
                            @php
                                if($data->tipe === 'masuk'){
                                    $totalan += $data->jumlah;
                                } else {
                                    $totalan -= $data->jumlah;
                                }
                            @endphp
                            {{-- Rincian --}}
                            <tr class="lvl-4">
                                <td class="kode">&nbsp;</td>
                                <td style="padding-left: 76px" class="flex flex-row justify-start items-center gap-2">
                                    <span class="uraian">{{ $rno++ }}&nbsp; {{ $data->judul }}</span>
                                    <span class=" border border-red-200 text-xs px-2 bg-amber-50">{{ $data->sumberDana->kode }}</span>
                                </td>
                                <td class="num"><span class="varian {{ $data->tipe == 'masuk' ? 'is-up' : 'is-down' }}">{{ number_format($data->jumlah) }}</span></td>
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
            <td colspan="2" style="text-transform: capitalize;">Jumlah {{ $mode }}</td>
            <td class="num">{{ number_format($totalan) }}</td>
            @foreach ($apbd_perubahan as $ap)
                <td class="num">{{ isset($res) ? number_format($res['perubahan_totals'][$ap->id]) : 0 }}</td>
                <td class="num">{{ isset($res) ? number_format($totalan - $res['perubahan_totals'][$ap->id]) : number_format($totalan) }}</td>
            @endforeach
        </tr>
    </tfoot>
</table>