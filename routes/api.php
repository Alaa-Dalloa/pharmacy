
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\Categoriescontroller;
use App\Http\Controllers\RepositoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PharmaciesController;
use App\Http\Controllers\TipesController;
use App\Http\Controllers\C_DelivaryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\C_insuranceController;
use App\Http\Controllers\OfferFphController;
use App\Http\Controllers\OfferFSupController;
use App\Http\Controllers\PurchaseInvoicController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReturnInvoicController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\BearenController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Routes of users

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [UserController::class, 'authenticate']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/delete/{id}', [UserController::class, 'delete']);
    Route::get('/allUser', [UserController::class, 'index']);
    Route::post("editUser/{id}", [UserController::class, 'update']);


//Route of Distributor
Route::post('/creatDistributor', [DistributorController::class, 'creatDistributor']);
Route::get('/indexDistributor', [DistributorController::class, 'index']);
Route::get("searchDistributor/{name}" , [DistributorController::class,'search']);
Route::post("deleteDistributor/{id}" , [DistributorController::class,'delete']);
Route::post("editDistributor/{id}" , [DistributorController::class,'update']);


//Route of administor


Route::post('/creatAdmin', [AdminController::class, 'creatAdmin']);
Route::get('/indexAdministor', [AdminController::class, 'index']);
Route::get("searchAdmin/{name}" , [AdminController::class,'search']);
Route::post("deleteAdmin/{id}" , [AdminController::class,'delete']);
Route::post("editAdmin/{id}" , [AdminController::class,'update']);
Route::get('/indexSuper_Admin', [AdminController::class, 'indexSuper']);

//Rout of categories


Route::post("addcategories" , [Categoriescontroller::class,'create']);
Route::get("allcategories" , [Categoriescontroller::class,'index']);
Route::get("category/{id}" , [Categoriescontroller::class,'show']);
Route::put("update/{id}" , [Categoriescontroller::class,'update']);
Route::post("destroy/{id}" , [Categoriescontroller::class,'delete']);
Route::get("search" , [Categoriescontroller::class,'search']);




//Rout of repository


Route::post('/creatRepository', [RepositoriesController::class, 'create']);
Route::get('/indexRepository', [RepositoriesController::class, 'index']);
Route::get("searchRepository" , [RepositoriesController::class,'search']);
Route::post("deleteRepository/{id}" , [RepositoriesController::class,'delete']);
Route::post("editRepository/{id}" , [RepositoriesController::class,'update']);



//Route of product

Route::post('/creatProduct', [ProductsController::class, 'create']);
Route::get('/indexProduct', [ProductsController::class, 'index']);
Route::get("searchProduct" , [ProductsController::class,'search']);
Route::post("deleteProduct/{id}" , [ProductsController::class,'delete']);
Route::post("editProduct/{id}" , [ProductsController::class,'update']);
Route::get('/allProductwillbeexpire' , [ProductsController::class,'indexallnotificationend']);
Route::get('/allProductwillbeempty' , [ProductsController::class,'indexallproductcount']);
Route::get("productbycategory/{name}" , [ProductsController::class,'showProductByCategory']);
Route::get("showProduct/{id}", [ProductsController::class, 'show']);
Route::get("productNeedSort" , [PurchaseInvoicController::class,'productNeedSort']);


//Route of Pharmacy

Route::post('/creatPhamacy', [PharmaciesController::class, 'create']);
Route::get('/indexPhamacy', [PharmaciesController::class, 'index']);
Route::get("searchPhamacy" , [PharmaciesController::class,'search']);
Route::post("deletePhamacy/{id}" , [PharmaciesController::class,'delete']);
Route::post("editPhamacy/{id}" , [PharmaciesController::class,'update']);


//Route of tips

Route::post('/creatTips', [TipesController::class, 'create']);
Route::get('/indexTips', [TipesController::class, 'indexs']);
Route::post("deleteTips/{id}" , [TipesController::class,'delete']);
Route::post("editTips/{id}" , [TipesController::class,'update']);



//Route of Company_Delivery

Route::post('/creatDelivery', [C_DelivaryController::class, 'create']);
Route::get('/indexDelivery', [C_DelivaryController::class, 'index']);
Route::post("deleteDelivery/{id}" , [C_DelivaryController::class,'delete']);
Route::post("editDelivery/{id}" , [C_DelivaryController::class,'update']);
Route::get("searchDelivery" , [C_DelivaryController::class,'search']);



//Route of Orders

Route::post('/creatOrder', [OrdersController::class, 'create']);
Route::get('/indexOrders', [OrdersController::class, 'index']);
Route::post("deleteOrder/{id}" , [OrdersController::class,'delete']);
Route::post("editOrder/{id}" , [OrdersController::class,'update']);



