<style>
    :root {
        --pecatu-navy: #072A38;
        --deep-blue: #0C3A4D;
        --digital-blue: #14536A;
        --pecatu-gold: #C9A25A;
        --soft-gold: #E0BD79;
        --emblem-blue: #4E7C93;

        --white: #FFFFFF;
        --soft-bg: #F6F1E6;
        --panel-bg: #FFFDF9;
        --border-soft: #EDE6D4;
        --text-dark: #16262C;
        --text-muted: #4A5D63;
        --text-soft: #7C8F94;

        --success: #16A34A;
        --warning: #D97A4E;
        --danger: #DC2626;
        --info: #2563EB;
        --dark: #16262C;

        --shadow-soft: 0 16px 40px rgba(7, 42, 56, 0.08);
        --shadow-card: 0 10px 30px rgba(7, 42, 56, 0.07);

        --topbar-height: 76px;
        --radius-card: 22px;
        --radius-input: 14px;
        --radius-button: 14px;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--soft-bg);
        color: var(--text-dark);
        min-height: 100vh;
    }

    .wrap {
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        min-height: 100vh;
    }

    /* ---------- LEFT PANEL ---------- */
    .hero {
        position: relative;
        background:
            radial-gradient(ellipse 900px 500px at 15% -10%, rgba(224, 189, 121, 0.10), transparent 60%),
            linear-gradient(160deg, var(--pecatu-navy) 0%, var(--deep-blue) 55%, var(--digital-blue) 100%);
        color: var(--soft-bg);
        padding: 56px 64px 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
    }

    .hero::before {
        /* subtle wave contour lines evoking Uluwatu's cliff coastline */
        content: "";
        position: absolute;
        inset: 0;
        background-image: repeating-linear-gradient(100deg,
                transparent 0px,
                transparent 68px,
                rgba(255, 255, 255, 0.035) 69px,
                transparent 70px);
        pointer-events: none;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 2;
    }

    .brand-mark {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: linear-gradient(150deg, var(--soft-gold), var(--pecatu-gold) 70%);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        flex-shrink: 0;
    }

    .brand-name {
        font-family: 'Fraunces', serif;
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .brand-sub {
        font-size: 11px;
        letter-spacing: 1.6px;
        color: var(--soft-gold);
        font-weight: 600;
        margin-top: 2px;
    }

    .eyebrow {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 11.5px;
        letter-spacing: 2px;
        font-weight: 700;
        color: var(--soft-gold);
        margin: 40px 0 18px;
        position: relative;
        z-index: 2;
    }

    .eyebrow::before {
        content: "";
        width: 26px;
        height: 2px;
        background: var(--soft-gold);
        display: inline-block;
    }

    .headline {
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: 44px;
        line-height: 1.12;
        max-width: 560px;
        position: relative;
        z-index: 2;
    }

    .headline em {
        font-style: italic;
        color: var(--soft-gold);
        font-weight: 500;
    }

    .desc {
        margin-top: 20px;
        max-width: 460px;
        font-size: 15px;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.72);
        position: relative;
        z-index: 2;
    }

    .chips {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 30px;
        position: relative;
        z-index: 2;
    }

    .chip {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.14);
        padding: 9px 15px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--soft-bg);
        backdrop-filter: blur(6px);
    }

    .chip .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--soft-gold);
        flex-shrink: 0;
    }

    /* Signature: Candi Bentar (split gate) silhouette */
    .gate {
        position: absolute;
        right: -40px;
        bottom: -30px;
        width: 340px;
        height: 340px;
        opacity: 0.16;
        z-index: 1;
        pointer-events: none;
    }

    .stats {
        display: flex;
        gap: 44px;
        padding-top: 28px;
        border-top: 1px solid rgba(255, 255, 255, 0.14);
        position: relative;
        z-index: 2;
    }

    .stat-num {
        font-family: 'Fraunces', serif;
        font-size: 28px;
        font-weight: 600;
        color: var(--soft-gold);
    }

    .stat-label {
        font-size: 11.5px;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 3px;
        letter-spacing: 0.3px;
    }

    /* ---------- RIGHT PANEL ---------- */
    .panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background: var(--soft-bg);
    }

    .form-card {
        width: 100%;
        max-width: 400px;
    }

    .form-eyebrow {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 11px;
        letter-spacing: 2px;
        font-weight: 700;
        color: var(--digital-blue);
        margin-bottom: 14px;
    }

    .form-eyebrow::before {
        content: "";
        width: 22px;
        height: 2px;
        background: var(--digital-blue);
        display: inline-block;
    }

    .welcome {
        font-family: 'Fraunces', serif;
        font-size: 32px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .welcome-sub {
        margin-top: 10px;
        font-size: 14.5px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    form {
        margin-top: 30px;
    }

    .field {
        margin-bottom: 18px;
    }

    label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 7px;
    }

    label sup {
        color: var(--warning);
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 13px 14px;
        border-radius: 10px;
        border: 1.5px solid #DED5BE;
        background: var(--panel-bg);
        font-family: inherit;
        font-size: 14.5px;
        color: var(--text-dark);
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    input::placeholder {
        color: #A9A08C;
    }

    input:focus {
        outline: none;
        border-color: var(--digital-blue);
        box-shadow: 0 0 0 4px rgba(20, 83, 106, 0.12);
    }

    .row-between {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 6px 0 24px;
    }

    .remember {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: var(--text-muted);
    }

    .remember input {
        width: 16px;
        height: 16px;
        accent-color: var(--deep-blue);
        cursor: pointer;
    }

    .forgot {
        font-size: 13.5px;
        color: var(--digital-blue);
        font-weight: 600;
        text-decoration: none;
    }

    .forgot:hover {
        text-decoration: underline;
    }

    .fi-ac-btn-action {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--digital-blue), var(--pecatu-navy));
        color: #fff;
        font-family: inherit;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.3px;
        cursor: pointer;
        box-shadow: 0 10px 24px rgba(7, 42, 56, 0.25);
        transition: transform .12s ease, box-shadow .12s ease;
    }

    .fi-ac-btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(7, 42, 56, 0.32);
    }

    .fi-ac-btn-action:active {
        transform: translateY(0);
    }

    .divider {
        height: 1px;
        background: #E4DBC5;
        margin: 28px 0 20px;
    }

    .help-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13.5px;
        color: var(--text-muted);
        margin-bottom: 10px;
    }

    .help-row a {
        color: var(--digital-blue);
        font-weight: 700;
        text-decoration: none;
    }

    .help-row a:hover {
        text-decoration: underline;
    }

    .help-icon {
        width: 16px;
        text-align: center;
        margin-top: 1px;
    }

    .footer-note {
        text-align: center;
        margin-top: 26px;
        font-size: 11.5px;
        color: #9C927A;
        line-height: 1.6;
    }

    @media (max-width: 880px) {
        .wrap {
            grid-template-columns: 1fr;
        }

        .hero {
            padding: 40px 28px;
            min-height: 340px;
        }

        .headline {
            font-size: 32px;
        }

        .stats {
            gap: 28px;
        }

        .panel {
            padding: 36px 24px;
        }
    }

    .fi-fo-field-label-ctn {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
</style>
