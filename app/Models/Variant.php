<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $table = 'variants';

    protected $fillable = [
        'name',
        'price',
        'discount',
        'image',
        'product_id',
    ];

    public function products(){
        return $this->belongsTo(Product::class);
    }

}
