<?php
namespace App\Consts;

class BookConsts
{
	// タスクステータス
	public const VERYBAD	= 1	;
	public const BAD		= 2	;
	public const NORMAL		= 3 ;
	public const GOOD		= 4 ;
	public const VERYGOOD	= 5 ;
	
	public const BOOK_STATUS_LIST = [
		"とてもいい"	=> self::VERYGOOD	,
		"良い"		=> self::GOOD		,
		"普通"		=> self::NORMAL		,
		"悪い"		=> self::BAD		,
		"とても悪い"	=> self::VERYBAD	,
	];
}
