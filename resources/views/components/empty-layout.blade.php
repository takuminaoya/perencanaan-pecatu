<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk — e-Usulan Pemerintah</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap"
        rel="stylesheet" />
    <x-css.authcss />

    <link rel="icon" type="image/x-icon" href="{{ asset('storage/public_assets/icon.png') }}"/>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body>
    <div class="wrap">
        <!-- LEFT: HERO -->
        <div class="hero">
            <svg class="gate" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 190 L10 90 Q10 40 45 40 L45 190" stroke="var(--soft-bg)" stroke-width="4" />
                <path d="M20 190 L20 80 Q20 55 45 55" stroke="var(--soft-bg)" stroke-width="2" />
                <rect x="4" y="188" width="48" height="6" fill="var(--soft-bg)" />
                <path d="M190 190 L190 90 Q190 40 155 40 L155 190" stroke="var(--soft-bg)" stroke-width="4" />
                <path d="M180 190 L180 80 Q180 55 155 55" stroke="var(--soft-bg)" stroke-width="2" />
                <rect x="148" y="188" width="48" height="6" fill="var(--soft-bg)" />
                <circle cx="27.5" cy="30" r="5" fill="var(--soft-bg)" />
                <circle cx="172.5" cy="30" r="5" fill="var(--soft-bg)" />
            </svg>

            <div class="brand">
                <div class="brand-mark">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                        <path d="M13 2 L22 8 V18 L13 24 L4 18 V8 Z" stroke="#072A38" stroke-width="1.6" />
                        <path d="M13 8 Q9 13 13 18 Q17 13 13 8 Z" fill="#072A38" />
                    </svg>
                </div>
                <div>
                    <div class="brand-name">SI-RENBANG</div>
                    <div class="brand-sub">DESA PECATU</div>
                </div>
            </div>

            <div>
                <div class="eyebrow">PORTAL RESMI PEMERINTAH DESA</div>
                <h1 class="headline">Perencanaan Desa <em>Lebih Terarah,</em><br>Pembangunan Lebih Tepat Sasaran</h1>
                <p class="desc">
                    Sistem Perencanaan Desa Pecatu — platform digital untuk pengajuan usulan Musrenbang, penyusunan
                    RKPDes &amp; APBDes, serta pemantauan realisasi pembangunan di seluruh banjar dinas Desa Pecatu,
                    Kecamatan Kuta Selatan, Kabupaten Badung.
                </p>

                <div class="chips">
                    <div class="chip"><span class="dot"></span>Keamanan Berlapis</div>
                    <div class="chip"><span class="dot"></span>Tracking Realisasi Real-time</div>
                    <div class="chip"><span class="dot"></span>Transparansi APBDes</div>
                    <div class="chip"><span class="dot"></span>Integrasi SIPD &amp; OM-SPAN</div>
                </div>
            </div>

            <div class="stats">
                <div>
                    <div class="stat-num">1.240</div>
                    <div class="stat-label">Usulan Diproses</div>
                </div>
                <div>
                    <div class="stat-num">6</div>
                    <div class="stat-label">Banjar Dinas Terdaftar</div>
                </div>
                <div>
                    <div class="stat-num">99,2%</div>
                    <div class="stat-label">Uptime Sistem</div>
                </div>
            </div>
        </div>

        <!-- RIGHT: LOGIN FORM -->
        <div class="panel">
            <div class="form-card">
                <div class="form-eyebrow">AUTENTIKASI PENGGUNA</div>
                <div class="welcome">Selamat Datang</div>
                <p class="welcome-sub">Masuk menggunakan akun resmi perangkat desa atau operator banjar untuk mengakses
                    Sistem Perencanaan Desa Pecatu.</p>

                {{ $slot }}

                <div class="divider"></div>

                <div class="help-row">
                    <span class="help-icon">📞</span>
                    <span>Bantuan: <a href="#">Hubungi Admin Desa</a> atau ext. 1234</span>
                </div>
                <div class="help-row">
                    <span class="help-icon">📘</span>
                    <span><a href="#">Panduan Penggunaan</a> &amp; <a href="#">FAQ</a></span>
                </div>

                <div class="footer-note">
                    © 2025 Pemerintah Desa Pecatu — Hak Cipta Dilindungi<br>
                    Versi 1.0.0 | Sistem ini dipantau &amp; diaudit secara berkala
                </div>
            </div>
        </div>
    </div>

    @filamentScripts
    @vite('resources/js/app.js')

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("form.password");
        const loginForm = document.getElementById("form");
        const toast = document.getElementById("toast");

        function showToast() {
            toast.classList.add("show");

            setTimeout(() => {
                toast.classList.remove("show");
            }, 3200);
        }

        loginForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const button = loginForm.querySelector(".fi-btn");
            const originalContent = button.innerHTML;

            button.innerHTML = "Memproses akses...";
            button.disabled = true;
            button.style.opacity = "0.82";
            button.style.cursor = "not-allowed";

            setTimeout(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
                button.style.opacity = "1";
                button.style.cursor = "pointer";
            }, 1200);
        });
    </script>
</body>

</html>
