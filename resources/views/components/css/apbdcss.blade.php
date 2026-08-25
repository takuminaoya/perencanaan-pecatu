<style>
    body {
        color: var(--text-dark);
        font-family: var(--font-body);
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
    }

    ::selection { background: var(--soft-gold); color: var(--pecatu-navy); }

    .wrap {
    }

    /* ============ HEADER ============ */
    .masthead {
        background:
            linear-gradient(180deg, rgba(7,42,56,0.0) 0%, rgba(7,42,56,0.0) 100%),
            var(--pecatu-navy);
        background-image:
            repeating-linear-gradient(115deg, rgba(201,162,90,0.05) 0px, rgba(201,162,90,0.05) 1px, transparent 1px, transparent 64px),
            linear-gradient(135deg, var(--pecatu-navy) 0%, var(--deep-blue) 55%, var(--digital-blue) 100%);
        color: var(--white);
        position: relative;
        border-bottom: 3px solid var(--pecatu-gold);
        overflow: hidden;
    }

    .masthead::after {
        content: "";
        position: absolute;
        top: -40%;
        right: -6%;
        width: 480px;
        height: 480px;
        border: 1px solid rgba(224,189,121,0.18);
        border-radius: 50%;
    }
    .masthead::before {
        content: "";
        position: absolute;
        top: -30%;
        right: 2%;
        width: 340px;
        height: 340px;
        border: 1px solid rgba(224,189,121,0.14);
        border-radius: 50%;
    }

    .masthead-inner {
        position: relative;
        padding: 46px 34px 34px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 32px;
        flex-wrap: wrap;
    }

    .eyebrow {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: var(--font-mono);
        font-size: 12px;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--soft-gold);
        margin-bottom: 16px;
    }
    .eyebrow .dot { width: 6px; height: 6px; background: var(--pecatu-gold); }
    .eyebrow .rule { width: 28px; height: 1px; background: rgba(224,189,121,0.5); }

    .masthead h1 {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 40px;
        line-height: 1.12;
        max-width: 620px;
        letter-spacing: -0.01em;
    }

    .masthead .subline {
        margin-top: 12px;
        font-size: 14.5px;
        color: rgba(255,255,255,0.72);
        max-width: 520px;
    }

    .meta-panel {
        display: flex;
        gap: 0;
        border: 1px solid rgba(224,189,121,0.35);
        background: rgba(7,42,56,0.35);
        backdrop-filter: blur(2px);
    }
    .meta-item {
        padding: 16px 22px;
        border-right: 1px solid rgba(224,189,121,0.25);
        min-width: 128px;
    }
    .meta-item:last-child { border-right: none; }
    .meta-label {
        font-family: var(--font-mono);
        font-size: 10px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--soft-gold);
        margin-bottom: 6px;
    }
    .meta-value {
        font-family: var(--font-display);
        font-size: 19px;
        font-weight: 600;
        color: var(--white);
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-family: var(--font-mono);
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.02em;
    }
    .status-pill::before {
        content: "";
        width: 7px;
        height: 7px;
        background: var(--success);
        box-shadow: 0 0 0 3px rgba(22,163,74,0.22);
    }
    .meta-value.mono { font-family: var(--font-mono); font-size: 15px; font-weight: 500; color: rgba(255,255,255,0.85); }

    /* ============ SECTION SHELL ============ */
    .section { padding: 56px 0 0; }
    .section-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }
    .section-kicker {
        font-family: var(--font-mono);
        font-size: 11.5px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--digital-blue);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }
    .section-kicker .num {
        background: var(--pecatu-navy);
        color: var(--soft-gold);
        font-weight: 700;
        padding: 2px 7px;
    }
    .section-title {
        font-family: var(--font-display);
        font-weight: 600;
        font-size: 26px;
        color: var(--pecatu-navy);
    }
    .section-desc { font-size: 13.5px; color: var(--text-muted); max-width: 460px; text-align: right; }

    /* ============ TABLE — SECTION 1 (ringkasan) ============ */
    .ledger {
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        margin-bottom: 18px;
    }
    table.apbdes {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }
    table.apbdes thead th {
        background: var(--deep-blue);
        color: var(--white);
        font-family: var(--font-mono);
        font-weight: 500;
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        text-align: left;
        padding: 12px 16px;
        border-bottom: 2px solid var(--pecatu-gold);
    }
    table.apbdes thead tr.sub th {
        background: var(--digital-blue);
        border-bottom: 2px solid var(--pecatu-gold);
        font-size: 10.5px;
        padding: 8px 16px;
    }
    table.apbdes th.num, table.apbdes td.num { text-align: right; font-family: var(--font-mono); }
    table.apbdes td {
        padding: 10px 16px;
        border-bottom: 1px solid var(--border-soft);
        vertical-align: middle;
    }
    table.apbdes tbody tr:hover td { background: rgba(20,83,106,0.04); }

    tr.grp td {
        background: var(--soft-bg);
        font-weight: 700;
        color: var(--pecatu-navy);
        font-size: 12.5px;
        letter-spacing: 0.02em;
        border-top: 1px solid var(--border-soft);
    }
    tr.total td {
        background: var(--pecatu-navy);
        color: var(--white);
        font-weight: 700;
        font-family: var(--font-mono);
    }
    tr.total td.label { font-family: var(--font-body); letter-spacing: 0.02em; }
    tr.surplus td {
        background: var(--soft-gold);
        color: var(--pecatu-navy);
        font-weight: 700;
        font-family: var(--font-mono);
    }
    tr.surplus td.label { font-family: var(--font-body); }
    tr.net td {
        background: var(--emblem-blue);
        color: var(--white);
        font-weight: 700;
        font-family: var(--font-mono);
    }
    tr.net td.label { font-family: var(--font-body); }

    td.kode { color: var(--text-soft); font-family: var(--font-mono); font-size: 12px; width: 56px; }
    td.uraian { color: var(--text-dark); }
    td.uraian.indent1 { padding-left: 32px; }
    td.uraian.indent2 { padding-left: 48px; font-weight: 400; color: var(--text-muted); }

    .delta-pos { color: var(--success); }
    .delta-neg { color: var(--danger); }
    .delta-zero { color: var(--text-soft); }

    .ledger-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        border-top: 1px solid var(--border-soft);
        font-family: var(--font-mono);
        font-size: 10.5px;
        color: var(--text-soft);
        letter-spacing: 0.03em;
    }

    /* ============ SECTION 2 — bidang cards ============ */
    .bidang-card {
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-card);
        margin-bottom: 22px;
        border-left: 4px solid var(--pecatu-gold);
        overflow: hidden;
    }
    .bidang-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding: 16px 20px;
        background: linear-gradient(90deg, var(--pecatu-navy), var(--deep-blue));
        color: var(--white);
        flex-wrap: wrap;
    }
    .bidang-head-left { display: flex; align-items: center; gap: 14px; }
    .bidang-index {
        font-family: var(--font-mono);
        font-size: 11px;
        color: var(--pecatu-navy);
        background: var(--soft-gold);
        padding: 4px 9px;
        font-weight: 700;
    }
    .bidang-name { font-family: var(--font-display); font-size: 17px; font-weight: 600; }
    .bidang-totals { font-family: var(--font-mono); font-size: 12.5px; color: rgba(255,255,255,0.75); margin-top: 3px; }
    .bidang-totals b { color: var(--soft-gold); font-weight: 600; }

    .row-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .btn {
        font-family: var(--font-body);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.01em;
        padding: 7px 13px;
        border: 1px solid transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        transition: transform .12s ease, background .15s ease, border-color .15s ease, opacity .15s ease;
        line-height: 1;
    }
    .btn:active { transform: translateY(1px); }
    .btn svg { width: 13px; height: 13px; }

    .btn-toggle {
        background: rgba(255,255,255,0.08);
        border-color: rgba(224,189,121,0.4);
        color: var(--soft-gold);
    }
    .btn-toggle:hover { background: rgba(224,189,121,0.15); }

    .btn-edit {
        background: rgba(37,99,235,0.12);
        border-color: rgba(37,99,235,0.35);
        color: #6FA0FF;
    }
    .btn-edit:hover { background: rgba(37,99,235,0.22); }

    .btn-delete {
        background: rgba(220,38,38,0.12);
        border-color: rgba(220,38,38,0.4);
        color: #FF8A8A;
    }
    .btn-delete:hover { background: rgba(220,38,38,0.22); }

    .bidang-body {
        overflow: hidden;
        max-height: 2000px;
        transition: max-height .38s ease, opacity .28s ease;
        opacity: 1;
    }
    .bidang-card.collapsed .bidang-body {
        max-height: 0;
        opacity: 0;
    }
    .bidang-card.collapsed .btn-toggle .toggle-label::after { content: "Tampilkan"; }
    .btn-toggle .toggle-label::after { content: "Sembunyikan"; }
    .btn-toggle .toggle-label { font-size: 0; }
    .btn-toggle .toggle-label::after { font-size: 12px; }

    .bidang-card.is-removing {
        opacity: 0;
        transform: scale(0.98);
        transition: opacity .25s ease, transform .25s ease;
    }

    table.rincian { width: 100%; border-collapse: collapse; font-size: 13px; }
    table.rincian thead th {
        background: var(--soft-bg);
        color: var(--text-muted);
        font-family: var(--font-mono);
        font-size: 10.5px;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        text-align: left;
        padding: 9px 20px;
        border-bottom: 1px solid var(--border-soft);
    }
    table.rincian th.num, table.rincian td.num { text-align: right; font-family: var(--font-mono); }
    table.rincian td {
        padding: 9px 20px;
        border-bottom: 1px solid var(--border-soft);
    }
    table.rincian tbody tr:last-child td { border-bottom: none; }
    table.rincian tbody tr:hover td { background: rgba(20,83,106,0.035); }
    table.rincian td.kode { color: var(--text-soft); font-family: var(--font-mono); font-size: 11.5px; width: 64px; }
    table.rincian .sumberdana-tag {
        font-family: var(--font-mono);
        font-size: 10px;
        color: var(--emblem-blue);
        border: 1px solid var(--emblem-blue);
        padding: 2px 6px;
        white-space: nowrap;
    }

    /* ============ SECTION 3 — empty state ============ */
    .empty-state {
        background: var(--panel-bg);
        border: 1px dashed var(--emblem-blue);
        box-shadow: var(--shadow-card);
        padding: 56px 32px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
    }
    .empty-icon {
        width: 56px;
        height: 56px;
        border: 1px solid var(--border-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--emblem-blue);
        margin-bottom: 4px;
    }
    .empty-state h3 {
        font-family: var(--font-display);
        font-size: 20px;
        font-weight: 600;
        color: var(--pecatu-navy);
    }
    .empty-state p {
        font-size: 13.5px;
        color: var(--text-muted);
        max-width: 380px;
    }
    .btn-add {
        margin-top: 10px;
        background: var(--pecatu-navy);
        color: var(--white);
        border: 1px solid var(--pecatu-navy);
        font-size: 13px;
        padding: 11px 22px;
        display: inline-flex;
        gap: 8px;
        align-items: center;
        cursor: pointer;
        font-weight: 600;
        transition: background .15s ease, transform .12s ease;
    }
    .btn-add:hover { background: var(--deep-blue); }
    .btn-add:active { transform: translateY(1px); }
    .btn-add svg { width: 14px; height: 14px; }

    /* footer */
    .doc-footer {
        margin-top: 60px;
        padding: 22px 0 0;
        border-top: 1px solid var(--border-soft);
        display: flex;
        justify-content: space-between;
        font-family: var(--font-mono);
        font-size: 11px;
        color: var(--text-soft);
        letter-spacing: 0.03em;
        flex-wrap: wrap;
        gap: 8px;
    }

    /* fade-in on load */
    .fade-in {
        opacity: 0;
        transform: translateY(10px);
        animation: fadeInUp .6s ease forwards;
    }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 760px) {
        .wrap { padding: 0 18px; }
        .masthead h1 { font-size: 28px; }
        .meta-panel { width: 100%; }
        .meta-item { flex: 1; min-width: 0; padding: 12px 12px; }
        .section-desc { text-align: left; }
        table.apbdes, table.rincian { font-size: 12px; }
        td.uraian.indent1 { padding-left: 18px; }
        td.uraian.indent2 { padding-left: 28px; }
    }

    :focus-visible {
        outline: 2px solid var(--info);
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
        * { animation-duration: 0.001ms !important; transition-duration: 0.001ms !important; }
    }

    /* Addon #2 */
    table.apbdes th.col-aksi,
    table.apbdes td.aksi {
        text-align: center;
        width: 100px;
    }

    .row-aksi {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .icon-only {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-soft);
        background: var(--white);
        color: var(--text-muted);
        padding: 0;
        cursor: pointer;
        transition: border-color 0.15s ease, background 0.15s ease, color 0.15s ease;
    }
    .icon-only svg { width: 12px; height: 12px; }

    .icon-only.icon-edit:hover {
        border-color: #2563EB;
        background: rgba(37,99,235,0.08);
        color: #2563EB;
    }
    .icon-only.icon-add:hover {
        border-color: var(--success);
        background: rgba(22,163,74,0.08);
        color: var(--success);
    }
    .icon-only.icon-delete:hover {
        border-color: var(--danger);
        background: rgba(220,38,38,0.08);
        color: var(--danger);
    }
    .icon-only:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 2px;
    }

    .ledger-actions {
        display: flex;
        justify-content: flex-end;
        padding: 12px 16px;
        border-top: 1px solid var(--border-soft);
        background: var(--panel-bg);
    }

    .btn-add-rincian {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: 1.5px solid var(--pecatu-navy);
        color: var(--pecatu-navy);
        font-family: var(--font-body);
        font-size: 12.5px;
        font-weight: 600;
        padding: 9px 16px;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
    }
    .btn-add-rincian:hover { background: var(--pecatu-navy); color: var(--white); }
    .btn-add-rincian:active { transform: translateY(1px); }
    .btn-add-rincian svg { width: 13px; height: 13px; }
    .btn-add-rincian:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 2px;
    }

    /* ===== FLOATING MENU (kanan bawah) ===== */
    .fab-container {
        position: fixed;
        right: 26px;
        bottom: 28px;
        z-index: 500;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        pointer-events: none;
    }

    .fab-container .fab-main {
        pointer-events: auto;
    }

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

    .fab-container.is-open .fab-menu {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
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
        border-radius: var(--radius-button);
        box-shadow: var(--shadow-card);
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s ease, border-color 0.15s ease, transform 0.15s ease;
    }

    .fab-item:hover { background: var(--white); border-color: var(--pecatu-gold); }
    .fab-item:active { transform: scale(0.97); }

    .fab-item:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 2px;
    }

    .fab-item-icon {
        width: 30px;
        height: 30px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--soft-bg);
        color: var(--digital-blue);
    }

    .fab-item.fab-docs .fab-item-icon { color: var(--emblem-blue); }
    .fab-item.fab-add .fab-item-icon { color: var(--success); }

    .fab-item-icon svg { width: 15px; height: 15px; }

    .fab-main {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        border: none;
        background: var(--pecatu-navy);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow-soft);
        position: relative;
        transition: background 0.2s ease, transform 0.25s ease;
    }

    .fab-main::after {
        content: "";
        position: absolute;
        inset: -4px;
        border: 1px solid rgba(201,162,90,0.35);
        border-radius: 50%;
        pointer-events: none;
    }

    .fab-main:hover { background: var(--digital-blue); }
    .fab-main:active { transform: scale(0.95); }

    .fab-main:focus-visible {
        outline: 2px solid var(--pecatu-gold);
        outline-offset: 3px;
    }

    .fab-main svg {
        width: 22px;
        height: 22px;
        transition: transform 0.25s ease;
    }

    .fab-container.is-open .fab-main svg { transform: rotate(45deg); }

    .fab-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(7,42,56,0.18);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 490;
    }

    .fab-container.is-open ~ .fab-backdrop,
    .fab-backdrop.is-visible {
        opacity: 1;
        pointer-events: auto;
    }

    /* ===== FLOATING MENU — optimisasi mobile ===== */
    @media (max-width: 760px) {
        .fab-container {
            right: 16px;
            bottom: calc(20px + env(safe-area-inset-bottom, 0px));
            gap: 10px;
        }

        .fab-main {
            width: 52px;
            height: 52px;
        }

        .fab-main svg { width: 20px; height: 20px; }

        .fab-item {
            padding: 10px 16px 10px 12px;
            font-size: 13px;
            box-shadow: var(--shadow-soft);
        }

        .fab-item-icon {
            width: 28px;
            height: 28px;
        }
    }

    @media (max-width: 420px) {
        .fab-item-label { display: none; }
        .fab-item {
            width: 46px;
            height: 46px;
            padding: 0;
            justify-content: center;
            border-radius: 50%;
        }
        .fab-item-icon { background: transparent; }
    }
</style>