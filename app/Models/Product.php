<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table= "products";
    protected $fillable = ['service_id', 'subcategory_id', 'product_name', 'price', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function service()
{
    return $this->belongsTo(Service::class);
}

    // Relationship with SubCategory
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
