<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

use App\News;
use App\Profile;

class NewsController extends Controller
{
   public function index(Request $request)
   {
     $cond_title = $request->cond_title;
     // $cond_title が空白でない場合は記事を検索して取得する
     if ($cond_title != '') {
         $posts = News::where('title', $cond_title).orderBy('updated_at', 'desc')->get();
     } else {
         $posts = News::all()->sortByDesc('updated_at');
     }
     if (count($posts) > 0) {
         $headline = $posts->shift();
     } else {
         $headline = null;
     }

     //news/index.blade.php ファイルを渡している
     // また View テンプレートに headline posts cond_title という変数を渡している
     return view('news.index', ['headline' => $headline, 'posts' => $posts, 'cond_title' => $cond_title]);
   }

   public function profile()
   {
     $profile = Profile::orderBy('created_at', 'desc')->first();
     $profiles = Profile::all();

     return view('news.profile',['profiles' => $profiles]);
   }
}
