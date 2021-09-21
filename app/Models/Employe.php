<?php

namespace App\Models;

use App\Models\User;
use App\Models\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['position_id', 'user_id', 'name', 'birthdate', 'gender', 'image'];
    public function user()
    {
        return $this->belongsTo(User::class,);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
