<?php

use App\Models\Pengguna;
use Livewire\Component;

new class extends Component {
    public $user;

    public $nama_lengkap, $nik, $banjar, $phone, $email, $password, $contract, $role = 'pengguna';

    public function mount()
    {
        $this->user = whois('pengguna');
        $this->nama_lengkap = $this->user->nama_lengkap;
        $this->nik = $this->user->nik;
        $this->banjar = $this->user->banjar;
        $this->phone = $this->user->phone;
        $this->email = $this->user->email;
    }

    public function update() {
        try {
            DB::beginTransaction();

             $validates = $this->validate([
                'nama_lengkap' => 'required',
                'nik' => 'required|min:1|max:16',
                'banjar' => 'required',
                'phone' => 'required',
            ]);

            $validates['uuid'] = Str::uuid();

            $data = Pengguna::find($this->user->id)
                ->update($validates);

            DB::commit();
            
            session()->flash('status', 'Data diri telah berhasil diperbarui.');

            return $this->redirect('/profil');
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            abort(500);
        }
    }

    public function logout()
    {
        Auth::guard('pengguna')->logout();

        return $this->redirect('/');
    }
};
?>

<div>
    <div class="dash-shell">
        <x-public.sidebar :user="$user" />

        <!-- ============ MAIN ============ -->
        <main class="dash-main">
            <div class="dash-welcome">
                <div>
                    <h1>Profil Saya</h1>
                    <p>Kelola informasi pribadi dan keamanan akun Anda.</p>
                </div>
            </div>

            <div class="alert alert-info {{ session('status') ? 'show' : '' }}" id="loginAlert">
                @if (session('status'))
                    {{ session('status') }}
                @endif
            </div>

            <div class="profile-grid">
                <!-- Summary card -->
                <div class="profile-summary-card">
                    <div class="avatar-xl" data-session-avatar>W</div>
                    <h3 data-session-name>Warga Pecatu</h3>
                    <div class="p-email" data-session-email>{{ $user->nama_lengkap }}</div>
                    <span class="badge-online" style="margin-top: 12px;">Akun Aktif</span>

                    <div class="p-meta">
                        <div class="row"><span>NIK</span><span>{{ $user->nik }}</span></div>
                        <div class="row"><span>Banjar</span><span>{{ $user->banjar }}</span></div>
                        <div class="row"><span>Bergabung Sejak</span><span>{{ $user->created_at->since() }}</span></div>
                        <div class="row"><span>Total Usulan</span><span>{{ count($user->usulans) }} Usulan</span></div>
                    </div>
                </div>

                <!-- Form card -->
                <div class="profile-form-card">
                    <form data-blank-submit wire:submit="update">
                        <h3>Informasi Pribadi</h3>
                        <p class="sec-desc">Data ini digunakan untuk verifikasi kependudukan pada setiap usulan yang
                            Anda ajukan.</p>

                        <div class="field-grid">
                            <div class="field">
                                <label for="p-fullname">Nama Lengkap</label>
                                <div class="input-wrap no-icon">
                                    <input wire:model="nama_lengkap" type="text" id="p-fullname" value="Warga Pecatu">
                                </div>
                            </div>
                            <div class="field">
                                <label for="p-nik">NIK <span class="hint">16 digit</span></label>
                                <div class="input-wrap no-icon">
                                    <input wire:model="nik" type="text" id="p-nik" inputmode="numeric" maxlength="16"
                                        value="3204010101000142">
                                </div>
                            </div>
                        </div>

                        <div class="field-grid">
                            <div class="field">
                                <label for="p-banjar">Banjar / Dusun</label>
                                <div class="input-wrap no-icon">
                                    <select wire:model="banjar" id="p-banjar">
                                        <option value="Banjar Tengah">Banjar Tengah</option>
                                        <option value="Banjar Kauh">Banjar Kauh</option>
                                        <option value="Banjar Kangin">Banjar Kangin</option>
                                        <option value="Banjar Tambiyak">Banjar Tambiyak</option>
                                        <option value="Banjar Wijaya Kusuma">Banjar Wijaya Kusuma</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label for="p-phone">Nomor HP / WhatsApp</label>
                                <div class="input-wrap no-icon">
                                    <input wire:model="phone" type="tel" id="p-phone" value="081234567890">
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label for="p-address">Alamat Lengkap</label>
                            <textarea class="input" id="p-address">Jl. Pantai Suluban No. 8, Banjar Tengah, Pecatu, Kuta Selatan, Badung, Bali</textarea>
                        </div>

                        <hr class="sec-divider">

                        <h3>Akun &amp; Kontak</h3>
                        <p class="sec-desc">Email digunakan untuk masuk dan menerima notifikasi status usulan.</p>

                        <div class="field-grid">
                            <div class="field">
                                <label for="p-email">Email</label>
                                <div class="input-wrap no-icon">
                                    <input readonly wire:model="email" type="email" id="p-email" placeholder="nama@email.com"
                                        data-session-email-input>
                                </div>
                            </div>
                            <div class="field">
                                <label for="p-role">Jenis Akun</label>
                                <div class="input-wrap no-icon">
                                    <input type="text" id="p-role" value="Warga Pecatu" disabled
                                        style="color: var(--text-soft);">
                                </div>
                            </div>
                        </div>

                        <hr class="sec-divider">

                        <h3>Keamanan</h3>
                        <p class="sec-desc">Perbarui kata sandi secara berkala untuk menjaga keamanan akun Anda.</p>

                        <div class="field-grid">
                            <div class="field">
                                <label for="p-pass-new">Kata Sandi Baru</label>
                                <div class="input-wrap no-icon">
                                    <input type="password" id="p-pass-new" placeholder="Minimal 8 karakter">
                                </div>
                            </div>
                            <div class="field">
                                <label for="p-pass-confirm">Konfirmasi Kata Sandi</label>
                                <div class="input-wrap no-icon">
                                    <input type="password" id="p-pass-confirm" placeholder="Ulangi kata sandi baru">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="reset" class="btn btn-ghost">Batalkan</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
