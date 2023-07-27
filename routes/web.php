<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
    $user = User::find(4);
   
    $user->name = 'Shaikh Developer';
    dd($user);
    
    //return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar',[AvatarController::class,'update'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/users',function(){
    $users = DB::select('select * from users');
    dd($users);
})->middleware(['auth', 'verified'])->name('users');

Route::get('/users/create',function(){
    $users = DB::insert('insert into users (name,email,password) values (?,?,?)',['shaikh Erum','shaikh.erum.it@gmail.com','admin1111']);
    dd($users);
})->middleware(['auth', 'verified'])->name('usersCreate');

Route::get('/users/update',function(){
    $users = DB::update('update users set email = ? where name = ?',[
        'shaikh.erum.kid@gmail.com',
        'shaikh Erum']);
    dd($users);
})->middleware(['auth', 'verified'])->name('usersUpdate');


Route::middleware(['auth','verified'])->get('usersList',function(){
    $users =  DB::table('users')->where('email','shaikh.erum.kid@gmail.com')->get('name');
    return $users;
});


Route::get('/usersCreate', function(){
    $users = DB::table('users')->insert([
        'name' => 'shaikh Jasmina',
        'email' => 'shaikh.jasmina.it@gmail.com',
        'password' => 'admin123456'
    ]);
})->middleware(['auth','verified']);


Route::get('/usersUpdates',function(){
     $users = DB::table('users')
     ->where('id',2)
     ->update(['name'=>'Erum Shaikh Cuteee']);
     return $users;
});

Route::get('/users/{id}',function($id){
    
    $user = DB::table('users')->find($id);
    return $user;
});


require __DIR__.'/auth.php';
