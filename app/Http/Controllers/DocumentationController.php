<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\Documentation;
use App\Models\Globalization;

class DocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $global = Globalization::index();
        $documentation = Documentation::all();
        return view('documentation.index', compact('global', 'documentation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $global = Globalization::index();
        $menu = Menu::all();
        return view('documentation.create', compact('global', "menu"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Documentation::create($request->all());
        return redirect()->route('documentation.index')->with('success', ucfirst('documentation has been stored.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $global = Globalization::index();
        $documentation = Documentation::whereId($id)->get()->last();
        return view('documentation.show', compact('global', 'documentation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $global = Globalization::index();
        $documentation = Documentation::whereId($id)->get()->last();
        $menu = Menu::all();
        return view('documentation.edit', compact('global', 'documentation', "menu"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Documentation::whereId($id)->update([
            'menu_id' => $request->menu_id,
            'description' => $request->description,
        ]);
        Documentation::updateLog();
        return redirect()->route('documentation.index')->with('success', ucfirst('documentation has been updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Documentation::whereId($id)->delete();
        Documentation::deleteLog();
        return redirect()->route('documentation.index')->with('success', ucfirst('documentation has been deleted.'));
    }
}
