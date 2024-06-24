<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMistake extends Model
{
    use HasFactory;
    protected $table='user_mistake';
    protected $fillable=['user_id','curentStatus','description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
