<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Globalization;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $global = Globalization::index();
        $permission = Permission::all();
        return view('permission.index', compact('global', 'permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $global = Globalization::index();
        return view('permission.create', compact('global'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create($request->all());
        return redirect()->route('permission.index')->with('success', ucfirst('permission has been stored.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $global = Globalization::index();
        $permission = Permission::whereId($id)->get()->last();
        return view('permission.show', compact('global', 'permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $global = Globalization::index();
        $permission = Permission::whereId($id)->get()->last();
        return view('permission.edit', compact('global', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Permission::whereId($id)->update([
            'role_id' => $request->role_id,
            'menu_id' => $request->menu_id,
        ]);
        return redirect()->route('permission.index')->with('success', ucfirst('permission has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::whereId($id)->delete();
        return redirect()->route('permission.index')->with('success', ucfirst('permission has been deleted.'));
    }
}
