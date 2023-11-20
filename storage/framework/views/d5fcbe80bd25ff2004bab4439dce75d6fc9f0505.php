<a href="<?php echo e($urlBack ?? (\Route::has($routes.'.index') ? rut($routes.'.index') : url()->previous())); ?>"
	class="btn btn-hover-text-primary font-weight-bolder pr-0 base-content--replace"
	data-toggle="tooltip"
	data-original-title="<?php echo e(__('Kembali')); ?>"
	data-placement="top">
	<i aria-hidden="true" class="ki ki-close"></i>
</a>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/forms/btnBackTop.blade.php ENDPATH**/ ?>