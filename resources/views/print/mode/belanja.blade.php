<table class="ledger">
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
            <th colspan="4" class="group-divider">Rincian Penjabaran Pertama
            </th>
            <th rowspan="2" class="group-divider">Awal (Rp)</th>
            {{-- <th rowspan="2">Bertambah<br>(Berkurang) (Rp)</th> --}}
        </tr>
        <tr>
            @foreach ($sub_mains as $sm)
                <th
                    style="
                    overflow-wrap: break-word;
                    word-break: break-word;
                    white-space: normal;
                ">
                    {{ $sm->nama }} (Rp)</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @foreach ($results as $res)
            <tr class="lvl-0">
                <td class="kode">{{ $res['kode'] }}</td>
                <td colspan="7"><span class="uraian">{{ $res['nama'] }}</span></td>
                <td class="num"><span
                        class="varian is-up">{{ number_format($res['total']) }}</span></td>
            </tr>
            @foreach ($res['sub_bidangs'] as $sub_bidang)
                <tr class="lvl-1">
                    <td class="kode">{{ $sub_bidang['kode'] }}</td>
                    <td style="padding-left:28px" colspan="3"><span
                            class="uraian">{{ $sub_bidang['nama'] }}</span></td>
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
                        <td style="padding-left:44px" colspan="3"><span
                                class="uraian">{{ $kegiatan['nama'] }}</span></td>
                        <td class="num group-divider"></td>
                        <td class="num"></td>
                        <td class="num"></td>
                        <td class="num"></td>
                        <td class="num group-divider">{{ number_format($kegiatan['total']) }}</td>
                        {{-- <td class="num"><span class="varian is-flat">0,00</span></td> --}}
                    </tr>

                    @foreach ($kegiatan['sub_kegiatans'] as $sub_kegiatan)
                        <tr class="lvl-3">
                            <td class="kode">{{ $sub_kegiatan['kode'] }}</td>
                            <td style="padding-left:60px" colspan="3"><span
                                    class="uraian">{{ $sub_kegiatan['nama'] }}</span></td>
                            <td class="num group-divider"></td>
                            <td class="num"></td>
                            <td class="num"></td>
                            <td class="num"></td>
                            <td class="num"><span
                                    class="varian is-flat">{{ number_format($sub_kegiatan['total']) }}</span>
                            </td>
                        </tr>

                        @php
                            $knomor = 1;
                        @endphp
                        @foreach ($sub_kegiatan['groups'] as $gp)
                            <tr class="lvl-4">
                                <td class="kode"></td>
                                <td style="padding-left:68px" colspan="3"><span
                                        class=" font-light">{{ $knomor++ }} &nbsp;
                                        {{ $gp['nama'] }}</span></td>
                                @if (count($gp['rincian_per_submain']) > 0)
                                    @foreach ($gp['rincian_per_submain'] as $rps)
                                        <td class="num group-divider">
                                            {{ number_format($rps['total']) }}</td>
                                    @endforeach
                                    <td class="num group-divider">{{ number_format($gp['total']) }}
                                    </td>
                                @else
                                    <td class="num group-divider"></td>
                                    <td class="num"></td>
                                    <td class="num"></td>
                                    <td class="num"></td>
                                    <td class="num group-divider">0,00</td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
