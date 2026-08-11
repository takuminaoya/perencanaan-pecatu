<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>
    <!-- ============ HERO ============ -->
    <section class="hero">
        <div class="container hero-inner">
            <div>
                <span class="eyebrow">Sistem Usulan Digital Desa</span>
                <h1>
                    Sampaikan usulan pembangunan <em>tanpa harus ke kantor desa</em>
                </h1>
                <p class="lead">
                    Usulan Elektronik Masyarakat Desa Pecatu memudahkan warga Banjar dan
                    Desa Adat Pecatu untuk mengajukan usulan infrastruktur, sosial, dan
                    ekonomi secara daring — terpantau dari pengajuan hingga realisasi.
                </p>
                <div class="hero-actions">
                    <a href="/regis" class="btn btn-gold">Daftar sebagai Warga</a>
                    <a href="/tentang" class="btn btn-outline"
                        style="border-color: rgba(255, 255, 255, 0.25); color: #fff">Pelajari Layanan</a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <div class="num">5</div>
                        <div class="lbl">Banjar Adat Terhubung</div>
                    </div>
                    <div class="stat">
                        <div class="num">24/7</div>
                        <div class="lbl">Pengajuan Daring</div>
                    </div>
                    <div class="stat">
                        <div class="num">100%</div>
                        <div class="lbl">Transparan &amp; Terlacak</div>
                    </div>
                </div>
            </div>

            <div class="hero-art">
                <div class="hero-gate-wrap">
                    <svg viewBox="0 0 420 420" xmlns="http://www.w3.org/2000/svg">
                        <!-- Candi Bentar (split gate) silhouette, signature motif -->
                        <defs>
                            <linearGradient id="gateGold" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#F3C542" />
                                <stop offset="100%" stop-color="#D6A100" />
                            </linearGradient>
                        </defs>
                        <g opacity="0.95">
                            <!-- left tower -->
                            <path d="M40 360 L40 200 L60 150 L80 200 L80 360 Z" fill="url(#gateGold)" />
                            <path d="M30 360 L90 360 L90 375 L30 375 Z" fill="#0B5FEA" opacity="0.85" />
                            <path d="M48 200 H72 M44 230 H76 M42 270 H78" stroke="#061B4E" stroke-width="2"
                                opacity="0.4" />
                            <path d="M60 150 L52 165 H68 Z" fill="#061B4E" />
                            <!-- right tower (mirrored) -->
                            <path d="M380 360 L380 200 L360 150 L340 200 L340 360 Z" fill="url(#gateGold)" />
                            <path d="M330 360 L390 360 L390 375 L330 375 Z" fill="#0B5FEA" opacity="0.85" />
                            <path d="M348 200 H372 M344 230 H376 M342 270 H378" stroke="#061B4E" stroke-width="2"
                                opacity="0.4" />
                            <path d="M360 150 L352 165 H368 Z" fill="#061B4E" />
                            <!-- center sun emblem -->
                            <circle cx="210" cy="120" r="34" fill="none" stroke="#F3C542"
                                stroke-width="3" />
                            <circle cx="210" cy="120" r="8" fill="#F3C542" />
                            <g stroke="#F3C542" stroke-width="2.5" stroke-linecap="round">
                                <line x1="210" y1="70" x2="210" y2="82" />
                                <line x1="210" y1="158" x2="210" y2="170" />
                                <line x1="160" y1="120" x2="172" y2="120" />
                                <line x1="248" y1="120" x2="260" y2="120" />
                                <line x1="176" y1="86" x2="184" y2="94" />
                                <line x1="236" y1="146" x2="244" y2="154" />
                                <line x1="244" y1="86" x2="236" y2="94" />
                                <line x1="184" y1="146" x2="176" y2="154" />
                            </g>
                            <!-- ground line -->
                            <path d="M10 375 H410" stroke="#69A8D8" stroke-width="2" opacity="0.5" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        <svg class="gate-divider" viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60 L0 30 Q720 0 1440 30 L1440 60 Z" fill="#F5F7FB" />
        </svg>
    </section>

    <!-- ============ LAYANAN / FEATURES ============ -->
    <section class="section" id="layanan">
        <div class="container">
            <div class="section-head center">
                <span class="eyebrow">Layanan Utama</span>
                <h2>Satu pintu untuk semua usulan masyarakat</h2>
                <p>
                    Dari jalan lingkungan, irigasi subak, hingga bantuan UMKM — setiap
                    usulan tercatat rapi dan dapat dipantau statusnya oleh pengusul.
                </p>
            </div>

            <div class="grid-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19V9L12 3L20 9V19" stroke="#F3C542" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M9 19V13H15V19" stroke="#F3C542" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Usulan Infrastruktur</h3>
                    <p>
                        Ajukan kebutuhan jalan, jembatan, drainase, dan penerangan
                        lingkungan banjar secara terperinci dengan lokasi dan foto
                        kondisi.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 21C12 21 5 15.5 5 10.5C5 7 7.5 4.5 11 4.5C12.2 4.5 13.3 5 14 5.8"
                                stroke="#F3C542" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M12 21C12 21 19 15.5 19 10.5C19 7 16.5 4.5 13 4.5C12.7 4.5 12.4 4.5 12 4.6"
                                stroke="#F3C542" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3>Usulan Sosial &amp; Kesehatan</h3>
                    <p>
                        Sampaikan kebutuhan posyandu, bantuan lansia, atau kegiatan adat
                        dan keagamaan yang memerlukan dukungan desa.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 12H21" stroke="#F3C542" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M7 12C7 8 9 5 12 5C15 5 17 8 17 12C17 16 15 19 12 19C9 19 7 16 7 12Z"
                                stroke="#F3C542" stroke-width="1.8" />
                        </svg>
                    </div>
                    <h3>Usulan Ekonomi &amp; UMKM</h3>
                    <p>
                        Daftarkan kebutuhan modal usaha, pelatihan keterampilan, dan
                        dukungan pemasaran produk lokal Pecatu.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 11L12 14L21 5" stroke="#F3C542" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M21 12V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H16"
                                stroke="#F3C542" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3>Pelacakan Status</h3>
                    <p>
                        Setiap usulan memiliki nomor tiket, dapat dipantau mulai dari
                        diajukan, diverifikasi, dijadwalkan, hingga direalisasikan.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="4" width="16" height="16" rx="3" stroke="#F3C542"
                                stroke-width="1.8" />
                            <path d="M8 9H16M8 13H16M8 17H12" stroke="#F3C542" stroke-width="1.8"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3>Riwayat &amp; Dokumentasi</h3>
                    <p>
                        Seluruh usulan yang pernah diajukan tersimpan rapi dalam riwayat
                        akun, lengkap dengan lampiran dan catatan petugas.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L4 6V12C4 17 7.5 20.5 12 22C16.5 20.5 20 17 20 12V6L12 2Z" stroke="#F3C542"
                                stroke-width="1.8" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Data Terlindungi</h3>
                    <p>
                        Data kependudukan dan usulan warga dikelola dengan akses terbatas
                        hanya untuk perangkat desa yang berwenang.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PROSES ============ -->
    <section class="section section-alt">
        <div class="container">
            <div class="grid-2" style="align-items: center; gap: 56px">
                <div>
                    <span class="eyebrow">Cara Kerja</span>
                    <h2 style="font-size: 30px; margin-top: 14px">
                        Empat langkah dari usulan menjadi kenyataan
                    </h2>
                    <p
                        style="
                color: var(--text-muted);
                margin-top: 14px;
                font-size: 15px;
              ">
                        Proses dirancang sesederhana mungkin agar warga dari segala usia
                        dapat mengajukan usulan tanpa kebingungan.
                    </p>

                    <div style="margin-top: 32px; display: flex; flex-direction: column">
                        <div class="step-row">
                            <div
                                style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                  ">
                                <div class="step-num">1</div>
                                <div class="step-line"></div>
                            </div>
                            <div style="padding-bottom: 22px">
                                <h4>Daftar &amp; Verifikasi Data</h4>
                                <p>
                                    Buat akun menggunakan NIK dan data kependudukan yang
                                    terdaftar di Desa Pecatu.
                                </p>
                            </div>
                        </div>
                        <div class="step-row">
                            <div
                                style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                  ">
                                <div class="step-num">2</div>
                                <div class="step-line"></div>
                            </div>
                            <div style="padding-bottom: 22px">
                                <h4>Ajukan Usulan</h4>
                                <p>
                                    Isi formulir usulan lengkap dengan kategori, lokasi,
                                    deskripsi, dan lampiran pendukung.
                                </p>
                            </div>
                        </div>
                        <div class="step-row">
                            <div
                                style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                  ">
                                <div class="step-num">3</div>
                                <div class="step-line"></div>
                            </div>
                            <div style="padding-bottom: 22px">
                                <h4>Verifikasi Perangkat Desa</h4>
                                <p>
                                    Tim desa meninjau kelayakan usulan dan menjadwalkannya dalam
                                    musyawarah atau anggaran.
                                </p>
                            </div>
                        </div>
                        <div class="step-row">
                            <div class="step-num">4</div>
                            <div>
                                <h4>Realisasi &amp; Laporan</h4>
                                <p>
                                    Status diperbarui hingga usulan terealisasi, disertai
                                    laporan dan dokumentasi akhir.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="background: var(--pecatu-navy); border: none">
                    <span class="eyebrow" style="color: var(--soft-gold)">Contoh Tiket Usulan</span>
                    <h3 style="color: #fff; margin-top: 12px; font-size: 19px">
                        Perbaikan Jalan Lingkungan Banjar Tengah
                    </h3>
                    <p
                        style="
                color: rgba(255, 255, 255, 0.6);
                font-size: 13.5px;
                margin-top: 8px;
              ">
                        No. Tiket: PCT-2026-00142
                    </p>

                    <div
                        style="
                margin-top: 22px;
                display: flex;
                flex-direction: column;
                gap: 14px;
              ">
                        <div
                            style="
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                  padding-bottom: 12px;
                  border-bottom: 1px solid rgba(255, 255, 255, 0.12);
                ">
                            <span style="color: rgba(255, 255, 255, 0.6); font-size: 13px">Diajukan</span>
                            <span
                                style="
                    color: var(--soft-gold);
                    font-size: 13px;
                    font-weight: 700;
                  ">✓
                                Selesai</span>
                        </div>
                        <div
                            style="
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                  padding-bottom: 12px;
                  border-bottom: 1px solid rgba(255, 255, 255, 0.12);
                ">
                            <span style="color: rgba(255, 255, 255, 0.6); font-size: 13px">Verifikasi Desa</span>
                            <span
                                style="
                    color: var(--soft-gold);
                    font-size: 13px;
                    font-weight: 700;
                  ">✓
                                Selesai</span>
                        </div>
                        <div
                            style="
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                  padding-bottom: 12px;
                  border-bottom: 1px solid rgba(255, 255, 255, 0.12);
                ">
                            <span style="color: rgba(255, 255, 255, 0.6); font-size: 13px">Dijadwalkan
                                Musrenbang</span>
                            <span style="color: #fff; font-size: 13px; font-weight: 700">Berjalan</span>
                        </div>
                        <div
                            style="
                  display: flex;
                  justify-content: space-between;
                  align-items: center;
                ">
                            <span style="color: rgba(255, 255, 255, 0.35); font-size: 13px">Realisasi</span>
                            <span
                                style="
                    color: rgba(255, 255, 255, 0.35);
                    font-size: 13px;
                    font-weight: 700;
                  ">Menunggu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="section">
        <div class="container">
            <div class="card center"
                style="
            max-width: 760px;
            padding: 56px 48px;
            background: linear-gradient(135deg, var(--panel-bg), var(--white));
          ">
                <span class="eyebrow center">Bergabung Sekarang</span>
                <h2 style="margin-top: 14px; font-size: 28px">
                    Suara Anda menentukan arah pembangunan Pecatu
                </h2>
                <p style="color: var(--text-muted); margin-top: 14px; font-size: 15px">
                    Daftar sebagai warga untuk mulai mengajukan usulan, atau hubungi
                    kami bila memerlukan bantuan pendaftaran.
                </p>
                <div
                    style="
              display: flex;
              gap: 14px;
              justify-content: center;
              margin-top: 26px;
              flex-wrap: wrap;
            ">
                    <a href="/regis" class="btn btn-primary">Daftar Akun Warga</a>
                    <a href="/kontak" class="btn btn-outline">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>
</div>
