<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(){
        return view('product.index');
    }

    public function getServersideDatatable()
    {
        $products = Product::with('product_category')->select(['id','product_category_id','name', 'price', 'stock']);
        
        return DataTables::of($products)
            ->addColumn('category_name', function($product){
                return $product->product_category->name;
            })
            ->addColumn('action', function($product){
                return '
                    <button class="btn btn-sm btn-primary edit-btn" data-id="'.$product->id.'"><i class="fa fa-pencil"></i> Ubah</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$product->id.'"><i class="fa fa-trash"></i> Hapus</button>
                ';
            })
            ->editColumn('price', function($product){
                return 'Rp ' . number_format($product->price, 2);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
