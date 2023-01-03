<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use App\Models\Book;
use App\Consts\TaskConsts;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;		//クエリビルダ

class TopsController extends Controller
{
	public function index()
	{
		/*----------------------------*/
		//今日のタスク
		/*----------------------------*/
		$today_task = DB::table('tasks')
		->join( 'categories' , 'tasks.category' , '=' , 'categories.id' )
		->where([
			[ 'tasks.user_id'	, '=' 	, Auth::user()->id				] ,
			['tasks.status'		, '=' 	, TaskConsts::TASK_PROGRESS		]
		])
		//idカラム名の重複回避のため名前だけ取得
		->get([ 'tasks.*' , 'categories.category_name']);

		/*----------------------------*/
		//未対応
		/*----------------------------*/
		$tasks3 = DB::table('tasks')
		->join('categories', 'tasks.category', '=', 'categories.id')
		->where([
			[ 'tasks.user_id'		, '='	, Auth::user()->id				] ,
			[ 'tasks.status'		, '='	, TaskConsts::TASK_INCOMPLETE	]
		])
		//idカラム名の重複回避のため名前だけ取得
		->get(['tasks.*', 'categories.category_name']);

		/*----------------------------*/
		//完了
		/*----------------------------*/
		$tasks4 = DB::table('tasks')
		->join('categories', 'tasks.category', '=', 'categories.id')
		->where([
			[ 'tasks.user_id'	, '='	, Auth::user()->id				] ,
			[ 'tasks.status'	, '='	, TaskConsts::TASK_COMPLETED	]
		])
		->orderBy('updated_at', 'desc')
		->limit(16)
		//idカラム名の重複回避のため名前だけ取得
		->get(['tasks.*', 'categories.category_name']);

		$task_status_list_flip = array_flip(TaskConsts::TASK_STATUS_LIST);
		$tasks 		= array( 
			$task_status_list_flip[2] => $today_task	, 
			$task_status_list_flip[1] => $tasks3		, 
			$task_status_list_flip[3] => $tasks4		)
		;

		$tasks_fin_count = DB::table('tasks')
		->join('categories', 'tasks.category', '=', 'categories.id')
		->where([
			[ 'tasks.user_id'	, '=' , Auth::user()->id			] ,
			[ 'tasks.status'	, '=' , TaskConsts::TASK_COMPLETED	]
		])
		//idカラム名の重複回避のため名前だけ取得
		->get(['tasks.*', 'categories.category_name']);

		//やることリストのカウント
		$tasks_day_count = count($today_task);
		$tasks_fin_count = count($tasks_fin_count);
		$tasks_day_count = $tasks_day_count + $tasks_fin_count;
		// dd($today_task);

		//カテゴリーテーブルの情報取得
		$categories = Category::get();

		//タスクステータス一覧のステータス名と数値情報の取得
		$select_task_list = array_flip(TaskConsts::TASK_STATUS_LIST) ;
		array_unshift( $select_task_list , "チェックしたステータスの変更" ) ;

		return view('top.index')->with([
			'tasks'				=> $tasks				,
			'categories'		=> $categories			,
			'select_task_list'	=> $select_task_list	,
			'tasks_day_count'	=> $tasks_day_count		,
			'tasks_fin_count'	=> $tasks_fin_count		,
		]);
	}


