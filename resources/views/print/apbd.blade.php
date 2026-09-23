<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Rincian Anggaran Pendapatan Desa — Pemerintah Desa Pecatu</title>

    <style>
        /* ---------- Halaman cetak ---------- */
        @page {
            margin: 1.5cm 2cm 1.5cm 2cm;
        }

        /* ---------- Dasar ---------- */
        html {
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #000000;
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.3;
        }

        /* ---------- Pratinjau layar (kertas di atas latar abu-abu) ---------- */
        @media screen {
            body {
                /* background: #999999; */
                padding: 20px 0;
            }

            .sheet {
                /* width: 17cm; */
                margin: 0 auto;
                padding: 1.5cm 2cm;
                background: #ffffff;
                /* border: 1px solid #666666; */
            }
        }

        @media print {
            .sheet {
                width: auto;
                margin: 0;
                padding: 0;
                border: 0;
            }
        }


        .kop {
            display: table;
            width: 100%;
            /* table-layout: fixed; */
            border-collapse: collapse;
        }

        .kop__logo,
        .kop__text,
        .kop__space {
            display: table-cell;
            vertical-align: middle;
        }

        .kop__logo {
            width: 2.6cm;
            text-align: left;
        }

        .kop__logo img {
            display: block;
            width: 2.3cm;
            height: 2.6cm;
            border: 0;
        }

        .kop__space {
            width: 2.6cm;
        }

        .kop__text {
            text-align: center;
        }

        .kop__line1,
        .kop__line2 {
            margin: 0;
            padding: 0;
            font-size: 14pt;
            font-weight: bold;
            line-height: 1.2;
            text-transform: uppercase;
        }

        .kop__line3 {
            margin: 0;
            padding: 0;
            font-size: 17pt;
            font-weight: bold;
            line-height: 1.25;
            letter-spacing: 1pt;
            text-transform: uppercase;
        }

        .kop__address {
            margin: 3pt 0 0 0;
            padding: 0;
            font-size: 9.5pt;
            font-style: italic;
            line-height: 1.3;
        }

        /* Garis ganda kop surat: tebal di atas, tipis di bawah */
        .kop-rule {
            height: 1.5pt;
            margin: 6pt 0 0 0;
            padding: 0;
            border-top: 3pt solid #000000;
            border-bottom: 1pt solid #000000;
            font-size: 0;
            line-height: 0;
            overflow: hidden;
        }


        .title {
            margin: 16pt 0 12pt 0;
            padding: 0;
            text-align: center;
        }

        .title__main {
            margin: 0;
            padding: 0;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            line-height: 1.3;
        }

        .title__sub {
            margin: 3pt 0 0 0;
            padding: 0;
            font-size: 11pt;
            font-weight: normal;
            line-height: 1.3;
        }

        /* ---------- Keterangan dokumen ---------- */
        .info {
            width: 100%;
            margin: 0 0 8pt 0;
            border-collapse: collapse;
            font-size: 10pt;
        }

        .info td {
            padding: 1pt 0;
            border: 0;
            vertical-align: top;
        }

        .info .k {
            width: 3.6cm;
        }

        .info .s {
            width: 0.4cm;
            text-align: center;
        }


        .ledger {
            width: 100%;
            /* table-layout: fixed; */
            border-collapse: collapse;
            border: 1pt solid #000000;
            font-size: 9pt;
            line-height: 1.25;
        }

        .ledger thead {
            display: table-header-group;
            /* ulangi header di tiap halaman */
        }

        .ledger tr {
            page-break-inside: avoid;
        }

        .ledger th {
            padding: 4pt 4pt;
            border: 0.5pt solid #000000;
            background: #d9d9d9;
            font-weight: bold;
            font-size: 9pt;
            text-align: center;
            vertical-align: middle;
        }

        .ledger td {
            padding: 2.5pt 4pt;
            border: 0.5pt solid #000000;
            vertical-align: top;
            text-align: left;
        }

        /* Lebar kolom */
        /* .ledger .c-kode {
            width: 2.5cm;
        }

        .ledger .c-uraian {
            width: 5.3cm;
        }

        .ledger .c-num {
            width: 3.06cm;
        } */

        .ledger td.kode {
            text-align: left;
            white-space: nowrap;
        }

        .ledger td.num {
            text-align: right;
            white-space: nowrap;
        }

        /* Nomor kolom (baris 1 2 3 4 5 di bawah header) */
        .ledger .colno td {
            padding: 1.5pt 4pt;
            background: #f0f0f0;
            font-size: 8pt;
            font-style: italic;
            text-align: center;
        }

        /* Tingkat hierarki — dibedakan dengan tebal, latar, dan indentasi */
        .ledger .lvl-0 td {
            background: #d9d9d9;
            font-weight: bold;
        }

        .ledger .lvl-1 td {
            background: #ececec;
            font-weight: bold;
        }

        .ledger .lvl-2 td {
            background: #ffffff;
            font-weight: bold;
        }

        .ledger .lvl-3 td {
            background: #ffffff;
            font-weight: normal;
        }

        .ledger .lvl-4 td {
            background: #ffffff;
            font-weight: normal;
            font-style: italic;
        }

        /* Indentasi kolom uraian */
        .ledger td.i0 {
            padding-left: 4pt;
        }

        .ledger td.i1 {
            padding-left: 12pt;
        }

        .ledger td.i2 {
            padding-left: 20pt;
        }

        .ledger td.i3 {
            padding-left: 28pt;
        }

        .ledger td.i4 {
            padding-left: 36pt;
        }

        /* Baris kosong / tanda strip */
        .ledger td.blank {
            text-align: center;
        }


        .note {
            margin: 8pt 0 0 0;
            padding: 0;
            font-size: 8.5pt;
            font-style: italic;
            line-height: 1.3;
        }

        .signoff {
            display: table;
            width: 100%;
            margin: 20pt 0 0 0;
            page-break-inside: avoid;
        }

        .signoff__left,
        .signoff__right {
            display: table-cell;
            vertical-align: top;
        }

        .signoff__left {
            width: 55%;
        }

        .signoff__right {
            width: 45%;
            text-align: center;
            font-size: 11pt;
            line-height: 1.35;
        }

        .signoff__space {
            height: 2.4cm;
        }

        .signoff__name {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
    </style>

    <style>
        table.info-kegiatan {
            width: 100%;
            border-collapse: collapse;
            border-left: 0.5pt solid #000000;
            border-top: 0.5pt solid #000000;
            border-right: 0.5pt solid #000000;
        }

        table.info-kegiatan td {
            padding: 2px 6px;
            vertical-align: top;
            font-size: 9pt;
        }

        table.info-kegiatan td.info-label {
            width: 150px;
            font-weight: bold;
        }

        table.info-kegiatan td.info-titik {
            width: 12px;
        }

        .caption-rab {
            font-weight: bold;
            text-decoration: underline;
            margin: 14px 0 6px 0;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <div class="sheet">
        <!-- ======================= KOP SURAT ======================= -->
        <div class="kop">
            <div class="kop__logo">
                <!-- Ganti dengan file lambang Kabupaten Badung (PNG/JPG) -->
                {{-- <img src="logo-badung.png" alt="Lambang Kabupaten Badung" /> --}}
            </div>
            <div class="kop__text">
                <p class="kop__line1">Pemerintah Kabupaten Badung</p>
                <p class="kop__line2">Kecamatan Kuta Selatan</p>
                <p class="kop__line3">Desa Pecatu</p>
                <!-- Lengkapi dengan nama jalan, kode pos, telepon, dan email desa -->
                <p class="kop__address">
                    Pecatu, Kecamatan Kuta Selatan, Kabupaten Badung, Provinsi Bali
                </p>
            </div>
            <div class="kop__space">&nbsp;</div>
        </div>
        <div class="kop-rule"></div>

        <!-- ======================= JUDUL ======================= -->
        <div class="title">
            <p class="title__main">Rincian Anggaran {{ $mode }} Desa</p>
            <p class="title__sub">Tahun Anggaran {{ $apbd->tahun }}</p>
        </div>

        <table class="info">
            <tr>
                <td class="k">Dokumen</td>
                <td class="s">:</td>
                <td>{{ $apbd->judul }}</td>
            </tr>
            <tr>
                <td class="k">Kode Rekening</td>
                <td class="s">:</td>
                <td style="text-transform: capitalize;">{{ $utama->kode }} &ndash; Kelompok {{ $mode }}</td>
            </tr>
            <tr>
                <td class="k">Satuan</td>
                <td class="s">:</td>
                <td>Rupiah (Rp)</td>
            </tr>
        </table>

        @include('print.mode.' . $mode)

        <p class="note">
            Sumber: {{ $apbd->judul }}
            Tahun Anggaran {{ $apbd->tahun }}.
        </p>

        <!-- ======================= TANDA TANGAN ======================= -->
        <div class="signoff">
            <div class="signoff__left">&nbsp;</div>
            <div class="signoff__right">
                Pecatu, ................................ {{ $apbd->tahun }}<br />
                Kepala Desa Pecatu
                <div class="signoff__space">&nbsp;</div>
                <span class="signoff__name">..............................</span>
            </div>
        </div>
    </div>
</body>

</html>
