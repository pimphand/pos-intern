<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('product.index');

        $data = Product::with('getCategory')->latest()->paginate(5);

        return response()->json([
            'success'    => true,
            'message'    => "Daftar produk ditampilkan",
            'data'       => ProductResource::collection($data),
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('product.store');

        $data = $request->all();

        $validator = Validator::make($data,[
            'image'           => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'name'            => 'required',
            'size'            => 'required',
            'stock'           => 'required',
            'price'           => 'required',
            'description'     => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda masukkan tidak sesuai',
                'error'     => $validator->errors()
            ],401);
        }

        if($image = $request->file('image')){
            $destinationPath     = 'product/';
            $productImage        = date('Ymd').'-'.$image->getClientOriginalName();
            $image->move($destinationPath, $productImage);
            $data['image']      = $productImage;
        } 

        $product = Product::create($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Produk berhasil ditambahkan',
            'data'      => new ProductResource($product)
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('product.index');

        $product = Product::findOrFail($id);

        return response()->json([
            'success'   => true,
            'message'   => 'Detail produk berhasil ditampilkan',
            'data'      => new ProductResource($product)
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('product.update');

        $data = $request->all();

        $validator = Validator::make($data,[
            'image'           => 'image|mimes:jpg,jpeg,png|max:2048',
            'name'            => 'required',
            'size'            => 'required',
            'stock'           => 'required',
            'price'           => 'required',
            'description'     => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda masukkan tidak sesuai',
                'error'     => $validator->errors()
            ],400);
        }

        $product = Product::findOrFail($id);

        if($request->hasFile('image') && $request->file('image') != null){

            $image_path = public_path().'/product/'.$product->image;
            if(File::exists($image_path)){
                unlink($image_path);
            }

            $image = $request->file('image');
            $destinationPath     = 'product/';
            $productImage        = date('Ymd').'-'.$image->getClientOriginalName();
            $image->move($destinationPath, $productImage);
            $data['image']      = $productImage;

        } 

        $product->update($data);
        return response()->json([
                'success'   => true,
                'message'   => 'Data produk berhasil diubah',
                'data'      => new ProductResource($product),
            ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('product.destroy');

        $product = Product::findOrFail($id);
        $image_path = public_path().'/product/'.$product->image;
        unlink($image_path);
        $product->delete();
        
        return response()->json([
            'success'   => true,
            'message'   => 'Data produk berhasil dihapus'
        ]);
    }
}
