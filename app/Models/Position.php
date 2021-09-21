<?php

namespace App\Models;

use App\Models\Employe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'gaji'];

    public function employe()
    {
        return $this->hasMany(Employe::class);
    }
}
