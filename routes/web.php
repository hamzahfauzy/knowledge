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
        $posts = Post::where('visibility','public');
        
        $tags = "";
        $all_posts = $posts->get();
        foreach($all_posts as $post)
            $tags .= ",".$post->tags;

        $tags = array_unique(explode(',', $tags));
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
                if($_GET['filter']['tag'] != 'NULL')
                    $posts = $posts->where('tags','LIKE','%'.$_GET['filter']['tag'].'%');
            }

            if(!empty($_GET['filter']['user']))
            {
                $posts = $posts->where('posted_by_id',$_GET['filter']['user']);
            }

            if(!empty($_GET['filter']['bulan']) && !empty($_GET['filter']['tahun']))
            {
                $bulan = $_GET['filter']['bulan'];
                $bulan = $bulan < 10 ? "0".$bulan : $bulan; 
                $filter = $_GET['filter']['tahun'].'-'.$bulan;
                $from = $filter.'-01 00:00:00';
                $to = $filter.'-31 23:59:59';
                $posts = $posts->whereBetween('created_at',[$from,$to]);
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
                    if($_GET['filter']['tag'] != 'NULL')
                        $posts = $posts->where('tags','LIKE','%'.$_GET['filter']['tag'].'%');
                }

                if(!empty($_GET['filter']['user']))
                {
                    $posts = $posts->where('posted_by_id',$_GET['filter']['user']);
                }

                if(!empty($_GET['filter']['bulan']) && !empty($_GET['filter']['tahun']))
                {
                    $bulan = $_GET['filter']['bulan'];
                    $bulan = $bulan < 10 ? "0".$bulan : $bulan; 
                    $filter = $_GET['filter']['tahun'].'-'.$bulan;
                    $from = $filter.'-01 00:00:00';
                    $to = $filter.'-31 23:59:59';
                    $posts = $posts->whereBetween('created_at',[$from,$to]);
                }
            }
            $posts = $posts->where('content','LIKE','%'.$_GET['keyword'].'%');
        }
        $posts = $posts->orderby('id','DESC')->paginate(20);
        return view('welcome',compact('posts','tags'));
    })->name('home');

    Route::get('/tags', function () {
        $posts = Post::where('visibility','public')->get();
        $tags = "";
        foreach($posts as $post)
        {
            if($post->tags == "") continue;
            if($tags == "") $tags .= $post->tags;
            else $tags .= ",".$post->tags;
        }
        $tags = array_unique(explode(',', $tags));
        foreach($tags as $key => $tag)
        {
            $num = Post::where('tags','LIKE','%'.$tag.'%')->count();
            if($tag == "")
                $tags[$key] = ['tag'=>'NULL','label'=>"Tanpa Tag (".$num.")"];
            else
                $tags[$key] = ['tag'=>$tag,'label'=>$tag." (".$num.")"];;
        }
        return view('tags',compact('tags'));
    });

    Route::get('/statistic',function(){
        $posts = Post::where('visibility','public');

        if(isset($_GET['filter']))
        {
            if(!empty($_GET['filter']['bulan']) && !empty($_GET['filter']['tahun']))
            {
                $bulan = $_GET['filter']['bulan'];
                $bulan = $bulan < 10 ? "0".$bulan : $bulan; 
                $filter = $_GET['filter']['tahun'].'-'.$bulan;
                $from = $filter.'-01 00:00:00';
                $to = $filter.'-31 23:59:59';
                $posts = $posts->whereBetween('created_at',[$from,$to]);
            }
        }
        
        $posts = $posts->groupby('posted_by_id')
                    ->select('posted_by_name','posted_by_id', DB::raw('count(*) as jumlah'))
                    ->orderby('jumlah','desc')
                    ->get();
        return view('statistic',compact('posts'));
    });

    Route::middleware('jwt_auth')->group(function () {
        Route::get('message-content/{pengaduan_id}',function(){

        })->name('message-content');

        Route::get('/logout',function(){
            \Cookie::forget('labura_layanan_app_token');
            return redirect()->to('https://layanan.labura.go.id');
        })->name('logout');
        Route::get('pengetahuan/{pengetahuan}/delete',[PengetahuanController::class,'delete'])->name('pengetahuan.delete');
        Route::get('pengetahuan/me',[PengetahuanController::class,'index'])->name('pengetahuan.me');
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
    Route::post('{slug}',[PengetahuanController::class,'comment'])->name('comment');
});
