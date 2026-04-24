<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriterias';

    protected $fillable = [
        'kode',
        'nama',
        'bobot',
        'tipe',
    ];

    protected $casts = [
        'bobot' => 'float',
    ];

    /*
    |----------------------------------
    | RELATION
    |----------------------------------
    */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'kriteria_id');
    }

    /*
    |----------------------------------
    | AUTO DELETE RELASI (SAFE)
    |----------------------------------
    */
    protected static function booted()
    {
        static::deleting(function ($kriteria) {
            $kriteria->penilaians()->delete();
        });
    }

    public function isBenefit()
    {
        return $this->tipe === 'benefit';
    }

    public function isCost()
    {
        return $this->tipe === 'cost';
    }

    public function getBobotAttribute($value)
    {
        return $value ?? 0;
    }

    public function parameters()
    {
        return $this->hasMany(KriteriaParameter::class);
    }
}