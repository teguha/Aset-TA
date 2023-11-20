

<?php $__env->startSection('filters'); ?>
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-3 pb-2 mr-n6">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="<?php echo e(__('Kota / Kabupaten')); ?>">
		</div>
		<div class="ml-4" style="width: 250px">
            <select class="form-control filter-control base-plugin--select2-ajax"
				data-url="<?php echo e(rut('ajax.provinceOptionsBySearch', [
					'search'=>'all'
				])); ?>" data-post="province_id" placeholder="<?php echo e(__('Provinsi')); ?>">
                <option value=""><?php echo e(__('Provinsi')); ?></option>
            </select>
        </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttons'); ?>
	<?php if(auth()->user()->checkPerms($perms.'.create')): ?>
		<?php echo $__env->make('layouts.forms.btnAdd', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lists', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/master/geografis/kota/index.blade.php ENDPATH**/ ?>