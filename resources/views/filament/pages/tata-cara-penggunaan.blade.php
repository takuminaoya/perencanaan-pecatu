<x-filament-panels::page>
    <x-css.tatacara />

    <header class="hero">
        <div class="wrap hero-grid">
            <div>
                <div class="eyebrow">Tata Cara Penggunaan Sistem</div>
                <h1 class="hero-title">Dari anggaran <em>dituliskan</em>,<br>menjadi anggaran <em>dijalankan</em>.</h1>
                <p class="hero-desc">
                    Panduan ini menuntun perangkat desa melalui alur resmi pengelolaan APBDes &mdash;
                    mulai dari pembuatan dokumen anggaran, penginputan detail dan rincian pendapatan,
                    hingga penyusunan Rencana Anggaran Biaya (RAB) yang mengacu pada APBDes yang sudah dibuat.
                </p>
                <div class="hero-meta">
                    <div>
                        <div class="num">5</div>
                        <div class="lbl">Tahap alur utama</div>
                    </div>
                    <div>
                        <div class="num">2</div>
                        <div class="lbl">Dokumen inti: APBDes &amp; RAB</div>
                    </div>
                    <div>
                        <div class="num">3</div>
                        <div class="lbl">Lapis penginputan RAB</div>
                    </div>
                </div>
            </div>
            <div class="hero-emblem">
                <div class="orbit-dot d1"></div>
                <div class="orbit-dot d2"></div>
                <div class="orbit-dot d3"></div>
                <div class="hero-emblem-core">
                    <div class="en">Panduan Resmi</div>
                    <div class="word">APBDes</div>
                    <div class="sub">&amp; Rencana Anggaran Biaya</div>
                </div>
            </div>
        </div>
    </header>

    <section class="stepper-strip">
        <div class="wrap">
            <div class="stepper-track">
                <a class="step-node" href="#step-1">
                    <div class="dot">01</div>
                    <div class="label">Buat APBDes</div>
                    <div class="sub">Judul, tahun, jenis</div>
                </a>
                <a class="step-node" href="#step-2">
                    <div class="dot">02</div>
                    <div class="label">Tambah Detail</div>
                    <div class="sub">Rangkuman pendapatan</div>
                </a>
                <a class="step-node" href="#step-3">
                    <div class="dot">03</div>
                    <div class="label">Tambah Rincian</div>
                    <div class="sub">Nilai semula &amp; menjadi</div>
                </a>
                <a class="step-node" href="#step-4">
                    <div class="dot">04</div>
                    <div class="label">Buat RAB</div>
                    <div class="sub">Mengacu pada APBDes</div>
                </a>
                <a class="step-node" href="#step-5">
                    <div class="dot">05</div>
                    <div class="label">Detail RAB</div>
                    <div class="sub">Bidang, uraian, detail</div>
                </a>
            </div>
        </div>
    </section>

    <main class="wrap content-area">

        <aside class="side-nav">
            <div class="side-nav-title">Daftar Isi</div>
            <a href="#step-1"><span class="n">01</span> Membuat APBDes</a>
            <a href="#step-2"><span class="n">02</span> Menambah Detail</a>
            <a href="#step-3"><span class="n">03</span> Menambah Rincian</a>
            <a href="#step-4"><span class="n">04</span> Membuat RAB</a>
            <a href="#step-5"><span class="n">05</span> Detail RAB</a>
            <div class="side-nav-note">
                Ikuti tahap secara berurutan &mdash; setiap tahap menjadi syarat bagi tahap berikutnya.
            </div>
        </aside>

        <div class="steps-col">

            <!-- STEP 1 -->
            <section class="step-card" id="step-1">
                <div class="step-head">
                    <div class="step-num">01</div>
                    <div>
                        <div class="step-tag">Tahap Awal</div>
                        <h2>Membuat APBDes</h2>
                    </div>
                </div>
                <div class="step-body">
                    <p class="lead">
                        Alur pertama dari seluruh proses adalah membuat dokumen APBDes. Sebelum masuk ke halaman
                        detail, lengkapi terlebih dahulu data pokoknya: judul, tahun anggaran, dan jenis APBDes.
                    </p>
                    <ul class="flow-list">
                        <li><span class="bullet">1</span> Buka menu <b>Anggaran Pendapatan dan Belanja Desa</b>, lalu
                            pilih <b>Buat</b>.</li>
                        <li><span class="bullet">2</span> Isi <b>Judul</b> APBDes agar mudah dikenali, misalnya sesuai
                            tahun anggaran berjalan.</li>
                        <li><span class="bullet">3</span> Tentukan <b>Tahun</b> anggaran dan <b>Jenis</b> APBDes yang
                            akan dibuat.</li>
                        <li><span class="bullet">4</span> Simpan dokumen &mdash; sistem akan mengarahkan ke halaman
                            detail APBDes.</li>
                    </ul>

                    <div class="mockup">
                        <div class="mockup-label">Ilustrasi &mdash; Formulir Pembuatan APBDes</div>
                        <div class="mock-context-strip"><span>Anggaran Pendapatan dan Belanja
                                Desa</span><span>Buat</span></div>
                        <div class="mock-modal" style="border-radius: 0 0 16px 16px;">
                            <div class="mock-modal-head">
                                <h3>Buat Anggaran Pendapatan dan Belanja Desa</h3>
                            </div>
                            <div class="mock-row" style="margin-bottom:18px;">
                                <div class="mock-field" style="margin-bottom:0;">
                                    <label>Judul<span class="req">*</span></label>
                                    <div class="mock-input filled">APBDes Tahun Anggaran 2026</div>
                                </div>
                                <div class="mock-field" style="margin-bottom:0;">
                                    <label>Tahun<span class="req">*</span></label>
                                    <div class="mock-input filled">2026</div>
                                </div>
                            </div>
                            <div class="mock-field">
                                <label>Jenis</label>
                                <div class="mock-input filled">APBDes Murni</div>
                            </div>
                            <div class="mock-btn-row">
                                <div class="mock-btn primary">Buat</div>
                                <div class="mock-btn ghost">Buat &amp; buat lainnya</div>
                                <div class="mock-btn ghost">Batal</div>
                            </div>
                        </div>
                    </div>

                    <div class="callout info" style="margin-top:24px; margin-bottom:0;">
                        <div class="icon">i</div>
                        <div>Data judul, tahun, dan jenis inilah yang nantinya menjadi acuan saat menghubungkan RAB pada
                            tahap 4, jadi pastikan tahun anggaran diisi dengan benar.</div>
                    </div>
                </div>
            </section>

            <!-- STEP 2 -->
            <section class="step-card" id="step-2">
                <div class="step-head">
                    <div class="step-num">02</div>
                    <div>
                        <div class="step-tag">Halaman Detail APBDes</div>
                        <h2>Menambah Detail</h2>
                    </div>
                </div>
                <div class="step-body">
                    <p class="lead">
                        Setelah APBDes tersimpan, sistem membawa perangkat desa masuk ke halaman detail. Langkah
                        berikutnya adalah menambah <b>Detail</b>, yaitu rangkuman kelompok pendapatan sebelum
                        rinciannya diinput satu per satu.
                    </p>
                    <ul class="flow-list">
                        <li><span class="bullet">1</span> Klik tombol <b>Tambah Detail</b> &mdash; tersedia di pojok
                            kanan bawah maupun di bagian atas halaman.</li>
                        <li><span class="bullet">2</span> Pilih <b>Daftar Kas Utama</b>, misalnya <b>Pendapatan</b>.
                        </li>
                        <li><span class="bullet">3</span> Centang <b>Daftar Sub Utama</b> yang sesuai: Pendapatan Asli
                            Desa, Pendapatan Transfer, dan/atau Pendapatan Lain-lain.</li>
                        <li><span class="bullet">4</span> Klik <b>Kirim</b> untuk menyimpan. Detail ini menjadi
                            rangkuman &mdash; belum berisi nilai anggaran.</li>
                    </ul>

                    <div class="mockup">
                        <div class="mockup-label">Ilustrasi &mdash; Modal Tambah Detail</div>
                        <div class="mock-modal">
                            <div class="mock-modal-head">
                                <h3>Tambah Detail</h3>
                                <span class="mock-x">&times;</span>
                            </div>
                            <div class="mock-field">
                                <label>Daftar Kas Utama<span class="req">*</span></label>
                                <div class="mock-input filled">PENDAPATAN <span class="chev">▾</span></div>
                            </div>
                            <div class="mock-field" style="margin-bottom:10px;">
                                <label>Daftar Sub Utama<span class="req">*</span></label>
                                <span class="mock-link">Batalkan semua pilihan</span>
                                <div class="mock-check-grid">
                                    <div class="mock-check"><span class="box">✓</span> Pendapatan Asli Desa</div>
                                    <div class="mock-check"><span class="box">✓</span> Pendapatan Transfer</div>
                                    <div class="mock-check"><span class="box">✓</span> Pendapatan Lain-lain</div>
                                </div>
                            </div>
                            <div class="mock-btn-row" style="margin-top:14px;">
                                <div class="mock-btn primary">Kirim</div>
                                <div class="mock-btn ghost">Batal</div>
                            </div>
                        </div>
                    </div>

                    <div class="callout ok" style="margin-top:24px; margin-bottom:0;">
                        <div class="icon">✓</div>
                        <div>Setelah detail berhasil dikirim, kelompok pendapatan akan muncul di ringkasan APBDes dan
                            siap dilanjutkan ke penginputan rincian pada tahap berikutnya.</div>
                    </div>
                </div>
            </section>

            <!-- STEP 3 -->
            <section class="step-card" id="step-3">
                <div class="step-head">
                    <div class="step-num">03</div>
                    <div>
                        <div class="step-tag">Halaman Detail APBDes</div>
                        <h2>Menambah Rincian</h2>
                    </div>
                </div>
                <div class="step-body">
                    <p class="lead">
                        Rincian adalah nilai anggaran sesungguhnya di bawah setiap sub utama yang sudah dipilih pada
                        tahap Detail. Tombol berada di posisi yang sama seperti sebelumnya, namun labelnya berubah
                        menjadi <b>Tambah Rincian</b>.
                    </p>

                    <div class="callout warn">
                        <div class="icon">!</div>
                        <div><b>Rincian tidak dapat diinputkan selama Detail masih kosong.</b> Pastikan tahap 2 (Tambah
                            Detail) sudah tersimpan terlebih dahulu sebelum membuka formulir ini.</div>
                    </div>

                    <ul class="flow-list">
                        <li><span class="bullet">1</span> Klik <b>Tambah Rincian</b>, lalu pilih <b>Daftar APBD Sub
                                Utama</b> yang akan diisi rinciannya.</li>
                        <li><span class="bullet">2</span> Tentukan <b>Tipe</b>, misalnya <b>Pemasukan/Pendapatan</b>.
                        </li>
                        <li><span class="bullet">3</span> Pada bagian <b>Daftar Sub Utama Untuk
                                Pemasukan/Pendapatan</b>, pilih <b>Kas id</b> yang sesuai, lalu isi nilai <b>Semula</b>,
                            <b>Menjadi</b>, dan <b>Sumber dana</b>.</li>
                        <li><span class="bullet">4</span> Gunakan <b>Tambahkan ke daftar Sub Utama</b> bila ada lebih
                            dari satu baris rincian dalam sub utama yang sama.</li>
                        <li><span class="bullet">5</span> Klik <b>Kirim</b> &mdash; setelah seluruh rincian terisi,
                            dokumen APBDes siap dijadikan acuan RAB.</li>
                    </ul>

                    <div class="mockup">
                        <div class="mockup-label">Ilustrasi &mdash; Modal Tambah Rincian</div>
                        <div class="mock-modal">
                            <div class="mock-modal-head">
                                <h3>Tambah Rincian</h3>
                                <span class="mock-x">&times;</span>
                            </div>
                            <div class="mock-field">
                                <label>Daftar APBD Sub Utama<span class="req">*</span></label>
                                <div class="mock-input filled">5.3. Belanja Modal <span class="chev">▾</span></div>
                            </div>
                            <div class="mock-field">
                                <label>Tipe</label>
                                <div class="mock-input filled">Pemasukan/Pendapatan <span class="chev">▾</span>
                                </div>
                            </div>
                            <div class="mock-field" style="margin-bottom:10px;">
                                <label>Daftar Sub Utama Untuk Pemasukan/Pendapatan<span class="req">*</span></label>
                                <div class="mock-sub-panel">
                                    <div class="mock-sub-panel-head"><span>↕</span><span>🗑</span></div>
                                    <div class="mock-field">
                                        <label>Kas id<span class="req">*</span></label>
                                        <div class="mock-input filled">5.3.1. Belanja Modal Pengadaan Tanah <span
                                                class="chev">▾</span></div>
                                    </div>
                                    <div class="mock-row3">
                                        <div class="mock-field">
                                            <label>Semula<span class="req">*</span></label>
                                            <div class="mock-input filled">Rp 23.232.323</div>
                                        </div>
                                        <div class="mock-field">
                                            <label>Menjadi<span class="req">*</span></label>
                                            <div class="mock-input filled">Rp 22.222.222</div>
                                        </div>
                                        <div class="mock-field">
                                            <label>Sumber dana</label>
                                            <div class="mock-input filled">Dana Desa</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mock-input"
                                    style="justify-content:center; color: var(--digital-blue); font-weight:600;">+
                                    Tambahkan ke daftar Sub Utama Untuk Pemasukan/Pendapatan</div>
                            </div>
                            <div class="mock-btn-row" style="margin-top:14px;">
                                <div class="mock-btn primary">Kirim</div>
                                <div class="mock-btn ghost">Batal</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STEP 4 -->
            <section class="step-card" id="step-4">
                <div class="step-head">
                    <div class="step-num">04</div>
                    <div>
                        <div class="step-tag">Menu Rencana Anggaran Biaya</div>
                        <h2>Membuat RAB</h2>
                    </div>
                </div>
                <div class="step-body">
                    <p class="lead">
                        Rencana Anggaran Biaya (RAB) selalu mengacu pada APBDes yang sudah ada. RAB tidak dapat
                        dibuat tanpa APBDes sebagai acuannya, karena setiap bidang dan kegiatan pada RAB ditarik
                        dari struktur pendapatan yang telah diinput sebelumnya.
                    </p>

                    <div class="callout warn">
                        <div class="icon">!</div>
                        <div>Pastikan APBDes untuk tahun anggaran yang dituju sudah lengkap sampai tahap Rincian. Tanpa
                            APBD, RAB tidak memiliki acuan.</div>
                    </div>

                    <ul class="flow-list">
                        <li><span class="bullet">1</span> Buka menu <b>Rencana Anggaran Biaya</b>, lalu pilih
                            <b>Buat</b>.</li>
                        <li><span class="bullet">2</span> Pada <b>Kaitkan APBD Pada RAB ini</b>, pilih APBDes yang
                            sudah dibuat pada tahap 1&ndash;3.</li>
                        <li><span class="bullet">3</span> Isi <b>Judul</b>, <b>Tahun</b>, dan <b>Jenis</b> RAB.</li>
                        <li><span class="bullet">4</span> Klik <b>Buat</b> untuk lanjut ke halaman detail, atau <b>Buat
                                &amp; buat lainnya</b> jika ingin langsung membuat RAB berikutnya.</li>
                    </ul>

                    <div class="mockup">
                        <div class="mockup-label">Ilustrasi &mdash; Formulir Buat Rencana Anggaran Biaya</div>
                        <div class="mock-context-strip"><span>Rencana Anggaran Biaya</span><span>Buat</span></div>
                        <div class="mock-modal" style="border-radius: 0 0 16px 16px;">
                            <div class="mock-modal-head">
                                <h3>Buat Rencana Anggaran Biaya</h3>
                            </div>
                            <div class="mock-row" style="margin-bottom: 18px;">
                                <div class="mock-field" style="margin-bottom:0;">
                                    <label>Kaitkan APBD Pada RAB ini<span class="req">*</span></label>
                                    <div class="mock-input filled">Anggaran Pendapatan dan Belanja Desa <span
                                            class="chev">▾</span></div>
                                </div>
                                <div class="mock-field" style="margin-bottom:0;">
                                    <label>Judul<span class="req">*</span></label>
                                    <div class="mock-input filled">Rencana Anggaran Biaya</div>
                                </div>
                            </div>
                            <div class="mock-row">
                                <div class="mock-field">
                                    <label>Tahun<span class="req">*</span></label>
                                    <div class="mock-input filled">2026</div>
                                </div>
                                <div class="mock-field">
                                    <label>Jenis</label>
                                    <div class="mock-input filled">Belanja Modal</div>
                                </div>
                            </div>
                            <div class="mock-btn-row">
                                <div class="mock-btn primary">Buat</div>
                                <div class="mock-btn ghost">Buat &amp; buat lainnya</div>
                                <div class="mock-btn ghost">Batal</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STEP 5 -->
            <section class="step-card" id="step-5">
                <div class="step-head">
                    <div class="step-num">05</div>
                    <div>
                        <div class="step-tag">Halaman Detail RAB</div>
                        <h2>Melengkapi Detail RAB</h2>
                    </div>
                </div>
                <div class="step-body">
                    <p class="lead">
                        Setelah RAB dibuat, sistem mengarahkan langsung ke halaman detailnya. Di sini penginputan
                        berjalan bertahap dalam tiga lapis, dari yang paling umum ke yang paling rinci.
                    </p>

                    <div class="phase-grid">
                        <div class="phase-card">
                            <div class="phase-tag">LAPIS 1</div>
                            <h4>Penambahan Bidang</h4>
                            <p>Bidang ditambahkan berdasarkan struktur pendapatan yang sudah diinput di APBDes.</p>
                            <ul>
                                <li>Bidang mengikuti sumber pendapatan</li>
                            </ul>
                        </div>
                        <div class="phase-card">
                            <div class="phase-tag">LAPIS 2</div>
                            <h4>Penambahan Uraian</h4>
                            <p>Uraian menentukan kelompok kegiatan serta parameter kas yang akan dipakai di lapis
                                berikutnya.</p>
                            <ul>
                                <li>Kelompok kegiatan</li>
                                <li>Parameter kas</li>
                            </ul>
                        </div>
                        <div class="phase-card">
                            <div class="phase-tag">LAPIS 3</div>
                            <h4>Detail Uraian</h4>
                            <p>Lapis paling rinci &mdash; nilai teknis pelaksanaan kegiatan diinput di sini.</p>
                            <ul>
                                <li>Jumlah</li>
                                <li>Satuan</li>
                                <li>Volume, dan lainnya</li>
                            </ul>
                        </div>
                    </div>

                    <div class="callout ok" style="margin-top:26px; margin-bottom:0;">
                        <div class="icon">✓</div>
                        <div>Setelah ketiga lapis terisi, RAB siap dibaca sebagai rincian pelaksanaan dari APBDes yang
                            menjadi acuannya.</div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <footer class="site-footer">
        <div class="wrap">
            <div class="seal-mini">AD</div>
            <p>Panduan Penggunaan Sistem Keuangan Desa &mdash; Alur APBDes &amp; Rencana Anggaran Biaya</p>
        </div>
    </footer>

    <script>
        // Penyorotan tautan aktif pada panel navigasi samping saat menggulir (murni bantuan tampilan, tanpa data dinamis)
        const sections = document.querySelectorAll('.step-card');
        const navLinks = document.querySelectorAll('.side-nav a');
        const setActive = () => {
            let currentId = sections[0].id;
            sections.forEach(sec => {
                const rect = sec.getBoundingClientRect();
                if (rect.top <= 140) currentId = sec.id;
            });
            navLinks.forEach(link => {
                link.style.color = link.getAttribute('href') === '#' + currentId ? 'var(--pecatu-navy)' :
                    'var(--text-muted)';
                link.style.fontWeight = link.getAttribute('href') === '#' + currentId ? '700' : '400';
            });
        };
        document.addEventListener('scroll', setActive);
        setActive();
    </script>
</x-filament-panels::page>
