<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'category_id',
        'seller_id',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
        
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    
}
