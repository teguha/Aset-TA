

<?php $__env->startSection('action', rut($routes.'.store')); ?>

<?php $__env->startSection('modal-body'); ?>
	<?php echo method_field('POST'); ?>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label"><?php echo e(__('Parent')); ?></label>
		<div class="col-sm-12 parent-group">
			<select name="parent_id" class="form-control base-plugin--select2-ajax"
				data-url="<?php echo e(rut('ajax.selectStruct', 'parent_bod')); ?>"
				data-placeholder="<?php echo e(__('Pilih Salah Satu')); ?>">
			</select>
			<div class="form-text text-muted">*Parent berupa Root/Direktur</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label"><?php echo e(__('Kode')); ?></label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="code_manual" class="form-control" placeholder="<?php echo e(__('Kode')); ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-12 col-form-label"><?php echo e(__('Nama')); ?></label>
		<div class="col-sm-12 parent-group">
			<input type="text" name="name" class="form-control" placeholder="<?php echo e(__('Nama')); ?>">
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/master/org/bod/create.blade.php ENDPATH**/ ?>