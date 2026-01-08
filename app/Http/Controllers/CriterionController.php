<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public function index()
    {
        $criteria = Criterion::all();
        return view('criteria.index', compact('criteria'));
    }

    public function create()
    {
        return view('criteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'weight' => 'required|numeric',
            'attribute' => 'required|in:benefit,cost',
        ]);

        Criterion::create($request->all());
        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function edit(Criterion $criterion)
    {
        return view('criteria.edit', compact('criterion'));
    }

    public function update(Request $request, Criterion $criterion)
    {
        $request->validate([
            'name' => 'required',
            'weight' => 'required|numeric',
            'attribute' => 'required|in:benefit,cost',
        ]);

        $criterion->update($request->all());
        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil diupdate!');
    }

    public function destroy(Criterion $criterion)
    {
        $criterion->delete();
        return redirect()->route('criteria.index')->with('success', 'Kriteria dihapus!');
    }
}
