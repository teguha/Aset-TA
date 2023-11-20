

<?php $__env->startSection('filters'); ?>
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-3 pb-2 mr-n6">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="<?php echo e(__('Nama')); ?>">
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttons-right'); ?>
	<?php if(auth()->user()->checkPerms($perms.'.create')): ?>
		<?php echo $__env->make('layouts.forms.btnAdd', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('buttons'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.lists', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/master/vendor/type-vendor/index.blade.php ENDPATH**/ ?>