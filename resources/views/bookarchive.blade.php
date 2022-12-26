<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('top') }}
		</h2>
	</x-slot>
	{{Form::open([ 'url' => '/' ])}}
	{{Form::token()}}
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
				<h2 class="">読書一覧</h2>
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
					<div class="text-center mt-3 mb-3"><a href="./booksingle">新規登録</a></div>
					<div class="bg-white overflow-hidden mt-4">
						<div class="task-wrap p-3">
							<!--  -->
							@if(!empty($books) && $books->count())
							<p>{{ $books->total() }}件中
								{{ $books->firstItem() }}〜{{ $books->lastItem() }} 件を表示
							</p>
							<div class="row">
								@foreach($books as $key => $value)
								<div class="col-2 mb-3">
									<a href="#" class="book-wrap h-100">
										<span class="d-block mb-2"><img src='{{ $value->img_path }}' alt='イメージ'></span>
										<span class="d-block book-title mb-2">{{ $value->title }}</span>
										<span class="d-block">
											@if ( $value->evaluation )
											@for ( $i = 0 ; $i < $value->evaluation ; $i++ )
												<i class="fa-solid fa-star star-color"></i>
												@endfor
												@endif
										</span>
										{{Form::button( '詳しく見る' , [
											'type'			=> 'submit'													,
											'class'			=> 'btn btn-primary task-edit-btn fa-solid fa-angle-right'	,
											'formaction'	=> 'booksingle'												,
											'value'			=> $value->id												,
											'name'			=> 'book_id'												])
										}}
									</a>
								</div>
								@endforeach
							</div>
							@else
							<div>データがありません</div>
							@endif
						</div>
						<div class="mt-3 pageNation row justify-content-center">
							{!! $books->links() !!}
						</div>
						<!--  -->
					</div>
				</div>
			</div>
		</div>
	</div>
	{{Form::close()}}
</x-app-layout>