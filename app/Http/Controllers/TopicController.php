<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic as Topic;
use Validator;
 
class TopicController extends Controller
{

    public function __construct()
    {
       $this->gridColumns =['id','name','description'];
       $this->gridNumberOfPages =5;
    }
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

        $topics =Topic::select($this->gridColumns)->orderBy('name')->paginate($this->gridNumberOfPages);
        $title = 'Topics';
        $topics_data =["title"=>$title,"gridData"=>$topics];
        return response()->json(
            $topics_data,
            200
        );
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic = Topic::find($id);
        return response()->json( $topic, 201); 
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        
        $topics = Topic::select($this->gridColumns)->where('name','LIKE', (is_null($request->name)?' ':'%'.$request->name.'%'))
        ->orWhere('description','LIKE',(is_null($request->description)?' ':'%'.$request->description.'%'))
        ->orderBy('name')
        ->paginate($this->gridNumberOfPages);

        if(!$request->name && !$request->description){
           $topics = Topic::select($this->gridColumns)->orderBy('name')->paginate($this->gridNumberOfPages);
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
        //validate topics
       $validationMessages = $this->validateTopics($request,$topic);
       if ($validationMessages['success']=='true'){
        //Create topic
        $topic->name = isset($request->name)==true?$request->name:'';
        $topic->description = isset($request->description)==true?$request->description:'';
        $topic->save();
        return response()->json( $topic, 201);
       }
       else
       {
        //Validation Errors   
        return response()->json(
           $validationMessages,422
        );
       }
      
    }
    
    public function validateTopics($request,$topic){
     
        $validator = Validator::make($request->all(), $topic->rules);
        if ($validator->fails()) {
        $response=['error'=>$validator->messages(),'success'=>'false' ];
        }
        else{
           $response=['success'=>'true' ];
        } 
        
         return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {  
        $topic = Topic::find($id);
        $validationMessages = $this->validateTopics($request,$topic);
       if ($validationMessages['success']=='true'){
        //Create topic
        $topic->name = isset($request->name)==true?$request->name:'';
        $topic->description = isset($request->description)==true?$request->description:'';
        $topic->save();
        return response()->json( $topic, 201);
       }
       else
       {
        //Validation Errors   
        return response()->json(
           $validationMessages,422
        );
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $topic = Topic::find($id);
        if (!$topic) {
             return response()->json(
            ["error"=>"Topic not found"],422
        );
        }
 
        if($topic->delete()) {
             return response()->json(
            ["success"=>"true"],201);
        } else 
        {
            return response()->json(["success"=>false,"error"=>"Topic can not be deleted"],422);
        }
    }
}
