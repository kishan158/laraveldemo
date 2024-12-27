<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table= "sub_categories";
    protected $fillable = [
        'product_type',
       
        'image',
    ];

    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function products()
{
    return $this->hasMany(Product::class); // A SubCategory can have many Products
}
}
