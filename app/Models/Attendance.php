<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'in', 'permission', 'out', 'desc'];


    public function user()
    {
        $this->hasMany(User::class);
    }
}
