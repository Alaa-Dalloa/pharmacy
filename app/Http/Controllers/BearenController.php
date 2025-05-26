<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Bearen;
use DB;

class BearenController extends Controller
{
   public function bearen()
        {     
            if(auth()->user()->user_type=='super_admin')
       {
              $bearen = new Bearen;
              $bearen->month_name=Carbon::now()->format('M');
              $data= DB::table('users')->sum('salary');
              $data2=DB::table('purchase_invoics')->sum('invoice_price_total');
              $bearen->pay=$data+$data2;
              $products=Product::all();
               foreach ($products as $product ) {
                 if(Carbon::createFromFormat('Y-m-d',$product->end_date)->subDays(0)<=Carbon::now())
                 {
                  DB::table('products')->where("name","like","%".$product->name."%")->update(['expire'=>3,
                   'messagee_notify'=>'product expired',
                    'timee_notify'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A')]);
                 }
             }
              $bearen->loss=Product::where('expire','=',3)->sum('pharmacies_price');
              $data7=DB::table('sale_invoics')->sum('profitable');
              $data8=DB::table('orders')->sum('profitable');
              $bearen->earnings=$data7+$data8;
              $bearen->revenues=DB::table('sale_invoics')->sum('invoice_price_total');
              $result=$bearen->save();
        
         return DB::table('bearens')->select('month_name','loss','pay','earnings','revenues')->latest()->first();
         }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
           
        }
        public function loss()
        {
            if(auth()->user()->user_type=='super_admin')
       {
              $products=Product::all();
               foreach ($products as $product ) {
                $date1=Carbon::createFromFormat('Y-m-d',$product->end_date);
                $date2=Carbon::now();
                 if(Carbon::createFromFormat('Y-m-d',$product->end_date)->lt(Carbon::now()))
                 {
                  DB::table('products')->where("name","like","%".$product->name."%")->update(['expire'=>3,
                   'messagee_notify'=>'product expired',
                    'timee_notify'=>Carbon::now()->tz('Europe/London')->addHours(2)->format('H:i A')]);
                 }
             }
        return DB::table('bearens')->select('month_name','loss')->latest()->first();
        }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }    
        }
        public function pay()
        {
            if(auth()->user()->user_type=='super_admin')
       {
        return DB::table('bearens')->select('month_name','pay')->latest()->first();
        }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }    
        }   
        public function earnings()
        {
            if(auth()->user()->user_type=='super_admin')
       {
        return DB::table('bearens')->select('month_name','earnings')->latest()->first();
        }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }    
        }   
        public function revenues()
        {
            if(auth()->user()->user_type=='super_admin')
       {
        return DB::table('bearens')->select('month_name','revenues')->latest()->first();
        }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }    
        } 
    public function maxWanted()
    {

    return DB::table('products')->where('profitable','>','100')->get();

    }   
}