//Route of Company_Insurance

Route::post('/creatInsurance', [C_insuranceController::class, 'create']);
Route::get('/indexInsurance', [C_insuranceController::class, 'index']);
Route::post("deleteInsurance/{id}" , [C_insuranceController::class,'delete']);
Route::post("editInsurance/{id}" , [C_insuranceController::class,'update']);
Route::get("searchInsurance" , [C_insuranceController::class,'search']);

//Route of Offerfph

Route::post('/creatOfferfph', [OfferFphController::class, 'create']);
Route::get('/indexOfferfph', [OfferFphController::class, 'index']);
Route::post("deleteOfferfph/{id}" , [OfferFphController::class,'delete']);
Route::post("editOfferfph/{id}" , [OfferFphController::class,'update']);


//Route of OfferFSup

Route::post('/creatOfferFSup', [OfferFSupController::class, 'create']);
Route::get('/indexOfferFSup', [OfferFSupController::class, 'index']);
Route::post("deleteOfferFSup/{id}" , [OfferFSupController::class,'delete']);
Route::post("editOfferFSup/{id}" , [OfferFSupController::class,'update']);
Route::get('/index', [OfferFSupController::class, 'show']);



//Route of PurchaseInvoic

Route::post('/creatPurchaseInvoic', [PurchaseInvoicController::class, 'create']);
Route::get('/indexPurchaseInvoic', [PurchaseInvoicController::class, 'index']);
Route::post("deletePurchaseInvoic/{id}" , [PurchaseInvoicController::class,'delete']);
Route::get("detailes_purchase_invoice/{id}" , [PurchaseInvoicController::class,'detailes_purchase_invoice']);
Route::get('/numberPurchaseInvoic', [PurchaseInvoicController::class, 'number']);




//Route of ReturnInvoic

Route::post('/creatReturnInvoic', [ReturnInvoicController::class, 'create']);
Route::get('/indexReturnInvoic', [ReturnInvoicController::class, 'index']);
Route::post("deleteReturnInvoic/{id}",[ReturnInvoicController::class,'delete']);
Route::get("detailes_return_invoice/{id}" ,[ReturnInvoicController::class,'detailes_return_invoice']);
Route::get('/numberReturnInvoic', [ReturnInvoicController::class, 'number']);


//Route of SaleInvoic

Route::post('/creatSaleInvoic', [SaleInvoiceController::class, 'create']);
Route::get('/indexSaleInvoic', [SaleInvoiceController::class, 'index']);
Route::post("deleteSaleInvoic/{id}",[SaleInvoiceController::class,'delete']);
Route::get("detailOfInvoice/{id}" ,[SaleInvoiceController::class,'detailes_sale_invoice']);
Route::get('/numberSaleInvoic', [SaleInvoiceController::class, 'number']);
Route::get('/profitablesdaily', [SaleInvoiceController::class, 'profitable']);





Route::post('/createConsulMed', [ContactController::class, 'create']);



//Notifications generate

//notify enddate
Route::get('/notificationsE', [ProductsController::class, 'allNotificationenddate']);

//notify count
Route::get('/notificationsC', [ProductsController::class, 'allNotificationcount']);

//notify consluation midiical
Route::get('/notificationsCONS', [ContactController::class, 'allNotificationCons']);
Route::get("DetaileCons/{id}", [ContactController::class, 'detailCons']);
//notify order
Route::get('/notificationsOrder', [OrdersController::class, 'allNotificationOrder']);
Route::get("DetaileOrder/{id}", [OrdersController::class, 'detaileOrder']);

//notify offer
Route::get('/notificationsOffer', [OfferFSupController::class, 'allNotificationOffer']);
Route::get("DetaileOffer/{id}", [OfferFSupController::class, 'detaileOffer']);


//Route for old notification
Route::get('/notifications', [ProductsController::class, 'allNotification']);


//Bearen

Route::get('/AllBearenMonthly', [BearenController::class, 'bearen']);
Route::get('/loss', [BearenController::class, 'loss']);
Route::get('/pay', [BearenController::class, 'pay']);
Route::get('/earnings', [BearenController::class, 'earnings']);
Route::get('/revenues', [BearenController::class, 'revenues']);


//maxWanted
Route::get('/max', [BearenController::class, 'maxWanted']);
Route::get('/allProductwillbeempty', [ProductsController::class, 'indexallproductcount']);
Route::get('/allProductwillbeexpire', [ProductsController::class, 'indexallnotificationend']);



//new notify
Route::post('/refreshToken', [AdminController::class, 'refreshToken']);
Route::post('/sendNotify', [AdminController::class, 'sendNotification']);
Route::post('/sendNotifyMuli', [AdminController::class, 'sendNotifications']);








});



