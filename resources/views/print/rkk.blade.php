<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak — RKP Desa Pecatu</title>
    <style>
        :root {
            --ink: #16262C;
            --ink-muted: #45555A;
            --line: #999999;
            --line-strong: #000000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: var(--ink);
        }

        /* ===== KERTAS A4 LANDSCAPE ===== */
        .sheet {
            margin: 12mm auto;
            background: #ffffff;
            padding: 10mm 10mm 14mm;
            box-shadow: 0 0 0 1px #d8d8d8, 0 6px 24px rgba(0, 0, 0, 0.12);
            position: relative;
        }

        .screen-only {
            margin: 0 auto 4mm;
            display: flex;
            justify-content: flex-end;
        }

        .print-hint {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #555;
            background: #fff;
            border: 1px solid #ccc;
            padding: 8px 14px;
        }

        .print-hint kbd {
            font-family: monospace;
            background: #f1f1f1;
            border: 1px solid #ccc;
            padding: 1px 5px;
        }

        /* ===== KOP ===== */
        .kop-title {
            text-align: center;
            margin-bottom: 2.5mm;
        }

        .kop-title h1 {
            font-size: 12pt;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .kop-title h2 {
            font-size: 10pt;
            font-weight: 700;
            margin-top: 0.8mm;
        }

        .kop-meta {
            font-size: 8pt;
            margin-bottom: 2mm;
        }

        .kop-meta table {
            border-collapse: collapse;
        }

        .kop-meta td {
            padding: 0.3mm 0;
            vertical-align: top;
        }

        .kop-meta td.label {
            width: 30mm;
            font-weight: 700;
        }

        .kop-meta td.sep {
            width: 4mm;
        }

        /* ===== TABEL ===== */
        table.rkp {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 6.3pt;
            line-height: 1.25;
        }

        table.rkp th,
        table.rkp td {
            border: 1px solid var(--line-strong);
            padding: 0.7mm 1mm;
            vertical-align: top;
            overflow-wrap: break-word;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        table.rkp thead th {
            text-align: center;
            font-weight: 700;
            background: #f0f0f0;
            vertical-align: middle;
            font-size: 6.4pt;
            padding: 0.6mm 1mm;
        }

        table.rkp thead {
            display: table-header-group;
        }

        table.rkp tbody tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        table.rkp td.center,
        table.rkp th.center {
            text-align: center;
        }

        table.rkp td.num {
            text-align: right;
        }

        table.rkp tr.grp td {
            font-weight: 700;
            background: #f6f6f6;
        }

        table.rkp td .sub-bidang {
            color: var(--ink-muted);
        }

        table.rkp td .jenis {
            margin-top: 0.4mm;
            font-style: italic;
        }

        table.rkp td .sumber {
            display: block;
            font-size: 6pt;
            font-weight: 700;
            margin-top: 0.4mm;
        }

        col.kd {
            width: 3.5%;
        }

        col.bidang {
            width: 11%;
        }

        col.jenis {
            width: 12%;
        }

        col.lokasi {
            width: 6%;
        }

        col.volume {
            width: 4%;
        }

        col.satuan {
            width: 4.5%;
        }

        col.biaya {
            width: 8.5%;
        }

        col.sasaran {
            width: 3.6%;
        }

        col.durasi {
            width: 4.5%;
        }

        col.mulai {
            width: 4.5%;
        }

        col.selesai {
            width: 4.5%;
        }

        col.pelaksana {
            width: 9%;
        }

        col.tim {
            width: 7%;
        }

        /* ===== FOOTER CETAK (mengikuti gaya Siskeudes) ===== */
        .print-foot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2mm;
            font-size: 7.5pt;
        }

        .print-foot .stamp {
            background: var(--line-strong);
            color: #fff;
            padding: 1mm 3mm;
        }

        /* ===== PRINT RULES ===== */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            body {
                background: #ffffff;
            }

            .screen-only {
                display: none;
            }

            .sheet {
                width: auto;
                min-height: 0;
                margin: 0;
                padding: 6mm 6mm 7mm;
                box-shadow: none;
                page-break-after: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <div class="screen-only">
        <div class="print-hint">Tekan <kbd>Ctrl</kbd> + <kbd>P</kbd> (atau <kbd>Cmd</kbd> + <kbd>P</kbd> di Mac) untuk
            mencetak halaman ini &mdash; pilih orientasi <strong>Landscape</strong>.</div>
    </div>

    <div class="sheet">

        <div class="kop-title">
            <h1 style="text-transform: uppercase;">{{ $record->judul }}</h1>
            <h2 style="text-transform: uppercase;">TAHUN {{ $record->tahun }}</h2>
        </div>

        <div class="kop-meta">
            <table>
                <tr>
                    <td class="label">DESA</td>
                    <td class="sep">:</td>
                    <td>PEMERINTAH DESA PECATU</td>
                </tr>
                <tr>
                    <td class="label">KECAMATAN</td>
                    <td class="sep">:</td>
                    <td>KECAMATAN KUTA SELATAN</td>
                </tr>
                <tr>
                    <td class="label">KABUPATEN/KOTA</td>
                    <td class="sep">:</td>
                    <td>KABUPATEN BADUNG</td>
                </tr>
                <tr>
                    <td class="label">PROVINSI</td>
                    <td class="sep">:</td>
                    <td>PROVINSI BALI</td>
                </tr>
            </table>
        </div>

        <table class="rkp">
            <colgroup>
                <col class="kd">
                <col class="bidang">
                <col class="jenis">
                <col class="lokasi">
                <col class="volume">
                <col class="satuan">
                <col class="biaya">
                <col class="sasaran">
                <col class="sasaran">
                <col class="sasaran">
                <col class="sasaran">
                <col class="durasi">
                <col class="mulai">
                <col class="selesai">
                <col class="pelaksana">
                <col class="tim">
            </colgroup>
            <thead>
                <tr>
                    <th rowspan="3">KD</th>
                    <th colspan="2" rowspan="3">BIDANG/SUB BIDANG/JENIS KEGIATAN</th>
                    <th rowspan="3">JENIS KEGIATAN</th>
                    <th rowspan="3">LOKASI</th>
                    <th rowspan="3">VOLUME</th>
                    <th rowspan="3">SATUAN</th>
                    <th rowspan="3">BIAYA DAN<br>SUMBER DANA</th>
                    <th colspan="4">SASARAN</th>
                    <th colspan="3">WAKTU PELAKSANAAN</th>
                    <th rowspan="3">PELAKSANA<br>KEGIATAN<br>ANGGARAN</th>
                    <th rowspan="3">TIM YANG<br>MELAKSANAKAN</th>
                </tr>
                <tr>
                    <th>JUMLAH</th>
                    <th>LAKI LAKI</th>
                    <th>PEREMPUAN</th>
                    <th>A-RTM</th>
                    <th>DURASI</th>
                    <th>MULAI</th>
                    <th>SELESAI</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                    <th>11</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $apbd = $record->apbd;
                    $grpMains = $apbd->groupOfRincianUtamaBasedOnMainBidang();

                    $jumlah_total = 0;
                @endphp

                @foreach ($grpMains as $gm)
                    @php
                        $mainBidang = getBidang($gm->main_id);
                        $daftarChildDetails = getAPBDChildDetail($apbd->id, $gm->main_id);
                    @endphp
                    <tr class="grp">
                        <td class="center">{{ $mainBidang->kode }}</td>
                        <td colspan="15">{{ $mainBidang->nama }}</td>
                    </tr>
                    @foreach ($daftarChildDetails as $dcd)
                        @php
                            $jumlah_total += $dcd->menjadi_total;
                        @endphp
                            <tr>
                                <td class="kd"></td>
                                <td colspan="2">
                                    <div>{{ $dcd->sub->nama }}</div>
                                </td>
                                <td><div style="color:var(--text-soft); font-style:italic; margin-top:3px;">{{ $dcd->kegiatan->nama }}</div></td>
                                <td>{{ $dcd->lokasi }}</td>
                                <td class="num">{{ $dcd->menjadi_volume }}</td>
                                <td class="center">{{ $dcd->menjadi_indikator }}</td>
                                <td class="num">{{ number_format($dcd->menjadi_total) }}<span class="sumber-dana">{{ $dcd->sumber->kode }}</span></td>
                                <td class="sasaran">{{ $dcd->sasaran_male }}</td>
                                <td class="sasaran">{{ $dcd->sasaran_female }}</td>
                                <td class="sasaran">{{ $dcd->sasaran_artm }}</td>
                                <td class="sasaran">{{ ($dcd->sasaran_male + $dcd->sasaran_female + $dcd->sasaran_artm) }}</td>
                                <td class="center">{{ dateDiffCarbon($dcd->apbdru->tanggal_mulai, $dcd->apbdru->tanggal_selesai, 'month') }}</td>
                                <td class="center">{{ toCarbon($dcd->apbdru->tanggal_mulai, 'Y-m-d', 'm/Y') }}</td>
                                <td class="center">{{ toCarbon($dcd->apbdru->tanggal_selesai, 'Y-m-d', 'm/Y') }}</td>
                                <td>{{ $dcd->jabatan->nama }}</td>
                                <td></td>
                            </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align:right; font-weight:700; color:var(--pecatu-navy);">
                        Jumlah Total Biaya</td>
                    <td class="num" colspan="2" style="font-weight:700; font-size:10px; color:var(--pecatu-navy);">
                        {{ number_format($jumlah_total) }}</td>
                    <td colspan="8"></td>
                </tr>
            </tfoot>
        </table>

    </div>

</body>

</html>
