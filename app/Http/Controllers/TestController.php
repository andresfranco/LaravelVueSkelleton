<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
     /**
     * Test array
     *
     * @return \Illuminate\Http\Response
     */
    public function test(){
     $testarray =array( 
        array("text"=> 'Learn Laravel' ,"number"=>"1"),
        array("text"=> 'Learn MEAN' ,"number"=>"2"),
        array("text"=> 'Learn Rails' ,"number"=>"3"),
        array("text"=> 'Learn Vuejs' ,"number"=>"4"),
        array("text"=> 'Learn Angular 45' ,"number"=>"5"));
        
        return response()->json(
            $testarray,
            200
        );
    }
      /**
     * Test array
     *
     * @return \Illuminate\Http\Response
     */
    public function list_topics(){
     $testarray =array( 
        array("text"=> 'Learn Laravel' ,"number"=>"1"),
        array("text"=> 'Learn MEAN' ,"number"=>"2"),
        array("text"=> 'Learn Rails' ,"number"=>"3"),
        array("text"=> 'Learn Vuejs' ,"number"=>"4"),
        array("text"=> 'Learn Angular 45' ,"number"=>"5"));
        
        return response()->json(
            $testarray,
            200
        );
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
