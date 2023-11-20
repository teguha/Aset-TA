<button type="button" class="btn btn-secondary btn-back base-content--replace"
	data-url="{{ $urlBack ?? (\Route::has($routes.'.index') ? rut($routes.'.index') : url()->previous()) }}">
	<i class="fa fa-chevron-left mr-1"></i>
	{{ __('Kembali') }}
</button>
