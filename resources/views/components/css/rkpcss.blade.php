<style>
    body {
        font-family: var(--font-body);
        -webkit-font-smoothing: antialiased;
    }

    ::selection { background: var(--soft-gold); color: var(--pecatu-navy); }

    .page { }

    /* ===== HEADER ===== */
    .doc-header {
        background: var(--pecatu-navy);
        color: var(--white);
        padding: 40px 44px 34px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 50px rgba(7,42,56,0.16);
        opacity: 0;
        transform: translateY(14px);
        animation: rise 0.6s cubic-bezier(0.2,0.7,0.2,1) 0.05s forwards;
    }

    @keyframes rise { to { opacity: 1; transform: translateY(0); } }

    @media (prefers-reduced-motion: reduce) {
        .doc-header, .content-card, .fab-item, .fab-main { animation: none !important; opacity: 1 !important; transform: none !important; }
    }

    .doc-header::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--pecatu-gold), var(--soft-gold) 45%, var(--pecatu-gold) 75%, var(--emblem-blue));
    }

    .doc-header::after {
        content: "";
        position: absolute;
        right: -70px; top: -70px;
        width: 240px; height: 240px;
        border: 1px solid rgba(224,189,121,0.14);
        pointer-events: none;
    }

    .eyebrow {
        font-family: var(--font-mono);
        font-size: 11px;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--soft-gold);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }
    .eyebrow::before { content: ""; width: 22px; height: 1px; background: var(--pecatu-gold); }

    .doc-header h1 {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 30px;
        line-height: 1.25;
        max-width: 620px;
    }

    .doc-header .sub {
        font-size: 14px;
        color: rgba(255,255,255,0.6);
        margin-top: 8px;
    }

    .head-meta {
        display: grid;
        grid-template-columns: repeat(4, auto);
        gap: 28px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid rgba(224,189,121,0.2);
    }

    .head-meta .field .label {
        font-family: var(--font-mono);
        font-size: 10px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.45);
        margin-bottom: 6px;
    }
    .head-meta .field .value {
        font-size: 14.5px;
        font-weight: 500;
        color: var(--white);
    }

    /* ===== CONTENT CARD ===== */
    .content-card {
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        box-shadow: 0 16px 40px rgba(7,42,56,0.08);
        margin-top: 24px;
        overflow: hidden;
        opacity: 0;
        transform: translateY(14px);
        animation: rise 0.6s cubic-bezier(0.2,0.7,0.2,1) 0.16s forwards;
    }

    .card-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 22px 32px;
        border-bottom: 1px solid var(--border-soft);
    }
    .card-title h2 {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 16.5px;
        color: var(--deep-blue);
    }
    .card-title .hint {
        font-family: var(--font-mono);
        font-size: 10.5px;
        letter-spacing: 0.06em;
        color: var(--text-soft);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .card-title .hint svg { width: 13px; height: 13px; }

    /* ===== TABLE ===== */
    .table-scroll { padding: 0 0 4px; overflow-x: auto; }

    table.rkp {
        width: 100%;
        min-width: 1680px;
        border-collapse: collapse;
        font-size: 12px;
    }

    .rkp thead th {
        background: var(--deep-blue);
        color: var(--white);
        font-family: var(--font-mono);
        font-size: 9.5px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        font-weight: 500;
        text-align: center;
        padding: 8px 8px;
        vertical-align: middle;
        border: 1px solid rgba(255,255,255,0.12);
    }
    .rkp thead .subrow th {
        background: var(--digital-blue);
        font-size: 9px;
        padding: 6px 8px;
        color: rgba(255,255,255,0.85);
    }
    .rkp thead .numrow th {
        background: var(--pecatu-navy);
        font-family: var(--font-mono);
        font-size: 9px;
        color: rgba(255,255,255,0.6);
        padding: 4px 8px;
    }

    .rkp tbody td {
        padding: 8px 9px;
        border: 1px solid var(--border-soft);
        vertical-align: top;
        color: var(--text-dark);
        font-size: 11.5px;
    }
    .rkp tbody td.center { text-align: center; }
    .rkp tbody td.num {
        text-align: right;
        font-family: var(--font-mono);
        font-variant-numeric: tabular-nums;
        color: var(--text-muted);
        font-size: 11px;
    }
    .rkp tbody td.kd { text-align: center; font-family: var(--font-mono); color: var(--text-soft); }
    .rkp tbody td.sasaran { text-align: center; font-family: var(--font-mono); color: var(--text-muted); font-size: 11px; }
    .rkp tbody td.num span.sumber-dana {
        display: block;
        margin-top: 3px;
        font-family: var(--font-mono);
        font-size: 9.5px;
        letter-spacing: 0.05em;
        color: var(--emblem-blue);
        font-weight: 600;
    }

    .rkp tbody tr.grp td {
        background: var(--soft-bg);
        font-weight: 700;
        color: var(--pecatu-navy);
        font-size: 12.5px;
        letter-spacing: 0.01em;
        padding: 10px 12px;
    }

    .rkp tbody tr:hover:not(.grp) td { background: rgba(224,189,121,0.06); }

    @media (max-width: 720px) {
        .doc-header { padding: 32px 24px 26px; }
        .doc-header h1 { font-size: 22px; }
        .head-meta { grid-template-columns: 1fr 1fr; row-gap: 18px; }
        .card-title { flex-direction: column; align-items: flex-start; gap: 6px; padding: 20px 20px; }
        .fab-container { right: 16px; bottom: calc(18px + env(safe-area-inset-bottom, 0px)); }
        .fab-main { width: 52px; height: 52px; }
    }

    /* ===== FLOATING PRINT MENU ===== */
    .fab-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(7,42,56,0.16);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 490;
    }
    .fab-backdrop.is-visible { opacity: 1; pointer-events: auto; }

    .fab-container {
        position: fixed;
        right: 28px;
        bottom: 30px;
        z-index: 500;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        pointer-events: none;
    }
    .fab-container .fab-main { pointer-events: auto; }

    .fab-menu {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
        opacity: 0;
        transform: translateY(10px) scale(0.96);
        pointer-events: none;
        transition: opacity 0.18s ease, transform 0.18s ease;
        transform-origin: bottom right;
    }
    .fab-container.is-open .fab-menu { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }

    .fab-menu-label {
        font-family: var(--font-mono);
        font-size: 10px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--text-soft);
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        padding: 5px 12px;
    }

    .fab-item {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        color: var(--pecatu-navy);
        font-family: var(--font-body);
        font-size: 13.5px;
        font-weight: 600;
        padding: 11px 18px 11px 14px;
        box-shadow: 0 10px 26px rgba(7,42,56,0.1);
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s ease, border-color 0.15s ease, transform 0.15s ease;
        text-decoration: none;
    }
    .fab-item:hover { background: var(--white); border-color: var(--pecatu-gold); }
    .fab-item:active { transform: scale(0.97); }
    .fab-item:focus-visible { outline: 2px solid var(--pecatu-gold); outline-offset: 2px; }

    .fab-item-icon {
        width: 30px; height: 30px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--soft-bg);
        color: var(--digital-blue);
    }
    .fab-item.fab-open .fab-item-icon { color: var(--emblem-blue); }
    .fab-item.fab-quick .fab-item-icon { color: var(--success); }
    .fab-item-icon svg { width: 15px; height: 15px; }

    .fab-main {
        width: 58px; height: 58px;
        border: none;
        background: var(--pecatu-navy);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 16px 40px rgba(7,42,56,0.22);
        position: relative;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .fab-main::after {
        content: "";
        position: absolute;
        inset: -4px;
        border: 1px solid rgba(201,162,90,0.35);
        pointer-events: none;
    }
    .fab-main:hover { background: var(--digital-blue); }
    .fab-main:active { transform: scale(0.95); }
    .fab-main:focus-visible { outline: 2px solid var(--pecatu-gold); outline-offset: 3px; }
    .fab-main svg { width: 22px; height: 22px; transition: transform 0.25s ease; }
    .fab-container.is-open .fab-main svg { transform: rotate(45deg); }

    /* ===== PRINT (jika dicetak langsung dari halaman ini) ===== */
    @media print {
        body { background: var(--white); padding: 0; }
        .fab-container, .fab-backdrop { display: none !important; }
        .doc-header, .content-card { box-shadow: none; }
        .doc-header { break-inside: avoid; }
    }

    .rkp tfoot td {
        padding: 12px 12px;
        border: 1px solid var(--border-soft);
        border-top: 2px solid var(--pecatu-gold);
        background: var(--soft-bg);
    }
</style>