<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $guarded = ['created_at','updated_at'];
    
    public function product(){
        return $this->hasOne(Product::class);
    }
}
