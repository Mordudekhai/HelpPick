<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriterias';

    protected $fillable = [
        'nama',
        'bobot', // tetap dipertahankan
        'tipe',
    ];

    protected $casts = [
        'bobot' => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'kriteria_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */
    public function isBenefit()
    {
        return $this->tipe === 'benefit';
    }

    public function isCost()
    {
        return $this->tipe === 'cost';
    }

    /*
    |--------------------------------------------------------------------------
    | OPTIONAL (SAFE GUARD)
    |--------------------------------------------------------------------------
    */
    public function getBobotAttribute($value)
    {
        return $value ?? 0;
    }
}