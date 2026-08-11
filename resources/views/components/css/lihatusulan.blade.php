<style>
    .mono {
        font-family: 'IBM Plex Mono', monospace;
        letter-spacing: 0.02em;
    }

    .serif {
        font-family: 'Fraunces', serif;
    }

    .wrap {
        margin: 0 auto;
        width: 100%;
    }

    /* ===== Document header (kop surat style) ===== */
    .doc-header {
        position: relative;
        background: linear-gradient(135deg, var(--pecatu-navy) 0%, var(--deep-blue) 55%, var(--digital-blue) 130%);
        border-radius: var(--radius-card);
        padding: 34px 38px;
        color: var(--white);
        box-shadow: var(--shadow-soft);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 32px;
        overflow: hidden;
    }

    .doc-header::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: 16px 16px;
        opacity: 0.5;
        pointer-events: none;
    }

    .doc-header::after {
        content: "";
        position: absolute;
        right: -60px;
        top: -60px;
        width: 220px;
        height: 220px;
        border: 1px solid rgba(214, 161, 0, 0.25);
        border-radius: 50%;
    }

    .doc-header-left {
        position: relative;
        z-index: 1;
    }

    .doc-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: var(--soft-gold);
        font-weight: 600;
        margin-bottom: 14px;
    }

    .doc-eyebrow .dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--soft-gold);
    }

    .doc-title {
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: 30px;
        line-height: 1.25;
        max-width: 560px;
        margin-bottom: 14px;
    }

    .doc-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 22px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.72);
    }

    .doc-meta strong {
        color: var(--white);
        font-weight: 600;
    }

    .doc-meta .sep {
        color: rgba(255, 255, 255, 0.25);
    }

    /* ===== Seal / stamp ===== */
    .seal {
        position: relative;
        z-index: 1;
        flex-shrink: 0;
        width: 148px;
        height: 148px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .seal-ring {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 1.5px dashed rgba(243, 197, 66, 0.55);
        animation: spin 40s linear infinite;
    }

    .seal-core {
        width: 106px;
        height: 106px;
        border-radius: 50%;
        background: radial-gradient(circle at 32% 28%, rgba(255, 255, 255, 0.14), transparent 55%), var(--pecatu-gold);
        border: 2px solid var(--soft-gold);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--pecatu-navy);
        text-align: center;
        box-shadow: 0 8px 22px rgba(214, 161, 0, 0.35), inset 0 0 0 5px rgba(6, 27, 78, 0.06);
    }

    .seal-core.denied {
      background: radial-gradient(circle at 32% 28%, rgba(255, 255, 255, 0.14), transparent 55%), var(--danger);
      border: 2px solid lightcoral;
      color: white;

    }

    .seal-core.done {
      background: radial-gradient(circle at 32% 28%, rgba(255, 255, 255, 0.14), transparent 55%), var(--success);
      border: 2px solid lightgreen;

    }

    .seal-core .lbl-top {
        font-size: 8.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .seal-core .lbl-main {
        font-family: 'Fraunces', serif;
        font-weight: 700;
        font-size: 15px;
        line-height: 1.15;
        margin: 3px 0;
    }

    .seal-core .lbl-bottom {
        font-size: 8px;
        font-weight: 600;
        letter-spacing: 0.06em;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* ===== Layout grid ===== */
    .grid {
        display: grid;
        grid-template-columns: 1.55fr 1fr;
        gap: 24px;
        margin-top: 24px;
        align-items: start;
    }

    .card {
        background: var(--white);
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-card);
        padding: 30px 32px;
        margin-bottom: 24px;
    }

    .card:last-child {
        margin-bottom: 0;
    }

    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .card-title {
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: 19px;
        color: var(--pecatu-navy);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title .num {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        color: var(--digital-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        font-weight: 600;
    }

    /* ===== Pengaju ===== */
    .pengaju-top {
        display: flex;
        gap: 18px;
        align-items: center;
        padding-bottom: 22px;
        border-bottom: 1px dashed var(--border-soft);
        margin-bottom: 22px;
    }

    .avatar {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--digital-blue), var(--deep-blue));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: 20px;
        flex-shrink: 0;
    }

    .pengaju-name {
        font-size: 17px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .pengaju-role {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .verified-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 8px;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--success);
        background: rgba(22, 163, 74, 0.08);
        padding: 3px 9px;
        border-radius: 100px;
    }

    .verified-chip svg {
        width: 12px;
        height: 12px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
    }

    .info-item .lbl {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--text-soft);
        font-weight: 600;
        margin-bottom: 5px;
    }

    .info-item .val {
        font-size: 14.5px;
        color: var(--text-dark);
        font-weight: 500;
    }

    .info-item .val.mono {
        font-size: 13.5px;
    }

    .info-item.full {
        grid-column: 1 / -1;
    }

    /* ===== Deskripsi usulan ===== */
    .desc-text {
        font-size: 14.5px;
        color: var(--text-dark);
        line-height: 1.75;
    }

    .tag-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .tag {
        font-size: 12px;
        font-weight: 600;
        padding: 6px 13px;
        border-radius: 100px;
        border: 1px solid var(--border-soft);
        background: var(--panel-bg);
        color: var(--deep-blue);
    }

    .tag.gold {
        background: rgba(214, 161, 0, 0.09);
        border-color: rgba(214, 161, 0, 0.25);
        color: #8a6a00;
    }

    /* ===== Riwayat / timeline ===== */
    .timeline {
        position: relative;
        padding-left: 6px;
    }

    .t-item {
        position: relative;
        display: flex;
        gap: 18px;
        padding-bottom: 28px;
    }

    .t-item:last-child {
        padding-bottom: 0;
    }

    .t-line {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 16px;
        flex-shrink: 0;
    }

    .t-dot {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--white);
        border: 3px solid var(--digital-blue);
        z-index: 1;
        flex-shrink: 0;
    }

    .t-dot.done {
        border-color: var(--success);
        background: var(--success);
    }

    .t-dot.todo {
        border-color: #CCC;
        background: var(--panel-bg);
    }

    .t-dot.denied {
        border-color: var(--danger);
        background: var(--danger);
    }

    .t-dot.pending {
        border-color: var(--pecatu-gold);
        background: var(--soft-gold);
        box-shadow: 0 0 0 4px rgba(214, 161, 0, 0.16);
        animation: pulse 2.4s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 0 4px rgba(214, 161, 0, 0.16);
        }

        50% {
            box-shadow: 0 0 0 8px rgba(214, 161, 0, 0.09);
        }
    }

    .t-connector {
        position: absolute;
        top: 16px;
        bottom: -28px;
        width: 2px;
        background: var(--border-soft);
    }

    .t-item:last-child .t-connector {
        display: none;
    }

    .t-body {
        flex: 1;
    }

    .t-date {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11.5px;
        color: var(--text-soft);
        margin-bottom: 4px;
        font-weight: 500;
    }

    .t-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 3px;
    }

    .t-by {
        font-size: 12.5px;
        color: var(--text-muted);
        margin-bottom: 8px;
    }

    .t-note {
        font-size: 13px;
        color: var(--text-muted);
        background: var(--panel-bg);
        border-left: 2px solid var(--emblem-blue);
        padding: 9px 13px;
        border-radius: 0 10px 10px 0;
        line-height: 1.6;
    }

    .t-status {
        display: inline-block;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 2px 9px;
        border-radius: 100px;
        margin-left: 8px;
        position: relative;
        top: -1px;
    }

    .t-status.done {
        background: rgba(22, 163, 74, 0.1);
        color: var(--success);
    }

      .t-status.todo {
        background: darkgray;
        color: white;
    }

    .t-status.denied {
        background: rgba(22, 163, 74, 0.1);
        color: var(--danger);
    }

    .t-status.pending {
        background: rgba(214, 161, 0, 0.14);
        color: #8a6a00;
    }

    /* ===== Status verifikasi (aside) ===== */
    .status-banner {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 18px;
        border-radius: var(--radius-input);
        background: linear-gradient(135deg, rgba(214, 161, 0, 0.1), rgba(243, 197, 66, 0.06));
        border: 1px solid rgba(214, 161, 0, 0.25);
        margin-bottom: 24px;
    }

    .status-banner .ic {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--pecatu-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .status-banner .ic svg {
        width: 19px;
        height: 19px;
        stroke: var(--white);
    }

    .status-banner .t1 {
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #8a6a00;
        font-weight: 700;
    }

    .status-banner .t2 {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--text-dark);
        margin-top: 1px;
    }

    .stepper {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .s-item {
        display: flex;
        gap: 14px;
        position: relative;
        padding-bottom: 22px;
    }

    .s-item:last-child {
        padding-bottom: 0;
    }

    .s-marker {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
        z-index: 1;
        font-family: 'IBM Plex Mono', monospace;
    }

    .s-marker.done {
        background: var(--success);
        color: var(--white);
    }

    .s-marker.denied {
        background: var(--danger);
        color: var(--white);
    }

    .s-marker.active {
        background: var(--pecatu-gold);
        color: var(--white);
        box-shadow: 0 0 0 5px rgba(214, 161, 0, 0.16);
    }

    .s-marker.todo {
        background: var(--panel-bg);
        color: var(--text-soft);
        border: 1px solid var(--border-soft);
    }

    .s-connector {
        position: absolute;
        left: 15px;
        top: 30px;
        bottom: -22px;
        width: 2px;
        background: var(--border-soft);
    }

    .s-item.completed .s-connector {
        background: var(--success);
    }

    .s-item.denied .s-connector {
        background: var(--danger);
    }

    .s-item:last-child .s-connector {
        display: none;
    }

    .s-label {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-dark);
        padding-top: 4px;
    }

    .s-sub {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .s-item.todo .s-label {
        color: var(--text-soft);
    }

    /* ===== Map ===== */
    .map-frame {
        border-radius: var(--radius-input);
        overflow: hidden;
        border: 1px solid var(--border-soft);
        height: 260px;
    }

    .map-frame iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
        filter: saturate(0.92);
    }

    .map-coord {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px dashed var(--border-soft);
    }

    .map-coord .lbl {
        font-size: 11px;
        color: var(--text-soft);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-weight: 600;
    }

    .map-coord .val {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 13px;
        color: var(--deep-blue);
        font-weight: 600;
    }

    .map-addr {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 10px;
        line-height: 1.6;
    }

    @media (max-width: 900px) {
        .grid {
            grid-template-columns: 1fr;
        }

        .doc-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        body {
            padding: 28px 16px 60px;
        }

        .card {
            padding: 24px 20px;
        }
    }

    /* ===== Fade in on open / fade out on leave ===== */
    html {
        scroll-behavior: smooth;
    }

    body.pre-load {
        opacity: 0;
    }

    body.page-enter {
        opacity: 1;
        transition: opacity 0.6s ease;
    }

    body.page-leave {
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    .fade-el {
        opacity: 0;
        transform: translateY(14px);
        transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .fade-el.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>
