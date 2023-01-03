<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('top') }}
		</h2>
	</x-slot>
	<div class="py-1">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="">
				{{Form::open([ 'url' => '/updateStatus' ])}}
				{{Form::token()}}
					<div class="flex justify-content-between align-items-center">
						<div class="text-left mt-3 mb-3">
							<div class="d-inline-block mr-3">
								<div class="add-task">
									<a href="/regist"><i class="fa-solid fa-plus"></i>タスクを登録する</a>
								</div>
							</div>
							<div class="d-inline-block mr-3">
								<div class="copy-task">
									<span>
										{{ Form::submit('コピーして登録', [ 'class'=>'font-weight-bold' , 'formaction'=>'copyTask' ]) }}
									</span>
								</div>
							</div>
							<div class="d-inline-block mr-3">
								<div class="change-task-status">
									{{Form::select(
										'task_status' , $select_task_list , "" 	, [
											'class'		=> ''					,
											'onchange'	=> 'submit(this.form)'
										])
									}}
								</div>
							</div>
							<div class="d-inline-block mr-3">
								<div class="del-task">
									<span>
										{{ Form::submit('チェックしたものを削除する', ['class'=>'' , 'formaction'=>'deleteTask' , 'onclick'=>'return DeleteConfirm()']) }}
									</span>
								</div>
							</div>
						</div>
						<div class="achievement-rate">
							<div class="achievement-rate-txt">今日やることは{{$tasks_fin_count}}/{{$tasks_day_count}}個達成しました</div>
							<div class="achievement-rate-graph-wrap">
								<div class="achievement-rate-graph-all"></div>
								<div class="achievement-rate-graph-progress">
									<script>
										const tasks_day_count = @json($tasks_day_count); //1日のやること数
										const tasks_fin_count = @json($tasks_fin_count); //1日のやること終わった数
										$(function() {
											graph(tasks_day_count, tasks_fin_count);
										});
									</script>
								</div>
							</div>
						</div>
					</div>
					<div>
						<div class="mb-3">
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
						</div>
						@foreach ( $tasks as $key => $task )
							<div class="task-wrap mb-3">
								<h2 class="h2">{{$key}}</h2>
								<div class="">
									<div class="flex flex-wrap">
										@foreach ( $task as $key => $task )
											<label for="{{'Task' . $task->id }}" class="task-list flex-item-3 mb-2">
												<div class="sticky-note position-relative w-100">
													<div class="">
														{{Form::checkbox(
															'task_id[]'	,
															$task->id	,
															false 		,[
																'id' 	=> 'Task' . $task->id ,
																'class' => 'task-check',
															])
														}}
													</div>
													<div class="flex justify-content-between">
														<div class="task-title">
															@if ($task->status == TaskConsts::TASK_COMPLETED)
																<i class="fa-solid fa-circle-check check-icon"></i>
															@endif
															<span class="{{ $task->status == TaskConsts::TASK_COMPLETED ? 'check-color' : '' }}">{{$task->title}}</span>
														</div>
														<div class="task-category">{{$task->category_name}}</div>
													</div>
													<div class="task-detail">{{Str::limit($task->detail, 80, "...")}}</div>
													<div class="task-limit">{{$task->limit}}まで</div>
													<div class="task-edit-btn-wrap">
														@if (@$task->img_path)
															<img class="d-inline-block" src="{{ asset('images/icon_cmn_01.svg') }}" alt="">
														@endif
														@if (@$task->remarks)
															<img class="d-inline-block" src="{{ asset('images/icon_cmn_02.svg') }}" alt="">
														@endif
														{{Form::button( '詳しく見る' , [
															'type'			=> 'submit'													,
															'class'			=> 'btn btn-primary task-edit-btn fa-solid fa-angle-right'	,
															'formaction'	=> 'regist'													,
															'value'			=> $task->id												,
															'name'			=> 'task_id'												])
														}}
													</div>
												</div>
											</label>
										@endforeach
									</div>
								</div>
							</div>
						@endforeach
					</div>
				{{Form::close()}}
			</div>
		</div>
	</div>
</x-app-layout>