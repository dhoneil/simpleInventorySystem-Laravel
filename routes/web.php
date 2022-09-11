<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemCodeController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ItemGenreController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeauticianController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\SaleTransactionController;
use App\Http\Controllers\UserInformationController;
use App\Http\Controllers\RegistrationTokenController;
use App\Http\Controllers\PurchaseTransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


//LOGIN
Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/',[LoginController::class,'store']);

//LOGOUT
Route::post('/logout',[LogoutController::class, 'logout'])->name('logout');

//REGISTER
Route::get('/register',[RegisterController::class,'index'])->name('register');
Route::get('/register/token',[RegisterController::class,'registration_token'])->name('registration_token');
Route::post('/register/create',[RegisterController::class,'create'])->name('register_create');

//REGISTRATION TOKEN
Route::get('/admin/registration_tokens',[RegistrationTokenController::class,'index'])->name('registration_tokens');
Route::get('/admin/registration_tokens_list',[RegistrationTokenController::class,'GetAll'])->name('registration_tokens_list');
Route::get('/admin/registration_tokens_list_json',[RegistrationTokenController::class,'GetAllJson'])->name('registration_tokens_list_json');
Route::get('/admin/generate_token',[RegistrationTokenController::class,'generate_token'])->name('generate_token');
Route::post('/admin/registration_tokens_single',[RegistrationTokenController::class,'GetSingle'])->name('registration_tokens_single');
Route::post('/admin/registration_tokens_create',[RegistrationTokenController::class,'Save'])->name('registration_tokens_create');


//HELPERS
Route::get('/helper/getsingle',[HelperController::class,'GetSingleJson'])->name('get_single_json');

//CUSTOMERS
Route::get('/admin/customers',[CustomerController::class,'index'])->name('customers');
Route::get('/admin/customers_list',[CustomerController::class,'GetAll'])->name('customers_list');
Route::get('/admin/customers_list_json',[CustomerController::class,'GetAllJson'])->name('customers_list_json');
Route::post('/admin/customers_single',[CustomerController::class,'GetSingle'])->name('customers_single');
Route::post('/admin/customers_create',[CustomerController::class,'Save'])->name('customers_create');

//BEAUTICIAN
Route::get('/admin/beauticians',[BeauticianController::class,'index'])->name('beauticians');
Route::get('/admin/beauticians_list',[BeauticianController::class,'GetAll'])->name('beauticians_list');
Route::get('/admin/beauticians_list_json',[BeauticianController::class,'GetAllJson'])->name('beauticians_list_json');
Route::post('/admin/beautician_services_list_json',[BeauticianController::class,'GetBeauticianServices'])->name('beautician_services_list_json');
Route::post('/admin/beauticians_single',[BeauticianController::class,'GetSingle'])->name('beauticians_single');
Route::post('/admin/beauticians_create',[BeauticianController::class,'Save'])->name('beauticians_create');

//SERVICE
Route::get('/admin/Services',[ServiceController::class,'index'])->name('Services');
Route::get('/admin/Services_list',[ServiceController::class,'GetAll'])->name('Services_list');
Route::get('/admin/Services_list_json',[ServiceController::class,'GetAllJson'])->name('Services_list_json');
Route::post('/admin/Services_single',[ServiceController::class,'GetSingle'])->name('Services_single');
Route::post('/admin/Services_create',[ServiceController::class,'Save'])->name('Services_create');

//APPOINTMENT
Route::get('/admin/Appointments',[AppointmentController::class,'index'])->name('Appointments');
Route::get('/admin/Appointments_list',[AppointmentController::class,'GetAll'])->name('Appointments_list');
Route::post('/admin/Appointments_single',[AppointmentController::class,'GetSingle'])->name('Appointments_single');
Route::post('/admin/Appointments_create',[AppointmentController::class,'Save'])->name('Appointments_create');
Route::get('/Appointment/Create',[AppointmentController::class,'external'])->name('Appointments_create_external');

//PRODUCTS
Route::get('/admin/Products',[ProductController::class,'index'])->name('Products');
Route::get('/admin/Products_list',[ProductController::class,'GetAll'])->name('Products_list');
Route::get('/admin/Products_list_json',[ProductController::class,'GetAllJson'])->name('Products_list_json');
Route::post('/admin/Products_single',[ProductController::class,'GetSingle'])->name('Products_single');
Route::post('/admin/Products_create',[ProductController::class,'Save'])->name('Products_create');

