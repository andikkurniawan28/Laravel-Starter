<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\Globalization;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $global = Globalization::index();
        $menu = Menu::all();
        return view('menu.index', compact('global', 'menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $global = Globalization::index();
        return view('menu.create', compact('global'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Menu::create($request->all());
        return redirect()->route('menu.index')->with('success', ucfirst('menu has been stored.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $global = Globalization::index();
        $menu = Menu::whereId($id)->get()->last();
        return view('menu.show', compact('global', 'menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $global = Globalization::index();
        $menu = Menu::whereId($id)->get()->last();
        return view('menu.edit', compact('global', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Menu::whereId($id)->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'route' => $request->route,
        ]);
        Menu::updateLog($request);
        return redirect()->route('menu.index')->with('success', ucfirst('menu has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request = Menu::whereId($id)->get()->last();
        Menu::whereId($id)->delete();
        Menu::deleteLog($request);
        return redirect()->route('menu.index')->with('success', ucfirst('menu has been deleted.'));
    }
}
