<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferFSup;
use Validator;
use App\Models\User;
use DB;
use Http;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OfferNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
class OfferFSupController extends Controller
{
    public function create (Request $request)
 { 
  if(auth()->user()->user_type=='supplier')
       {
        $user_id=$request->user_id;
    $fcm_token=$request->fcm_token;
    $server_key=env('FCM_SERVER_KEY');
  $rules=array(
    "product_name"=>"required",
    "company_factor"=>"required",
   "product_photo"=>"required" ,
   "production_date"=>"required" ,
   "expiry_date"=>"required" ,
   "quantity"=>"required" ,
   "product_price_before_discount"=>"required" ,
   "product_price_after_discount"=>"required" 
   
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }

  
   $user=User::where("user_type","like","super_admin")->get();
   $offerFSup = new OfferFSup;
   $offerFSup->product_name=$request->product_name;
   $offerFSup->company_factor=$request->company_factor;
   if($request->hasFile('product_photo'))
           {
           $photoName =rand().time().'.'.$request->product_photo->getClientOriginalExtension();
            $path=$request->file('product_photo')->move('upload/', $photoName );
          $offerFSup->product_photo=$photoName ;
        }
   $offerFSup->production_date=$request->production_date; 
   $offerFSup->expiry_date=$request->expiry_date;
   $offerFSup->quantity=$request->quantity;
   $offerFSup->product_price_before_discount=$request->product_price_before_discount;
   $offerFSup->product_price_after_discount=$request->product_price_after_discount;
   $offerFSup->user_name=auth()->user()->name;
   $offerFSup->message_notify='sent purchase offer for you';
   $offerFSup->time_notify=Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A');
   $result=$offerFSup->save();
   $fcm=Http::acceptJson()->withToken($server_key)->post(
        'https://fcm.googleapis.com/fcm/send',
        [
          'to'=>$fcm_token,
          'notification'=>[
           'user_name'=>auth()->user()->name,
           'title_notify'=>'sent offer for you',
           'time_notify'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A'),
           'body'=>$offerFSup
          ]

        ]
        );
    return json_decode($fcm);
      
}
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }

}
 public function index()
 {
   return OfferFSup::all();
 }

 public function show($id)
 {  
    
    return OfferFSup::find($id);
    
 }


 public function update (Request $request , $id )
 { 
  if(auth()->user()->user_type=='supplier')
       {
  $rules=array(
   "product_name"=>"required",
    "company_factor"=>"required",
   "product_photo"=>"required" ,
   "production_date"=>"required" ,
   "expiry_date"=>"required" ,
   "quantity"=>"required" ,
   "product_price_before_discount"=>"required" ,
   "product_price_after_discount"=>"required" 
  );

  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
{

   $offerFSup= OfferFSup::find($id);
   $offerFSup->product_name=$request->product_name;
   $offerFSup->company_factor=$request->company_factor;
   $offerFSup->product_photo=$request->product_photo;
   $offerFSup->production_date=$request->production_date; 
   $offerFSup->expiry_date=$request->expiry_date;
   $offerFSup->quantity=$request->quantity;
   $offerFSup->product_price_before_discount=$request->product_price_before_discount;
   $offerFSup->product_price_after_discount=$request->product_price_after_discount;
   $result=$offerFSup->save();
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
   if(auth()->user()->user_type=='supplier')
       {
   $offerFSup= OfferFSup::find($id);
   $result=$offerFSup->delete();
   if($result){
    return ["Result"=>"data has been deleted"];
              }
              }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
}

public function allNotificationOffer()
 {
  return DB::table('offer_f_sups')->select('id','user_name','message_notify','time_notify')->get()->unique();
 }

 public function detaileOffer($id)
 {
  $time_notify=OfferFSup::where('id','=',$id)->value('time_notify');
  $offer=OfferFSup::where('time_notify','=',$time_notify)->get()->unique();
  return $offer;

 }
}




