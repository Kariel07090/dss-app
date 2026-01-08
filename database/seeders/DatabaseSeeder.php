<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criterion;
use App\Models\Alternative;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Login (Opsional, biar gak capek register)
        User::create([
            'name' => 'Admin SPK',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // passwordnya: password
        ]);

        // 2. Buat Data Kriteria
        // C1: Pengalaman (Benefit), C2: Pendidikan (Benefit), C3: Jarak (Cost)
        $c1 = Criterion::create(['name' => 'Pengalaman Kerja', 'attribute' => 'benefit', 'weight' => 0.4]);
        $c2 = Criterion::create(['name' => 'Pendidikan', 'attribute' => 'benefit', 'weight' => 0.3]);
        $c3 = Criterion::create(['name' => 'Jarak Rumah', 'attribute' => 'cost', 'weight' => 0.2]);
        $c4 = Criterion::create(['name' => 'Usia', 'attribute' => 'cost', 'weight' => 0.1]);

        // 3. Buat Data Alternatif (Kandidat)
        $a1 = Alternative::create(['name' => 'Adi Saputra']);
        $a2 = Alternative::create(['name' => 'Budi Santoso']);
        $a3 = Alternative::create(['name' => 'Citra Kirana']);

        // 4. Masukkan Nilai Evaluasi (Matriks X)

        // Nilai untuk Adi
        Evaluation::create(['alternative_id' => $a1->id, 'criterion_id' => $c1->id, 'value' => 85]); // Pengalaman
        Evaluation::create(['alternative_id' => $a1->id, 'criterion_id' => $c2->id, 'value' => 70]); // Pendidikan
        Evaluation::create(['alternative_id' => $a1->id, 'criterion_id' => $c3->id, 'value' => 5]);  // Jarak (KM)
        Evaluation::create(['alternative_id' => $a1->id, 'criterion_id' => $c4->id, 'value' => 25]); // Usia

        // Nilai untuk Budi
        Evaluation::create(['alternative_id' => $a2->id, 'criterion_id' => $c1->id, 'value' => 90]);
        Evaluation::create(['alternative_id' => $a2->id, 'criterion_id' => $c2->id, 'value' => 80]);
        Evaluation::create(['alternative_id' => $a2->id, 'criterion_id' => $c3->id, 'value' => 15]);
        Evaluation::create(['alternative_id' => $a2->id, 'criterion_id' => $c4->id, 'value' => 28]);

        // Nilai untuk Citra
        Evaluation::create(['alternative_id' => $a3->id, 'criterion_id' => $c1->id, 'value' => 75]);
        Evaluation::create(['alternative_id' => $a3->id, 'criterion_id' => $c2->id, 'value' => 90]);
        Evaluation::create(['alternative_id' => $a3->id, 'criterion_id' => $c3->id, 'value' => 8]);
        Evaluation::create(['alternative_id' => $a3->id, 'criterion_id' => $c4->id, 'value' => 23]);
    }
}
