<style>
    :root {
        --progress-height: 3px;
    }

    .container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 19px;
        border-radius: 999px;
        font-size: 13.5px;
        font-weight: 700;
        border: 1px solid transparent;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-ghost {
        background: var(--white);
        border-color: var(--border-soft);
        color: var(--text-dark);
    }

    .btn-primary {
        background: var(--digital-blue);
        color: var(--white);
        box-shadow: 0 8px 18px rgba(11, 95, 234, 0.28);
    }

    .progress-rail {
        height: var(--progress-height);
        background: var(--border-soft);
        position: sticky;
        top: var(--topbar-height);
        z-index: 59;
    }

    .progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--pecatu-gold), var(--digital-blue));
        transition: width .1s linear;
    }

    /* ============ HERO ============ */
    .hero {
        padding: 88px 0 70px;
        position: relative;
        overflow: hidden;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 48px;
        align-items: center;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #EAF1FD;
        border: 1px solid #D6E4FB;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: var(--digital-blue);
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }

    .eyebrow-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--digital-blue);
    }

    .hero-meta {
        display: flex;
        gap: 28px;
        margin-top: 34px;
        flex-wrap: wrap;
    }

    .hero-meta .m-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .hero-meta .m-item .num {
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 24px;
        color: var(--pecatu-gold);
    }

    .hero-meta .m-item .lab {
        font-size: 12.5px;
        color: var(--text-soft);
        font-weight: 600;
    }

    /* stacked numeral card, right side of hero */
    .hero-visual {
        position: relative;
        background: linear-gradient(160deg, var(--pecatu-navy), var(--deep-blue));
        border-radius: 24px;
        padding: 36px;
        box-shadow: var(--shadow-soft);
        color: var(--white);
        overflow: hidden;
    }

    .hero-visual::after {
        content: "";
        position: absolute;
        right: -60px;
        top: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(214, 161, 0, 0.28), transparent 70%);
    }

    .hero-visual .step-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 10px;
        font-size: 13.5px;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }

    .hero-visual .step-preview:last-child {
        margin-bottom: 0;
    }

    .hero-visual .step-preview .n {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        color: var(--soft-gold);
        flex-shrink: 0;
    }

    .hero-visual .step-preview span.t {
        color: rgba(255, 255, 255, 0.85);
    }

    /* ============ MAIN LAYOUT: sidebar + content ============ */
    .guide-section {
        padding: 60px 0 100px;
    }

    .guide-layout {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 56px;
        align-items: start;
    }

    .side-nav {
        position: sticky;
        top: calc(var(--topbar-height) + var(--progress-height) + 28px);
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .side-nav .side-kicker {
        font-size: 11.5px;
        font-weight: 700;
        color: var(--text-soft);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 14px;
    }

    .side-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-muted);
        border-left: 2px solid var(--border-soft);
        transition: color .15s, border-color .15s, background .15s;
    }

    .side-link .dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--panel-bg);
        border: 1.5px solid var(--border-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 800;
        color: var(--text-soft);
        flex-shrink: 0;
        transition: all .15s;
    }

    .side-link:hover {
        color: var(--pecatu-navy);
        background: var(--panel-bg);
    }

    .side-link.active {
        color: var(--digital-blue);
        background: #EAF1FD;
        border-left-color: var(--digital-blue);
    }

    .side-link.active .dot {
        background: var(--digital-blue);
        border-color: var(--digital-blue);
        color: var(--white);
    }

    .side-cta {
        margin-top: 22px;
        padding: 16px;
        border-radius: 14px;
        background: linear-gradient(155deg, #FDF3DA, #FBEAC1);
        border: 1px solid #F1DA9E;
    }

    .side-cta p {
        font-size: 13px;
        color: #6B5300;
        font-weight: 600;
    }

    /* content column */
    .steps-col {
        display: flex;
        flex-direction: column;
        gap: 86px;
    }

    .step-block {
        position: relative;
        scroll-margin-top: 110px;
    }

    .step-block .bignum {
        position: absolute;
        top: -34px;
        left: -6px;
        font-family: 'Sora', sans-serif;
        font-size: 110px;
        font-weight: 800;
        color: var(--pecatu-navy);
        opacity: 0.05;
        line-height: 1;
        z-index: 0;
        user-select: none;
        pointer-events: none;
    }

    .step-head {
        position: relative;
        z-index: 1;
        padding-top: 12px;
    }

    .step-tag {
        display: inline-block;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 4px 11px;
        border-radius: 999px;
        background: #EAF1FD;
        color: var(--digital-blue);
        margin-bottom: 14px;
    }

    .step-block:nth-of-type(5) .step-tag {
        background: #FDF3DA;
        color: #8A6400;
    }

    .step-head h3 {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        max-width: 560px;
    }

    .step-head p.desc {
        margin-top: 10px;
        color: var(--text-muted);
        font-size: 15px;
        max-width: 600px;
    }

    .step-shot {
        position: relative;
        z-index: 1;
        margin-top: 26px;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-card);
        background: var(--panel-bg);
    }

    .shot-frame-bar {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 11px 14px;
        background: var(--panel-bg);
        border-bottom: 1px solid var(--border-soft);
    }

    .shot-frame-bar span {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: var(--border-soft);
    }

    .step-shot img {
        display: block;
        width: 100%;
        height: auto;
    }

    /* connecting line between step blocks (content column, subtle) */
    .step-block:not(:last-child)::after {
        content: "";
        position: absolute;
        left: -34px;
        top: 60px;
        bottom: -86px;
        width: 1px;
        background: var(--border-soft);
        z-index: 0;
    }

    /* ============ NOTE + FOOTER ============ */
    .note-strip {
        margin-top: 90px;
        background: var(--white);
        border: 1px solid var(--border-soft);
        border-left: 4px solid var(--pecatu-gold);
        border-radius: 14px;
        padding: 22px 26px;
        display: flex;
        gap: 16px;
        box-shadow: var(--shadow-card);
    }

    .note-strip .icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #FDF3DA;
        color: #8A6400;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        flex-shrink: 0;
    }

    .note-strip h4 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .note-strip p {
        margin-top: 4px;
        font-size: 14px;
        color: var(--text-muted);
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 980px) {
        .hero-grid {
            grid-template-columns: 1fr;
        }

        .hero-visual {
            order: -1;
        }

        .guide-layout {
            grid-template-columns: 1fr;
        }

        .side-nav {
            position: static;
            flex-direction: row;
            overflow-x: auto;
            gap: 8px;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .side-nav .side-kicker {
            display: none;
        }

        .side-link {
            border-left: none;
            border-bottom: 2px solid var(--border-soft);
            white-space: nowrap;
        }

        .side-link.active {
            border-left: none;
            border-bottom-color: var(--digital-blue);
        }

        .side-cta {
            display: none;
        }

        .step-block .bignum {
            display: none;
        }

        .step-block:not(:last-child)::after {
            display: none;
        }
    }

    @media (max-width: 720px) {
        .navbar .nav-links {
            display: none;
        }

        .hero h1 {
            font-size: 32px;
        }

        .container {
            padding: 0 20px;
        }

        .steps-col {
            gap: 60px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        html {
            scroll-behavior: auto;
        }
    }
</style>
