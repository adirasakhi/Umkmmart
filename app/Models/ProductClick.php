<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductClick extends Model
{
    use HasFactory;
    protected $table='product_clicks';
    protected $fillable=['id','product_id','device_id','clicked_at'];
}