//ITEMS
Route::get('/admin/items',[ItemController::class,'index'])->name('items');
Route::get('/admin/Items_list',[ItemController::class,'GetAll'])->name('Items_list');
Route::get('/admin/items_list_json',[ItemController::class,'GetAllJson'])->name('items_list_json');
Route::post('/admin/items_single',[ItemController::class,'GetSingle'])->name('items_single');
Route::post('/admin/items_create',[ItemController::class,'Save'])->name('items_create');
Route::post('/admin/ItemInOutList',[ItemController::class,'GetInOutItems'])->name('ItemInOutList');

//ITEM CODE
Route::get('/admin/ItemCodes',[ItemCodeController::class,'index'])->name('ItemCodes');
Route::get('/admin/ItemCodes_list',[ItemCodeController::class,'GetAll'])->name('ItemCodes_list');
Route::get('/admin/ItemCodes_list_json',[ItemCodeController::class,'GetAllJson'])->name('ItemCodes_list_json');
Route::post('/admin/ItemCodes_single',[ItemCodeController::class,'GetSingle'])->name('ItemCodes_single');
Route::post('/admin/ItemCodes_create',[ItemCodeController::class,'Save'])->name('ItemCodes_create');

//ITEM GENRE
Route::get('/admin/ItemGenres',[ItemGenreController::class,'index'])->name('ItemGenres');
Route::get('/admin/ItemGenres_list',[ItemGenreController::class,'GetAll'])->name('ItemGenres_list');
Route::get('/admin/ItemGenres_list_json',[ItemGenreController::class,'GetAllJson'])->name('ItemGenres_list_json');
Route::post('/admin/ItemGenres_single',[ItemGenreController::class,'GetSingle'])->name('ItemGenres_single');
Route::post('/admin/ItemGenres_create',[ItemGenreController::class,'Save'])->name('ItemGenres_create');

//SALE TRANSACTION
Route::get('/admin/SaleTransactions',[SaleTransactionController::class,'index'])->name('SaleTransactions');
Route::get('/admin/SaleTransactions_list',[SaleTransactionController::class,'GetAll'])->name('SaleTransactions_list');
Route::get('/admin/SaleTransactions_list_json',[SaleTransactionController::class,'GetAllJson'])->name('SaleTransactions_list_json');
Route::post('/admin/SaleTransactions_single',[SaleTransactionController::class,'GetSingle'])->name('SaleTransactions_single');
Route::post('/admin/SaleTransactions_create',[SaleTransactionController::class,'Save'])->name('SaleTransactions_create');

//PURCHASE TRANSACTION
Route::get('/admin/PurchaseTransactions',[PurchaseTransactionController::class,'index'])->name('PurchaseTransactions');
Route::get('/admin/PurchaseTransactions_list',[PurchaseTransactionController::class,'GetAll'])->name('PurchaseTransactions_list');
Route::get('/admin/PurchaseTransactions_list_json',[PurchaseTransactionController::class,'GetAllJson'])->name('PurchaseTransactions_list_json');
Route::post('/admin/PurchaseTransactions_single',[PurchaseTransactionController::class,'GetSingle'])->name('PurchaseTransactions_single');
Route::post('/admin/PurchaseTransactions_create',[PurchaseTransactionController::class,'Save'])->name('PurchaseTransactions_create');

//PROFIT
Route::get('/admin/Profit',[ProfitController::class,'index'])->name('Profit');
Route::post('/admin/GetAllProfit',[ProfitController::class,'GetAllProfit'])->name('GetAllProfit');
Route::post('/admin/GetAllExpenses',[ProfitController::class,'GetAllExpenses'])->name('GetAllExpenses');

//USERS
Route::get('/admin/Users',[UserInformationController::class,'index'])->name('Users');
Route::get('/admin/Users_list',[UserInformationController::class,'GetAll'])->name('Users_list');
Route::post('/admin/Users_single',[UserInformationController::class,'GetSingle'])->name('Users_single');
Route::post('/admin/Users_create',[UserInformationController::class,'Save'])->name('Users_create');

//USER ROLES
Route::get('/admin/UserRoles',[UserRoleController::class,'index'])->name('UserRoles');
Route::get('/admin/UserRoles_list',[UserRoleController::class,'GetAll'])->name('UserRoles_list');
Route::get('/admin/UserRoles_list_json',[UserRoleController::class,'GetAllJson'])->name('UserRoles_list_json');
Route::post('/admin/UserRoles_single',[UserRoleController::class,'GetSingle'])->name('UserRoles_single');
Route::post('/admin/UserRoles_create',[UserRoleController::class,'Save'])->name('UserRoles_create');





//externals
Route::get('/users/appointment',[UserController::class,'appointment'])->name('user_appointment');
Route::get('/users/beauticians',[UserController::class,'getBeauticians'])->name('user_get_beauticians');