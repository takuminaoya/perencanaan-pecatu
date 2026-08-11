<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>
    <!-- ============ BANNER ============ -->
    <section class="profile-banner">
        <div class="container profile-banner-inner">
            <span class="eyebrow" style="color: var(--soft-gold)">Profil Desa</span>
            <h1>Mengenal Desa Pecatu &amp; layanan usulan warganya</h1>
            <p>
                Desa Pecatu terletak di ujung selatan Bali, dikenal dengan kawasan
                pesisir Uluwatu dan tradisi adatnya yang kuat. Platform ini hadir agar
                setiap usulan masyarakat tercatat, terverifikasi, dan terpantau secara
                transparan.
            </p>
        </div>
        <svg class="gate-divider" viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60 L0 30 Q720 0 1440 30 L1440 60 Z" fill="#F5F7FB" />
        </svg>
    </section>

    <!-- ============ VISI MISI ============ -->
    <section class="section">
        <div class="container">
            <div class="grid-2" style="gap: 32px">
                <div class="card">
                    <span class="eyebrow">Visi</span>
                    <h3 style="margin-top: 12px; font-size: 19px">
                        Desa yang mandiri, transparan, dan responsif
                    </h3>
                    <p
                        style="
                color: var(--text-muted);
                margin-top: 12px;
                font-size: 14.5px;
              ">
                        Mewujudkan Desa Pecatu sebagai desa wisata adat yang mandiri
                        secara ekonomi, dengan tata kelola pemerintahan yang transparan
                        dan responsif terhadap aspirasi masyarakat.
                    </p>
                </div>
                <div class="card">
                    <span class="eyebrow">Misi</span>
                    <h3 style="margin-top: 12px; font-size: 19px">
                        Tiga arah pelayanan
                    </h3>
                    <p
                        style="
                color: var(--text-muted);
                margin-top: 12px;
                font-size: 14.5px;
              ">
                        Mendigitalkan layanan usulan masyarakat, mempercepat respons
                        perangkat desa, dan menjaga akuntabilitas penggunaan anggaran
                        pembangunan melalui pelacakan usulan yang terbuka.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ NILAI ============ -->
    <section class="section section-alt">
        <div class="container">
            <div class="section-head center">
                <span class="eyebrow">Nilai Layanan</span>
                <h2>Prinsip yang kami pegang dalam setiap usulan</h2>
            </div>

            <div class="value-grid">
                <div class="value-item">
                    <div class="v-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L4 6V12C4 17 7.5 20.5 12 22C16.5 20.5 20 17 20 12V6L12 2Z" stroke="#D6A100"
                                stroke-width="1.8" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h4>Transparan</h4>
                    <p>Status usulan dapat dipantau setiap saat oleh pengusul.</p>
                </div>
                <div class="value-item">
                    <div class="v-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M9 11L12 14L21 5" stroke="#D6A100" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M21 12V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H16"
                                stroke="#D6A100" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h4>Akuntabel</h4>
                    <p>Setiap keputusan tercatat dan dapat dipertanggungjawabkan.</p>
                </div>
                <div class="value-item">
                    <div class="v-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 21C12 21 5 15.5 5 10.5C5 7 7.5 4.5 11 4.5C12.2 4.5 13.3 5 14 5.8"
                                stroke="#D6A100" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M12 21C12 21 19 15.5 19 10.5C19 7 16.5 4.5 13 4.5C12.7 4.5 12.4 4.5 12 4.6"
                                stroke="#D6A100" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h4>Berpihak pada Warga</h4>
                    <p>
                        Proses dirancang sederhana untuk segala usia dan latar belakang.
                    </p>
                </div>
                <div class="value-item">
                    <div class="v-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="9" stroke="#D6A100" stroke-width="1.8" />
                            <path d="M12 7V12L15 14" stroke="#D6A100" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h4>Responsif</h4>
                    <p>Verifikasi dan tindak lanjut usulan dilakukan secara berkala.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PERJALANAN ============ -->
    <section class="section">
        <div class="container">
            <div class="section-head">
                <span class="eyebrow">Perjalanan Layanan</span>
                <h2>Dari musyawarah banjar ke sistem digital</h2>
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <span class="yr">Sebelum 2020</span>
                    <h4>Usulan Lisan Melalui Musyawarah Banjar</h4>
                    <p>
                        Usulan masyarakat disampaikan secara lisan dalam pertemuan banjar
                        dan dicatat manual oleh kelian adat.
                    </p>
                </div>
                <div class="timeline-item">
                    <span class="yr">2021</span>
                    <h4>Formulir Usulan Tertulis</h4>
                    <p>
                        Desa memperkenalkan formulir usulan tertulis yang diserahkan
                        langsung ke kantor desa untuk diarsipkan.
                    </p>
                </div>
                <div class="timeline-item">
                    <span class="yr">2023</span>
                    <h4>Digitalisasi Arsip Usulan</h4>
                    <p>
                        Arsip usulan mulai dipindahkan ke sistem pencatatan digital
                        internal untuk mempermudah pelaporan.
                    </p>
                </div>
                <div class="timeline-item">
                    <span class="yr">2026</span>
                    <h4>Peluncuran Usulan Elektronik Pecatu</h4>
                    <p>
                        Warga kini dapat mendaftar, mengajukan, dan memantau status usulan
                        secara mandiri melalui platform ini.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ STRUKTUR PERANGKAT ============ -->
    <section class="section section-alt">
        <div class="container">
            <div class="section-head center">
                <span class="eyebrow">Perangkat Desa</span>
                <h2>Tim yang memverifikasi usulan Anda</h2>
                <p>
                    Setiap usulan diperiksa oleh perangkat desa terkait sebelum
                    dijadwalkan dalam musyawarah perencanaan.
                </p>
            </div>

            <div class="staff-grid">
                <div class="staff-card">
                    <div class="staff-avatar">IW</div>
                    <h4>I Wayan Sutarja</h4>
                    <div class="role">Kepala Desa</div>
                </div>
                <div class="staff-card">
                    <div class="staff-avatar">NK</div>
                    <h4>Ni Kadek Ariani</h4>
                    <div class="role">Sekretaris Desa</div>
                </div>
                <div class="staff-card">
                    <div class="staff-avatar">IM</div>
                    <h4>I Made Suardika</h4>
                    <div class="role">Kaur Perencanaan</div>
                </div>
                <div class="staff-card">
                    <div class="staff-avatar">NL</div>
                    <h4>Ni Luh Astini</h4>
                    <div class="role">Kaur Pelayanan Warga</div>
                </div>
            </div>
        </div>
    </section>
</div>
