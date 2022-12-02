<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Resources\PurchaseResource;

class PurchaseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('purchase.index');

        $data = Purchase::with('getSupplier')->latest()->paginate(5);

        return response()->json([
            'success'   => true,
            'message'   => 'Data pembelian berhasil ditampilkan',
            'data'      => PurchaseResource::collection($data),
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
        $this->authorize('purchase.store');

        $data = $request->all();

        $validator = Validator::make($data,[
            'name'              => 'required|unique:purchases',
            'supplier_id'       => 'required',
            'qty'               => 'required|integer',
            'purchase_price'    => 'required',
            'additional_costs'  => 'required',
            'receipt'           => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'diskon'            => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang dimasukkan tidak sesuai'
            ],401);
        }

        $data['total'] = $data['qty'] * $data['purchase_price'] + $data['additional_costs'];

        // $data['grand_total']    = sum('total');

        if($image = $request->file('receipt')){
            $destinationPath = 'kwitansi/';
            $receiptImage    = date('Ymd').'-'.$image->getClientOriginalName();
            $image->move($destinationPath, $receiptImage);
            $data['receipt']  = $receiptImage;
        }

        $purchase = Purchase::create($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data pembelian berhasil disimpan',
            'data'      => new PurchaseResource($purchase)
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
        $this->authorize('purchase.index');
        $purchase = Purchase::findOrFail($id);

        return response()->json([
            'success'   => true,
            'message'   => 'Data pembelian berhasil ditampilkan',
            'data'      => new PurchaseResource($purchase)
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
        $this->authorize('purchase.update');

        $data = $request->all();

        $validator = Validator::make($data, [
            'name'              => 'required',
            'supplier_id'       => 'required',
            'qty'               => 'required',
            'purchase_price'    => 'required',
            'additional_costs'  => 'required',
            'receipt'           => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'diskon'            => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang dimasukkan tidak sesuai'
            ],401);
        }

        $data['total'] = $data['qty'] * $data['purchase_price'] + $data['additional_costs'];

        $purchase = Purchase::findOrFail($id);

        if($request->hasFile('receipt') && $request->file('receipt') != null){
            $imagePath = public_path().'/kwitansi/'.$purchase->receipt;
            if(File::exists($imagePath)){
                unlink($imagePath);
            }

            $image = $request->file('receipt');
            $destinationPath    = 'kwitansi/';
            $receiptImage       = date('Ymd').'-'.$image->getClientOriginalName();
            $image->move($destinationPath, $receiptImage);
            $data['receipt']    =$receiptImage;
               
        } 

        $purchase->update();
        
        return response()->json([
            'success'   => true,
            'message'   => 'Data pembelian berhasil diubah',
            'data'      => new PurchaseResource($purchase)
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
        $this->authorize('purchase.destroy');

        $purchase = Purchase::findOrFail($id);

        $receiptImage = public_path().'/kwitansi/'.$purchase->receipt;
        unlink($receiptImage);

        $purchase->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Data pembelian berhasil dihapus'
        ],200);
    }
}
