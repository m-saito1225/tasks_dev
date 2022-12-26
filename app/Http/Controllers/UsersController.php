<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use App\Models\Book;
use App\Consts\TaskConsts;

class UsersController extends Controller
{
	public function regist( Request $request )
	{

		//タスクテーブルの情報
		$tasks = Task::where([
				[ 'user_id' , '=' , Auth::user()->id  ] ,
				[ 'id' 		, '=' , $request->task_id ]
		])->first();	//1レコード取得の場合はfirstを使用
		$categories = Category::get();

		//タスクステータス一覧のステータス名と数値情報の取得
		$select_task_list = array_flip(TaskConsts::TASK_STATUS_LIST);

		//viewへ
		return view('regist')->with([
			'tasks'				=> $tasks			,
			'categories'		=> $categories		,
			'select_task_list'	=> $select_task_list,
		]);
	}
}
