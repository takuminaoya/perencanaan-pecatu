<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap');

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: var(--font-body);
        background: var(--white);
        color: var(--text-dark);
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
    }

    /* ============ MASTHEAD ============ */

    .masthead {
        position: relative;
        background: linear-gradient(160deg, var(--pecatu-navy) 0%, var(--deep-blue) 62%, var(--digital-blue) 100%);
        color: var(--white);
        padding: 56px 48px 64px;
        overflow: hidden;
    }

    .masthead::before {
        content: "";
        position: absolute;
        inset: 0;
        opacity: 0.16;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='420' height='200' viewBox='0 0 420 200'%3E%3Cpath d='M0 150 C 60 120, 90 180, 150 140 S 260 100, 320 150 S 400 120, 420 150' stroke='%23E0BD79' stroke-width='1.4' fill='none'/%3E%3Cpath d='M0 100 C 60 70, 90 130, 150 90 S 260 50, 320 100 S 400 70, 420 100' stroke='%234E7C93' stroke-width='1' fill='none'/%3E%3C/svg%3E");
        background-repeat: repeat-x;
        background-position: bottom;
        pointer-events: none;
    }

    .masthead__inner {
        position: relative;
        /* max-width: 1180px; */
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 32px;
        flex-wrap: wrap;
    }

    .masthead__agency {
        font-size: 13px;
        letter-spacing: 0.06em;
        color: var(--soft-gold);
        font-weight: 600;
        margin-bottom: 18px;
    }

    .masthead__agency span {
        display: block;
        color: rgba(255, 255, 255, 0.68);
        font-weight: 400;
        letter-spacing: 0.02em;
        margin-top: 2px;
    }

    .masthead__title {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: clamp(32px, 4.4vw, 52px);
        line-height: 1.08;
        max-width: 620px;
    }

    .masthead__title em {
        font-style: normal;
        color: var(--soft-gold);
    }

    .masthead__rule {
        width: 64px;
        height: 3px;
        background: var(--pecatu-gold);
        margin: 22px 0 16px;
    }

    .masthead__meta {
        display: flex;
        gap: 28px;
        flex-wrap: wrap;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.78);
    }

    .masthead__meta strong {
        display: block;
        color: var(--white);
        font-weight: 600;
        font-size: 15px;
    }

    .masthead__meta div {
        padding-right: 28px;
        border-right: 1px solid rgba(255, 255, 255, 0.18);
    }

    .masthead__meta div:last-child {
        border-right: none;
        padding-right: 0;
    }

    .masthead__badge {
        text-align: right;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.7);
    }

    .masthead__badge .status {
        display: inline-block;
        margin-top: 10px;
        padding: 7px 16px;
        background: rgba(224, 189, 121, 0.14);
        border: 1px solid rgba(224, 189, 121, 0.5);
        color: var(--soft-gold);
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    /* ============ PAGE / PAPER PANEL ============ */

    .page {
        /* max-width: 1180px; */
        /* margin: -34px auto 64px; */
        /* padding: 0 24px; */
        position: relative;
    }

    .panel {
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-soft);
    }

    /* ============ STAT STRIP ============ */

    .stat-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }

    .stat {
        padding: 32px 34px;
        border-right: 1px solid var(--border-soft);
    }

    .stat:last-child {
        border-right: none;
    }

    .stat__label {
        font-size: 13.5px;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 10px;
    }

    .stat__value {
        font-family: var(--font-display);
        font-size: 27px;
        font-weight: 600;
        color: var(--pecatu-navy);
        letter-spacing: -0.01em;
        font-variant-numeric: tabular-nums;
    }

    .stat__value small {
        font-family: var(--font-body);
        font-size: 14px;
        font-weight: 600;
        color: var(--text-soft);
        margin-right: 3px;
    }

    .stat__delta {
        margin-top: 12px;
        font-size: 13.5px;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat__delta.is-up {
        color: var(--success);
    }

    .stat__delta.is-down {
        color: var(--danger);
    }

    .stat__delta.is-flat {
        color: var(--text-soft);
    }

    .stat__delta .arrow {
        font-size: 11px;
    }

    /* ============ SECTION HEADER ============ */

    .section-head {
        padding: 30px 34px 22px;
        border-top: 1px solid var(--border-soft);
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 14px;
    }

    .section-head h2 {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 23px;
        color: var(--pecatu-navy);
    }

    .section-head p {
        font-size: 13.5px;
        color: var(--text-muted);
        margin-top: 5px;
    }

    .legend {
        display: flex;
        gap: 18px;
        font-size: 12.5px;
        color: var(--text-soft);
        flex-wrap: wrap;
    }

    .legend span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .legend .dot {
        width: 9px;
        height: 9px;
        display: inline-block;
        background: var(--pecatu-gold);
    }

    .legend .dot.dot--navy {
        background: var(--pecatu-navy);
    }

    .legend .dot.dot--muted {
        background: var(--border-soft);
    }

    /* ============ LEDGER TABLE ============ */

    .table-wrap {
        overflow-x: auto;
    }

    table.ledger {
        width: 100%;
        border-collapse: collapse;
        font-size: 14.5px;
        min-width: 760px;
    }

    table.ledger thead th {
        position: sticky;
        top: 0;
        background: var(--pecatu-navy);
        color: rgba(255, 255, 255, 0.92);
        font-family: var(--font-body);
        font-weight: 600;
        font-size: 12.5px;
        letter-spacing: 0.03em;
        text-align: left;
        padding: 14px 16px;
        border-bottom: 2px solid var(--pecatu-gold);
        white-space: nowrap;
    }

    table.ledger thead th.num {
        text-align: right;
    }

    table.ledger thead th.kode {
        width: 110px;
    }

    table.ledger tbody td {
        padding: 11px 16px;
        border-bottom: 1px solid var(--border-soft);
        vertical-align: middle;
    }

    table.ledger tbody td.num {
        text-align: right;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }

    table.ledger tbody td.kode {
        color: var(--text-soft);
        font-size: 13px;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }

    table.ledger tbody tr:hover td {
        background: rgba(201, 162, 90, 0.07);
    }

    /* row level styling */

    tr.lvl-0 td {
        background: var(--pecatu-navy);
        color: var(--white);
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 15.5px;
        border-bottom: none;
    }

    tr.lvl-0 td.kode {
        color: rgba(255, 255, 255, 0.55);
    }

    tr.lvl-0 td.num {
        color: var(--soft-gold);
    }

    tr.lvl-1 td {
        background: rgba(78, 124, 147, 0.09);
        font-weight: 700;
        color: var(--pecatu-navy);
        border-left: 3px solid var(--pecatu-gold);
    }

    tr.lvl-1 td:first-child {
        border-left: 3px solid var(--pecatu-gold);
    }

    tr.lvl-2 td {
        font-weight: 600;
        color: var(--text-dark);
        background: rgba(78, 124, 147, 0.03);
    }

    tr.lvl-3 td {
        font-weight: 500;
        color: var(--text-dark);
    }

    tr.lvl-4 td {
        color: var(--text-muted);
        font-size: 13.8px;
    }

    .uraian {
        display: block;
    }

    .uraian--empty {
        color: var(--text-soft);
    }

    /* varian coloring */
    .varian {
        font-weight: 600;
    }

    .varian.is-up {
        color: var(--success);
    }

    .varian.is-down {
        color: var(--danger);
    }

    .varian.is-flat {
        color: var(--text-soft);
        font-weight: 500;
    }

    .varian.is-blank {
        color: var(--text-soft);
        font-weight: 400;
    }

    /* ============ FOOTER / SIGNATURE ============ */

    .footnote {
        padding: 22px 34px;
        border-top: 1px solid var(--border-soft);
        font-size: 12.5px;
        color: var(--text-soft);
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .footnote button {
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 600;
        color: var(--pecatu-navy);
        background: transparent;
        border: 1px solid var(--pecatu-navy);
        padding: 9px 18px;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
    }

    .footnote button:hover {
        background: var(--pecatu-navy);
        color: var(--white);
    }

    .signoff {
        max-width: 1180px;
        margin: 28px auto 0;
        padding: 0 24px 6px;
        display: flex;
        justify-content: flex-end;
    }

    .signoff__block {
        text-align: center;
        font-size: 13.5px;
        color: var(--text-muted);
        width: 240px;
    }

    .signoff__block .place-date {
        margin-bottom: 62px;
    }

    .signoff__block .name {
        font-weight: 700;
        color: var(--pecatu-navy);
        border-top: 1px solid var(--text-dark);
        padding-top: 6px;
        display: inline-block;
        min-width: 200px;
    }

    .signoff__block .role {
        color: var(--text-soft);
        margin-top: 2px;
    }

    /* ============ RESPONSIVE ============ */

    @media (max-width: 780px) {
        .masthead {
            padding: 40px 22px 52px;
        }

        .masthead__inner {
            align-items: flex-start;
        }

        .masthead__badge {
            text-align: left;
        }

        .page {
            padding: 0 14px;
            margin-top: -26px;
        }

        .stat-strip {
            grid-template-columns: 1fr;
        }

        .stat {
            border-right: none;
            border-bottom: 1px solid var(--border-soft);
        }

        .stat:last-child {
            border-bottom: none;
        }

        .section-head {
            padding: 24px 20px 16px;
        }

        table.ledger tbody td,
        table.ledger thead th {
            padding: 10px 12px;
        }

        .footnote {
            padding: 18px 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .signoff {
            justify-content: flex-start;
        }
    }

    :focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
        * {
            transition: none !important;
        }
    }

    @media print {
        .masthead::before {
            display: none;
        }

        .footnote button {
            display: none;
        }

        body {
            background: var(--white);
        }
    }

    /* ============ APBD SELECTOR BAR ============ */

    .selector-bar {
        max-width: 1180px;
        margin: -34px auto 0;
        padding: 0 24px;
        position: relative;
        z-index: 2;
    }

    .selector-bar__inner {
        /* background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-card);
        padding: 20px 28px; */
        display: flex;
        align-items: flex-end;
        gap: 18px;
    }

    .selector-field {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1 1 320px;
    }

    .selector-field label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-muted);
        letter-spacing: 0.02em;
    }

    .selector-field select {
        appearance: none;
        -webkit-appearance: none;
        font-family: var(--font-body);
        font-size: 14.5px;
        font-weight: 500;
        color: var(--text-dark);
        background: var(--white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%234E7C93' stroke-width='1.6' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 16px center;
        border: 1px solid var(--emblem-blue);
        padding: 12px 40px 12px 14px;
        cursor: pointer;
        width: 100%;
    }

    .selector-field select:focus-visible {
        border-color: var(--pecatu-gold);
    }

    .selector-bar__action {
        font-family: var(--font-body);
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.01em;
        color: var(--white);
        background: var(--pecatu-navy);
        border: 1px solid var(--pecatu-navy);
        padding: 13px 26px;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
        white-space: nowrap;
    }

    .selector-bar__action:hover {
        background: var(--digital-blue);
    }

    @media (max-width: 780px) {
        .selector-bar {
            padding: 0 14px;
        }

        .selector-bar__inner {
            padding: 18px 18px;
            flex-direction: column;
            align-items: stretch;
        }

        .selector-bar__action {
            width: 100%;
        }
    }

    /* =====================================================================
   TAMBAHAN — Halaman Ringkasan RAB (Rencana Anggaran Biaya)
   Ditambahkan untuk mendukung: info header per Kegiatan/Sub Kegiatan,
   tabel dua kelompok kolom (Anggaran Induk & Anggaran Perubahan),
   dan pembungkus ".rab-item" yang dirancang agar bisa diulang (loop)
   untuk setiap Kegiatan/Sub Kegiatan tambahan.
   ===================================================================== */

    /* ---- info-list: Bidang, Sub Bidang, Kegiatan, dst ---- */

    .info-list {
        padding: 30px 34px 6px;
        display: grid;
        grid-template-columns: 190px 1fr;
        row-gap: 9px;
        column-gap: 18px;
        font-size: 14px;
    }

    .info-list dt {
        color: var(--text-muted);
        font-weight: 600;
    }

    .info-list dt::after {
        content: ":";
        float: right;
    }

    .info-list dd {
        color: var(--text-dark);
        font-weight: 500;
    }

    .info-list dd.is-strong {
        color: var(--pecatu-navy);
        font-weight: 700;
    }

    /* ---- rab-item: one repeatable Kegiatan/Sub Kegiatan block ---- */

    .rab-item+.rab-item {
        border-top: 1px solid var(--border-soft);
        margin-top: 40px;
        padding-top: 6px;
    }

    .rab-item__caption {
        margin: 26px 34px 0;
        padding: 12px 18px;
        background: var(--pecatu-navy);
        color: var(--white);
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-align: center;
    }

    /* ---- grouped two-row table header ---- */

    table.ledger--rab thead th {
        text-align: center;
    }

    table.ledger--rab thead th.uraian-col {
        text-align: left;
    }

    table.ledger--rab thead th.group-divider {
        border-left: 2px solid var(--pecatu-gold);
    }

    table.ledger--rab thead tr:first-child th {
        border-bottom: 1px solid rgba(255, 255, 255, 0.25);
    }

    table.ledger--rab tbody td.group-divider {
        border-left: 2px solid var(--soft-gold);
    }

    table.ledger--rab tbody td.vol,
    table.ledger--rab tbody td.harga {
        text-align: right;
        font-variant-numeric: tabular-nums;
        color: var(--text-muted);
        white-space: nowrap;
    }

    /* ---- objek total row: highlighted (mirrors green emphasis in source doc) ---- */

    tr.lvl-1--emphasis td {
        background: rgba(22, 163, 74, 0.12);
        border-top: 1px solid rgba(22, 163, 74, 0.35);
        border-bottom: 1px solid rgba(22, 163, 74, 0.35);
        font-weight: 700;
        color: var(--pecatu-navy);
    }

    tr.lvl-1--emphasis td:first-child {
        border-left: 3px solid var(--success);
    }

    /* ---- leaf item numbering (Sekretaris Desa, dst) ---- */

    tr.lvl-3 td.uraian-cell {
        color: var(--text-muted);
        font-weight: 500;
    }

    /* ---- Jumlah Belanja footer row ---- */

    table.ledger--rab tfoot td {
        padding: 14px 16px;
        border-top: 2px solid var(--pecatu-navy);
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 15px;
        color: var(--pecatu-navy);
        background: rgba(78, 124, 147, 0.06);
    }

    table.ledger tfoot td.num {
        text-align: right;
        font-variant-numeric: tabular-nums;
    }

        table.ledger tfoot td {
        padding: 14px 16px;
        border-top: 2px solid var(--pecatu-navy);
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 15px;
        color: var(--pecatu-navy);
        background: rgba(78, 124, 147, 0.06);
    }

    table.ledger tfoot td.num {
        text-align: right;
        font-variant-numeric: tabular-nums;
    }

    @media (max-width: 780px) {
        .info-list {
            grid-template-columns: 1fr;
            padding: 24px 20px 4px;
        }

        .info-list dt::after {
            content: "";
        }

        .rab-item__caption {
            margin: 22px 20px 0;
        }

        /* ---- Full-screen scrollable fallback ----
       Saat lebar tabel (kolom Anggaran Induk + Anggaran Perubahan) tidak
       lagi muat di dalam kontainer/kartu panel, tabel "lepas" dari batas
       panel dan memakai lebar penuh layar (viewport) agar area geser
       horizontal lebih luas dan nyaman, alih-alih terpotong/tumpang tindih. */
        .table-wrap {
            width: 100vw;
            max-width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            padding: 0 20px 4px;
            box-sizing: border-box;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dateEl = document.querySelector('[data-print-date]');
        if (dateEl) {
            var now = new Date();
            var bulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            dateEl.textContent = now.getDate() + ' ' + bulan[now.getMonth()] + ' ' + now.getFullYear();
        }

        var printBtn = document.querySelector('[data-action="print"]');
        if (printBtn) {
            printBtn.addEventListener('click', function() {
                window.print();
            });
        }
    });
</script>
