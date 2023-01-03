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
				<h2 class="">タスクの登録/更新</h2>
			</div>
			<div class="flex inner">
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
							{{Form::open(['url' => 'upsertTask' , 'files' => true ])}}
							{{Form::token()}}
							<!--CSRFトークン-->
								<!--タスクタイトル-->
								<div class="form-group row">
									<div class="col-md-2 mb-3 no-wrap">
										{{Form::label('task_title' , 'やること')}}
									</div>
									<div class="col-md-10">
										{{Form::text(
											'task_title' , @$tasks->title , [
												'class' 		=> 'form-control'			,
												'id' 			=> 'TaskTitle'				,
												'placeholder' 	=> 'やることを入力してください'	
											]
										)}}
									</div>
								</div>
								<!--/タスクタイトル-->

								<!--タスク期限-->
								<div class="form-group row">
									<div class="col-md-2 mb-3 no-wrap">
										{{Form::label('task_limit','期限')}}
									</div>
									<div class="col-md-10">
										{{Form::date(
											//タスク期限が設定されていればそれを出力。なければ今日を出力。
											'task_limit' , @$tasks->limit ? @$tasks->limit : \Carbon\Carbon::now() , [
												'class' => 'form-control task-calendar'	,
												'id' 	=> 'TaskLimit'		,
											]
										)}}
									</div>
								</div>
								<!--/タスク期限-->
								<!--タスクの詳細-->
								<div class="form-group row">
									<div class="col-md-2 mb-3 no-wrap">
										{{Form::label('task_detail','詳細')}}
									</div>
									<div class="col-md-10">
										{{Form::textarea(
											'task_detail' , @$tasks->detail , [
												'class' => 'form-control h100' ,
												'id' 	=> 'TaskDetail'
											]
										)}}
									</div>
								</div>
								<!--/タスクの詳細-->

								<!--タスクの画像-->
								<div class="form-group row">
									<div class="col-md-2 mb-3 no-wrap">
										{{Form::label('task_img','画像')}}
									</div>
									<div class="col-md-10">
										{{Form::file(
											'task_img' , null , [
												'class' => 'form-control' ,
												'id' 	=> 'TaskImg'
											]
										)}}
									</div>
								</div>
								<img class="task-img mb-4" src="/storage/{{@$tasks->img_path}}" alt="">
								<!--/タスクの画像-->

								<!--タスク備考-->
								<div class="form-group row">
									<div class="col-md-2 mb-3 no-wrap">
										{{Form::label('task_remarks','備考')}}
									</div>
									<div class="col-md-10">
										{{Form::text(
											'task_remarks' , @$tasks->remarks , [
												'class'			=> 'form-control'		,
												'id'			=> 'TaskRemarks'		,
												'placeholder'	=> '備考を入力してください'
											]
										)}}
									</div>
								</div>
								<!--/タスク備考-->

								<!--タスクカテゴリ-->
								<div class="form-group row">
									<div class="col-md-2 mb-3 no-wrap">カテゴリ</div>
									<div class="col-md-10">
										@foreach ( $categories as $key => $category )
										<div class="custom-control custom-radio custom-control-inline">
											{{Form::radio(
												'task_category' , $category->id , false , [
													'class'		=> 'custom-control-input'					,
													'id'		=> 'category' . $category->id				,
													( $category->id == @$tasks->category ) ? "checked" : ""	,
												])
											}}
											{{Form::label(
												'category' . $category->id , $category->category_name , [
													'class' => 'custom-control-label'
												]
											)}}
										</div>
										@endforeach
									</div>
								</div>
								<!--/タスクカテゴリ-->
								<!--/ステータス  -->
								<div class="form-group row">
									<div class="col-md-2 mb-3 no-wrap">ステータス</div>
									<div class="col-md-10">
										{{
											Form::select(
												'task_status' 					,
												$select_task_list 				,
												//タスクステータスがあればそれを出力。なければ今日やることステータス。
												['selected' => @$tasks->status ? @$tasks->status : TaskConsts::TASK_PROGRESS ] ,[
													'class' => 'form-control'
												]
											)
										}}
									</div>
								</div>
								<!--/ステータス  -->
								<!--送信-->
								<div class="form-group row">
									<div class="col-sm-12">
										{{Form::button('送信' , [
											'class'	=> 'btn btn-send btn-block'	,
											'name'	=> 'task_id'					,
											'value'	=> @$tasks->id					,
											'type'	=> 'submit'						])
										}}
									</div>
								</div>
								<!--/送信-->
							{{Form::close()}}
							<!--</form>-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>