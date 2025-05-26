<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use App\Models\Product;
class TestEexpireAndEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TestEexpireAndEnd:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will test products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    { 
      $products=DB::table('products')->get();
      foreach($products as $product )
    {   
        if (Carbon::createFromFormat('Y-m-d',$product->end_date)->subDays(30)<=Carbon::now())
         {
            $product->expire=1;
         }
         elseif ($product->expire==1) 
         {  
            $product->name=DB::table('products')->where('expire','=','1')->select('name')->select('name')->first();
            $product->timee_notify=Carbon::now()->format('H:i A');
            $product->messagee_notify='product will be expire';
         }
         elseif ($product->count==15) 
         {  
            $product->name=DB::table('products')->where('count','=','15')->select('name')->first();
            $product->timec_notify=Carbon::now()->format('H:i A');
            $product->messagec_notify='product will be empty in pharmacy';
         }
    }
        
   }
}