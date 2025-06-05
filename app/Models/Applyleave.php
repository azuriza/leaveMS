<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leavetype;
use App\Models\User;

class Applyleave extends Model
{
    use HasFactory;

    public function leavetype()
    {
        return $this->belongsTo(Leavetype::class,'leave_type_id');
    }
    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }  
    public function Handover()
    {
        return $this->belongsTo(User::class,'handover_id');
    } 
    public function Handover2()
    {
        return $this->belongsTo(User::class, 'handover_id_2');
    }

    public function Handover3()
    {
        return $this->belongsTo(User::class, 'handover_id_3');
    }

    protected $table ='applyleaves';

    protected $fillable = [
        'user_id',
        'leave_type_id',
        'description',
        'leave_from',
        'leave_to',
        'status',
        'handover_id'        
    ];
  
}
