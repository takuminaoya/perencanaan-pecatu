<div>
    <div class="dash-shell">
        <x-public.sidebar :user="$user" />

        <!-- ============ MAIN ============ -->
        <main class="dash-main">
            <div class="dash-welcome">
                <div>
                    <h1>Status Verifikasi</h1>
                    <p>Pantau setiap tahap verifikasi usulan Anda, dari pengajuan hingga realisasi.</p>
                </div>
                <a href="/usulan" class="btn btn-outline">Lihat Semua Usulan</a>
            </div>

            <!-- Tracker 1: in progress, scheduled stage -->
            @if ($usulans && count($usulans) > 0)
                @foreach ($usulans as $usulan)
                    @php
                        $jumlah_tahapan = 7;
                        $status = [
                            'disetujui' => 'is-complete',
                            'current' => 'is-current',
                            'not' => ' ',
                            'ditolak' => 'is-denied',
                        ];
                        $tahapans = [
                            'Usulan Diajukan',
                            'Usulan telah Diverifikasi Admin',
                            'Verifikasi Tingkat Desa',
                            'Verifikasi Tingkat Banjar',
                            'Dijadwalkan Musrenbang',
                            'Realisasi',
                            'Selesai',
                        ];
                        $container = [];

                        $currentTahapan = $usulan->tahapan;
                        $currentStatus = $status['not'];
                        $nextTahapan = ($usulan->tahapan < 6) ? $currentTahapan : 6;
                        $catatan = "";

                        for ($i=0; $i < $jumlah_tahapan; $i++) { 
                            $model = null;
                            $stats = "";
                            $ditolak = false;

                            if($i == $currentTahapan){
                                $stats = $status['disetujui'];
                            }

                            if($usulan){
                                $model = $usulan->getVerifkasi($i);

                                if($model){
                                    if($model->status == 'ditolak'){
                                        $ditolak = true;
                                        $stats = $status['ditolak'];
                                        $catatan = $model->catatan;
                                    } else {
                                        $stats = $model->status == 'draft' ? $status['not'] : $status['disetujui'];
                                        if($model->uraian){
                                            $catatan = $model->uraian;
                                        }
                                    }
                                }
                            }

                            if($i == 0){
                                $stats = $status['disetujui'];
                            }

                            if($i == $nextTahapan && $ditolak == false){
                                $stats = $status['current'];
                            }
                            
                            $container[$i] = [
                                'no' => $i,
                                'nama' => $tahapans[$i],
                                'model' => $model,
                                'stats' => $stats,
                                'catatan' => $catatan
                            ];
                        }
                    @endphp

                    <div class="tracker-card">
                        <div class="tracker-head">
                            <div>
                                <h3>{{ $usulan->judul }}</h3>
                                <div class="t-ticket">No. Tiket: {{ $usulan->kode }} · {{ $usulan->kamus->nama }}</div>
                            </div>
                            @if ($currentTahapan == 4)
                                <span class="status-badge is-scheduled">Dijadwalkan</span>
                            @endif
                        </div>
                        <div class="tracker-steps">
                            @foreach ($container as $item)
                                <div class="tracker-step {{ $item['stats'] }}">
                                    <div class="t-dot">
                                        {{ $item['no'] }}
                                    </div>
                                    <div class="t-line"></div>
                                    <div class="t-label">{{ $item['nama'] }}</div>
                                    <div class="t-date">
                                        -
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($item['catatan'] != "")
                            <div class="tracker-note">
                                <div class="n-ic">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="9" stroke="currentColor"
                                            stroke-width="1.6" />
                                        <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                                <p><b>Catatan Petugas:</b> {{ $item['catatan'] }}</p>
                                
                            </div>
                        @endif
                        
                    </div>
                @endforeach
            @else
                Tidak ada usulan
            @endif
        </main>
    </div>
</div>
