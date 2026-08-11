<?php

use App\Models\KontakForm;
use Livewire\Component;

new class extends Component {
    public $nama, $email, $subjek, $pesan;

    public function save() {
        try {
            $validated = $this->validate([
                'nama' => 'required',
                'email' => 'required|email',
                'subjek' => 'required',
                'pesan' => 'required',
            ]);

            KontakForm::create($validated);
            session()->flash('status', 'Kontak telah berhasil dibuat. Terima Kasih atas masukan anda.');
        } catch (Exception $e) {
            dd($e);
        }
    }
};
?>

<div>
    {{-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison --}}
    <x-css.pcss />

    <div class="progress-rail"><div class="progress-fill" id="progressFill"></div></div>

    <div class="hero">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow"><span class="eyebrow-dot"></span> Panduan Warga</span>
                <h1>Ajukan usulan desa Anda,<br><span>hanya dalam 5 langkah.</span></h1>
                <p class="lead">Dari pendaftaran akun hingga memantau realisasi — begini cara warga Pecatu menggunakan
                    platform Usulan Pecatu.</p>
                <div class="hero-meta">
                    <div class="m-item"><span class="num">5</span><span class="lab">Langkah utama</span></div>
                    <div class="m-item"><span class="num">2</span><span class="lab">Tahap formulir usulan</span>
                    </div>
                    <div class="m-item"><span class="num">&lt;5</span><span class="lab">Menit untuk daftar</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="step-preview">
                    <div class="n">1</div><span class="t">Kunjungi &amp; klik Daftar</span>
                </div>
                <div class="step-preview">
                    <div class="n">2</div><span class="t">Isi data diri</span>
                </div>
                <div class="step-preview">
                    <div class="n">3</div><span class="t">Ajukan usulan baru</span>
                </div>
                <div class="step-preview">
                    <div class="n">4</div><span class="t">Lengkapi 2 tahap form</span>
                </div>
                <div class="step-preview">
                    <div class="n">5</div><span class="t">Pantau status verifikasi</span>
                </div>
            </div>
        </div>
    </div>

    <main class="guide-section">
        <div class="container guide-layout">

            <aside class="side-nav" id="sideNav">
                <div class="side-kicker">Daftar Langkah</div>
                <a class="side-link active" href="#step-1"><span class="dot">1</span> Kunjungi &amp; Daftar</a>
                <a class="side-link" href="#step-2"><span class="dot">2</span> Isi Data Diri</a>
                <a class="side-link" href="#step-3"><span class="dot">3</span> Ajukan Usulan</a>
                <a class="side-link" href="#step-4"><span class="dot">4</span> Lengkapi Form</a>
                <a class="side-link" href="#step-5"><span class="dot">5</span> Pantau Status</a>
                <div class="side-cta">
                    <p>Sudah punya akun? Langsung masuk dan mulai ajukan usulan Anda.</p>
                </div>
            </aside>

            <div class="steps-col">

                <section class="step-block" id="step-1">
                    <div class="bignum">01</div>
                    <div class="step-head">
                        <span class="step-tag">Mulai di sini</span>
                        <h3>Buka halaman Usulan Pecatu dan klik Daftar</h3>
                        <p class="desc">Kunjungi <strong>e-usulan.sicatu.id</strong> melalui browser. Pada bagian
                            kanan atas navigasi, klik tombol <strong>Daftar</strong> untuk membuat akun warga baru.</p>
                    </div>
                    <div class="step-shot">
                        <div class="shot-frame-bar"><span></span><span></span><span></span></div>
                        <img src="{{ asset('storage/public_assets/1.png') }}"
                            alt="Navigasi situs Usulan Pecatu dengan tombol Masuk dan Daftar di pojok kanan atas">
                    </div>
                </section>

                <section class="step-block" id="step-2">
                    <div class="bignum">02</div>
                    <div class="step-head">
                        <span class="step-tag">Pendaftaran</span>
                        <h3>Isi data diri, lalu tekan Daftar Sekarang</h3>
                        <p class="desc">Lengkapi formulir dengan Nama Lengkap, NIK 16 digit, Banjar/Dusun, Email,
                            Nomor HP/WhatsApp, dan Kata Sandi. Centang persetujuan data, lalu tekan <strong>Daftar
                                Sekarang</strong>. Jika berhasil, sistem otomatis membawa Anda ke halaman profil.</p>
                    </div>
                    <div class="step-shot">
                        <div class="shot-frame-bar"><span></span><span></span><span></span></div>
                        <img src="{{ asset('storage/public_assets/2.png') }}"
                            alt="Formulir pendaftaran warga pecatu berisi nama, NIK, banjar, email, nomor HP, dan kata sandi">
                    </div>
                </section>

                <section class="step-block" id="step-3">
                    <div class="bignum">03</div>
                    <div class="step-head">
                        <span class="step-tag">Halaman Profil</span>
                        <h3>Pilih Ajukan Usulan Baru</h3>
                        <p class="desc">Setelah masuk, Anda akan melihat ringkasan aktivitas usulan pada halaman
                            <strong>Ringkasan</strong>. Untuk mengajukan usulan pembangunan, klik tombol <strong>+
                                Ajukan Usulan Baru</strong> di pojok kanan atas.
                        </p>
                    </div>
                    <div class="step-shot">
                        <div class="shot-frame-bar"><span></span><span></span><span></span></div>
                        <img src="{{ asset('storage/public_assets/3.png') }}"
                            alt="Halaman profil warga dengan ringkasan usulan dan tombol Ajukan Usulan Baru">
                    </div>
                </section>

                <section class="step-block" id="step-4">
                    <div class="bignum">04</div>
                    <div class="step-head">
                        <span class="step-tag">2 Tahap Pengisian</span>
                        <h3>Lengkapi formulir usulan dalam dua tahap</h3>
                        <p class="desc">Isi seluruh data yang diperlukan melalui dua tahap: <strong>(1) Detail dan
                                Data Utama Pengajuan Usulan</strong> — tanggal, judul, kategori, kamus usulan, dan titik
                            lokasi pada peta — lalu <strong>(2) Informasi Tambahan atau Pendukung Lainnya</strong> untuk
                            melampirkan data atau dokumen pendukung.</p>
                    </div>
                    <div class="step-shot">
                        <div class="shot-frame-bar"><span></span><span></span><span></span></div>
                        <img src="{{ asset('storage/public_assets/4.png') }}"
                            alt="Formulir dua tahap pengajuan usulan berisi detail pengajuan dan informasi tambahan">
                    </div>
                </section>

                <section class="step-block" id="step-5">
                    <div class="bignum">05</div>
                    <div class="step-head">
                        <span class="step-tag">Selesai</span>
                        <h3>Pantau status usulan Anda</h3>
                        <p class="desc">Jika pengajuan berhasil, buka menu <strong>Status Verifikasi</strong> untuk
                            memantau setiap tahap usulan — mulai dari Diajukan, Verifikasi Desa, Dijadwalkan Musrenbang,
                            hingga Realisasi — beserta catatan dari petugas desa.</p>
                    </div>
                    <div class="step-shot">
                        <div class="shot-frame-bar"><span></span><span></span><span></span></div>
                        <img src="{{ asset('storage/public_assets/5.png') }}"
                            alt="Halaman status verifikasi menampilkan tahapan diajukan, verifikasi desa, dijadwalkan musrenbang, dan realisasi">
                    </div>
                </section>

                <div class="note-strip">
                    <div class="icon">i</div>
                    <div>
                        <h4>Butuh bantuan?</h4>
                        <p>Jika mengalami kendala saat mendaftar atau mengajukan usulan, hubungi Kantor Desa Pecatu
                            melalui menu <strong>Kontak</strong> pada navigasi utama.</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        // Scroll progress bar
        const progressFill = document.getElementById('progressFill');

        function updateProgress() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const pct = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            progressFill.style.width = pct + '%';
        }
        window.addEventListener('scroll', updateProgress, {
            passive: true
        });
        updateProgress();

        // Scrollspy for side nav
        const sideLinks = Array.from(document.querySelectorAll('.side-link'));
        const blocks = Array.from(document.querySelectorAll('.step-block'));

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const link = sideLinks.find(l => l.getAttribute('href') === '#' + entry.target.id);
                if (!link) return;
                if (entry.isIntersecting) {
                    sideLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        }, {
            rootMargin: '-40% 0px -50% 0px',
            threshold: 0
        });

        blocks.forEach(b => observer.observe(b));
    </script>
</div>