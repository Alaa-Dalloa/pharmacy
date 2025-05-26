<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OfferFph;
use Validator;
use Carbon\Carbon;
class OfferFphController extends Controller
{
  public function create (Request $request)
 { 
  if(auth()->user()->id==1)
       {
  $rules=array(
    "discount_end_date"=>"required",
    "discount"=>"required",
    "product_name"=>"required"
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $offerFph = new OfferFph;
   $offerFph->discount_start_date=Carbon::now();
   $offerFph->discount_end_date=$request->discount_end_date;
   $offerFph->discount=$request->discount;
   $offerFph->product_name=$request->product_name;
   $offerFph->quantity=Product::where("name","like","%".$request->product_name."%")->sum('count');
   $offerFph->photo=Product::where("name","like","%".$request->product_name."%")->value('photo');
   $offerFph->product_price_before_discount=Product::where("name","like","%".$request->product_name."%")->value('customer_price');
   $offerFph->product_price_after_discount=$request->discount*1/100*Product::where("name","like","%".$request->product_name."%")->value('customer_price');
   $result=$offerFph->save();
   if($result){
    return ["Result"=>"Offer added sucsess"];

 }
 }
}
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }    


}
 

 public function index()
 {
   return OfferFph::all();
 }

 public function show($id)
 {  
    
    return OfferFph::find($id);
    
 }


 public function update (Request $request , $id)
 { 
  if(auth()->user()->id==1)
       {
  $rules=array(
   "discount_end_date"=>"required",
    "discount"=>"required",
    "product_name"=>"required"
  );

  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
{
   $offerFph= OfferFph::find($id);
   $offerFph->discount_end_date=$request->discount_end_date;
   $offerFph->product_name=$request->product_name;
   $offerFph->discount=$request->discount;
   $offerFph->product_price_before_discount=Product::where("name","like","%".$request->product_name."%")->value('customer_price');
   $offerFph->product_price_after_discount=$request->discount*1/100*Product::where("name","like","%".$request->product_name."%")->value('customer_price');
   $result=$offerFph->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
 }
}
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }    

}

public function delete($id)
{
  if(auth()->user()->id==1)
       {
   
   $offerFph= OfferFph::find($id);
   $result=$offerFph->delete();
   if($result){
    return ["Result"=>"data has been deleted"];
              }
}

        else
        {
            return ["error"=>"you dont have permission to do this"];
        }    


}
}






