<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Pharmacy;
class PharmaciesController extends Controller
{
    public function create (Request $request)
 {  
  $rules=array(
    "name"=>"required",
    "email"=>"required|string|email|max:255|unique:pharmacies",
    "address"=>"required"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
    $pharmacy = new Pharmacy;
   $pharmacy->name=$request->name;
   $pharmacy->email=$request->email;
   $pharmacy->address=$request->address;
   $result=$pharmacy->save();
   if($result){
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
 }
}
        public function index()
    
    {
        return Pharmacy::all();

    }
    public function search(Request $request)
    {

    return Pharmacy::where("name","like","%".$request->name."%")->get();
    }
    public function delete($id)
    {
       
       $pharmacy= Pharmacy::find($id);
       $result=$pharmacy->delete();
       if($result){
        return ["Result"=>"data has been deleted"];
                  }
     return ["Result"=>"operation failed"];
    }

    public function update ($id,Request $request )
 { 
  $validator = Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:pharmacies',
    'address' => 'required',
    ]);

   if($validator->fails()){
   return response()->json($validator->errors()->toJson(), 400);
    }
   
   $pharmacy= Pharmacy::find($request->id);
   $pharmacy->name=$request->name;
   $pharmacy->email=$request->email;
   $pharmacy->address=$request->address;
   $result=$pharmacy->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
 return ["Result"=>"operation failed"];
}

}
