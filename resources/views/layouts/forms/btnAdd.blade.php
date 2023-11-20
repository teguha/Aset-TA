<a href="{{ $urlAdd ?? (\Route::has($routes.'.create') ? rut($routes.'.create') : 'javascript:;') }}"
	class="btn btn-info ml-2 {{ empty($baseContentReplace) ? 'base-modal--render' : 'base-content--replace' }}"
	data-modal-backdrop="false"
    data-modal-size="{{ $modal_size ?? 'modal-md' }}"
	data-modal-v-middle="false">
	<i class="fa fa-plus"></i> Data
</a>
