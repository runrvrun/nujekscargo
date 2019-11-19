<?php

namespace App\Http\Controllers;

use App\Spb;
use Illuminate\Http\Request;

class SpbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
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
     * @param  \App\Spb  $spb
     * @return \Illuminate\Http\Response
     */
    public function show(Spb $spb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spb  $spb
     * @return \Illuminate\Http\Response
     */
    public function edit(Spb $spb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spb  $spb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spb $spb)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Spb  $spb
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spb $spb)
    {
        //
    }
}
