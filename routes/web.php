<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\AlternativeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator; // Tambahan untuk pagination
use Illuminate\Pagination\LengthAwarePaginator; // Tambahan untuk pagination

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/download-pdf', [SpkController::class, 'downloadPDF'])->name('download.pdf');
    // 1. Dashboard Utama (SPK) dengan Pagination Ganda
    Route::get('/dashboard', function () {
        $criteria = \App\Models\Criterion::all();

        // 1. DATA UNTUK RANKING (Ambil SEMUA agar perhitungan akurat)
        $allAlternatives = \App\Models\Alternative::with('evaluations')->get();

        // --- LOGIKA SAW (Pakai $allAlternatives) ---
        $minMax = [];
        // 1. Mencari Nilai Min/Max untuk Normalisasi
        foreach ($criteria as $c) {
            $values = \App\Models\Evaluation::where('criterion_id', $c->id)->pluck('value')->toArray();
            if (count($values) > 0) {
                $minMax[$c->id] = ($c->attribute == 'cost') ? min($values) : max($values);
            } else {
                $minMax[$c->id] = 0;
            }
        }
        // 2. Perhitungan Normalisasi dan Skor Akhir
        $ranks = $allAlternatives->map(function ($alternative) use ($minMax, $criteria) {
            $totalScore = 0;
            foreach ($criteria as $c) {
                $eval = $alternative->evaluations->firstWhere('criterion_id', $c->id);
                $rawVal = $eval ? $eval->value : 0;
                $divisor = $minMax[$c->id] ?? 0;
                // Rumus Normalisasi
                $normalized = 0;
                if ($divisor != 0) {
                    if ($c->attribute == 'cost') {
                        $normalized = ($rawVal != 0) ? ($divisor / $rawVal) : 0;
                    } else {
                        $normalized = $rawVal / $divisor;
                    }
                }
                // Perhitungan Skor Akhir (Normalisasi * Bobot)
                $totalScore += $normalized * $c->weight;
            }
            $alternative->value = $totalScore;
            return $alternative;
        })->sortByDesc('value')->values();

        // --- MANUAL PAGINATION UNTUK TABEL RANKING (BARU) ---
        // Kita gunakan parameter 'rank_page' agar tidak bentrok dengan tabel input
        $rankPageName = 'rank_page';
        $currentRankPage = Paginator::resolveCurrentPage($rankPageName);
        $perPageRanking = 10; // Jumlah baris hasil ranking per halaman

        $currentRankItems = $ranks->slice(($currentRankPage - 1) * $perPageRanking, $perPageRanking)->all();
        $paginatedRanks = new LengthAwarePaginator(
            $currentRankItems,
            $ranks->count(),
            $perPageRanking,
            $currentRankPage,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $rankPageName,
            ]
        );

        // 2. DATA UNTUK TABEL INPUT (Gunakan 'input_page' agar independen)
        $alternatives = \App\Models\Alternative::with('evaluations')->paginate(10, ['*'], 'input_page');

        return view('dashboard', compact('ranks', 'paginatedRanks', 'alternatives', 'criteria'));
    })->middleware(['auth', 'verified'])->name('dashboard');

    // 2. CRUD Data Kriteria
    Route::resource('criteria', CriterionController::class);

    // 3. CRUD Data Alternatif
    Route::resource('alternatives', AlternativeController::class);

    // 4. Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 5. Simpan Penilaian
    Route::post('/evaluation', [SpkController::class, 'storeEvaluation'])
        ->name('evaluation.store')
        ->middleware(['auth', 'verified']);
});

require __DIR__ . '/auth.php';
