<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OrderCategoryResource;

class OrderCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = OrderCategory::latest()->paginate(5);

        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori pemesanan berhasil ditampilkan',
            'data'      => OrderCategoryResource::collection($data)
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
            'name'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data wajib di isi!'
            ],401);
        }

        $orderCategory = OrderCategory::create($data);


        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori pemesanan berhasil disimpan',
            'data'      => new OrderCategoryResource($orderCategory)
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
        $orderCategory = OrderCategory::findOrFail($id);

        if(is_null($orderCategory)){
            return response()->json([
                'success'   => false,
                'message'   => 'Data kategori pemesanan tidak ditemukan'
            ],401);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori pemesanan berhasil ditampilkan',
            'data'      => new OrderCategoryResource($orderCategory)
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
        $orderCategory = OrderCategory::findOrFail($id);


        $data = $request->all();

        $validator = Validator::make($data,[
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data wajib di isi'
            ],401);
        }

        $orderCategory->update($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori pemesanan berhasil di perbarui',
            'data'      => new OrderCategoryResource($orderCategory),
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
        $orderCategory = OrderCategory::findOrFail($id);
        $orderCategory->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori pemesanan berhasil di hapus'
        ]);
    }
}
