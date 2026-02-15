<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    // ================= Dashboard Admin =================
    public function dashboard(Request $request)
    {
        $query = Siswa::query();

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nisn', 'like', "%$search%")
                  ->orWhere('nama', 'like', "%$search%")
                  ->orWhere('kelas', 'like', "%$search%")
                  ->orWhere('jurusan', 'like', "%$search%");
            });
        }

        $siswa = $query->orderBy('nama', 'asc')->get();

        return view('admin.siswa', compact('siswa'));
    }

    // ================= Dashboard Siswa =================
    public function siswaDashboard()
    {
        $kategori = Kategori::all();

        if (Auth::check()) {
            // Ambil aspirasi milik siswa login
            $nisn = Auth::user()->nisn;
            $aspirasi = Aspirasi::with(['inputAspirasi.kategori', 'inputAspirasi.siswa'])
                ->whereHas('inputAspirasi', fn($q) => $q->where('nisn', $nisn))
                ->latest()
                ->get();
        } else {
            // Ambil semua aspirasi jika belum login
            $aspirasi = Aspirasi::with(['inputAspirasi.kategori'])->latest()->get();
        }

        return view('siswa.dashboard', compact('kategori', 'aspirasi'));
    }

    // ================= CRUD Siswa =================
    public function store(Request $request)
    {
        $request->validate([
            'nisn'     => 'required|max:10|unique:siswa,nisn|unique:users,username',
            'nama'     => 'required',
            'kelas'    => 'required',
            'jurusan'  => 'required',
            'password' => 'required|min:6',
        ]);

        try {
            DB::beginTransaction();

            // Simpan ke tabel siswa
            $siswa = Siswa::create([
                'nisn'     => $request->nisn,
                'nama'     => $request->nama,
                'kelas'    => $request->kelas,
                'jurusan'  => $request->jurusan,
                'password' => Hash::make($request->password),
            ]);

            // Simpan ke tabel users
            User::create([
                'username' => $request->nisn,
                'password' => Hash::make($request->password),
                'nama'     => $request->nama,
                'role'     => 'siswa',
                'nisn'     => $siswa->nisn,
            ]);

            DB::commit();
            return back()->with('success', 'Siswa & akun login berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data ke dua tabel');
        }
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nisn'     => 'required|max:10|unique:siswa,nisn,' . $siswa->id,
            'nama'     => 'required',
            'kelas'    => 'required',
            'jurusan'  => 'required',
            'password' => 'nullable|min:6',
        ]);

        try {
            DB::beginTransaction();

            // Update siswa
            $siswa->update([
                'nisn'     => $request->nisn,
                'nama'     => $request->nama,
                'kelas'    => $request->kelas,
                'jurusan'  => $request->jurusan,
                'password' => $request->filled('password') ? Hash::make($request->password) : $siswa->password,
            ]);

            // Update user
            User::where('nisn', $siswa->nisn)->update([
                'username' => $request->nisn,
                'nama'     => $request->nama,
                'password' => $request->filled('password')
                    ? Hash::make($request->password)
                    : User::where('nisn', $siswa->nisn)->value('password'),
            ]);

            DB::commit();
            return back()->with('success', 'Data siswa & user berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update data');
        }
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        try {
            DB::beginTransaction();

            // Hapus user
            User::where('nisn', $siswa->nisn)->delete();

            // Hapus siswa
            $siswa->delete();

            DB::commit();
            return back()->with('success', 'Siswa & akun login berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data');
        }
    }

    // ================= Aspirasi Siswa =================
    public function storeAspirasi(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'lokasi'      => 'required',
            'keterangan'  => 'required',
        ]);

        $nisn = Auth::user()->nisn;

        $input = InputAspirasi::create([
            'nisn'        => $nisn,
            'kategori_id' => $request->kategori_id,
            'lokasi'      => $request->lokasi,
            'keterangan'  => $request->keterangan,
            'tgl_input'   => now(),
        ]);

        Aspirasi::create([
            'inputaspirasi_id' => $input->id,
            'status'           => 'menunggu',
            'tgl_aspirasi'     => now(),
        ]);

        return back()->with('success', 'Aspirasi berhasil dikirim');
    }

    // ================= Import Excel =================
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $data = Excel::toArray([], $request->file('file'));

        foreach ($data[0] as $row) {
            if ($row[0] == 'nisn') continue; // skip header

            // Simpan siswa
            Siswa::create([
                'nisn'     => $row[0],
                'nama'     => $row[1],
                'kelas'    => $row[2],
                'jurusan'  => $row[3],
                'password' => Hash::make($row[4]),
            ]);

            // Simpan user login
            User::create([
                'username' => $row[0],
                'nama'     => $row[1],
                'password' => Hash::make($row[4]),
                'role'     => 'siswa',
                'nisn'     => $row[0],
            ]);
        }

        return back()->with('success', 'Import Excel berhasil');
    }
}
