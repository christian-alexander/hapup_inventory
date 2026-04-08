<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(){
        $data['product_category'] = ProductCategory::all() ;
        return view('product.index', $data);
    }

    public function getServersideDatatable(){
        $products = Product::with('product_category')->select(['id','product_category_id','name', 'price', 'stock']);
        
        return DataTables::of($products)
            ->addColumn('category_name', function($product){
                return $product->product_category->name;
            })
            ->addColumn('action', function($product){
                return '
                    <button class="btn btn-sm btn-primary edit-btn" onclick="showEditProductModal('.$product->id.')"><i class="fa fa-edit"></i> Ubah</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$product->id.'"><i class="fa fa-trash"></i> Hapus</button>
                ';
            })
            ->editColumn('price', function($product){
                return 'Rp ' . number_format($product->price, 0, ',', '.');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getProductById(Request $request, $id){
        $response = ['success' => false, 'msg' => 'Data tidak ditemukan'];
        $product = Product::find($id);
        if($product !== null){
            $response['success'] = true;
            $response['msg'] = 'Data ditemukan';
            $response['data'] = $product;
        }
        return response()->json($response);
    }

    public function store(Request $request){
        $response = ['success' => false, 'msg' => 'Ada kesalahan, harap coba lagi'];

        $rules = [
            'name' => 'required',
            'product_category_id' => 'required|numeric|exists:product_categories,id',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1'
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response['success'] = false;
            $response['msg'] = $validator->messages();
            return response()->json($response);
        }

        Product::create([
            'name' => $request->name,
            'product_category_id' => $request->product_category_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        $response['success'] = true;
        $response['msg'] = 'Berhasil tambah produk';

        return response()->json($response);
    }

    public function update(Request $request, $id){
        $response = ['success' => false, 'msg' => 'Ada kesalahan, harap coba lagi'];

        $rules = [
            'name' => 'required',
            'product_category_id' => 'required|numeric|exists:product_categories,id',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1'
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response['success'] = false;
            $response['msg'] = $validator->messages();
            return response()->json($response);
        }

        Product::find($id)->update([
            'name' => $request->name,
            'product_category_id' => $request->product_category_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        $response['success'] = true;
        $response['msg'] = 'Berhasil ubah produk';

        return response()->json($response);
    }

}
