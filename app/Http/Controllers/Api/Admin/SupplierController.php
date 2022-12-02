<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplierData = Supplier::latest()->paginate(5);

        return response()->json([
            'success'   => true,
            'message'   => 'Data supplier berhasil ditampilkan',
            'data'      => SupplierResource::collection($supplierData),
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
        $data   = $request->all();

        $validator = Validator::make($data, [
            'name'      => 'required',
            'address'   => 'required',
            'phone'     => 'required|numeric',
            'status'    => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda masukkan tidak sesuai',
            ],401);

        }

        $supplierData = Supplier::create($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data supplier berhasil di simpan',
            'data'      => new SupplierResource($supplierData)
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
        $supplierData = Supplier::findOrFail($id);

        return response()->json([
            'success'   => true,
            'message'   => 'Data supplier berhasil ditampilkan',
            'data'      => new SupplierResource($supplierData)
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
        $supplierData = Supplier::findOrFail($id);

        $data = $request->all();

        $validator = Validator::make($data, [
            'name'      => 'required',
            'address'   => 'required',
            'phone'     => 'required|number',
            'status'    => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda masukkan tidak sesuai',
            ]);
        }
        
        $supplierData->update($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data supplier berhasil diubah'
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
        $supplierData = Supplier::findOrFail($id);
        $supplierData->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Data supplier berhasil dihapus'
        ],200);
    }
}
