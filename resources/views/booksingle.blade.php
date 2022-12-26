<?php


// echo "<pre>";
// echo var_dump(@$book);
// echo "</pre>";

?>
<?php
// echo "<pre>";
// var_dump(BookConsts::BOOK_STATUS_LIST);
// echo "</pre>";
?>
<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('top') }}
		</h2>
	</x-slot>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				@if (session('SuccessMessage'))
				<div class="success-message mt-3 text-center">
					{{ session('SuccessMessage') }}
				</div>
				@endif
				@if (session('ErrorMessage'))
				<div class="error-message mt-3 text-center">
					{{ session('ErrorMessage') }}
				</div>
				@endif
				<h2 class="">読書詳細</h2>
			</div>
			<div class="flex">
				<div class="col-sm-12 col-md-12">
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					<div class="bg-white overflow-hidden mt-4">
						<div class="p-6 bg-white">
							<!--  -->
							{{Form::open(['url' => 'upsertBook'])}}
							{{Form::token()}}
							<!--CSRFトークン-->

							<div class="row border-bottom mb-4">
								<div class="col-12 col-md-11">
									<!--読書タイトル-->
									<div class="form-group row">
										<div class="col-md-12">
											{{Form::text(
										'book_title' , @$book->title , [
											'class' 		=> 'form-control'				,
											'id' 			=> 'BookTitle'					,
											'placeholder' 	=> '本のタイトルを入力してください'	
										]
									)}}
										</div>
									</div>
									<!--/読書タイトル-->
									<div class="row">
										<div class="col-6">
											<!--読書カテゴリ-->
											<div class="form-group row">
												<input type="radio" name="radio" class="form-control">test
												<input type="radio" name="radio" class="form-control">test
												<input type="radio" name="radio" class="form-control">test
											</div>
											<!--/読書カテゴリ-->
										</div>
										<div class="col-6 text-right">
											<!--/読書評価  -->
											<div class="form-group row d-inline-block">
												@foreach ( BookConsts::BOOK_STATUS_LIST as $key => $value )
												<label class="mr-2 mb-0">
													<input class="form-control" type="radio" name="book_evaluation" value="{{ $value }}" {{ @$book->evaluation == $value ? "checked" : "" }}>{{ $key }}
												</label>
												@endforeach
											</div>
											<!--/読書評価  -->
										</div>
									</div>
								</div>
								<div class="col-12 col-md-1">
									<!--読書の画像-->
									<div class="form-group row">
										<div class="col-md-10">
											<img src="{{@$book->img_path}}" alt="">
										</div>
									</div>
									<!--/読書の画像-->
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-md-6">
									<!--読書ワード-->
									<div class="form-group">
										<div class="">いいと思った言葉を入力してください</div>
										{{Form::textarea(
											'book_word' , @$book->word , [
												'class' 		=> 'form-control h-100'			,
												'id' 			=> 'BookWord'					,
												'placeholder' 	=> '気になったワード'	
											]
										)}}
									</div>
									<!--/読書ワード-->
								</div>
								<div class="col-12 col-md-6">
									<!--読書の詳細-->
									<div class="form-group">
										<div class="">感想を入力してください</div>
										{{Form::textarea(
											'book_detail' , @$book->detail , [
												'class' => 'form-control h-100' ,
												'id' 	=> 'BookDetail'
											]
										)}}
									</div>
									<!--/読書の詳細-->
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-md-6">
									<!--読書備考-->
									<div class="form-group">
										<div class="">備考</div>
										{{Form::text(
											'book_remarks' , @$book->remarks , [
												'class'			=> 'form-control h-100'		,
												'id'			=> 'BookRemarks'			,
												'placeholder'	=> '備考を入力してください'
											]
										)}}
									</div>
									<!--/読書備考-->
								</div>
								<div class="col-12 col-md-6">
									<!-- /画像URL -->
									<div class="form-group">
										<div class="">画像の絶対パス</div>
										{{Form::text(
											'book_img_path' , @$book->img_path , [
											'class' 		=> 'form-control h-100'			,
											'id' 			=> 'BookImgPath'				,
											'placeholder' 	=> '本の画像URLを入力してください'	
										]
									)}}
									</div>
									<!-- /画像URL -->
								</div>
							</div>
							<!--送信-->
							<div class="form-group row">
								<div class="col-sm-12">
									{{Form::button('送信' , [
										'class'	=> 'btn btn-send btn-block'	,
										'name'	=> 'book_id'					,
										'value'	=> @$book->id					,
										'type'	=> 'submit'						])
									}}
								</div>
							</div>
							<!--/送信-->
							{{Form::close()}}
							<!--</form>-->
							<!--  -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>