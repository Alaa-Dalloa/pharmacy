<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medical_tips;
use DB;
use Validator;
class TipesController extends Controller
{
 public function create (Request $request)
 {  
  $rules=array(
    "the_advice"=>"required"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
    $medical_tips = new Medical_tips;
   $medical_tips->the_advice=$request->the_advice;
  if($request->hasFile('photo'))
   {
   $photoName=rand().time().'.'.$request->photo->getClientOriginalExtension();
    $path=$request->file('photo')->move('upload/', $photoName );
    $medical_tips->photo=$photoName;
}
   $result=$medical_tips->save();
   if($result){
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
 }
}
 public function index()
 {
   return Medical_tips::all();
 }
 public function indexs()
{
    $data = DB::table('medical_tips')
                ->inRandomOrder()
                ->first();
                return $data;
}
public function show($id)
 { 
    return Medical_tips::find($id);
    
 }

 public function update ($id,Request $request)
 { 
  $rules=array(
    "the_advice"=>"required|min:9"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $medical_tips= Medical_tips::find($request->id);
   $medical_tips->the_advice=$request->the_advice;
   $result=$medical_tips->save();
   if($result){
    return ["Result"=>"data has been updated"];
 }
 return ["Result"=>"operation failed"];
 }
}
public function delete($id)
{  
   $medical_tips= Medical_tips::find($id);
   $result=$medical_tips->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
 }
 return ["Result"=>"operation failed"];

}



}



