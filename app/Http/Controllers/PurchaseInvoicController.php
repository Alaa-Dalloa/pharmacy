<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseInvoic;
use App\Models\Product;
use Validator;
use Carbon\Carbon;
use DB;
class PurchaseInvoicController extends Controller
{
  public function create (Request $request)
 {
   $purchaseInvoic=new PurchaseInvoic;
   foreach ($request->purchase_invoics as $purchaseInvoic) {
     $newPurchaseInvoic = PurchaseInvoic::query()->create([
     'product_name' => $purchaseInvoic['product_name'],
     'quantity' => $purchaseInvoic['quantity'],
     'repository' => $purchaseInvoic['repository'],
     'price_total' =>$purchaseInvoic['price_total'],
     'invoice_price_total'=> $request->invoice_price_total,
     
     ]);
     
   }

   $newPurchaseInvoic->update([
   'release_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d H:i A'),
   'invoice_price_total'=> $request->invoice_price_total,
   'number'=> PurchaseInvoic::increment('number'),
   ]);
   return  ['purchase_invoice' =>$request->purchase_invoics,
          'release_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d H:i A'),
          'invoice_price_total'=>$request->invoice_price_total
 ];
}


public function index()
 {
   
      return PurchaseInvoic::select('id','release_date')->whereNotNull('release_date')->get();
   

 }

 public function productNeedSort()
 {
   return DB::table('purchase_invoics')
   ->select('id','price_total','product_name','repository','quantity')->get();
 }

 public function number()
 {  
    
return [
   'number of purchase_invoics'=>DB::table('purchase_invoics')->value('number')
    ];     
 }
 public function detailes_purchase_invoice($id)
 {
   $invoice_price_total=DB::table('purchase_invoics')->where('id','=',$id)->value('invoice_price_total');
   $purchaseInvoic=DB::table('purchase_invoics')->where('invoice_price_total','=',$invoice_price_total)->select('product_name','quantity','repository','price_total')->get()->unique();
   return $purchaseInvoic;

}



 

public function delete($id)
{
   
   $purchaseInvoic= PurchaseInvoic::find($id);
   $result=$purchaseInvoic->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
   }
 return ["Result"=>"operation failed"];
}




}

