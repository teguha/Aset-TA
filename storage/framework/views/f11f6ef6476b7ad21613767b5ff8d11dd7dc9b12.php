<a href="<?php echo e($urlAdd ?? (\Route::has($routes.'.create') ? rut($routes.'.create') : 'javascript:;')); ?>"
	class="btn btn-info ml-2 <?php echo e(empty($baseContentReplace) ? 'base-modal--render' : 'base-content--replace'); ?>"
	data-modal-backdrop="false"
    data-modal-size="<?php echo e($modal_size ?? 'modal-md'); ?>"
	data-modal-v-middle="false">
	<i class="fa fa-plus"></i> Data
</a>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/forms/btnAdd.blade.php ENDPATH**/ ?>