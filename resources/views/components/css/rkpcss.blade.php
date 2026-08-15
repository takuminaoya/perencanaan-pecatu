<style>
    
    .font-display { font-family: 'Fraunces', serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }

    /* ===== layout shell ===== */
    .page {
    }

    .panel {
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-card);
    }

    /* ===== header ===== */
    .header-panel {
        overflow: hidden;
        box-shadow: 0 18px 44px rgba(7,42,56,0.2);
        margin-bottom: 20px;
        background: linear-gradient(135deg, var(--pecatu-navy) 0%, var(--deep-blue) 65%, var(--digital-blue) 130%);
    }
    .header-inner {
        padding: 28px 24px;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
    }
    @media (min-width: 768px) { .header-inner { padding: 32px 34px; flex-wrap: nowrap; } }

    .header-left { display: flex; align-items: flex-start; gap: 16px; }
    .header-eyebrow {
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: .2em;
        font-weight: 600;
        color: var(--emblem-blue);
    }
    .header-title {
        font-size: 28px;
        line-height: 1.15;
        font-weight: 600;
        color: var(--white);
        margin-top: 4px;
    }
    @media (min-width: 768px) { .header-title { font-size: 36px; } }
    .header-sub { font-size: 14px; margin-top: 6px; color: var(--soft-gold); }

    .header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        flex-shrink: 0;
    }
    @media (min-width: 768px) { .header-right { align-items: flex-end; } }

    .seal {
        width: 50px; height: 50px;
        background: radial-gradient(circle at 35% 28%, var(--soft-gold), var(--pecatu-gold) 58%, #9c7a3c 100%);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 16px rgba(0,0,0,0.28), inset 0 0 0 2px rgba(255,255,255,0.3);
        flex-shrink: 0;
        position: relative;
    }
    .seal::before {
        content: "";
        position: absolute; inset: 4px;
        border: 1px dashed rgba(58,42,12,0.35);
    }
    .seal span { font-family: 'Fraunces', serif; font-weight: 700; font-size: 13px; color: #3a2a0c; }

    .status-pill {
        border: 1px solid var(--soft-gold);
        background: rgba(224,189,121,0.12);
        color: var(--soft-gold);
        font-weight: 600;
        font-size: 12.5px;
        letter-spacing: .02em;
        display: inline-flex; align-items: center; gap: 7px;
        padding: 7px 16px;
    }
    .status-dot {
        width: 7px; height: 7px;
        background: #4ADE80;
        box-shadow: 0 0 0 3px rgba(74,222,128,0.22);
    }
    .updated-line { font-size: 12px; color: var(--emblem-blue); }
    .updated-value { font-family: 'JetBrains Mono', monospace; color: #E4EDF1; }

    /* ===== stat cards ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }
    @media (min-width: 768px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }

    .stat-card {
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        padding: 16px 18px;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: "";
        position: absolute; left:0; top:0; bottom:0; width: 4px;
        background: var(--pecatu-gold);
    }
    .stat-label { font-size: 11px; text-transform: uppercase; letter-spacing: .05em; font-weight: 600; color: var(--text-soft); }
    .stat-value { font-family: 'Fraunces', serif; font-weight: 600; font-size: 24px; margin-top: 6px; color: var(--pecatu-navy); }
    .stat-value.mono { font-family: 'JetBrains Mono', monospace; font-size: 20px; }
    @media (min-width: 768px) { .stat-value.mono { font-size: 24px; } }

    /* ===== bidang sections (berurutan, tanpa tab) ===== */
    .bidang-section { margin-bottom: 30px; }
    .bidang-section:last-of-type { margin-bottom: 16px; }

    .bidang-heading-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 20px;
        background: var(--pecatu-navy);
        border: 1px solid var(--pecatu-navy);
        margin-bottom: 0;
    }
    .bidang-heading-left { display: flex; align-items: baseline; gap: 10px; flex-wrap: wrap; }
    .bidang-index {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        font-weight: 700;
        color: var(--deep-blue);
        background: var(--soft-gold);
        padding: 3px 9px;
    }
    .bidang-title {
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: 18px;
        color: var(--white);
    }
    .bidang-title .bidang-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 13px;
        color: var(--soft-gold);
        margin-left: 10px;
    }

    .btn {
        font-family: inherit;
        border-radius: 0;
        font-weight: 600;
        font-size: 13px;
        padding: 9px 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
        transition: all .18s ease;
        border: 1.5px solid transparent;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-icon { font-size: 15px; line-height: 1; }
    .btn-gold {
        border-color: var(--pecatu-gold);
        color: var(--pecatu-navy);
        background: var(--soft-gold);
    }
    .btn-gold:hover {
        background: var(--white);
        color: var(--pecatu-navy);
        box-shadow: 0 8px 18px rgba(201,162,90,0.35);
        transform: translateY(-1px);
    }

    /* ===== table section ===== */
    .table-panel { padding: 18px; }
    @media (min-width: 768px) { .table-panel { padding: 20px; } }
    .table-panel-head {
        display: flex;
        flex-wrap: wrap;
        gap: 6px 16px;
        align-items: center;
        justify-content: flex-end;
        margin-bottom: 12px;
    }
    .table-hint { font-size: 11.5px; color: var(--text-soft); }

    .table-scroll { position: relative; overflow-x: auto; border: 1px solid var(--border-soft); }
    .rkk-table { border-collapse: separate; border-spacing: 0; width: 100%; min-width: 1400px; }
    .rkk-table thead th {
        background: var(--pecatu-navy);
        color: var(--soft-gold);
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .035em;
        padding: 11px 8px;
        border: 1px solid rgba(255,255,255,0.07);
        text-align: center;
        vertical-align: middle;
        line-height: 1.35;
        position: sticky;
        top: 0;
        z-index: 2;
    }
    .rkk-table thead tr:first-child th { background: var(--pecatu-navy); top: 0; }
    .rkk-table thead tr:last-child th { background: var(--deep-blue); font-size: 10px; top: 38px; }
    .rkk-table .grp-end { border-right: 2px solid rgba(201,162,90,0.55) !important; }

    .rkk-table tbody td {
        padding: 10px 9px;
        border: 1px solid var(--border-soft);
        font-size: 12.5px;
        color: var(--text-dark);
        vertical-align: middle;
    }
    .rkk-table tbody tr:nth-child(even) { background: #FBF7EE; }
    .rkk-table tbody tr:hover { background: rgba(78,124,147,0.09); }
    .cell-kd { font-family: 'JetBrains Mono', monospace; color: var(--digital-blue); font-weight: 700; text-align: center; white-space: nowrap; }
    .cell-num { font-family: 'JetBrains Mono', monospace; text-align: right; }
    .cell-center { text-align: center; }
    .badge-satuan {
        display: inline-block; padding: 2px 9px;
        background: rgba(78,124,147,0.12); color: var(--digital-blue);
        font-size: 11px; font-weight: 700;
    }

    /* ===== total row (per bidang) ===== */
    .total-row {
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-left: 4px solid var(--pecatu-gold);
        background: var(--panel-bg);
        border-top: 1px solid var(--border-soft);
        border-right: 1px solid var(--border-soft);
        border-bottom: 1px solid var(--border-soft);
    }
    .total-label { font-size: 13px; font-weight: 600; color: var(--text-muted); }
    .total-value { font-family: 'JetBrains Mono', monospace; font-size: 18px; font-weight: 700; color: var(--pecatu-navy); }

    /* ===== footer ===== */
    .page-footer {
        padding: 16px 24px;
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        background: var(--pecatu-navy);
        border-top: 2px solid var(--pecatu-gold);
    }
    @media (min-width: 640px) { .page-footer { flex-direction: row; } }
    .page-footer p { font-size: 12px; color: var(--emblem-blue); }
    .page-footer p.small { font-size: 11.5px; }

    ::-webkit-scrollbar { height: 10px; width: 10px; }
    ::-webkit-scrollbar-thumb { background: var(--emblem-blue); }
    ::-webkit-scrollbar-track { background: var(--border-soft); }

    @media print {
        body { background: #fff; }
        .panel, .table-scroll, .header-panel, .stat-card, .total-row { box-shadow: none !important; border-color: #ccc !important; }
        .btn-gold { display: none !important; }
    }
</style>