<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    // Menampilkan halaman data
    public function index()
    {
        // Menggunakan pagination 10 data per halaman
        $alternatives = Alternative::paginate(10);
        return view('alternatives.index', compact('alternatives'));
    }

    // Menyimpan data baru (Create)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Alternative::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Kandidat berhasil ditambahkan!');
    }

    // Mengupdate data (Edit) - INI YANG ANDA CARI
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $alternative = Alternative::findOrFail($id);
        $alternative->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Data kandidat berhasil diperbarui!');
    }

    // Menghapus data (Delete)
    public function destroy($id)
    {
        $alternative = Alternative::findOrFail($id);

        // Hapus juga nilai evaluasi terkait agar database bersih (Opsional, jika sudah di-cascade di migration tidak perlu)
        $alternative->evaluations()->delete();
        $alternative->delete();

        return redirect()->back()->with('success', 'Kandidat berhasil dihapus!');
    }
    public function deleteAll()
    {
        \App\Models\Alternative::query()->delete();
        return redirect()->back()->with('success', 'Semua data kandidat berhasil dihapus!');
    }
}
