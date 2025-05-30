<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tahun',
        'jatah_cuti',
        'carry_over',
        'cuti_terpakai',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hitung sisa cuti total untuk tahun ini
     * Dengan logika: carry over hanya berlaku sampai akhir April
     */
    public function getSisaCutiAttribute()
    {
        $tahunIni = now()->year;
        $sekarang = now();

        $carryOver = ($this->tahun == $tahunIni && $sekarang->lte(now()->copy()->setDate($tahunIni, 4, 30)))
            ? $this->carry_over
            : 0;

        return max(0, ($this->jatah_cuti + $carryOver) - $this->cuti_terpakai);
    }
}