	public function upsertTask( Request $request ){

		if ( empty( $request ) ) {
			return redirect('/top')->with('ErrorMessage', 'エラーが発生しました');
		}else {


			//--------------------------------------------------------
			//バリデーション
			//--------------------------------------------------------
			$request->validate(
				[
					'task_title'	=> [ 'required' , 'string' , 'max:30' ]	,
					'task_detail'	=> [ 'max:255' ]						,
					'task_remarks'	=> [ 'max:50' ]							,
					'task_category'	=> [ 'required' ]						,
					//'task_remarks'	=> ['integer'],			//参考
				],
				[
					'task_title.required'		=> 'タイトルは必須です'					  ,
					'task_title.max'			=> 'タイトルの文字数は最大30文字までです'	 ,
					'task_detail.max'			=> '詳細の文字数は最大255文字までです'		,
					'task_remarks.max'			=> '備考の文字数は最大50文字までです'		,
					'task_category.required'	=> 'カテゴリーは必須です'					,
					//'task_remarks.integer'	=> '整数です',	//参考
				]
			);
			
			//--------------------------------------------------------
			//画像の保存と削除
			//--------------------------------------------------------
			//画像のパスを取得
			$target_img_path = Task::where([
				[ 'id'		, '=' , $request->task_id ] ,
				[ 'user_id'	, '=' , Auth::user()->id ]
			])->first('img_path');

			//画像ファイルの保存

			//画像ファイル登録のリクエストがあったら
			if( isset($request->task_img ) ) {
				// アップロードされたファイルの取得
				$image = $request->file('task_img');
				// 保存先のディレクトリ
				$dir = 'task_img';
				//保存処理 画像があれば画像を保存して、ディレクトリ/画像名.拡張子までを$pathへ格納。なければ何もしない
				$path = isset($image) ? $image->store($dir, 'public') : '';

				//画像の削除 ※すでに画像がアップロードされていた場合、過去にアップロードした画像ファイルを削除する。
				if (isset($target_img_path)) {
					Storage::delete('/public/' . $target_img_path["img_path"]);
				}
			}
			//画像ファイル登録のリクエストが無かったら
			else {
				$path = @$target_img_path["img_path"];
			}
			//--------------------------------------------------------
			//保存前処理
			//--------------------------------------------------------
			//初回登録時はステータスをTASK_INCOMPLETEにする。編集後はリクエストされた値を代入。
			if( isset( $request->task_status ) ) {
				$task_status = $request->task_status ;
			}else {
				$task_status = TaskConsts::TASK_INCOMPLETE ;
			}
			//--------------------------------------------------------
			//DBへの保存
			//--------------------------------------------------------
			//upsert処理▼
			$data = array(
				'id'		=> $request->task_id		,
				'user_id'	=> Auth::user()->id			,
				'title'		=> $request->task_title		,
				'limit'		=> $request->task_limit		,
				'detail'	=> $request->task_detail	,
				'img_path'	=> $path					,
				'remarks'	=> $request->task_remarks	,
				'status'	=> $task_status				,
				'category'	=> $request->task_category	,
			);

			//第1引数...更新したい内容 連想配列
			//第2引数...プライマリーキー insertかupdateどちらなのかを判別するカラムの指定
			//第3引数...更新したいカラム 省略可
			Task::upsert($data, ['id']);
			//upsert処理▲
		}
		return redirect('/top')->with('SuccessMessage', 'タスクの登録が完了しました');
	}


	public function updateStatus( Request $request )
	{

		// dd($request->task_status);
		// dd(TaskConsts::TASK_PROGRESS);


		//選択していない時
		if ( empty( $request->task_id ) ) {
			return redirect('/top')->with('ErrorMessage', '変更するタスクを選択してください');  
		}
		
		foreach ( $request->task_id as $task_id ) {
			//チェックしたタスクIDを取得
			$task = Task::find($task_id);
			//ステータスを更新
			$task->status 		= $request->task_status ;
			$task->updated_at 	= \Carbon\Carbon::now()	;
			//セーブ
			$task->save();
		}
		return redirect('/top')->with('SuccessMessage', 'ステータスを変更しました');
	}




	public function deleteTask(Request $request)
	{
		//選択していない時
		if(empty($request->task_id)) {
			return redirect('/top')->with('ErrorMessage', 'タスクが選択されていません');
		}
		
		//削除処理
		foreach ($request->task_id as $task_id) {
			//チェックしたタスクIDを取得
			$task = Task::find($task_id);
			//タスクテーブルのレコードの削除
			$task::destroy($task_id);
		}
		return redirect('/top')->with('SuccessMessage', 'タスクの削除が完了しました');
	}


	public function copyTask(Request $request)
	{
		//選択していない時
		if (empty($request->task_id)) {
			return redirect('/top')->with('ErrorMessage', 'コピーするタスクが選択されていません');
		}

		foreach ($request->task_id as $task_id) {
			//チェックしたタスクIDを取得
			$task = Task::find($task_id);
			//コピー処理
			$copy_task = $task->replicate();
			//変更したいカラムに値をセット(日付は今日にする)
			$copy_task->limit 	= \Carbon\Carbon::now();
			$copy_task->status 	= TaskConsts::TASK_PROGRESS;
			//save
			$copy_task->save();
		}
		return redirect('/top')->with('SuccessMessage', 'タスクのコピーが完了しました');
	}













}
