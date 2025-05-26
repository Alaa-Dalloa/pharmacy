<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Http;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;
class OrdersController extends Controller
{
 public function create (Request $request)
 { 
    $user_id=$request->user_id;
    $fcm_token=$request->fcm_token;
    $server_key=env('FCM_SERVER_KEY');
     foreach ($request->orders as $order)
    {
     $newOrder = Order::query()->create([
     'product_name' =>$order['product_name'],
     'count' => $order['count'],
     'product_photo' => Product::where("name","like","%".$request->product_name."%")->value('photo'),
     'price_total' => $order['price_total'],
     'profitable' => Product::where("name","like","%".$request->product_name."%")->value('profitable'),
     'user_name'=> auth()->user()->name,
     'order_price_total'=> $request->order_price_total,
     'address'=> $request->address,
   'phone'=> $request->phone,
   'message_notify'=> 'Request Order From Pharmacy',
   'time_notify'=> Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A'),
     ]);
   $oo=DB::table('products')->where("name","like","%".$order['product_name']."%")->value('count');
     if($order['count']>$oo)
     {
      return ['product_name'=>$order['product_name'],
        'massage'=>'the quantity not available'];
     }else{
      DB::table('products')->where("name","like","%".$order['product_name']."%")->update(['count'=>$oo-$order['count']]);
     }
    
   }

   $newOrder->update([
   'address'=> $request->address,
   'phone'=> $request->phone,
   'user_name'=> auth()->user()->name,
   'order_price_total'=> $request->order_price_total,
   'message_notify'=> 'Request Order From Pharmacy',
   'time_notify'=> Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A'),
   ]);

  /* return  ['orders' =>$request->orders,
          'user_name'=>auth()->user()->name,
          'address'=> $request->address,
          'phone'=> $request->phone,
          'order_price_total'=>$request->order_price_total];*/

        $fcm=Http::acceptJson()->withToken($server_key)->post(
        'https://fcm.googleapis.com/fcm/send',
        [
          'to'=>$fcm_token,
          'notification'=>[
          'user_name'=>auth()->user()->name,
          'title_notify'=>'request order from pharmay',
          'time_notify'=> Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A'),
          'body'=>$request->orders
          ]

        ]
);
    return json_decode($fcm);
}
 public function index()
 {
   return Order::all();
 }


public function delete($id)
{
   
   $order= Order::find($id);
   $result=$order->delete();
   if($result){
    return ["Result"=>"data has been deleted"];
              }
 return ["Result"=>"operation failed"];
}

 public function allNotificationOrder()
 {
  return DB::table('orders')->select('id',
    'user_name','message_notify','time_notify')->whereNotNull('message_notify')->get();
 }

 public function detaileOrder($id)
 {
  
  $name=Order::where('id','=',$id)->value('user_name');
  $order=Order::where('user_name','=',$name)->get()->unique();
  return $order;

 }

}








