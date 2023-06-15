<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Globalization;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $global = Globalization::index();
        $user = User::all();
        return view('user.index', compact('global', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $global = Globalization::index();
        return view('user.create', compact('global'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['password' => User::hashPassword($request)]);
        User::create($request->all());
        return redirect()->route('user.index')->with('success', ucfirst('user has been stored.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $global = Globalization::index();
        $user = User::whereId($id)->get()->last();
        return view('user.show', compact('global', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $global = Globalization::index();
        $user = User::whereId($id)->get()->last();
        return view('user.edit', compact('global', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        User::whereId($id)->update([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'username' => $request->username,
        ]);
        User::updateLog($request);
        return redirect()->route('user.index')->with('success', ucfirst('user has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request = User::whereId($id)->get()->last();
        User::whereId($id)->delete();
        User::deleteLog($request);
        return redirect()->route('user.index')->with('success', ucfirst('user has been deleted.'));
    }
}
