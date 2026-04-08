<?php

namespace App\Models;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['created_at','updated_at'];
    
    public function product_category(){
        return $this->belongsTo(ProductCategory::class);
    }
}
