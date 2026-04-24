<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaParameter extends Model
{
    protected $fillable = [
        'kriteria_id',
        'label',
        'min_value',
        'max_value',
        'score',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}