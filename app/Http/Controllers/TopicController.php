<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic as Topic;
class TopicController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $topics =Topic::orderBy('name')->paginate(20);
        $title = 'Topics';
        $topics_data =["title"=>$title,"topics"=>$topics];
        return response()->json(
            $topics_data,
            200
        );
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        
        $topics = Topic::where('name','LIKE', (is_null($request->name)?'':'%'.$request->name.'%'))
        ->orWhere('description','LIKE',(is_null($request->description)?'':'%'.$request->description.'%'))
        ->orderBy('name')
        ->paginate(20);

        if(!$request->name && !$request->description){
           $topics = Topic::orderBy('name')->paginate(20);  
        }    
        return response()->json($topics,201);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $topic = new Topic;
        $topic->name = $request->name;
        $topic->description = $request->description;
        $topic->save();

        return response()->json( $topic, 201);
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
