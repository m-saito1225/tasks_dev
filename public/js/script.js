/*------------------------------------------------*/
//タスクの削除時に確認ダイアログを表示する
/*------------------------------------------------*/
function DeleteConfirm() {
	var checked = confirm("選択したタスクを本当に削除してよろしいですか？");

	if ( checked == true ) {
		return true;
	} else {
		return false;
	}
}

/*------------------------------------------------*/
//チェックボックスの常時監視
/*------------------------------------------------*/

$('input[type=checkbox]').change(function () {
	if ( $( this ).prop( 'checked' ) ) {
		$( this ).parents( 'label' ).css( 'background' , '#ccc' );
	} else {
		$( this ).parents( 'label' ).css( 'background' , '#fff' );
	}
});



/*------------------------------------------------*/
//グラフの計算
/*------------------------------------------------*/
function graph(tasks_day_count,tasks_fin_count) {
	const progress = tasks_fin_count/tasks_day_count*100;
	$('.achievement-rate-graph-progress').width (progress + '%' ) ;
}