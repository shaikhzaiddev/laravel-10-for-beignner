<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
//use Illuminate\Support\Facades\Facade;
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

//Custom facade
class Facade{
    public static function __callStatic($name,$args){
        return app()->make(static::getFacadeAccessor())->$name(...$args);
    }
}

class Maths{
    public function add($a,$b){
        return $a+$b;
    }
    public function sub($a,$b){
        return $a-$b;
    }
    public function mul($a,$b){
        return $a*$b;
    }
}

class Bike{
    public function start(){
        return 'Starting!!!!!!';
    }
    public function stop(){
        return 'Stoppping!!!!!!';
    }
}


class MathsFacade extends Facade{
    protected static function getFacadeAccessor(){
        return 'maths';
    }
}


class BikeFacade extends Facade{
    protected static function getFacadeAccessor(){
        return 'bike';
    }
}

app()->bind('maths',function(){
    return new Maths;
});

app()->bind('bike', function (){
    return new Bike;
});


Route::get('/', function () {
    //dd(MathsFacade::add(5, 3));
    dd(BikeFacade::start());

   
    //Register in Service Container using service providers
    //dd(app('whats_your_name'));

    $user = User::find(4);
   
    $user->name = 'Shaikh Developer';
    dd($user);
    
    //return view('welcome');
});

Route::get('/dashboard', function () { dd(app('whats_your_name'));
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
