<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aspirasi;
use App\Models\Feedback;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
     public function dashboard()
{
    $totalAspirasi = Aspirasi::count();

    $menunggu = Aspirasi::where('status', 'menunggu')->count();

    $proses = Aspirasi::where('status', 'proses')->count();

    $selesai = Aspirasi::where('status', 'selesai')->count();

    return view('admin.dashboard', compact(
        'totalAspirasi',
        'menunggu',
        'proses',
        'selesai'
    ));
}

    /* ================= KATEGORI ================= */
    public function kategori(Request $request)
{
    $query = Kategori::query();

    // SEARCH
    if ($request->search) {

        $search = $request->search;

        $query->where('nama_kategori', 'like', "%$search%");
    }

    $kategori = $query->orderBy('nama_kategori', 'asc')->get();

    return view('admin.kategori', compact('kategori'));
}


    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $id
        ]);

        Kategori::findOrFail($id)->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroyKategori($id)
    {
        Kategori::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }
    
public function aspirasi(Request $request)
{
    $search = $request->input('search');

    $query = Aspirasi::with([
        'inputAspirasi.siswa',
        'inputAspirasi.kategori',
        'feedback'
    ])->where('status', 'menunggu'); // hanya yang status menunggu

    // Jika ada search, filter data
    if($search){
        $query->where(function($q) use ($search) {
            // Cari di kolom relasi siswa
            $q->whereHas('inputAspirasi.siswa', function($q2) use ($search) {
                $q2->where('nama', 'like', "%{$search}%");
            });
              $q->whereHas('inputAspirasi.siswa', function($q3) use ($search) {
                $q3->where('nisn', 'like', "%{$search}%");
            });
            // Cari di kolom relasi kategori
            $q->orWhereHas('inputAspirasi.kategori', function($q2) use ($search) {
                $q2->where('nama_kategori', 'like', "%{$search}%");
            });
             $q->orWhereHas('inputAspirasi', function($q2) use ($search) {
                $q2->where('keterangan', 'like', "%{$search}%");
            });
            // Cari di kolom inputAspirasi lainnya, misal lokasi
            $q->orWhereHas('inputAspirasi', function($q2) use ($search) {
                $q2->where('lokasi', 'like', "%{$search}%");
            });
        });
    }

    $aspirasi = $query->latest()->get();

    return view('admin.aspirasi', compact('aspirasi'));
}


    // ==================== PENGGUNA ====================
    public function pengguna(Request $request)
{
    $query = User::query();

    // SEARCH
    if ($request->search) {

        $search = $request->search;

        $query->where('nama', 'like', "%$search%")
              ->orWhere('username', 'like', "%$search%")
              ->orWhere('nisn', 'like', "%$search%")
              ->orWhere('role', 'like', "%$search%");
    }

    $users = $query->orderBy('nama', 'asc')->get();

    return view('admin.pengguna', compact('users'));
}


    public function storePengguna(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'nama'     => 'required',
            'password' => 'required|min:6',
            'role'     => 'required|in:siswa,admin,kepsek',
        ]);

        User::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function updatePengguna(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'nama'     => 'required',
            'role'     => 'required|in:siswa,admin,kepsek',
        ]);

        $user->username = $request->username;
        $user->nama     = $request->nama;
        $user->role     = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroyPengguna($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
    }
    public function showAspirasi($id)
{
    $aspirasi = Aspirasi::with([
        'inputAspirasi.siswa',
        'inputAspirasi.kategori'
    ])->findOrFail($id);

    return view('admin.detail_aspirasi', compact('aspirasi'));
}
    public function destroyAspirasi($id)
{
    Aspirasi::findOrFail($id)->delete();

    return back()->with('success','Aspirasi berhasil dihapus');
}
public function feedback(Request $request, $id)
{
    $request->validate([
        'isi_feedback' => 'required',
        'status'       => 'required'
    ]);

    $aspirasi = Aspirasi::findOrFail($id);

    Feedback::create([
        'aspirasi_id'  => $aspirasi->id,
        'user_id'      => auth()->user()->id,
        'isi_feedback' => $request->isi_feedback,
        'status'       => $request->status
    ]);

    // **Update status aspirasi**
    $aspirasi->status = $request->status;
    $aspirasi->save();

    return back()->with('success', 'Feedback berhasil dikirim');
}




   public function feedbackList()
{
    $feedbacks = Feedback::with([
        'aspirasi.inputAspirasi.siswa',
        'aspirasi.inputAspirasi.kategori'
    ])
    ->whereHas('aspirasi', function($q){
        $q->where('status', 'proses'); // hanya aspirasi yang status proses
    })
    ->latest()
    ->get();

    return view('admin.feedback', compact('feedbacks'));
}


public function history()
{
   $aspirasi = Aspirasi::with([
        'inputAspirasi.siswa',
        'inputAspirasi.kategori',
        'feedback.user'
    ])
    ->where('status', 'selesai') // 🔥 FILTER DI SINI
    ->get();


    return view('admin.history', compact('aspirasi'));
}

public function laporan(Request $request)
{
    // Eager load relasi
    $query = Aspirasi::with([
        'inputaspirasi.siswa',
        'inputaspirasi.kategori',
        'feedback.user'
    ]);

    // Filter search
    if ($request->search) {
        $search = $request->search;

        $query->where(function($q) use ($search) {
            $q->whereHas('inputaspirasi.siswa', function($q2) use ($search) {
                $q2->where('nama', 'like', "%$search%");
            })
            ->orWhereHas('inputaspirasi.kategori', function($q2) use ($search) {
                $q2->where('nama_kategori', 'like', "%$search%");
            })
            ->orWhereHas('inputaspirasi', function($q2) use ($search) {
                $q2->where('lokasi', 'like', "%$search%")
                   ->orWhere('keterangan', 'like', "%$search%");
            });
        });
    }

    // Filter tanggal
    if ($request->dari) {
        $query->whereDate('tgl_aspirasi', '>=', $request->dari);
    }
    if ($request->sampai) {
        $query->whereDate('tgl_aspirasi', '<=', $request->sampai);
    }

    $aspirasi = $query->latest()->get();

    return view('admin.laporan', compact('aspirasi'));
}

public function laporanPdf(Request $request)
{
    $query = Aspirasi::with([
        'inputAspirasi.siswa',
        'inputAspirasi.kategori'
    ]);

    // SEARCH
    if ($request->search) {

        $search = $request->search;

        $query->whereHas('inputAspirasi.siswa', function($q) use ($search) {
            $q->where('nama', 'like', "%$search%");
        })
        ->orWhereHas('inputAspirasi.kategori', function($q) use ($search) {
            $q->where('nama_kategori', 'like', "%$search%");
        })
        ->orWhereHas('inputAspirasi', function($q) use ($search) {
            $q->where('lokasi', 'like', "%$search%");
        });

    }

    if ($request->dari) {
        $query->whereDate('tgl_aspirasi', '>=', $request->dari);
    }

    if ($request->sampai) {
        $query->whereDate('tgl_aspirasi', '<=', $request->sampai);
    }

    $aspirasi = $query->get();

    $pdf = Pdf::loadView('admin.laporan_pdf', compact('aspirasi'));

    return $pdf->stream('laporan-aspirasi.pdf');
}
}


