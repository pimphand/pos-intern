<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('roles.index');

        $data = Role::with('permissions')->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data role berhasil ditampilkan',
            'data'      => RoleResource::collection($data),
        ],201);
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
        $this->authorize('roles.store');

        $data = $request->all();

        $validator = Validator::make($data, [
            'name'          => 'required|unique:roles,name',
            'permission'    => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda inputkan sudah ada atau data tidak sesuai',
            ],401);
        }

        

        $role = Role::create($data);
        $role->givePermissionTo($request->input('permission'));
        // $role->syncPermission($request->input('permission'));


        return response()->json([
            'success'   => true,
            'message'   => 'Data role berhasil disimpan',
            'data'      => new RoleResource($role)
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
        $this->authorize('roles.index');
        $role = Role::findOrFail($id);
        $rolePermissions = Permission::join('role_has_permissions','role_has_permissions.permission_id', '=' , 'permission_id')
            ->where('role_has_permissions.role_id', $id)
            ->get();


        return response()->json([
            'success'       => true,
            'message'       => 'Data role berhasil ditampilkan',
            'data'          => $role,
            'permission'    => new RoleResource($role)
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
        $this->authorize('roles.update');
        $data        = $request->all();
        $validator   = Validator::make($data,[
            'name'          => 'required',
            // 'permissions'    => 'required',
        ]); 

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data harus diisi'
            ]);
        }

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->syncPermissions($request->input('permissions'));
        $role->save();


        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil di perbarui',
            'data'      => $role,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('roles.destroy');

        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Data berhasil dihapus'
        ]);
    }
}
