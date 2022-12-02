<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Arr;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('users.index');

        $data = User::with('roles')->latest()->paginate(5);

        return response()->json([
            'success'   => true,
            'message'   => 'Data User berhasil ditampilkan',
            'data'      => UserResource::collection($data),
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
        $this->authorize('users.store');

        $data = $request->all();

        $validator = Validator::make($data,[
            'name'      => 'required',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|min:8',
            'roles'     => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda input tidak sesuai',
                'error'     => $validator->errors(),
            ],400);
        }

        $data['password']   = bcrypt($request->password);


        $user = User::create($data);
        $user->assignRole($request->input('roles'));

        return response()->json([
            'success'   => true,
            'message'   => 'Data user berhasil ditambahkan',
            'data'      => new UserResource($user),
            
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
        $this->authorize('users.index');

        $user = User::with('roles')->findOrFail($id);
        
        return response()->json([
            'success'   => true,
            'message'   => 'Data user ditampilkan',
            'data'      => new UserResource($user),
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
        $this->authorize('uses.update');

        $data = $request->all();

        $validator = Validator::make($data,[
            'name'      => 'required',
            'email'     => 'required|string|email|',
            'password'  => 'required|string|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda masukkan tidak sesuai',
                'error'     => $validator->errors()
            ],400);
        }

        if(!empty($data['password'])){
            $data['password']   = bcrypt($data['password']);
        } else {
            $data = Arr::except($data,array('password'));
        }

        $user = User::findOrFail($id);
        $user->syncRoles($request->input('roles'));
        $user->update($data);

        return response()->json([
            'success'   => true,
            'message'   => 'Data user berhasil diperbarui',
            'data'      => new UserResource($user),
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
        $this->authorize('users.destroy');
        
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Data user berhasil dihapus'
        ],200);
    }
}
