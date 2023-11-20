<div class="btn-group dropdown ml-2">
	<button type="button" class="btn btn-primary dropdown-toggle"
		data-toggle="dropdown"
		aria-haspopup="true"
		aria-expanded="false">
		<i class="mr-1 fa fa-save"></i>
		<?php echo e(__('Import')); ?>

	</button>
	<div class="dropdown-menu dropdown-menu-right">
		<a href="<?php echo e(rut($routes.'.import')); ?>"
			class="dropdown-item align-items-center base-modal--render">
			<i class="mr-2 fa fa-upload text-primary"></i>
			<?php echo e(__('Import')); ?>

		</a>
		<div class="dropdown-divider"></div>
		<a href="<?php echo e(rut($routes.'.import', ['download' => 'template'])); ?>"
			target="_blank"
			class="dropdown-item align-items-center">
			<i class="mr-2 fa fa-download text-primary"></i>
			<?php echo e(__('Download Template')); ?>

		</a>
	</div>
</div>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/forms/btnAddImport.blade.php ENDPATH**/ ?>