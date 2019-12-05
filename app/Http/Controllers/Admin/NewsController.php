<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\News;
use App\History;
use Carbon\Carbon;
use Storage;
class NewsController extends Controller
{
  public function add()
  {
      return view('admin.news.create');
  }

  public function create(Request $request)//Requestクラスでユーザーから送られる情報を全て含んでいるオブジェクトを取得。
  { 
      $this->validate($request, News::$rules);
      
      
      $news = new News;//Newsモデルからインスタンス（NewsレコードつまりNewsテーブル）を生成
      $form = $request->all();//ユーザーが入力したデータを取得できる

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {//引数の中のデータの有無を判断するメソッド
       $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
        $news->image_path = Storage::disk('s3')->url($path);
      } else {
          $news->image_path = null;
      }
      //25行目の$formに入っているtokenとimageを削除する（titleとbodyに値があればNewsテーブルに保存できる
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // $formの配列をカラムに代入→データベースに保存する。そのためのfillメソッド
      $news->fill($form);//これでデータを入れることができる
      $news->save();//データを保存
      // admin/news/createにリダイレクトする
      return redirect('admin/news/create');
  }  
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title !='') {
        // 検索されたら検索結果を取得する
        $posts = News::where('title', $cond_title)->get();//newsテーブルのtitleカラムで$cond_titleに一致するレコードを全て取得
      } else {
        // それ以外はすべてのニュースを取得する
        $posts = News::all();//Newsモデルを使ってnewsテーブルのレコードを全て取得している
      }
      return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);//Requestにcond_titleを送っている
  }


public function edit(Request $request)//編集画面の部分
  {
      // News Modelからデータを取得する
      $news = News::find($request->id);
      if (empty($news)) {
        abort(404);    
      }
      return view('admin.news.edit', ['news_form' => $news]);
  }

public function update(Request $request)//編集画面から送信されたフォームデータを処理する部分
  {
      $this->validate($request, News::$rules);
        $news = News::find($request->id);
        $news_form = $request->all();
        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
          $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
           $news->image_path = Storage::disk('s3')->url($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }

        unset($news_form['_token']);
        unset($news_form['image']);
        unset($news_form['remove']);
        $news->fill($news_form)->save();
      
      $history = new History;
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();//現在時刻を取得
        $history->save();

       return redirect('admin/news');
  }
  
  public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $news = News::find($request->id);
      // 削除する
      $news->delete();//$news->save();の逆
      return redirect('admin/news/');
  }  
}