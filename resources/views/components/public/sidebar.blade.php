@props([
    "user" => null
])
<!-- ============ SIDEBAR ============ -->
<aside class="dash-sidebar">
    <div class="dash-user-card">
        <div class="avatar-lg" data-session-avatar>W</div>
        <div class="nm" data-session-name>Warga Pecatu</div>
        <div class="em" data-session-email>{{ $user->nama_lengkap }}</div>
        <span class="badge-online">Status: Masuk</span>
    </div>

    <nav class="dash-nav">
        <a href="/dashboard" class="{{ Route::is('auth.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none">
                <rect x="3" y="3" width="8" height="8" rx="1.5" stroke="currentColor"
                    stroke-width="1.6" />
                <rect x="13" y="3" width="8" height="8" rx="1.5" stroke="currentColor"
                    stroke-width="1.6" />
                <rect x="3" y="13" width="8" height="8" rx="1.5" stroke="currentColor"
                    stroke-width="1.6" />
                <rect x="13" y="13" width="8" height="8" rx="1.5" stroke="currentColor"
                    stroke-width="1.6" />
            </svg>
            Ringkasan
        </a>
        <a href="/usulan" class="{{ Route::is('auth.usulan') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2Z"
                    stroke="currentColor" stroke-width="1.6" />
                <path d="M14 2V8H20" stroke="currentColor" stroke-width="1.6" />
            </svg>
            Usulan Saya
        </a>
        <a href="/status" class="{{ Route::is('auth.status') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 2L4 6V12C4 17 7.5 20.5 12 22C16.5 20.5 20 17 20 12V6L12 2Z" stroke="currentColor"
                    stroke-width="1.6" />
            </svg>
            Status Verifikasi
        </a>
        <a href="/profil" class="{{ Route::is('auth.profil') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.6" />
                <path d="M5 21C5 17 8 14.5 12 14.5C16 14.5 19 17 19 21" stroke="currentColor"
                    stroke-width="1.6" />
            </svg>
            Profil Saya
        </a>
        <a wire:click="logout" data-demo-logout
            style="margin-top: 14px; border-top: 1px solid var(--border-soft); padding-top: 16px; cursor:pointer;">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M9 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H9" stroke="currentColor"
                    stroke-width="1.6" stroke-linecap="round" />
                <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M21 12H9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
            </svg>
            Keluar
        </a>
    </nav>
</aside>
