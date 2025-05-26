<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsluationMedical;
use Validator;
use App\Models\User;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ConsluationMedicalNotification;
use Illuminate\Support\Facades\Notification;
class ContactController extends Controller
{
    public function create (Request $request)
 { 
  $rules=array(
    "name"=>"required",
    "email"=>"required",
    "phone"=>"required",
    "message"=>"required"
  
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $user=User::where("user_type","like","super_admin")->get();
   $consluationmedical = new ConsluationMedical;
   $consluationmedical->name=$request->name;
   $consluationmedical->email=$request->email;
   $consluationmedical->phone=$request->phone;
   $consluationmedical->message=$request->message; 
   $consluationmedical->user_name=auth()->user()->name;
   $consluationmedical->message_notify='send message to email';
   $consluationmedical->time_notify=Carbon::now()->format('H:i A');
   $result=$consluationmedical->save();
   $name=auth()->user()->name;
   $email=auth()->user()->email;
   $time=Carbon::now()->format('H:i:s A');
  
   $detailes=[
    'name'=>$name,
    'email'=>$email,
    'Notification'=> 'sent midical consulation to email',
    'time'=>$time,
    'consluationmedical'=>$request->message
    ];
   Notification::send($user , new ConsluationMedicalNotification($detailes));


   if($result){
    return ["Result"=>"your message has been sent succssecfuly"];
 }
 return ["Result"=>"operation failed"];
}

}
 public function index()
 {
   return ConsluationMedical::all();
 }

 public function allNotificationCons()
 {
  return DB::table('consluation_medicals')->select('user_name','message_notify','time_notify')->get();
 }
public function detailCons($id)
 {
  return DB::table('consluation_medicals')->where('id','=',$id)->get();
 }

}

