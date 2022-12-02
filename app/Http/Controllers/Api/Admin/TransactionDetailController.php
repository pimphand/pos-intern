<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionDetailResource;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TransactionDetail::with('getTransaction')->latest()->paginate(5);

        return response()->json([
            'success'   => true,
            'message'   => 'Data detail transaksi berhasil ditampilkan',
            'data'      => TransactionDetailResource::collection($data),
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
        $data = $request->all();

        $validator = Validator::make($data,[
            'transaction_id'    => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => $validator->errors()
            ],401);
        }

        $noTrx  = TransactionDetail::count();

        $no     = $noTrx;
        $auto   = intval($no) + 1;
        $idTrx  = 'INV' . str_pad($auto, 6, '0', STR_PAD_LEFT);

        $product    = Product::findOrFail($request->product_id);

        $harga      = $product->price;
        $qty        = $request->qty;
        $data['no_invoice'] = $idTrx;
        $data['total']      = $harga * $qty;
        $transaction = TransactionDetail::create($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Transaksi berhasil dilakukan',
            'data'      => new TransactionDetailResource($transaction)
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
        //
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
}
