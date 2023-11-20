

<?php $menu = app('App\Models\Globals\Menu'); ?>

<?php $__env->startSection('filters'); ?>
<div class="row">
	<div class="col-5">
		<select class="form-control base-plugin--select2-ajax filter-control" data-post="module_name"
			data-placeholder="<?php echo e(__('Modul')); ?>">
			<option value="" selected><?php echo e(__('Modul')); ?></option>
			<?php $__currentLoopData = $menu->grid()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if($menu->parent_id == NULL): ?>
			<option value="<?php echo e($menu->module); ?>"><?php echo e($menu->show_module); ?></option>
			<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttons'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lists', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/setting/flow/index.blade.php ENDPATH**/ ?>