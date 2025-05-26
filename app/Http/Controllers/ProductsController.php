<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\EnddateNotification;
use App\Notifications\CountNotification;
use Illuminate\Support\Facades\Notification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;
class ProductsController extends Controller
{
 public function create (Request $request)
 { 
  $rules=array(
    "name"=>"required" , 
    "pharmacies_price"=>"required",
   "customer_price"=>"required",
   "count"=>"required",
   "note"=>"required",
   "photo"=>"required",
   "description"=>"required",
   "start_date"=>"required" ,
   "end_date"=>"required" ,
   "alternative"=>"required" ,
   "company_factor"=>"required" ,
   "category_name"=>"required" ,
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $user=User::where("user_type","like","super_admin")->get();
   $product = new Product;
   $product->name=$request->name;
   $product->pharmacies_price=$request->pharmacies_price;
   $product->customer_price=$request->customer_price;
   $product->profitable=$request->customer_price-$request->pharmacies_price;
   $product->count=$request->count;
   $product->note=$request->note;
   if($request->hasFile('photo'))
   {
   $photoName=rand().time().'.'.$request->photo->getClientOriginalExtension();
    $path=$request->file('photo')->move('upload/', $photoName );
    $product->photo=$photoName ;
}
   $product->description=$request->description;
   $product->start_date=$request->start_date;
   $product->end_date=$request->end_date;
   $product->alternative=$request->alternative;
   $product->company_factor=$request->company_factor;
   $product->category_name=$request->category_name; 
   $product->prescrept=$request->prescrept;
   $Qrcode=QrCode::generate($product->name);
   $product->Qrcode=$Qrcode;
   $time=Carbon::now()->format('H:i:s A');
   if(Carbon::createFromFormat('Y-m-d',$request->end_date)->subDays(20)<=Carbon::now())
  {
    $product->expire=1;
    $product->timee_notify=Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A');
    $product->messagee_notify='product will be expire';
    $detailes= [
     'product_name'=> $request->name ,
     'notification'=> 'product will be expire',
     'time'=>$time

    ];
    Notification::send($user , new EnddateNotification($detailes));
  }
  if($request->count<=8)
  {
    $product->timec_notify=Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A');
    $product->messagec_notify='product will be empty in pharmacy';
    $time=Carbon::now()->format('H:i:s A');
    $detaile=[
      'product_name'=> $request->name ,
      'time'=>$time,
     'notification'=> 'product will be empty in pharmacy'
    ];
    Notification::send($user , new CountNotification($detaile));
  } 
  if(isset($request->name))
  {
    $oo=DB::table('products')->where("name","like","%".$request->name."%")->value('count');
    DB::table('products')->where("name","like","%".$request->name."%")->update(['count'=>$oo+$request->count]);
  }
  
  $result=$product->save();
  if($result)
  {
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
}


}
 public function index()
 {
   return Product::all()->unique('name');

 }

 public function indexallnotificationend()
 {
   $products=Product::all();
   foreach ($products as $product ) {
     if(Carbon::createFromFormat('Y-m-d',$product->end_date)->subDays(20)<=Carbon::now())
     {
      DB::table('products')->where("name","like","%".$product->name."%")->update(['expire'=>1,
       'messagee_notify'=>'product will be expire',
        'timee_notify'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A')]);
     }
    
   }

  return DB::table('products')->where('expire','=',1)->get();

 }


 public function indexallproductcount()
 {
   $products=Product::all();
   foreach ($products as $product ) {
     if($product->count<9)
     {
      DB::table('products')->where('count','<','9')->update([
                'messagec_notify'=>'product will empty in pharmacy',
                'timec_notify'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A')]);
     }
   }
  return DB::table('products')->where('count','<',9)->get();
   }
 

 

 public function show($id)
 {  
    
    return Product::find($id);
    
 }


  public function showProductByCategory($name)
 {  
    
   return Product::where('category_name','=',$name)->where('expire','=','0')->get();
   
 }

 

 public function update (Request $request , $id)
 { 
  $rules=array(
   "name"=>"required" , 
    "pharmacies_price"=>"required",
   "customer_price"=>"required",
   "count"=>"required",
  
  );

  $validator=Validator::make($request->all() , $rules);
  if($validator->fails())
  {
    return $validator->errors();
  }
  else
{
  $product= Product::find($id);
   $product->name=$request->name;
   $product->pharmacies_price=$request->pharmacies_price;
   $product->customer_price=$request->customer_price;
   $product->count=$request->count;
   $result=$product->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
 return ["Result"=>"operation failed"];
}
}

public function delete($id)
{
   
   $product= Product::find($id);
   $result=$product->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
   }
 return ["Result"=>"operation failed"];
}
public function search(Request $request)
{

return Product::where("name","like","%".$request->name."%")->get();
}


 public function allNotificationenddate()
 {
   $products=Product::all();
   foreach ($products as $product ) {
     if(Carbon::createFromFormat('Y-m-d',$product->end_date)->subDays(20)<=Carbon::now())
     {
      DB::table('products')->where("name","like","%".$product->name."%")->update(['expire'=>1,
       'messagee_notify'=>'product will be expire',
        'timee_notify'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A')]);
     }
   }

  return DB::table('products')->where('expire','=','1')
  ->select('name','messagee_notify','timee_notify')->whereNotNull('timee_notify')->get();

 }
 
 public function allNotificationcount()
 {

  $products=Product::all();
   foreach ($products as $product ) {
     if($product->count<9)
     {
      DB::table('products')->where('count','<','9')->update([
                'messagec_notify'=>'product will empty in pharmacy',
                'timec_notify'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A')]);
     }
   }
  return DB::table('products')->where('count','<','9')
  ->select('name','messagec_notify','timec_notify')->whereNotNull('timec_notify')->get();

 }

public function allNotification()
 {
  return DB::table('notifications')->select('data')->get();
 }


}


