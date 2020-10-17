<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
         ]);
         
         $user= User::create($data);
 
 
         if ($request->has('role')) {
             $user->assignRole($request->role['name']);
         }
 
         if ($request->has('permissions')) {
             $user->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
         }
 
         return response(['message'=>'User Created', 'user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        if($request->has('password')) {
            $data['password'] = 'confirmed|min:6';
        }
        
        $user->update($data);

        if ($request->has('role')) {
            $user->syncRoles($request->role['name']);
        }
        
        if ($request->has('permissions')) {
            // return response(['permissions' => dd(collect($request->permissions)->pluck('id')->toArray())]);
            $user->syncPermissions(collect($request->permissions)->pluck('id')->toArray());
        }

        return response(['message'=>'User Updated', 'user'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }
}
