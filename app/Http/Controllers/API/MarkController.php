<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Mark;
use Validator;
use Storage;
use App\Http\Resources\Mark as MarkResource;
   
class MarkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try {
            $marks = Mark::all();
        } catch (exception $e) {
            Echo "" . $e;
        }    
        return $this->sendResponse(MarkResource::collection($marks), 'Marks retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        try {
            $input = $request->all();
       
            $validator = Validator::make($input, [
                'picture' => 'required',
                'mark_date' => 'required'
            ]);
       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }

             $image_64 = $request['picture']; //your base64 encoded data

             $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1]; 
             $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
             $image = str_replace($replace, '', $image_64); 
             $image = str_replace(' ', '+', $image); 

             $imageName = Str::random(10).'.'.$extension;
             Storage::disk('public')->put($imageName, base64_decode($image));
       
            $input['picture'] = '/public/' . $imageName;
            $mark = Mark::create($input); 
        } catch (exception $e) {
            Echo "" . $e;
        }
        return $this->sendResponse(new MarkResource($mark), 'Mark created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        try {
            $mark = Mark::find($id);
      
            if (is_null($mark)) {
                return $this->sendError('Mark not found.');
            }
        } catch (exception $e) {
            Echo "" . $e;
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
    public function update(Request $request, Mark $mark){
        try {
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
        } catch (exception $e) {
            Echo "" . $e;
        }
   
        return $this->sendResponse(new MarkResource($mark), 'Mark updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mark $mark){
        try{
            $mark->delete();
        } catch(exception $e){
            Echo "" . $e;
        }
   
        return $this->sendResponse([], 'Mark deleted successfully.');
    }
}