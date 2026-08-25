<?php

namespace App\Http\Controllers;

use App\Models\RencanaKerjaKegiatan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function printRKK($id) {
        $record = RencanaKerjaKegiatan::find($id);
        $pdf = Pdf::loadView('print.rkk', [
            'record' => $record
        ]);

        return $pdf->setPaper('a4', 'landscape')->stream(str_replace(' ', '_', $record->judul) . '_' . date('ymdhis') . '.pdf');
    }

    public function downloadRKK($id) {
        $record = RencanaKerjaKegiatan::find($id);
        $pdf = Pdf::loadView('print.rkk', [
            'record' => $record
        ]);

        return $pdf->setPaper('a4', 'landscape')->download(str_replace(' ', '_', $record->judul) . '_' . date('ymdhis') . '.pdf');
    }
}
