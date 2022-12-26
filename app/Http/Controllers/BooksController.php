<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use App\Models\Book;
use App\Consts\TaskConsts;
use App\Consts\BookConsts;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;		//クエリビルダ

class BooksController extends Controller
{
	public function bookarchive()
	{
		$books = DB::table('books')->orderByDesc( 'created_at' , 'updeted_at' )->paginate(20);
		return view('bookarchive')->with([
			'books'	=> $books,
		]);
	}

	public function booksingle( Request $request )
	{

		if (empty($request)) {
			return redirect('/bookarchive')->with('ErrorMessage', 'エラーが発生しました');
		} else {
			//カテゴリーテーブルの情報取得
			$book = Book::where([
				['user_id'	, '=', Auth::user()->id ],
				['id'		, '=', $request->book_id]
			])->first();	//1レコード取得の場合はfirstを使用

			return view('booksingle')->with([
				'book'		=> $book,
			]);
		}
	}

	public function upsertBook(Request $request)
	{

		// dd($request);
		if (empty($request)) {
			return redirect('/top')->with('ErrorMessage', 'エラーが発生しました');
		} else {


			//--------------------------------------------------------
			//バリデーション
			//--------------------------------------------------------
			$request->validate(
				[
					'book_title'		=> ['required', 'string', 'max:100'],
					'book_word'			=> ['max:10000'],
					'book_detail'		=> ['max:10000'],
					'book_path'			=> ['max:100'],
					'book_remarks'		=> ['max:50'],
					#'book_category'		=> ['required'],
					'book_evaluation'	=> ['required'],
					//'task_remarks'	=> ['integer'],			//参考
				],
				[
					'book_title.required'		=> 'タイトルは必須です',
					'book_title.max'			=> 'タイトルの文字数は最大30文字までです',
					'book_detail.max'			=> '詳細の文字数は最大255文字までです',
					'book_remarks.max'			=> '備考の文字数は最大50文字までです',
					#'book_category.required'	=> 'カテゴリーは必須です',
					//'task_remarks.integer'	=> '整数です',	//参考
				]
			);

			//--------------------------------------------------------
			//DBへの保存
			//--------------------------------------------------------
			//upsert処理▼
			$data = array(
				'id'			=> $request->book_id,
				'user_id'		=> Auth::user()->id,
				'title'			=> $request->book_title,
				'word'			=> $request->book_word,
				'detail'		=> $request->book_detail,
				'img_path'		=> $request->book_img_path,
				'remarks'		=> $request->book_remarks,
				'category'		=> $request->book_category,
				'evaluation'	=> $request->book_evaluation,
			);

			//第1引数...更新したい内容 連想配列
			//第2引数...プライマリーキー insertかupdateどちらなのかを判別するカラムの指定
			//第3引数...更新したいカラム 省略可
			Book::upsert($data, ['id']);
			//upsert処理▲
		}
		return redirect('/bookarchive')->with('SuccessMessage', '読書の登録が完了しました');
	}
}
