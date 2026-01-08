<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'attribute', 'weight'];

    // Relasi ke evaluation (jika nanti dibutuhkan)
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
