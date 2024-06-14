<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Atribut tabel
    protected $table = 'category';

    // Relasi tabel (jika ada)
   /* public function posts()
    {
        return $this->hasMany(Post::class);
    }*/
}
