<?php

use App\Models\Pengguna;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component {
    public $nama_lengkap, $nik, $banjar, $phone, $email, $password, $contract, $role = 'pengguna';

    public function save() {
    
        try {
            DB::beginTransaction();

             $validates = $this->validate([
                'nama_lengkap' => 'required',
                'nik' => 'required|min:1|max:16',
                'banjar' => 'required',
                'phone' => 'required',
                'email' => 'required|email|unique:penggunas,email',
                'password' => 'required',
            ]);

            $validates['uuid'] = Str::uuid();

            $data = Pengguna::create($validates);

            Auth::guard('pengguna')->loginUsingId($data->id);

            DB::commit();

            return $this->redirect('/dashboard');
        } catch (Exception $e) {
            DB::rollback();
            abort(500);
        }
    }
};
?>

<div>
    <div class="auth-wrap">
        <!-- Left visual aside -->
        <div class="auth-aside">
            <div class="aside-top">
                <span class="gate-mark">
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 50V34C14 26 19 20 27 20C35 20 40 26 40 34V50" stroke="#F3C542" stroke-width="2.5"
                            stroke-linecap="round" />
                        <path d="M27 20V14" stroke="#F3C542" stroke-width="2.5" stroke-linecap="round" />
                        <circle cx="27" cy="11" r="2.4" fill="#F3C542" />
                        <path d="M9 50H45" stroke="#69A8D8" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                </span>
                <h2>Satu akun untuk seluruh layanan usulan desa.</h2>
                <p>Daftarkan diri Anda sekali, gunakan akun yang sama untuk mengajukan usulan apa pun — infrastruktur,
                    sosial, hingga ekonomi.</p>
            </div>

            <div class="aside-quote">
                <b>Data Anda dijaga.</b> Hanya perangkat desa berwenang yang dapat mengaksesnya.
            </div>
        </div>

        <!-- Right form -->
        <div class="auth-main">
            <div class="auth-card" style="max-width: 460px;">
                <span class="gate-mark">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23" fill="#061B4E" stroke="#D6A100"
                            stroke-width="1.5" />
                        <path d="M14 32V24C14 19 18 15 24 15C30 15 34 19 34 24V32" stroke="#F3C542" stroke-width="2"
                            stroke-linecap="round" />
                        <path d="M11 32H37" stroke="#69A8D8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </span>

                <h1>Daftar Akun Warga</h1>
                <p class="sub">Lengkapi data sesuai KTP/KK untuk verifikasi kependudukan.</p>

                <div class="alert alert-info" id="registerAlert">
                    Form ini hanya untuk tampilan — proses pendaftaran belum terhubung ke sistem.
                </div>

                <form wire:submit="save" method="POST">
                    <div class="role-toggle">
                        <label>
                            <input wire:model="role" type="radio" name="role" value="pengguna" checked>
                            <span>Warga Pecatu</span>
                        </label>
                        <label>
                            <input wire:model="role" type="radio" name="role" value="perangkat">
                            <span>Perangkat Desa</span>
                        </label>
                    </div>

                    <div class="field">
                        <label for="fullname">Nama Lengkap</label>
                        <div class="input-wrap">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="8" r="3.5" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M5 21C5 17 8 14.5 12 14.5C16 14.5 19 17 19 21" stroke="currentColor"
                                    stroke-width="1.6" />
                            </svg>
                            <input wire:model="nama_lengkap" type="text" id="fullname" placeholder="Sesuai KTP" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="nik">NIK <span class="hint">16 digit</span></label>
                        <div class="input-wrap">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M7 9H11M7 13H15" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" />
                            </svg>
                            <input wire:model="nik" type="text" id="nik" inputmode="numeric" maxlength="16"
                                placeholder="3204XXXXXXXXXXXX" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="banjar">Banjar / Dusun</label>
                        <div class="input-wrap">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M2 6L12 13L22 6" stroke="currentColor" stroke-width="1.6" />
                            </svg>
                            <select wire:model="banjar" id="banjar" required>
                                <option value="" disabled selected>Pilih banjar</option>
                                <option>Banjar Tengah</option>
                                <option>Banjar Kauh</option>
                                <option>Banjar Kangin</option>
                                <option>Banjar Tambiyak</option>
                                <option>Banjar Wijaya Kusuma</option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <div class="input-wrap">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M2 6L12 13L22 6" stroke="currentColor" stroke-width="1.6" />
                            </svg>
                            <input wire:model="email" type="email" id="email" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="phone">Nomor HP / WhatsApp</label>
                        <div class="input-wrap">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M22 16.9V19.9C22 20.5 21.5 21 20.9 21C9.9 21 1 12.1 1 1.1C1 0.5 1.5 0 2.1 0H5.1C5.6 0 6.1 0.4 6.2 0.9L7 4.9C7.1 5.4 6.9 5.9 6.5 6.2L4.9 7.4C6.1 10.4 8.6 12.9 11.6 14.1L12.8 12.5C13.1 12.1 13.6 11.9 14.1 12L18.1 12.8C18.6 12.9 19 13.4 19 13.9V16.9"
                                    stroke="currentColor" stroke-width="1.5" />
                            </svg>
                            <input wire:model="phone" type="tel" id="phone" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">Kata Sandi</label>
                        <div class="input-wrap">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <rect x="4" y="10" width="16" height="10" rx="2"
                                    stroke="currentColor" stroke-width="1.6" />
                                <path d="M8 10V7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7V10" stroke="currentColor"
                                    stroke-width="1.6" />
                            </svg>
                            <input wire:model="password" type="password" id="password" placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>

                    <label class="checkbox-line" style="margin-bottom: 22px;">
                        <input wire:model="contract" type="checkbox" required>
                        Saya menyatakan data yang diisi benar dan dapat dipertanggungjawabkan
                    </label>

                    <button type="submit" class="btn btn-primary btn-block">Daftar Sekarang</button>
                </form>

                <p class="foot-note">Sudah punya akun? <a href="/login" class="link-accent">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>
