<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company_delivery;
use Validator;
class C_DelivaryController extends Controller
{
 public function create (Request $request)
 {  
  $rules=array(
    "name"=>"required",
    "phone"=>"required",
    "delivary_places"=>"required"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
    $c_delivery = new Company_delivery;
    $c_delivery->name=$request->name;
    $c_delivery->phone=$request->phone;
    $c_delivery->delivary_places=$request->delivary_places;
   $result=$c_delivery->save();
   if($result){
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
 }
}
 public function index()
 {
   return Company_delivery::all();
 }
public function show($id)
 { 
    return Company_delivery::find($id);
    
 }

 public function update ($id,Request $request)
 { 
  $rules=array(
    "name"=>"required",
    "phone"=>"required",
    "delivary_places"=>"required"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $c_delivery= Company_delivery::find($request->id);
   $c_delivery->name=$request->name;
    $c_delivery->phone=$request->phone;
    $c_delivery->delivary_places=$request->delivary_places;
   $result=$c_delivery->save();
   if($result){
    return ["Result"=>"data has been updated"];
 }
 return ["Result"=>"operation failed"];
 }
}
public function delete($id)
{  
   $c_delivery= Company_delivery::find($id);
   $result=$c_delivery->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
 }
 return ["Result"=>"operation failed"];

}

public function search(Request $request)
{

return Company_delivery::where("name","like","%".$request->name."%")->get();
}

}
