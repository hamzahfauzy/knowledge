<?php

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\OtpAuthController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\PengetahuanController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\NotifEventController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Pengawas\DashboardController as PengawasDashboardController;
use App\Http\Controllers\Pengawas\PengaduanController as PengawasPengaduanController;

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

Route::get('auth/login/{id}/{token}',function(){
    return redirect()->route('home');
});

Route::middleware('jwt_middleware')->group(function () {

    Route::get('/', function () {
        $categories = Category::get();
        $posts = Post::where('visibility','public');
        if(isset($_GET['filter']))
        {
            if(!empty($_GET['filter']['opd']))
            {
                $posts = $posts->whereHas('shares',function($q) {
                    $q->where('opd_id',$_GET['filter']['opd']);
                });
            }

            if(!empty($_GET['filter']['category']))
            {
                $posts = $posts->whereHas('categories',function($q) {
                    $q->where('category_id',$_GET['filter']['category']);
                });
            }

            if(!empty($_GET['filter']['tag']))
            {
                $posts = $posts->where('tags','LIKE','%'.$_GET['filter']['tag'].'%');
            }
        }

        if(isset($_GET['keyword']))
        {
            $posts = $posts->where('title','LIKE','%'.$_GET['keyword'].'%');
            $posts = $posts->orwhere('visibility','public');
            if(isset($_GET['filter']))
            {
                if(!empty($_GET['filter']['opd']))
                {
                    $posts = $posts->where('opd_id',$_GET['filter']['opd']);
                }

                if(!empty($_GET['filter']['category']))
                {
                    $posts = $posts->whereHas('categories',function($q) {
                        $q->where('category_id',$_GET['filter']['category']);
                    });
                }

                if(!empty($_GET['filter']['tag']))
                {
                    $posts = $posts->where('tags','LIKE','%'.$_GET['filter']['tag'].'%');
                }
            }
            $posts = $posts->where('content','LIKE','%'.$_GET['keyword'].'%');
        }
        $posts = $posts->orderby('id','DESC')->paginate(20);
        return view('welcome',compact('posts','categories'));
    })->name('home');

    Route::prefix('otp')->name('otp.')->group(function () {
        Route::get('/', [OtpAuthController::class, 'index'])->name('index');
        Route::post('send', [OtpAuthController::class, 'send'])->name('send');
        Route::post('verified', [OtpAuthController::class, 'verified'])->name('verified');
    });

    Route::prefix('guest')->name('guest.')->group(function () {
        Route::get('/', [GuestController::class, 'index'])->name('index');
        Route::middleware('otp_auth')->group(function () {
            Route::get('/', [GuestController::class, 'index'])->name('index');
            Route::get('create', [GuestController::class, 'create'])->name('create');
            Route::post('store', [GuestController::class, 'store'])->name('store');
            Route::post('send-msg/{pengaduan}', [GuestController::class, 'sendMsg'])->name('send-msg');
            Route::get('conversation/{pengaduan}', [GuestController::class, 'conversation'])->name('conversation');
            Route::get('show/{pengaduan}', [GuestController::class, 'show'])->name('show');
        });

        // otp
        Route::get('message-content/{pengaduan_id}',function(Pengaduan $pengaduan){
            
        })->name('message-content');
    });

    Route::middleware('jwt_auth')->group(function () {
        Route::get('message-content/{pengaduan_id}',function(){

        })->name('message-content');

        Route::get('/logout',function(){
            \Cookie::forget('labura_layanan_app_token');
            return redirect()->to('https://layanan.labura.go.id');
        })->name('logout');
        Route::get('pengetahuan/{pengetahuan}/delete',[PengetahuanController::class,'delete'])->name('pengetahuan.delete');
        Route::resource('pengetahuan',PengetahuanController::class);
        Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
            Route::get('kategori/{kategori}/delete',[CategoryController::class,'delete'])->name('kategori.delete');
            Route::resource('kategori', CategoryController::class);
            Route::match(['get','post'],'notif', [NotifEventController::class,'index'])->name('notif.index');
            // Route::resource('notif', NotifEventController::class);
        });
    });

    Route::get('{slug}',[PengetahuanController::class,'detail'])->name('detail');
});
