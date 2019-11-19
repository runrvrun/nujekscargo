<?php

namespace App\Http\Controllers;

use App\Role;
use App\Page;
use App\Role_privilege;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
 
    public function privilege($role_id = null)
    {
        $pages = Page::all();
        return view('role.privilege', compact('pages','role_id'));
    }

    public function privilegesave(Request $request)
    {
        $role_id = $request->role_id;
        Role_privilege::where('role_id',$role_id)->delete();
        foreach($request->priv as $key=>$val){
            $requestData = ['role_id'=>$role_id,'page_id'=>$key];            
            $requestData = array_merge($requestData,$val);
            Role_privilege::create($requestData);
        }
        $pages = Page::all();
        return redirect('role/'.$role_id);
    }

    public function privilegejson($role_id){
        return Role_privilege::where('role_id',$role_id)->get();
    }
}
