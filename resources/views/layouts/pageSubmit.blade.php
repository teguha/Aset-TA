@extends('layouts.app')

@section('title', $title)

@section('content')
	@section('content-header')
		@include('layouts.base.subheader')
	@show
	@section('content-body')
    <form action="@yield('action', '#')" method="POST"  data-req-method="@yield('req-method')" id="searchform" autocomplete="@yield('autocomplete', 'off')">
		<div class="d-flex flex-column-fluid">
			<div class="{{ $container ?? 'container-fluid' }}">
				@yield('page-start')
				@section('page')
					<div class="card card-custom">
						@section('card-header')
					    	<div class="card-header">
					    		<h3 class="card-title">@yield('card-title', $title)</h3>
								<div class="card-toolbar">
									@section('card-toolbar')
										@include('layouts.forms.btnBackTop')
									@show
								</div>
					        </div>
						@show

						<div class="card-body">
							@csrf
							@yield('card-body')
						</div>

						@section('buttons')
							<div class="card-footer">
								@section('card-footer')
									<div class="d-flex justify-content-between">
										@include('layouts.forms.btnBack')
										@include('layouts.forms.btnSubmitPage')
									</div>
								@show
							</div>
						@show
					</div>
				@show
				@yield('page-end')
			</div>
		</div>
    </form>
	@show
@endsection