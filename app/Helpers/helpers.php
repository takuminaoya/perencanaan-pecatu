<?php

use App\Enums\CapaianEnum;
use App\Enums\PrioritasTugas;
use App\Enums\Status;
use App\Enums\TipeVerif;
use App\Models\APBDDetailMain;
use App\Models\APBDRicianChildDetail;
use App\Models\ParameterBidang;
use App\Models\RencanaAnggaranBiayaBidang;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function notif($title = 'Notifikasi Sistem', $message = 'Terjadi Kesalahan Pada Sistem.', $icon = Heroicon::XCircle){
    return Notification::make('notif')
        ->title($title)
        ->body($message)
        ->icon($icon)
        ->send();
}

function whois($guard = 'web') {
    return Auth::guard($guard)->user();
}

function status(string $stats) {
    return Status::tryFrom($stats);
}

function toCarbon(mixed $date, $searchFormat = "Y-m-d", $format = 'D, d F Y') {
    if($date != null){
        $d = Carbon::createFromFormat($searchFormat, $date);
    
        return $d->locale('id')->timezone('Asia/Singapore')->translatedFormat($format);
    }

    return "-";
}

function tahapan(int $nomor) : string {
    switch($nomor){
        case 0 : 
            return "Usulan Diajukan";
            break;
        case 1 : 
            return "Usulan telah Diverifikasi Admin";
            break;
        case 2 : 
            return "Verifikasi Tingkat Desa";
            break;
        case 3 : 
            return "Verifikasi Tingkat Banjar";
            break;
        case 4 : 
            return "Dijadwalkan Musrenbang";
            break;
        case 5 : 
            return "Realisasi";
            break;
        case 6 : 
            return "Selesai";
            break;
        default:
            return "";
    }
}

/**
 * Menyamarkan sebagian karakter pada sebuah nomor/string.
 *
 * @param string $number       Nomor asli, boleh mengandung spasi/strip (akan dibersihkan)
 * @param int    $visibleStart Jumlah karakter di awal yang tetap ditampilkan
 * @param int    $visibleEnd   Jumlah karakter di akhir yang tetap ditampilkan
 * @param int    $groupSize    Ukuran pengelompokan tampilan (misal 4 -> "xxxx xxxx")
 * @param string $maskChar     Karakter mask, default 'x'
 * @return string              Nomor yang sudah disamarkan
 */
function maskNumber(
    string $number,
    int $visibleStart = 4,
    int $visibleEnd = 4,
    int $groupSize = 4,
    string $maskChar = 'x'
): string {
    // Bersihkan dari spasi/strip agar perhitungan panjang akurat
    $clean = preg_replace('/\s+|-/', '', $number);
    $length = strlen($clean);

    // Jika nomor terlalu pendek untuk disamarkan, kembalikan apa adanya
    if ($length <= $visibleStart + $visibleEnd) {
        return $clean;
    }

    $start  = substr($clean, 0, $visibleStart);
    $end    = substr($clean, -$visibleEnd);
    $midLen = $length - $visibleStart - $visibleEnd;
    $masked = str_repeat($maskChar, $midLen);

    $result = $start . $masked . $end;

    // Kelompokkan ulang per $groupSize karakter, dipisah spasi
    $groups = str_split($result, $groupSize);

    return implode(' ', $groups);
}

function dateDiffCarbon(string $date1, string $date2, string $unit = 'day'): string
{
    $start = Carbon::parse($date1);
    $end = Carbon::parse($date2);

    if ($start->greaterThan($end)) {
        [$start, $end] = [$end, $start];
    }

    $unit = strtolower($unit);

    switch ($unit) {
        case 'year':
        case 'years':
            $value = $start->diffInYears($end);
            $label = 'Tahun';
            break;

        case 'month':
        case 'months':
            $value = $start->diffInMonths($end);
            $label = 'Bulan';
            break;

        case 'day':
        case 'days':
        default:
            $value = $start->diffInDays($end);
            $label = 'Hari';
            break;
    }

    // Auto pluralize
    $value = ceil($value);
    $label .= $value > 1 ? '' : '';

    return "{$value} {$label}";
}

function getAPBDMain($id) {
    return APBDDetailMain::find($id);
}

function getDaftarKodeSatuan() {
    $res = [];

    $datas = DB::table('ep_parameter_kegiatans')
            ->select('satuan_output')
            ->groupBy('satuan_output')
            ->get();

    foreach($datas as $d){
        $res[$d->satuan_output] = $d->satuan_output;
    }

    return $res;
}

function getBidang($id) {
    return ParameterBidang::find($id);
}

function getRabBidang($rab_id, $main_id) {
    return RencanaAnggaranBiayaBidang::where('rab_id', $rab_id)->where('main_bidang_id', $main_id)->get();
}

function getAPBDChildDetail($apbd_id, $main_id) {
    return APBDRicianChildDetail::where('apbd_id', $apbd_id)->where('main_id', $main_id)->where('tipe', 'keluar')->get();
}

function getSisaSumSumber(int $sumber_id, $apbd_id, $dana = 'semula_total') {
    $masuk = APBDRicianChildDetail::where('apbd_id', $apbd_id)->where('tipe', 'masuk')->where('sumber_id', $sumber_id)->sum($dana);
    $keluar = APBDRicianChildDetail::where('apbd_id', $apbd_id)->where('tipe', 'keluar')->where('sumber_id', $sumber_id)->sum($dana);
    $hasil = $masuk - $keluar;

    return $hasil;
}

function isSuperadmin() : bool {
    $superadmin_id = 1;
    return whois()->jabatan->id == $superadmin_id ? true : false;
}

function isFeatureAvailable($dibuat_oleh) : bool {
    return $dibuat_oleh == whois()->id ? true : false;
}

function getUser($id) {
    return User::find($id);
} 
