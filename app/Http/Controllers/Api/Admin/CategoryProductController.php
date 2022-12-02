<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryProductResource;

class CategoryProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('categories-product.index');

        $data = CategoryProduct::latest()->paginate(5);

        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori produk ditampilkan',
            'data'      => CategoryProductResource::collection($data),
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
        $this->authorize('categories-product.store');
        $data = $request->all();

        $validator = Validator::make($data,[
            'name'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data wajib di isi'
            ],401);
        }

        $category = CategoryProduct::create($data);
        
        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil disimpan',
            'data'      => new CategoryProductResource($category),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('categories-product.index');

        $category = CategoryProduct::findOrFail($id);

        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori berhasil ditampilkan',
            'data'      => new CategoryProductResource($category)
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
        $this->authorize('categories-product.update');

        $data = $request->all();

        $validator = Validator::make($data,[
            'name'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data wajib di isi'
            ],401);
        }

        $category = CategoryProduct::findOrFail($id);
        $category->update($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori berhasil diperbarui',
            'data'      => new CategoryProductResource($category)
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
        $this->authorize('categories-product.destroy');

        $category = CategoryProduct::findOrFail($id);

        $category->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Data kategori berhasil dihapus'
        ],200);
    }
}
