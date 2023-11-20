<button type="button" class="btn btn-secondary btn-back base-content--replace"
	data-url="<?php echo e($urlBack ?? (\Route::has($routes.'.index') ? rut($routes.'.index') : url()->previous())); ?>">
	<i class="fa fa-chevron-left mr-1"></i>
	<?php echo e(__('Kembali')); ?>

</button>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/forms/btnBack.blade.php ENDPATH**/ ?>