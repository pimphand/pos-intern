<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class SellingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:selling.index',['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product  = Product::all();

        return response()->json([
            'success'   => true,
            'message'   => 'Menu produk berhasil ditampilkan',
            'data'      => $product,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        if(is_null($product)){
            return response()->json([
                'success'   => false,
                'message'   => 'Data produk atau menu tidak ditemukan'
            ], 403);
        }

        return response()->json([
            'success'   => true, 
            'message'   => 'Data produk atau menu berhasil ditampilkan',
            'data'      => $product
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addToCart(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data,[
            'product_id'    => 'required|exist:product,id',
            'qty'           => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang dimasukkan tidak sesuai',
                'error'     => $validator->errors()
            ],401);
        }

        $product = Product::findOrFail($id);
        
        $carts = json_decode($request->cookie('carts'), true);

        if($carts && array_key_exists($product->id, $carts)){
            $carts[$product->id]['qty'] += $request->qty;
        } else {
            $carts[$product->id] = [
                'qty'           => $request->qty,
                'name'          => $product->name,
                'price'         => $product->price,
                'product_image' => $product->image,
            ];
        }

        $cookie = cookie('carts', json_encode($carts));

        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil dimasukkan ke keranjang',
            'data'      => $cookie,
        ],200);
    }

    public function listCart(Request $request)
    {
        $carts = json_decode(request()->cookie('carts'), true);

        $subTotal = collect($carts)->sum(function($q){
            return $q['qty'] * $q['price'];
        });

        return response()->json([
            'success'   => true,
            'message'   => 'Data kerjang berhasil ditampilkan',
            'data'      => $carts['name'],
            'sub total' => $subTotal,
        ],200);
    }
}
