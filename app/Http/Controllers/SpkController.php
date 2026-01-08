<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Alternative;
use App\Models\Criterion;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::with('evaluations')->get();
        $criteria = Criterion::all();

        // Logika SAW
        $minMax = [];
        foreach ($criteria as $c) {
            $values = Evaluation::where('criterion_id', $c->id)->pluck('value')->toArray();
            if (!empty($values)) {
                $minMax[$c->id] = ['min' => min($values), 'max' => max($values)];
            } else {
                $minMax[$c->id] = ['min' => 0, 'max' => 0];
            }
        }

        $ranks = [];
        foreach ($alternatives as $alt) {
            $totalScore = 0;
            foreach ($criteria as $c) {
                $eval = $alt->evaluations->where('criterion_id', $c->id)->first();
                $nilai = $eval ? $eval->value : 0;

                $normalisasi = 0;
                if ($minMax[$c->id]['max'] != 0) {
                    if ($c->attribute == 'benefit') {
                        $normalisasi = $nilai / $minMax[$c->id]['max'];
                    } elseif ($c->attribute == 'cost') {
                        $normalisasi = ($nilai != 0) ? $minMax[$c->id]['min'] / $nilai : 0;
                    }
                }
                $totalScore += $normalisasi * $c->weight;
            }
            $ranks[] = ['alternative' => $alt->name, 'score' => $totalScore];
        }

        // Sorting
        usort($ranks, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return view('dashboard', compact('alternatives', 'criteria', 'ranks'));
    }

    public function storeEvaluation(Request $request)
    {
        // Validasi input
        $request->validate([
            'alternative_id' => 'required|exists:alternatives,id',
            'criteria'       => 'required|array',
        ]);

        // Loop dan simpan setiap nilai kriteria
        foreach ($request->criteria as $criterionId => $value) {
            Evaluation::updateOrCreate(
                [
                    'alternative_id' => $request->alternative_id,
                    'criterion_id'   => $criterionId,
                ],
                [
                    'value' => $value ?? 0 // Simpan 0 jika kosong
                ]
            );
        }

        // 4. Kembali ke halaman dashboard
        return redirect()->route('dashboard')->with('success', 'Penilaian berhasil disimpan!');
    }
    public function downloadPDF()
    {
        $criteria = Criterion::all();
        $alternatives = Alternative::with('evaluations')->get();

        // Hitung SAW (Logika harus sama dengan Dashboard)
        $minMax = [];
        foreach ($criteria as $c) {
            $values = Evaluation::where('criterion_id', $c->id)->pluck('value')->toArray();
            if (count($values) > 0) {
                $minMax[$c->id] = ($c->attribute == 'cost') ? min($values) : max($values);
            } else {
                $minMax[$c->id] = 0;
            }
        }

        $ranks = $alternatives->map(function ($alternative) use ($minMax, $criteria) {
            $totalScore = 0;
            foreach ($criteria as $c) {
                $eval = $alternative->evaluations->firstWhere('criterion_id', $c->id);
                $rawVal = $eval ? $eval->value : 0;
                $divisor = $minMax[$c->id] ?? 0;
                $normalized = 0;
                if ($divisor != 0) {
                    if ($c->attribute == 'cost') {
                        $normalized = ($rawVal != 0) ? ($divisor / $rawVal) : 0;
                    } else {
                        $normalized = $rawVal / $divisor;
                    }
                }
                $totalScore += $normalized * $c->weight;
            }
            $alternative->value = $totalScore;
            return $alternative;
        })->sortByDesc('value')->values();

        // Load view khusus PDF
        $pdf = Pdf::loadView('reports.ranking', compact('ranks', 'criteria'));

        return $pdf->download('Laporan-Ranking-SAW.pdf');
    }
}
