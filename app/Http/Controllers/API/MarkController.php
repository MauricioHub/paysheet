<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Mark;
use Validator;
use App\Http\Resources\Mark as MarkResource;
   
class MarkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marks = Mark::all();
    
        return $this->sendResponse(MarkResource::collection($marks), 'Marks retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'picture' => 'required',
            'mark_date' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $mark = Mark::create($input);
   
        return $this->sendResponse(new MarkResource($mark), 'Mark created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mark = Mark::find($id);
  
        if (is_null($mark)) {
            return $this->sendError('Mark not found.');
        }
   
        return $this->sendResponse(new MarkResource($mark), 'Mark retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mark $mark)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'picture' => 'required',
            'mark_date' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $mark->picture = $input['picture'];
        $mark->mark_date = $input['mark_date'];
        $mark->save();
   
        return $this->sendResponse(new MarkResource($mark), 'Mark updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mark $mark)
    {
        $mark->delete();
   
        return $this->sendResponse([], 'Mark deleted successfully.');
    }
}