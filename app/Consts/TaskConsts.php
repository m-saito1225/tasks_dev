<?php
namespace App\Consts;

class TaskConsts
{
	// タスクステータス
	public const TASK_INCOMPLETE	= 1 ;
	public const TASK_PROGRESS		= 2 ;
	public const TASK_COMPLETED		= 3 ;
	
	public const TASK_STATUS_LIST = [
		"未対応"			=> self::TASK_INCOMPLETE	,
		"今日やること"	=> self::TASK_PROGRESS		,
		"完了"			=> self::TASK_COMPLETED		,
	];
}
