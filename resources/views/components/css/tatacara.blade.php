<style>
  body {
    font-family: var(--font-body);
    background: var(--soft-bg);
    color: var(--text-dark);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
  }

  body::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    background-image:
      radial-gradient(circle at 1px 1px, rgba(7,42,56,0.05) 1px, transparent 0);
    background-size: 26px 26px;
    opacity: .5;
  }

  a { color: inherit; text-decoration: none; }
  img { max-width: 100%; display: block; }

  .wrap {

  }

  /* ---------- TOPBAR ---------- */
  .topbar {
    position: sticky;
    top: 0;
    z-index: 50;
    height: var(--topbar-height);
    display: flex;
    align-items: center;
    background: linear-gradient(180deg, var(--pecatu-navy), var(--deep-blue));
    box-shadow: 0 8px 24px rgba(7,42,56,0.18);
  }

  .topbar-inner {
    max-width: 1180px;
    margin: 0 auto;
    width: 100%;
    padding: 0 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .brand { display: flex; align-items: center; gap: 14px; }

  .brand-seal {
    width: 42px; height: 42px;
    border-radius: 50%;
    border: 1.5px solid var(--pecatu-gold);
    display: flex; align-items: center; justify-content: center;
    position: relative;
  }
  .brand-seal::before {
    content: "";
    position: absolute; inset: 4px;
    border: 1px solid rgba(201,162,90,0.5);
    border-radius: 50%;
  }
  .brand-seal span {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: 14px;
    color: var(--soft-gold);
    letter-spacing: 0.5px;
  }

  .brand-text .brand-title {
    font-family: var(--font-display);
    color: var(--white);
    font-size: 17px;
    font-weight: 600;
    letter-spacing: 0.2px;
  }
  .brand-text .brand-sub {
    color: var(--emblem-blue);
    font-size: 11.5px;
    letter-spacing: 1.6px;
    text-transform: uppercase;
    margin-top: 2px;
  }

  .topnav {
    display: flex;
    gap: 30px;
    font-size: 13.5px;
    color: rgba(255,255,255,0.72);
  }
  .topnav a { position: relative; padding: 6px 0; transition: color .2s; }
  .topnav a:hover { color: var(--soft-gold); }

  /* ---------- HERO ---------- */
  .hero {
    padding: 84px 0 64px;
    position: relative;
  }
  .hero-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 56px;
    align-items: center;
  }
  .eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font-mono);
    font-size: 12px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--digital-blue);
    background: rgba(20,83,106,0.08);
    border: 1px solid rgba(20,83,106,0.16);
    padding: 7px 14px;
    border-radius: 100px;
    margin-bottom: 26px;
  }
  .eyebrow::before {
    content: "";
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--pecatu-gold);
  }
  h1.hero-title {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: 52px;
    line-height: 1.08;
    color: var(--pecatu-navy);
    letter-spacing: -0.5px;
  }
  h1.hero-title em {
    font-style: italic;
    color: var(--digital-blue);
    font-weight: 500;
  }
  .hero-desc {
    margin-top: 22px;
    max-width: 520px;
    color: var(--text-muted);
    font-size: 16px;
  }
  .hero-meta {
    margin-top: 34px;
    display: flex;
    gap: 34px;
  }
  .hero-meta div { border-left: 2px solid var(--pecatu-gold); padding-left: 14px; }
  .hero-meta .num {
    font-family: var(--font-display);
    font-size: 24px;
    color: var(--pecatu-navy);
    font-weight: 600;
  }
  .hero-meta .lbl {
    font-size: 12.5px;
    color: var(--text-soft);
    margin-top: 2px;
  }

  /* Hero signature emblem */
  .hero-emblem {
    position: relative;
    aspect-ratio: 1/1;
    border-radius: 50%;
    background: radial-gradient(circle at 32% 28%, var(--digital-blue), var(--pecatu-navy) 68%);
    box-shadow: var(--shadow-soft);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .hero-emblem::before {
    content: "";
    position: absolute; inset: 18px;
    border: 1px dashed rgba(224,189,121,0.45);
    border-radius: 50%;
  }
  .hero-emblem::after {
    content: "";
    position: absolute; inset: 34px;
    border: 1px solid rgba(224,189,121,0.3);
    border-radius: 50%;
  }
  .hero-emblem-core {
    text-align: center;
    color: var(--soft-gold);
    z-index: 2;
  }
  .hero-emblem-core .en { font-family: var(--font-mono); font-size: 11px; letter-spacing: 3px; opacity: .75; text-transform: uppercase;}
  .hero-emblem-core .word {
    font-family: var(--font-display);
    font-size: 30px;
    font-weight: 600;
    color: var(--white);
    margin-top: 6px;
  }
  .hero-emblem-core .sub { font-size: 11px; color: var(--emblem-blue); margin-top: 6px; letter-spacing: .5px;}
  .orbit-dot {
    position: absolute;
    width: 9px; height: 9px;
    border-radius: 50%;
    background: var(--pecatu-gold);
    box-shadow: 0 0 0 4px rgba(201,162,90,0.18);
  }
  .orbit-dot.d1 { top: 10%; left: 50%; }
  .orbit-dot.d2 { top: 50%; right: 6%; }
  .orbit-dot.d3 { bottom: 12%; left: 22%; }

  /* ---------- STEPPER STRIP ---------- */
  .stepper-strip {
    padding: 8px 0 56px;
  }
  .stepper-track {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    background: var(--panel-bg);
    border: 1px solid var(--border-soft);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-card);
    padding: 26px 10px;
    position: relative;
  }
  .stepper-track::before {
    content: "";
    position: absolute;
    top: 46px;
    left: 10%;
    right: 10%;
    height: 1px;
    background: repeating-linear-gradient(90deg, var(--pecatu-gold) 0 6px, transparent 6px 12px);
    z-index: 0;
  }
  .step-node {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 0 10px;
    cursor: pointer;
  }
  .step-node .dot {
    width: 40px; height: 40px;
    margin: 0 auto 12px;
    border-radius: 50%;
    background: var(--panel-bg);
    border: 1.5px solid var(--pecatu-gold);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-mono);
    font-weight: 600;
    color: var(--pecatu-navy);
    font-size: 14px;
    transition: transform .2s, background .2s, color .2s;
  }
  .step-node:hover .dot {
    background: var(--pecatu-navy);
    color: var(--soft-gold);
    transform: translateY(-3px);
  }
  .step-node .label {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-dark);
  }
  .step-node .sub {
    font-size: 11px;
    color: var(--text-soft);
    margin-top: 2px;
  }

  /* ---------- MAIN LAYOUT ---------- */
  .content-area {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 48px;
    padding-bottom: 120px;
    align-items: start;
  }

  .side-nav {
    position: sticky;
    top: calc(var(--topbar-height) + 24px);
    background: var(--panel-bg);
    border: 1px solid var(--border-soft);
    border-radius: var(--radius-card);
    padding: 22px 20px;
    box-shadow: var(--shadow-card);
  }
  .side-nav-title {
    font-family: var(--font-mono);
    font-size: 11px;
    letter-spacing: 1.6px;
    text-transform: uppercase;
    color: var(--text-soft);
    margin-bottom: 16px;
  }
  .side-nav a {
    display: flex;
    align-items: baseline;
    gap: 10px;
    padding: 10px 0;
    font-size: 13.5px;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border-soft);
  }
  .side-nav a:last-child { border-bottom: none; }
  .side-nav a .n {
    font-family: var(--font-mono);
    color: var(--pecatu-gold);
    font-size: 12px;
    font-weight: 600;
  }
  .side-nav a:hover { color: var(--pecatu-navy); }
  .side-nav-note {
    margin-top: 18px;
    padding-top: 16px;
    border-top: 1px dashed var(--border-soft);
    font-size: 12px;
    color: var(--text-soft);
  }

  .steps-col { display: flex; flex-direction: column; gap: 26px; }

  /* ---------- STEP CARD ---------- */
  .step-card {
    background: var(--panel-bg);
    border: 1px solid var(--border-soft);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-card);
    padding: 40px 44px;
    scroll-margin-top: calc(var(--topbar-height) + 20px);
  }
  .step-head { display: flex; gap: 20px; align-items: flex-start; margin-bottom: 18px; }
  .step-num {
    flex-shrink: 0;
    width: 54px; height: 54px;
    border-radius: 50%;
    background: linear-gradient(160deg, var(--pecatu-navy), var(--digital-blue));
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-display);
    color: var(--soft-gold);
    font-weight: 600;
    font-size: 20px;
    box-shadow: 0 6px 16px rgba(7,42,56,0.25);
  }
  .step-head h2 {
    font-family: var(--font-display);
    font-size: 27px;
    font-weight: 600;
    color: var(--pecatu-navy);
    margin-bottom: 6px;
  }
  .step-head .step-tag {
    font-family: var(--font-mono);
    font-size: 11px;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: var(--digital-blue);
  }
  .step-body p.lead {
    color: var(--text-muted);
    font-size: 15px;
    max-width: 640px;
    margin-bottom: 22px;
  }

  .flow-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 24px;
  }
  .flow-list li {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    font-size: 14px;
    color: var(--text-dark);
  }
  .flow-list li .bullet {
    flex-shrink: 0;
    width: 20px; height: 20px;
    border-radius: 6px;
    background: rgba(201,162,90,0.15);
    color: var(--pecatu-gold);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
    font-family: var(--font-mono);
    font-weight: 700;
    margin-top: 1px;
  }
  .flow-list li b { color: var(--pecatu-navy); }

  .callout {
    border-radius: var(--radius-input);
    padding: 16px 18px;
    font-size: 13.5px;
    display: flex;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 24px;
  }
  .callout .icon {
    flex-shrink: 0;
    width: 22px; height: 22px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    font-weight: 700;
    font-family: var(--font-mono);
  }
  .callout.warn {
    background: rgba(217,122,78,0.09);
    border: 1px solid rgba(217,122,78,0.28);
    color: #8a4a2c;
  }
  .callout.warn .icon { background: var(--warning); color: white; }
  .callout.info {
    background: rgba(37,99,235,0.07);
    border: 1px solid rgba(37,99,235,0.2);
    color: #1d4c8f;
  }
  .callout.info .icon { background: var(--info); color: white; }
  .callout.ok {
    background: rgba(22,163,74,0.08);
    border: 1px solid rgba(22,163,74,0.22);
    color: #14622f;
  }
  .callout.ok .icon { background: var(--success); color: white; }

  /* ---------- MOCKUP UI (recreations) ---------- */
  .mockup {
    background: var(--soft-bg);
    border: 1px solid var(--border-soft);
    border-radius: 18px;
    padding: 22px;
  }
  .mockup-label {
    font-family: var(--font-mono);
    font-size: 10.5px;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: var(--text-soft);
    margin-bottom: 12px;
  }
  .mock-modal {
    background: var(--white);
    border-radius: 16px;
    box-shadow: 0 14px 34px rgba(7,42,56,0.14);
    padding: 26px 28px;
    max-width: 560px;
    margin: 0 auto;
  }
  .mock-modal-head {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px;
  }
  .mock-modal-head h3 {
    font-family: var(--font-display);
    font-size: 19px;
    color: var(--pecatu-navy);
    font-weight: 600;
  }
  .mock-x { color: var(--text-soft); font-size: 16px; }
  .mock-field { margin-bottom: 18px; }
  .mock-field label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 7px;
  }
  .mock-field label .req { color: var(--danger); margin-left: 2px; }
  .mock-input {
    border: 1px solid var(--border-soft);
    border-radius: 10px;
    padding: 10px 13px;
    font-size: 13px;
    color: var(--text-dark);
    background: var(--panel-bg);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .mock-input.filled { color: var(--text-dark); font-weight: 500; }
  .mock-input .chev { color: var(--text-soft); font-size: 11px; }
  .mock-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .mock-row3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
  .mock-check-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    margin-top: 8px;
  }
  .mock-check {
    display: flex; align-items: center; gap: 8px;
    font-size: 12.5px;
    color: var(--text-dark);
  }
  .mock-check .box {
    width: 16px; height: 16px;
    border-radius: 4px;
    background: var(--pecatu-gold);
    color: white;
    font-size: 10px;
    display: flex; align-items: center; justify-content: center;
  }
  .mock-link {
    font-size: 12px;
    color: var(--warning);
    margin-bottom: 4px;
    display: inline-block;
  }
  .mock-sub-panel {
    border: 1px solid var(--border-soft);
    border-radius: 12px;
    padding: 16px;
    background: var(--soft-bg);
    margin-bottom: 18px;
  }
  .mock-sub-panel-head {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 14px;
    color: var(--text-soft);
    font-size: 13px;
  }
  .mock-btn-row { display: flex; gap: 10px; margin-top: 6px; }
  .mock-btn {
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
  }
  .mock-btn.primary { background: var(--pecatu-gold); color: var(--pecatu-navy); }
  .mock-btn.ghost { background: var(--white); border: 1px solid var(--border-soft); color: var(--text-muted); }

  /* mini table for context */
  .mock-context-strip {
    display: flex;
    justify-content: space-between;
    font-family: var(--font-mono);
    font-size: 10.5px;
    color: var(--text-soft);
    background: var(--pecatu-navy);
    color: white;
    padding: 8px 14px;
    border-radius: 8px 8px 0 0;
    max-width: 560px;
    margin: 0 auto;
    opacity: .85;
  }

  /* three-phase cards for step 5 */
  .phase-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-top: 6px;
  }
  .phase-card {
    background: var(--soft-bg);
    border: 1px solid var(--border-soft);
    border-radius: 16px;
    padding: 20px;
    position: relative;
  }
  .phase-card .phase-tag {
    font-family: var(--font-mono);
    font-size: 10.5px;
    color: var(--pecatu-gold);
    letter-spacing: 1px;
    margin-bottom: 8px;
  }
  .phase-card h4 {
    font-family: var(--font-display);
    font-size: 16.5px;
    color: var(--pecatu-navy);
    margin-bottom: 8px;
    font-weight: 600;
  }
  .phase-card p { font-size: 12.5px; color: var(--text-muted); margin-bottom: 12px; }
  .phase-card ul { list-style: none; display: flex; flex-direction: column; gap: 6px; }
  .phase-card ul li {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--digital-blue);
    background: rgba(20,83,106,0.06);
    border-radius: 6px;
    padding: 5px 9px;
  }
  .phase-arrow {
    display: none;
  }
  @media (min-width: 900px) {
    .phase-grid { position: relative; }
    .phase-card:not(:last-child)::after {
      content: "→";
      position: absolute;
      right: -16px; top: 50%;
      transform: translateY(-50%);
      color: var(--pecatu-gold);
      font-size: 16px;
      z-index: 2;
    }
  }

  /* footer */
  .site-footer {
    border-top: 1px solid var(--border-soft);
    padding: 40px 0 60px;
    text-align: center;
  }
  .site-footer p { font-size: 12.5px; color: var(--text-soft); }
  .site-footer .seal-mini {
    width: 34px; height: 34px;
    border-radius: 50%;
    border: 1px solid var(--pecatu-gold);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    font-family: var(--font-display);
    font-size: 12px;
    color: var(--pecatu-gold);
  }

  @media (max-width: 980px) {
    .content-area { grid-template-columns: 1fr; }
    .side-nav { position: static; }
    .hero-grid { grid-template-columns: 1fr; }
    .hero-emblem { max-width: 260px; margin: 0 auto; }
    .stepper-track { grid-template-columns: repeat(3, 1fr); row-gap: 26px; }
    .stepper-track::before { display: none; }
    .topnav { display: none; }
    .phase-grid { grid-template-columns: 1fr; }
  }
  @media (max-width: 640px) {
    .wrap { padding: 0 18px; }
    h1.hero-title { font-size: 34px; }
    .step-card { padding: 28px 22px; }
    .mock-row, .mock-row3 { grid-template-columns: 1fr; }
    .stepper-track { grid-template-columns: repeat(2, 1fr); }
  }
</style>