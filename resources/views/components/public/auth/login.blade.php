<?php

use Livewire\Component;

new class extends Component {
    public $email, $password, $remember;

    public function mount() {
        if(whois('pengguna')){
            $this->redirect('/dashboard');
        }
    }

    public function login() {
        $validate = $this->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if(Auth::guard('pengguna')->attempt($validate, $this->remember)){
            $this->redirect('/dashboard');
        } else {
            session()->flash('status', 'Email atau Kata Sandi salah mohon dicek apakah penulisannya sudah benar.');
            $this->redirect('/login');
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
                <h2>Selamat datang kembali, warga Pecatu.</h2>
                <p>Masuk untuk melanjutkan pengajuan usulan, memantau status, atau melihat riwayat pengajuan Anda
                    sebelumnya. </p>
            </div>

            <div class="aside-quote">
                <b>“Suara setiap warga</b> adalah arah pembangunan desa.” — Pemerintah Desa Pecatu
            </div>
        </div>

        <!-- Right form -->
        <div class="auth-main">
            <div class="auth-card">
                <span class="gate-mark">
                    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="23" fill="#061B4E" stroke="#D6A100"
                            stroke-width="1.5" />
                        <path d="M14 32V24C14 19 18 15 24 15C30 15 34 19 34 24V32" stroke="#F3C542" stroke-width="2"
                            stroke-linecap="round" />
                        <path d="M11 32H37" stroke="#69A8D8" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </span>

                <h1>Masuk ke Akun Anda</h1>
                <p class="sub">Gunakan email dan kata sandi terdaftar untuk mengakses layanan usulan.</p>

                <div class="alert alert-info {{ session('status') ? 'show' : '' }}" id="loginAlert">
                    @if (session('status'))
                        {{ session('status') }}
                    @endif
                </div>

                <form wire:submit="login">
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
                        <label for="password">Kata Sandi</label>
                        <div class="input-wrap">
                            <svg class="icon" viewBox="0 0 24 24" fill="none">
                                <rect x="4" y="10" width="16" height="10" rx="2" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M8 10V7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7V10" stroke="currentColor"
                                    stroke-width="1.6" />
                            </svg>
                            <input wire:model="password" type="password" id="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="field-row">
                        <label class="checkbox-line">
                            <input wire:model="remember" type="checkbox">
                            Ingat saya
                        </label>
                        <a href="#" class="link-accent">Lupa kata sandi?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" data-demo-login>Masuk</button>
                </form>

                <div class="divider-text">atau</div>

                <p class="foot-note">Belum punya akun? <a href="/regis" class="link-accent">Daftar sebagai
                        warga</a></p>
            </div>
        </div>
    </div>
</div>
