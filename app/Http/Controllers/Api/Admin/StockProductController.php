<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StockProduct;
use App\Http\Resources\StockProductResource;

class StockProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('stocks-product.index');

        $data = StockProduct::with('getCategory')->latest()->paginate(5);

        return response()->json([
            'success'   => true,
            'message'   => 'Data stok produk berhasil ditampilkan',
            'data'      => StockProductResource::collection($data),
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
        $this->authorize('stocks.store');

        $data = $request->all();

        $validator = Validator::make($data,[
            'name'              => 'required',
            'stock'             => 'required',
            'selling_price'     => 'required',
            'purchase_price'    => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang diisi tidak sesuai',
            ],400);
        }

        $data['margin'] = $request->selling_price - $request->purchase_price;
        $stockProduct = StockProduct::create($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data stock produk berhasil ditambah',
            'data'      => new StockProductResource($stockProduct),
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
        $this->authorize('stocks.index');

        $data = StockProduct::with('getCategory')->findOrFail($id);

        return response()->json([
            'success'   => true,
            'message'   => 'Data stok produk berhasil ditampilkan',
            'data'      => new StockProductResource($data)
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
        $this->authorize('stocks.update');

        $data = $request->all();

        $validator = Validator::make($data,[
            'name'              => 'required',
            'stock'             => 'required',
            'selling_price'     => 'required',
            'purchase_price'    => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda masukkan tidak sesuai',
            ],400);
        }

        $data['margin'] = $request->selling_price - $request->purchase_price;
        $stockProduct = StockProduct::findOrFail($id);
        $stockProduct->update($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data stok produk berhasil diubah',
            'data'      => new StockProductResource($stockProduct)
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
        $this->authorize('stocks.destroy');

        $stockProduct = StockProduct::findOrFail($id);
        $stockProduct->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Data stok produk berhasil di hapus',
        ],200); 
    }
}
