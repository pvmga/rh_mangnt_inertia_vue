<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamentos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function user()
    {

        // 1 departamento pode ter varios usuários
        return $this->belongsToMany(User::class);
    }
}
