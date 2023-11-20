

<?php $__env->startSection('filters'); ?>
<div class="row">
	<div class="ml-4 pb-2 mr-n2" style="width: 350px">
		<input type="text" class="form-control filter-control" data-post="name" placeholder="<?php echo e(__('Nama')); ?>">
	</div>
	<div class="ml-4 pb-2" style="width: 350px">
		<select class="form-control filter-control base-plugin--select2-ajax"
			data-url="<?php echo e(rut('ajax.selectStruct', 'parent_bod')); ?>" data-post="parent_id"
			data-placeholder="<?php echo e(__('Parent')); ?>">
		</select>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttons'); ?>
<?php if(auth()->user()->checkPerms($perms.'.create')): ?>

<?php echo $__env->make('layouts.forms.btnAdd', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lists', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/master/org/bod/index.blade.php ENDPATH**/ ?>