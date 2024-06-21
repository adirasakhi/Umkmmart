<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $table='social_media';
    protected $fillable=['id','user_id','facebook','whatsapp','instagram','tiktok'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
