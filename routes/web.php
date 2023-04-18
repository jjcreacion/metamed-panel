<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

*/
Route::get('/', function () {
    return view('auth.login');
});

//Route::get('/', [ControllerUser::class,'index']);

/*
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dash', function () {
        return view('dash.index');
    })->name('dash');
}); */

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dash', [ControllerUser::class,'index']);
    Route::post('/deleteuser',[ControllerUser::class,'destroy']);
    Route::post('/getuser',[ControllerUser::class,'getuser']);
    Route::post('/updateuser',[ControllerUser::class,'update']);
    Route::post('/mostrardatos/{id}',[ControllerUser::class,'mostrardatos']);
    Route::post('/allusers',[ControllerUser::class,'allusers']);
});


