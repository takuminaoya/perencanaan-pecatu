<style>

    .document {
        opacity: 0;
        transform: translateY(14px);
        animation: rise 0.7s cubic-bezier(0.2, 0.7, 0.2, 1) forwards;
    }

    @keyframes rise {
        to { opacity: 1; transform: translateY(0); }
    }

    @media (prefers-reduced-motion: reduce) {
        .document, .bidang-block, .seal { animation: none !important; opacity: 1 !important; transform: none !important; }
    }

    /* ===== HEADER ===== */
    .letterhead {
        background: var(--pecatu-navy);
        color: var(--white);
        padding: 44px 48px 38px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-soft);
    }

    .letterhead::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--pecatu-gold), var(--soft-gold) 40%, var(--pecatu-gold) 70%, var(--emblem-blue));
    }

    .letterhead::after {
        content: "";
        position: absolute;
        right: -60px; top: -60px;
        width: 260px; height: 260px;
        border: 1px solid rgba(224,189,121,0.14);
        transform: rotate(45deg);
        pointer-events: none;
    }

    .eyebrow {
        font-family: var(--font-mono);
        font-size: 11.5px;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--soft-gold);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
    }

    .eyebrow::before {
        content: "";
        width: 22px;
        height: 1px;
        background: var(--pecatu-gold);
    }

    .letterhead h1 {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 34px;
        line-height: 1.22;
        letter-spacing: 0.01em;
        max-width: 620px;
    }

    .letterhead .sub {
        font-family: var(--font-body);
        font-size: 14.5px;
        color: rgba(255,255,255,0.62);
        margin-top: 10px;
        letter-spacing: 0.01em;
    }

    .head-meta {
        display: grid;
        grid-template-columns: repeat(3, auto) 1fr;
        gap: 34px;
        margin-top: 34px;
        padding-top: 26px;
        border-top: 1px solid rgba(224,189,121,0.2);
        align-items: end;
    }

    .head-meta .field .label {
        font-family: var(--font-mono);
        font-size: 10px;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.45);
        margin-bottom: 6px;
    }

    .head-meta .field .value {
        font-size: 15.5px;
        font-weight: 500;
        color: var(--white);
    }

    .head-meta .field .value.updated {
        font-family: var(--font-mono);
        font-size: 13.5px;
        font-weight: 400;
        color: rgba(255,255,255,0.78);
    }

    /* seal / stamp */
    .seal {
        justify-self: end;
        width: 92px;
        height: 92px;
        border: 1.5px solid var(--pecatu-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: rotate(-9deg);
        position: relative;
        flex-shrink: 0;
        animation: stamp 0.5s 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }

    @keyframes stamp {
        0% { opacity: 0; transform: rotate(-9deg) scale(1.6); }
        100% { opacity: 1; transform: rotate(-9deg) scale(1); }
    }

    .seal::before {
        content: "";
        position: absolute;
        inset: 6px;
        border: 1px dashed rgba(201,162,90,0.55);
        border-radius: 50%;
    }

    .seal .seal-text {
        font-family: var(--font-mono);
        font-size: 10px;
        letter-spacing: 0.08em;
        font-weight: 700;
        color: var(--soft-gold);
        text-align: center;
        text-transform: uppercase;
        line-height: 1.5;
    }

    /* ===== BIDANG BLOCK ===== */
    .content-wrap {
        background: var(--panel-bg);
        box-shadow: var(--shadow-card);
    }

    .bidang-block {
        border-bottom: 1px solid var(--border-soft);
    }

    .bidang-block:last-child { border-bottom: none; }

    .bidang-meta {
        padding: 34px 48px 26px;
        display: grid;
        grid-template-columns: 190px 1fr;
        row-gap: 13px;
        column-gap: 20px;
    }

    .bidang-meta .m-label {
        font-family: var(--font-mono);
        font-size: 11px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-soft);
        padding-top: 2px;
    }

    .bidang-meta .m-value {
        font-size: 15px;
        color: var(--text-dark);
        line-height: 1.5;
    }

    .bidang-meta .m-value.strong {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 17px;
        color: var(--deep-blue);
    }

    .meta-actions {
        grid-column: 1 / -1;
        display: flex;
        justify-content: flex-end;
        margin-top: 6px;
        padding-top: 20px;
        border-top: 1px solid var(--border-soft);
    }

    .btn-add-sm {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        color: var(--digital-blue);
        border: 1.5px solid var(--emblem-blue);
        padding: 9px 18px;
        font-family: var(--font-body);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    .btn-add-sm:hover {
        background: var(--deep-blue);
        border-color: var(--deep-blue);
        color: var(--white);
    }

    .btn-add-sm:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 3px;
    }

    .btn-add-sm .plus {
        font-family: var(--font-mono);
        font-size: 15px;
        line-height: 1;
        color: var(--pecatu-gold);
    }
    .btn-add-sm:hover .plus { color: var(--soft-gold); }

    /* ===== TABLE ===== */
    .table-scroll {
        padding: 0 48px 40px;
    }

    table.rab-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .rab-table thead th {
        background: var(--deep-blue);
        color: var(--white);
        font-family: var(--font-mono);
        font-size: 10.5px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        font-weight: 500;
        text-align: left;
        padding: 13px 16px;
    }

    .rab-table thead .subrow th {
        background: var(--digital-blue);
        font-size: 10px;
        padding: 9px 16px;
        color: rgba(255,255,255,0.85);
    }

    .rab-table th.col-kode, .rab-table td.col-kode { width: 70px; }
    .rab-table th.col-num, .rab-table td.col-num { text-align: right; width: 130px; }
    .rab-table thead th.col-num, .rab-table thead th.col-kode { text-align: left; }
    .rab-table thead .subrow th.col-num { text-align: right; }

    .rab-table tbody td {
        padding: 10px 16px;
        border-bottom: 1px solid var(--border-soft);
        vertical-align: top;
        color: var(--text-dark);
    }

    .rab-table tbody td.col-kode {
        font-family: var(--font-mono);
        font-size: 12.5px;
        color: var(--text-soft);
    }

    .rab-table tbody td.col-num {
        font-family: var(--font-mono);
        text-align: right;
        font-variant-numeric: tabular-nums;
        color: var(--text-muted);
    }

    .rab-table tbody tr.row-belanja > td {
        font-weight: 700;
        color: var(--pecatu-navy);
        border-top: 2px solid var(--pecatu-navy);
        border-bottom: 1px solid var(--border-soft);
        padding-top: 14px;
    }
    .rab-table tbody tr.row-belanja td.col-num { font-family: var(--font-mono); }

    .rab-table tbody tr.row-item-head > td {
        font-weight: 700;
        font-style: italic;
        text-decoration: underline;
        text-decoration-color: var(--pecatu-gold);
        text-decoration-thickness: 1.5px;
        text-underline-offset: 3px;
        color: var(--deep-blue);
        background: rgba(224,189,121,0.08);
    }

    .rab-table tbody tr.row-sub > td {
        font-style: italic;
        color: var(--text-muted);
        padding-left: 30px;
    }
    .rab-table tbody tr.row-sub td.col-uraian { padding-left: 30px; }

    .rab-table tbody tr.row-detail td.col-uraian {
        padding-left: 30px;
        color: var(--text-dark);
    }

    .rab-table tbody tr.row-item td.col-uraian {
        padding-left: 48px;
        color: var(--text-muted);
    }

    .rab-table tbody tr.row-item .satuan-tag {
        font-family: var(--font-mono);
        font-size: 10px;
        letter-spacing: 0.06em;
        color: var(--emblem-blue);
        background: rgba(78,124,147,0.1);
        padding: 1px 7px;
        margin-left: 8px;
    }

    .rab-table tbody tr:hover td {
        background: rgba(224,189,121,0.06);
    }
    .rab-table tbody tr.row-belanja:hover > td,
    .rab-table tbody tr.row-item-head:hover > td { background: rgba(224,189,121,0.12); }

    /* ===== ROW: TAMBAH DETAIL URAIAN ===== */
    .rab-table tbody tr.row-add-detail td {
        padding: 7px 16px 7px 48px;
        border-bottom: 1px solid var(--border-soft);
        background: var(--panel-bg);
    }

    .btn-add-detail {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: none;
        border: none;
        padding: 5px 2px;
        font-family: var(--font-body);
        font-size: 12.5px;
        font-weight: 600;
        color: var(--emblem-blue);
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .btn-add-detail:hover { color: var(--digital-blue); }

    .btn-add-detail:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 3px;
    }

    .btn-add-detail .plus {
        font-family: var(--font-mono);
        font-size: 14px;
        line-height: 1;
        color: var(--pecatu-gold);
    }

    .rab-table tfoot td {
        padding: 15px 16px;
        border-top: 2px solid var(--pecatu-gold);
        font-weight: 700;
        color: var(--white);
        background: var(--pecatu-navy);
    }

    .rab-table tfoot td.col-num {
        font-family: var(--font-mono);
        text-align: right;
        font-size: 15px;
        letter-spacing: 0.02em;
        color: var(--soft-gold);
    }

    /* ===== TABLE EMPTY ROW ===== */
    .rab-table tbody tr.row-empty { display: table-row; }
    .rab-table tbody tr.row-empty.is-visible { display: table-row; }

    .rab-table tbody tr.row-empty td {
        padding: 46px 16px;
        text-align: center;
        border-bottom: 1px solid var(--border-soft);
    }

    .rab-table tbody tr.row-empty .empty-row-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .rab-table tbody tr.row-empty .empty-row-icon {
        width: 38px;
        height: 38px;
        border: 1.5px dashed var(--pecatu-gold);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .rab-table tbody tr.row-empty .empty-row-icon svg { width: 17px; height: 17px; }

    .rab-table tbody tr.row-empty .empty-row-text {
        font-size: 13.5px;
        color: var(--text-soft);
        font-style: normal;
    }

    .rab-table tbody tr.row-empty:hover td { background: transparent; }

    /* ===== FOOTNOTE ===== */
    .doc-footer {
        text-align: center;
        margin-top: 28px;
        font-family: var(--font-mono);
        font-size: 11px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-soft);
    }

    /* ===== ACTION BAR (pojok kanan atas) ===== */
    .doc-actions {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 14px;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: var(--pecatu-navy);
        color: var(--white);
        border: 1px solid var(--pecatu-navy);
        padding: 12px 22px;
        font-family: var(--font-body);
        font-size: 13.5px;
        font-weight: 600;
        letter-spacing: 0.01em;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.15s ease, border-color 0.2s ease;
    }

    .btn-add:hover {
        background: var(--digital-blue);
        border-color: var(--digital-blue);
    }

    .btn-add:active { transform: translateY(1px); }

    .btn-add .plus {
        font-family: var(--font-mono);
        font-size: 16px;
        line-height: 1;
        color: var(--soft-gold);
    }

    .btn-add:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 3px;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 96px 40px 104px;
    }

    .empty-state.is-visible { display: flex; }

    .empty-icon {
        width: 84px;
        height: 84px;
        border: 1.5px dashed var(--pecatu-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        position: relative;
    }

    .empty-icon::before,
    .empty-icon::after {
        content: "";
        position: absolute;
        width: 10px;
        height: 10px;
        border-top: 1.5px solid var(--pecatu-gold);
        border-left: 1.5px solid var(--pecatu-gold);
    }

    .empty-icon::before { top: -1.5px; left: -1.5px; }
    .empty-icon::after { bottom: -1.5px; right: -1.5px; transform: rotate(180deg); }

    .empty-icon svg { width: 34px; height: 34px; }

    .empty-state h2 {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 22px;
        color: var(--deep-blue);
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 14.5px;
        color: var(--text-muted);
        max-width: 400px;
        line-height: 1.65;
        margin-bottom: 30px;
    }

    .empty-state p .ref-link {
        color: var(--digital-blue);
        font-weight: 600;
        border-bottom: 1px solid var(--soft-gold);
    }

    .empty-state .eyebrow-tag {
        font-family: var(--font-mono);
        font-size: 10.5px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--text-soft);
        margin-bottom: 14px;
    }

    .btn-add-outline {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: transparent;
        color: var(--pecatu-navy);
        border: 1.5px solid var(--pecatu-navy);
        padding: 13px 26px;
        font-family: var(--font-body);
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .btn-add-outline:hover {
        background: var(--pecatu-navy);
        color: var(--white);
    }

    .btn-add-outline:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 3px;
    }

    .btn-add-outline .plus {
        font-family: var(--font-mono);
        font-size: 16px;
        line-height: 1;
        color: var(--pecatu-gold);
    }
    .btn-add-outline:hover .plus { color: var(--soft-gold); }

    /* ===== demo preview switch (hanya untuk pratinjau dua state) ===== */
    .preview-switch {
        text-align: center;
        margin-top: 22px;
    }

    .preview-switch button {
        background: none;
        border: none;
        font-family: var(--font-mono);
        font-size: 11px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-soft);
        text-decoration: underline;
        text-underline-offset: 3px;
        cursor: pointer;
        padding: 6px;
    }
    .preview-switch button:hover { color: var(--digital-blue); }

    @media (max-width: 720px) {
        .letterhead { padding: 32px 22px 28px; }
        .letterhead h1 { font-size: 25px; }
        .head-meta { grid-template-columns: 1fr 1fr; row-gap: 20px; }
        .seal { grid-column: span 2; justify-self: start; margin-top: 4px; }
        .bidang-meta { grid-template-columns: 1fr; padding: 26px 22px 20px; }
        .table-scroll { padding: 0 14px 28px; overflow-x: auto; }
        table.rab-table { min-width: 640px; }
    }

    /* ===== AKSI BARIS (edit / hapus) — tr.row-item & tr.row-item-head ===== */
    .rab-table tbody tr.row-item td.col-uraian,
    .rab-table tbody tr.row-item-head td.col-uraian {
        padding-right: 10px;
    }

    .item-uraian-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .row-actions {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
        opacity: 0;
        transform: translateX(4px);
        transition: opacity 0.15s ease, transform 0.15s ease;
    }

    .rab-table tbody tr.row-item:hover .row-actions,
    .rab-table tbody tr.row-item-head:hover .row-actions,
    .row-actions:focus-within {
        opacity: 1;
        transform: translateX(0);
    }

    /* tombol aksi tidak ikut italic/underline gaya row-item-head */
    .rab-table tbody tr.row-item-head .row-actions,
    .rab-table tbody tr.row-item-head .icon-btn {
        font-style: normal;
        text-decoration: none;
    }

    /* ===== COLLAPSE / EXPAND — tr.bidang-block ===== */
    .bidang-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 48px;
        cursor: pointer;
        background: var(--panel-bg);
        user-select: none;
    }

    .bidang-header-bar:hover { background: rgba(224, 189, 121, 0.07); }

    .bidang-header-left {
        display: flex;
        align-items: baseline;
        gap: 12px;
        min-width: 0;
    }

    .bidang-header-tag {
        font-family: var(--font-mono);
        font-size: 10.5px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--text-soft);
        flex-shrink: 0;
    }

    .bidang-header-title {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 17px;
        color: var(--deep-blue);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bidang-header-right {
        display: flex;
        align-items: center;
        gap: 22px;
        flex-shrink: 0;
    }

    .bidang-header-total {
        font-family: var(--font-mono);
        font-size: 14px;
        font-weight: 600;
        color: var(--pecatu-navy);
        font-variant-numeric: tabular-nums;
    }

    .toggle-collapse {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--white);
        border: 1px solid var(--border-soft);
        cursor: pointer;
        padding: 0;
        flex-shrink: 0;
        transition: border-color 0.15s ease, background 0.15s ease;
    }

    .toggle-collapse:hover {
        border-color: var(--pecatu-gold);
        background: rgba(201, 162, 90, 0.08);
    }

    .toggle-collapse:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 2px;
    }

    .toggle-collapse svg {
        width: 13px;
        height: 13px;
        transition: transform 0.25s ease;
    }

    .bidang-block.is-collapsed .toggle-collapse svg {
        transform: rotate(-90deg);
    }

    .bidang-collapsible {
        display: grid;
        grid-template-rows: 1fr;
        transition: grid-template-rows 0.3s ease;
    }

    .bidang-block.is-collapsed .bidang-collapsible {
        grid-template-rows: 0fr;
    }

    .bidang-collapsible-inner {
        overflow: hidden;
    }

    .bidang-block.is-collapsed .bidang-header-bar {
        border-bottom: none;
    }

    .icon-btn {
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--white);
        border: 1px solid var(--border-soft);
        cursor: pointer;
        padding: 0;
        transition: border-color 0.15s ease, background 0.15s ease;
    }

    .icon-btn.icon-edit {
        width: 30px !important;
        height: 30px !important;
    }

    .icon-btn.icon-delete {
        width: 30px !important;
        height: 30px !important;
    }

    .icon-btn svg {
        width: 13px;
        height: 13px;
    }

    .icon-btn.icon-edit:hover {
        border-color: var(--digital-blue);
        background: rgba(20, 83, 106, 0.06);
    }

    .icon-btn.icon-delete:hover {
        border-color: var(--danger);
        background: rgba(220, 38, 38, 0.06);
    }

    .icon-btn:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 2px;
    }
</style>