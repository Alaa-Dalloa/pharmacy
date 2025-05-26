<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company_insurance;
use Validator;
class C_insuranceController extends Controller
{
 public function create (Request $request)
 {  
  $rules=array(
    "name"=>"required",
    "phone"=>"required",
  
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
    $c_insurance = new Company_insurance;
    $c_insurance->name=$request->name;
    $c_insurance->phone=$request->phone;
    $result=$c_insurance->save();
   if($result){
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
 }
}
 public function index()
 {
   return Company_insurance::all();
 }
public function show($id)
 { 
    return Company_insurance::find($id);
    
 }

 public function update ($id,Request $request)
 { 
  $rules=array(
    "name"=>"required",
    "phone"=>"required",
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $c_insurance= Company_insurance::find($request->id);
   $c_insurance->name=$request->name;
    $c_insurance->phone=$request->phone;
   $result=$c_insurance->save();
   if($result){
    return ["Result"=>"data has been updated"];
 }
 return ["Result"=>"operation failed"];
 }
}
public function delete($id)
{  
   $c_insurance= Company_insurance::find($id);
   $result=$c_insurance->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
 }
 return ["Result"=>"operation failed"];

}

public function search(Request $request)
{

return Company_insurance::where("name","like","%".$request->name."%")->get();
}

}
