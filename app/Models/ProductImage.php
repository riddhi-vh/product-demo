<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];

    public $table = 'product_images';
    public $fillable = ['p_id','p_image'];
}
