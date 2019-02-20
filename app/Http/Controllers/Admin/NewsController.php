<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;

//historyの使用許可
use App\History;
//じかん
use Carbon\Carbon;

class NewsController extends Controller
{
    //以下を追記
    public function add(){
      return view('admin.news.create');
    }
    public function create(Request $request){
      $this->validate($request, News::$rules);
      //Varidationを行う
      $news = new News;
      $form = $request->all();
      //フォームから画像が送られてきたら、保存して、$news->image_pathに画像のパスを保存
      if (isset($form['image'])){
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
      }else{
        $news->image_path = null;
      }
      //フォームから送信されてきた_tokenを削除
      unset($form['_token']);
      //フォームから送信されてきたimageを削除
      unset($form['image']);
      //データベースに保存
      $news->fill($form);
      $news->save();

      return redirect('admin/news/create');
    }

    public function index(Request $request){
      $cond_title= $request->cond_title;
      if ($cond_title != ''){
        $posts = News::where('title', $cond_title)->get();
      }else {
        $posts = News::all();
      }
      return view('admin.news.index', ['posts' => $posts,
       'cond_title'=> $cond_title]);
    }

    public function edit(Request $request){
      $news = News::find($request->id);
      if(empty($news)) {
        abort(404);
      }
      return view('admin.news.edit', ['news_form' => $news]);
    }

    public function update(Request $request){
      //Validationをかける
      $this->validate($request, News::$rules);
      //News Modelからデータ取得
      $news = News::find($request->id);
      //送信されてきたフォームデータを格納
      $news_form = $request->all();
      //画像変更時対策
      if (isset($news_form['image'])){
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
      }else{
        $news->image_path = null;
      }
      //\Debugbar::info(isset($news_form['image']));
      unset($news_form['_token']);
      unset($news_form['image']);
      //該当するデータを上書き保存
      $news->fill($news_form)->save();

      //histories関連
      $history = new History;
      $history->news_id = $news->id;
      $history->edited_at = Carbon::now();
      $history->save();

      return redirect('admin/news/');
    }

    public function delete(Request $request){
      //該当するNews Modelを取得
      $news = News::find($request->id);
      //削除
      $news->delete();
      return redirect('admin/news/');
    }
}
