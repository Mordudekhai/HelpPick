<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hasil extends Model
{
    use HasFactory;

    protected $table = 'hasils';

    protected $fillable = [
        'alternatif_id',
        'skor',
        'ranking',
    ];

    protected $casts = [
        'skor' => 'float',
        'ranking' => 'integer',
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }
}