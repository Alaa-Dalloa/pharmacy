<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoic;
use App\Models\Product;
use Validator;
use Carbon\Carbon;
use DB;
class SaleInvoiceController extends Controller
{
  public function create (Request $request)
 {
   $saleInvoic=new SaleInvoic;
   foreach ($request->sale_invoics as $saleInvoic) {
     $newSaleInvoic = SaleInvoic::query()->create([
     'product_name' => $saleInvoic['product_name'],
     'quantity' => $saleInvoic['quantity'],
     'price_total' =>$saleInvoic['price_total'],
     'profitable' =>Product::where("name","like","%".$request->product_name."%")->value('profitable'),
     'invoice_price_total'=> $request->invoice_price_total
     ]);
     $oo=DB::table('products')->where("name","like","%".$saleInvoic['product_name']."%")->value('count');
     if($saleInvoic['quantity']>$oo)
     {
      return ['product_name'=>$saleInvoic['product_name'],
        'massage'=>'the quantity not available'];
     }else{
      DB::table('products')->where("name","like","%".$saleInvoic['product_name']."%")->update(['count'=>$oo-$saleInvoic['quantity']]);
     }
    
   }

   $newSaleInvoic->update([
   'release_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d H:i A'),
   'invoice_price_total'=> $request->invoice_price_total,
   'number'=> SaleInvoic::increment('number'),
   ]);
   return  ['sale_invoice' =>$request->sale_invoics,
          'release_date'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('Y-m-d H:i A'),
          'invoice_price_total'=>$request->invoice_price_total
 ];
}


 public function index()
 {
   
      return SaleInvoic::select('id','release_date')->whereNotNull('release_date')->get();
   

 }

 public function number()
 {  
    
   return [
   'number of sale_invoics'=>DB::table('sale_invoics')->value('number')
      ];    
 }





public function delete($id)
{
   
   $saleInvoic= SaleInvoic::find($id);
   $result=$saleInvoic->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
   }
 return ["Result"=>"operation failed"];
}

public function detailes_sale_invoice($id)
 {
   $invoice_price_total=DB::table('sale_invoics')->where('id','=',$id)->value('invoice_price_total');
   $saleInvoic=DB::table('sale_invoics')->where('invoice_price_total','=',$invoice_price_total)->select('product_name','quantity','price_total')->get()->unique();
   return $saleInvoic;

}

}

