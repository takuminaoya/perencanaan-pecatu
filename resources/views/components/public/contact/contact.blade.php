<div>
    <section class="profile-banner" style="padding-bottom: 0;">
        <div class="container profile-banner-inner" style="padding-bottom: 56px;">
            <span class="eyebrow" style="color: var(--soft-gold);">Hubungi Kami</span>
            <h1 style="font-size: 32px;">Punya pertanyaan tentang usulan Anda?</h1>
            <p>Tim Kaur Pelayanan Warga siap membantu proses pendaftaran, pengajuan usulan, hingga kendala teknis pada
                platform ini.</p>
        </div>
        <svg class="gate-divider" viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60 L0 30 Q720 0 1440 30 L1440 60 Z" fill="#F5F7FB" />
        </svg>
    </section>

    <section class="section" style="padding-top: 64px;">
        <div class="container">
            <div class="contact-grid">

                <!-- Info card -->
                <div class="contact-info-card">
                    <h3>Kantor Desa Pecatu</h3>
                    <p class="desc">Datang langsung pada jam layanan, atau hubungi kami melalui kontak di bawah.</p>

                    <div class="contact-row">
                        <div class="ic">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M21 10C21 16 12 22 12 22C12 22 3 16 3 10C3 5.5 7 2 12 2C17 2 21 5.5 21 10Z"
                                    stroke="#F3C542" stroke-width="1.6" />
                                <circle cx="12" cy="10" r="3" stroke="#F3C542" stroke-width="1.6" />
                            </svg>
                        </div>
                        <div>
                            <div class="label">Alamat</div>
                            <div class="value">Jl. Raya Pecatu, Kuta Selatan, Badung, Bali 80361</div>
                        </div>
                    </div>

                    <div class="contact-row">
                        <div class="ic">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M22 16.9V19.9C22 20.5 21.5 21 20.9 21C9.9 21 1 12.1 1 1.1C1 0.5 1.5 0 2.1 0H5.1C5.6 0 6.1 0.4 6.2 0.9L7 4.9C7.1 5.4 6.9 5.9 6.5 6.2L4.9 7.4C6.1 10.4 8.6 12.9 11.6 14.1L12.8 12.5C13.1 12.1 13.6 11.9 14.1 12L18.1 12.8C18.6 12.9 19 13.4 19 13.9V16.9"
                                    stroke="#F3C542" stroke-width="1.5" />
                            </svg>
                        </div>
                        <div>
                            <div class="label">Telepon</div>
                            <div class="value">(0361) 703-0000</div>
                        </div>
                    </div>

                    <div class="contact-row">
                        <div class="ic">
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect x="2" y="4" width="20" height="16" rx="2" stroke="#F3C542"
                                    stroke-width="1.6" />
                                <path d="M2 6L12 13L22 6" stroke="#F3C542" stroke-width="1.6" />
                            </svg>
                        </div>
                        <div>
                            <div class="label">Email</div>
                            <div class="value">layanan@pecatu.desa.id</div>
                        </div>
                    </div>

                    <div class="contact-row">
                        <div class="ic">
                            <svg viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="9" stroke="#F3C542" stroke-width="1.6" />
                                <path d="M12 7V12L15.5 14" stroke="#F3C542" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <div class="label">Jam Layanan</div>
                            <div class="value">Senin–Jumat, 08.00–15.00 WITA</div>
                        </div>
                    </div>

                    <div class="social-row">
                        <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="18" height="18" rx="5" stroke="#fff"
                                    stroke-width="1.6" />
                                <circle cx="12" cy="12" r="4" stroke="#fff" stroke-width="1.6" />
                                <circle cx="17.5" cy="6.5" r="1" fill="#fff" />
                            </svg></a>
                        <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="none">
                                <path d="M14 9H17V6H14C12 6 11 7.5 11 9V11H9V14H11V21H14V14H16.5L17 11H14V9Z"
                                    stroke="#fff" stroke-width="1.2" fill="#fff" />
                            </svg></a>
                        <a href="#" aria-label="WhatsApp"><svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M12 2C6.5 2 2 6.5 2 12C2 13.8 2.5 15.5 3.4 17L2 22L7.2 20.6C8.7 21.5 10.3 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2Z"
                                    stroke="#fff" stroke-width="1.4" />
                            </svg></a>
                    </div>
                </div>

                <!-- Form + FAQ -->
                <div>
                    <div class="card" style="margin-bottom: 28px;">
                        <h3 style="font-size: 19px;">Kirim Pesan</h3>
                        <p style="color: var(--text-muted); font-size: 14px; margin-top: 6px; margin-bottom: 24px;">Isi
                            formulir di bawah, kami akan merespons dalam 1–2 hari kerja.</p>

                        <div class="alert alert-info {{ session('status') ? 'show' : '' }}" id="loginAlert">
                            @if (session('status'))
                                {{ session('status') }}
                            @endif
                        </div>

                        <form wire:submit="save" data-blank-submit method="POST">
                            <div class="grid-2" style="gap: 16px;">
                                <div class="field">
                                    <label for="cname">Nama Lengkap</label>
                                    <div class="input-wrap no-icon">
                                        <input type="text" wire:model="nama" id="cname" placeholder="Nama Anda" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="cemail">Email</label>
                                    <div class="input-wrap no-icon">
                                        <input type="email" wire:model="email" id="cemail" placeholder="nama@email.com" required>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <label for="csubject">Subjek</label>
                                <div class="input-wrap no-icon">
                                    <select id="csubject" wire:model="subjek" required>
                                        <option value="" disabled selected>Pilih topik pesan</option>
                                        <option value="Bantuan Pendaftaran Akun">Bantuan Pendaftaran Akun</option>
                                        <option value="Kendala Pengajuan Usulan">Kendala Pengajuan Usulan</option>
                                        <option value="Status Usulan">Status Usulan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label for="cmessage">Pesan</label>
                                <textarea wire:model="pesan" class="input" id="cmessage" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Kirim Pesan</button>
                        </form>
                    </div>

                    <div class="card">
                        <h3 style="font-size: 19px; margin-bottom: 16px;">Pertanyaan Umum</h3>

                        <details class="faq-item" open>
                            <summary>Siapa yang bisa mendaftar di platform ini?</summary>
                            <p>Seluruh warga yang berdomisili dan tercatat dalam data kependudukan Desa Pecatu dapat
                                mendaftar menggunakan NIK yang valid.</p>
                        </details>
                        <details class="faq-item">
                            <summary>Berapa lama usulan diverifikasi?</summary>
                            <p>Perangkat desa biasanya memverifikasi usulan dalam 3–7 hari kerja sebelum dijadwalkan ke
                                musyawarah perencanaan.</p>
                        </details>
                        <details class="faq-item">
                            <summary>Apakah saya bisa mengubah usulan setelah dikirim?</summary>
                            <p>Usulan yang sudah masuk status verifikasi tidak dapat diubah, namun Anda dapat
                                menghubungi Kaur Pelayanan Warga untuk koreksi data.</p>
                        </details>
                        <details class="faq-item">
                            <summary>Apakah data saya aman?</summary>
                            <p>Data kependudukan dan usulan hanya dapat diakses oleh perangkat desa yang berwenang dan
                                tidak dibagikan ke pihak luar.</p>
                        </details>
                    </div>
                </div>
            </div>

            <div class="map-frame">
                <iframe width="425" height="350"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=115.04453659057619%2C-8.860648239550983%2C115.15714645385744%2C-8.787792362389574&amp;layer=mapnik"
                    style="border: 1px solid black"></iframe><br /><small><a
                        href="https://www.openstreetmap.org/?#map=14/-8.82422/115.10084">View Larger Map</a></small>
            </div>
        </div>
    </section>
</div>