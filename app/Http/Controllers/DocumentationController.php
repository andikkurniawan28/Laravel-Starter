<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Documentation::serveRecord();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Documentation::showCreationForm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Documentation::handleStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Documentation::showSpecificRecord($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Documentation::showEditingForm($id);
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
        return Documentation::handleUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documentation  $documentation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Documentation::handleDelete($id);
    }
}
