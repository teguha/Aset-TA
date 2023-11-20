

<?php $__env->startSection('filters'); ?>
	<div class="row">
        <div class="col-12 col-sm-6 col-xl-2 px-1 pl-3">
			<input class="form-control filter-control" data-post="name" placeholder="<?php echo e(__('Name / Email')); ?>">
		</div>
        <div class="col-12 col-sm-6 col-xl-3 px-1">
			<select class="form-control filter-control base-plugin--select2-ajax"
				data-url="<?php echo e(route('ajax.selectStruct', ['search' => 'position_with_req'])); ?>"
				data-post="location_id"
				data-placeholder="<?php echo e(__('Struktur Organisasi')); ?>">
			</select>
		</div>
		<div class="col-12 col-sm-6 col-xl-3 px-1">
			<select class="form-control base-plugin--select2-ajax filter-control"
				data-post="role_id"
				data-url="<?php echo e(rut('ajax.selectRole', 'all')); ?>"
				data-placeholder="<?php echo e(__('Hak Akses')); ?>">
				<option value="" selected><?php echo e(__('Hak Akses')); ?></option>
			</select>
		</div>
		<div class="col-12 col-sm-6 col-xl-2 px-1">
			<select class="form-control base-plugin--select2-ajax filter-control"
				data-post="status"
				data-placeholder="<?php echo e(__('Status')); ?>">
				<option value="" selected><?php echo e(__('Status')); ?></option>
				<option value="active">Active</option>
				<option value="nonactive">Nonactive</option>
			</select>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttons'); ?>
	<?php if(auth()->user()->checkPerms($perms.'.create')): ?>
		<?php echo $__env->make('layouts.forms.btnAdd', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lists', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/setting/user/index.blade.php ENDPATH**/ ?>