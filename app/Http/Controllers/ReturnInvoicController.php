<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnInvoic;
use App\Models\Product;
use Validator;
use Carbon\Carbon;
use DB;
class ReturnInvoicController extends Controller
{
  public function create (Request $request)
 { 

   foreach ($request->return_invoics as $returnInvoic) {
     $newreturnInvoic = ReturnInvoic::query()->create([
     'product_name' => $returnInvoic['product_name'],
     'count' => $returnInvoic['count'],
     'price_total' =>$returnInvoic['price_total'],
     'invoic_price_total'=> $request->invoic_price_total
     ]);

   $oo=DB::table('products')->where("name","like","%".$returnInvoic['product_name']."%")->value('count');
      DB::table('products')->where("name","like","%".$returnInvoic['product_name']."%")->update(['count'=>$oo+$returnInvoic['count']]);
    
   }

   $newreturnInvoic->update([
   'invoic_price_total'=> $request->invoic_price_total,
   'sell_date'=>$request->sell_date,
   'number'=> ReturnInvoic::increment('number'),
   ]);
   return  ['return_invoics' =>$request->return_invoics,
            'sell_date'=>$request->sell_date,
          'invoic_price_total'=>$request->invoic_price_total
 ];
}


public function index()
 {
   
      return ReturnInvoic::select('id','sell_date')->whereNotNull('sell_date')->get();
 }

 public function show($id)
 {  
    
    return ReturnInvoic::find($id);
    
 }
public function number()
 {  
    
   return [
   'number of return_invoics'=>DB::table('return_invoics')->value('number')
      ];    
 }


 

public function delete($id)
{
   
   $returnInvoic= ReturnInvoic::find($id);
   $result=$returnInvoic->delete();
   if($result)
   {
    return ["Result"=>"data has been deleted"];
   }
 return ["Result"=>"operation failed"];
}

public function detailes_return_invoice($id)
 {
   $invoice_price_total=DB::table('return_invoics')->where('id','=',$id)->value('invoic_price_total');
   $returnInvoic=DB::table('return_invoics')->where('invoic_price_total','=',$invoice_price_total)->select('product_name','count','price_total')->get()->unique();
   return $returnInvoic;

}
}

