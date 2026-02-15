<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;
use Barryvdh\DomPDF\Facade\Pdf;

class KepsekController extends Controller
{
    public function dashboard()
    {
        $totalAspirasi = Aspirasi::count();
        $menunggu      = Aspirasi::where('status','menunggu')->count();
        $proses        = Aspirasi::where('status','proses')->count();
        $selesai       = Aspirasi::where('status','selesai')->count();

        return view('kepsek.dashboard', compact('totalAspirasi','menunggu','proses','selesai'));
    }

    public function laporan(Request $request)
    {
        $query = Aspirasi::with(['inputAspirasi.siswa', 'inputAspirasi.kategori', 'feedback.user']);

        // FILTER SEARCH
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('inputAspirasi.siswa', fn($q2) => $q2->where('nama', 'like', "%$search%"))
                  ->orWhereHas('inputAspirasi.kategori', fn($q2) => $q2->where('nama_kategori', 'like', "%$search%"))
                  ->orWhereHas('inputAspirasi', fn($q2) => $q2->where('lokasi', 'like', "%$search%"));
            });
        }

        if ($request->dari) $query->whereDate('tgl_aspirasi', '>=', $request->dari);
        if ($request->sampai) $query->whereDate('tgl_aspirasi', '<=', $request->sampai);

        $aspirasi = $query->latest()->get();

        return view('kepsek.laporan', compact('aspirasi'));
    }

    public function laporanPdf(Request $request)
    {
        $query = Aspirasi::with(['inputAspirasi.siswa', 'inputAspirasi.kategori']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('inputAspirasi.siswa', fn($q2) => $q2->where('nama', 'like', "%$search%"))
                  ->orWhereHas('inputAspirasi.kategori', fn($q2) => $q2->where('nama_kategori', 'like', "%$search%"))
                  ->orWhereHas('inputAspirasi', fn($q2) => $q2->where('lokasi', 'like', "%$search%"));
            });
        }

        if ($request->dari) $query->whereDate('tgl_aspirasi', '>=', $request->dari);
        if ($request->sampai) $query->whereDate('tgl_aspirasi', '<=', $request->sampai);

        $aspirasi = $query->get();

        $pdf = Pdf::loadView('kepsek.laporan_pdf', compact('aspirasi'));

        return $pdf->stream('laporan-aspirasi.pdf');
    }
}
