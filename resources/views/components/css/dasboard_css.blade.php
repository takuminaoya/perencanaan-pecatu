    <style>
      h1,
      h2,
      h3,
      .brand-title {
        font-family: "Poppins", sans-serif;
      }

      .page-wrap {

      }

      /* ===== Header band: brand strip ===== */
      .header-band {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
        flex-wrap: wrap;
        gap: 12px;
      }

      .brand-mark {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .brand-mark .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: linear-gradient(
          135deg,
          var(--pecatu-gold),
          var(--soft-gold)
        );
        box-shadow: 0 0 0 5px rgba(214, 161, 0, 0.14);
      }

      .brand-title {
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--pecatu-navy);
      }

      .brand-title span {
        color: var(--digital-blue);
      }

      .breadcrumb-tag {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-muted);
        background: var(--white);
        border: 1px solid var(--border-soft);
        padding: 7px 14px;
        border-radius: 999px;
      }

      /* ===== Top row: profile + system info ===== */
      .top-row {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
      }

      .panel {
        background: var(--white);
        border-radius: var(--radius-card);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-card);
        padding: 26px 28px;
      }

      /* --- Profile panel --- */
      .profile-panel {
        background: linear-gradient(
          120deg,
          var(--pecatu-navy) 0%,
          var(--deep-blue) 55%,
          var(--digital-blue) 130%
        );
        color: var(--white);
        display: flex;
        align-items: center;
        gap: 22px;
        position: relative;
        overflow: hidden;
      }

      .profile-panel::after {
        content: "";
        position: absolute;
        right: -60px;
        top: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(
          circle,
          rgba(214, 161, 0, 0.25),
          transparent 70%
        );
      }

      .profile-photo {
        width: 84px;
        height: 84px;
        border-radius: 20px;
        flex-shrink: 0;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.25);
        background: linear-gradient(
          135deg,
          var(--emblem-blue),
          var(--soft-gold)
        );
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Poppins", sans-serif;
        font-weight: 700;
        font-size: 30px;
        color: var(--pecatu-navy);
        position: relative;
        z-index: 1;
      }

      .profile-info {
        position: relative;
        z-index: 1;
      }

      .profile-info .name {
        font-family: "Poppins", sans-serif;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
      }

      .profile-info .role {
        font-size: 13.5px;
        color: var(--soft-gold);
        font-weight: 600;
        margin-bottom: 10px;
      }

      .profile-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 20px;
        font-size: 12.5px;
        color: rgba(255, 255, 255, 0.82);
      }

      .profile-meta div span {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: rgba(255, 255, 255, 0.55);
        margin-bottom: 2px;
      }

      /* --- System info panel --- */
      .system-panel {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 14px;
      }

      .system-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 12px;
        border-bottom: 1px dashed var(--border-soft);
      }

      .system-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
      }

      .system-row .label {
        font-size: 12px;
        color: var(--text-soft);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 700;
      }

      .system-row .value {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--text-dark);
        text-align: right;
      }

      .system-row .value.datetime {
        font-size: 15px;
        color: var(--deep-blue);
      }

      .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        background: rgba(22, 163, 74, 0.1);
        color: var(--success);
      }

      .status-chip::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--success);
      }

      .version-tag {
        background: var(--panel-bg);
        border: 1px solid var(--border-soft);
        color: var(--digital-blue);
        padding: 4px 10px;
        border-radius: 8px;
        font-family: "Manrope", monospace;
        font-size: 12.5px;
        font-weight: 700;
      }

      /* ===== Pill / stat row ===== */
      .section-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-soft);
        margin: 6px 0 12px 4px;
      }

      .pill-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 26px;
      }

      .pill-card {
        background: var(--white);
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-card);
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        overflow: hidden;
        transition: transform 0.15s ease;
      }

      .pill-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
      }

      .pill-card.progress::before {
        background: var(--info);
      }
      .pill-card.musrenbang::before {
        background: var(--pecatu-gold);
      }
      .pill-card.realisasi::before {
        background: var(--digital-blue);
      }
      .pill-card.selesai::before {
        background: var(--success);
      }

      .pill-icon {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 22px;
      }

      .pill-card.progress .pill-icon {
        background: rgba(37, 99, 235, 0.1);
        color: var(--info);
      }
      .pill-card.musrenbang .pill-icon {
        background: rgba(214, 161, 0, 0.12);
        color: var(--pecatu-gold);
      }
      .pill-card.realisasi .pill-icon {
        background: rgba(11, 95, 234, 0.1);
        color: var(--digital-blue);
      }
      .pill-card.selesai .pill-icon {
        background: rgba(22, 163, 74, 0.1);
        color: var(--success);
      }

      .pill-text .count {
        font-family: "Poppins", sans-serif;
        font-size: 26px;
        font-weight: 800;
        line-height: 1.1;
        color: var(--text-dark);
      }

      .pill-text .label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-muted);
        margin-top: 2px;
      }

      /* ===== Empty card box for table ===== */
      .table-card {
        background: var(--white);
        border: 1px solid var(--border-soft);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-soft);
        min-height: 420px;
        display: flex;
        flex-direction: column;
      }

      .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 22px 26px;
        border-bottom: 1px solid var(--border-soft);
      }

      .table-card-header h2 {
        font-size: 17px;
        color: var(--pecatu-navy);
        font-weight: 700;
      }

      .table-card-header .hint {
        font-size: 12.5px;
        color: var(--text-soft);
        font-weight: 600;
      }

      .table-card-body {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
      }

      .table-placeholder {
        text-align: center;
        color: var(--text-soft);
      }

      .table-placeholder .icon-box {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        border-radius: 18px;
        border: 2px dashed var(--border-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: var(--emblem-blue);
      }

      .table-placeholder p {
        font-size: 13.5px;
        font-weight: 600;
      }

      .table-placeholder p.sub {
        font-size: 12px;
        color: var(--text-soft);
        font-weight: 500;
        margin-top: 4px;
      }

      @media (max-width: 900px) {
        .top-row {
          grid-template-columns: 1fr;
        }
        .pill-row {
          grid-template-columns: repeat(2, 1fr);
        }
      }

      @media (max-width: 520px) {
        .pill-row {
          grid-template-columns: 1fr;
        }
        .profile-panel {
          flex-direction: column;
          text-align: center;
        }
        .profile-meta {
          justify-content: center;
        }
      }
    </style>