<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
class BarrenTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'BarrenTest:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this will calcute monthly barren';

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
        $data= DB::table('users')->sum('salary');
              $data2=DB::table('purchase_invoics')->sum('invoice_price_total');
              $data3=$data+$data2;
              $time= Carbon::now()->format('M');
              return $detailes=
              [
               'mounth_name'=>$time,
               'pay'=>$data3
              ];


          $data2= Product::where('expire','=','1')->sum('pharmacies_price');
          $time2= Carbon::now()->format('M');
          return $detailes2=
          [
           'mounth_name'=>$time2,
           'loss'=>$data2
          ];

          $data3=DB::table('sale_invoics')->sum('profitable');
          $time3= Carbon::now()->format('M');
          return $detailes3=
          [
           'mounth_name'=>$time3,
           'profitables'=>$data3
          ];


    }     
}
