<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Department;
use App\Models\Applyleave;
use App\Models\leaveBalances;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
    public function Applyleave()
    {
        return $this->hasMany(Applyleave::class);
    }

    public function isEmployee()
    {
        return $this->role_as === 0;
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
    
    protected $table = 'users';

    protected $fillable = [
        'emplpyeeid',
        'department_id',
        'name',
        'last_name',
        'gender',
        'phone',
        'role_as',
        'email',
        'password',
        'profile_picture',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            DB::insert('INSERT INTO leave_balances (user_id, tahun, jatah_cuti, carry_over, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [
                $user->id,
                date('Y'),
                12,  // jatah cuti default
                0,   // carry over
                now(),
                now(),
            ]);
        });
    }


}

