<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Distributor;
use Validator;
class DistributorController extends Controller
{
 public function creatDistributor (Request $request)
 {  
  $rules=array(
    "name"=>"required",
     "phone"=>"required",
      "repo_name"=>"required"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
    $distributor = new Distributor;
   $distributor->name=$request->name;
   $distributor->phone=$request->phone;
   $distributor->repo_name=$request->repo_name;
   $result=$distributor->save();
   if($result){
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
 }
}
 public function index()
 {
   return Distributor::all();
 }
public function show($id)
 { 
    return Distributor::find($id);
    
 }

 public function update ($id,Request $request)
 { 
  $rules=array(
    "name"=>"required",
     "phone"=>"required",
      "repo_name"=>"required"
    );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $distributor= Distributor::find($request->id);
   $distributor->name=$request->name;
   $distributor->phone=$request->phone;
   $distributor->repo_name=$request->repo_name;
   $result=$distributor->save();
   if($result){
    return ["Result"=>"data has been updated"];
 }
 return ["Result"=>"operation failed"];
 }
}
public function delete($id)
{  
   $distributor= Distributor::find($id);
   $result=$distributor->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
 }
 return ["Result"=>"operation failed"];

}
public function search(Request $request)
{

return Distributor::where("name","like","%".$request->name."%")->get();
}


}