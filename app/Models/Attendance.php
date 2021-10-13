<?php

namespace App\Models;

use App\Models\Employe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['employe_id', 'in', 'permission', 'out', 'desc', 'attended_at'];


    public function employe()
    {
        return $this->hasMany(Employe::class);
    }
}
