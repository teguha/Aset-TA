

<?php $__env->startSection('page'); ?>
	<form action="<?php echo $__env->yieldContent('action', '#'); ?>" method="POST" autocomplete="<?php echo $__env->yieldContent('autocomplete', 'off'); ?>">
		<div class="card card-custom">
			<?php $__env->startSection('card-header'); ?>
		    	<div class="card-header">
		    		<h3 class="card-title"><?php echo $__env->yieldContent('card-title', $title); ?></h3>
					<div class="card-toolbar">
						<?php $__env->startSection('card-toolbar'); ?>
							<?php echo $__env->make('layouts.forms.btnBackTop', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php echo $__env->yieldSection(); ?>
					</div>
		        </div>
			<?php echo $__env->yieldSection(); ?>

			<div class="card-body">
				<?php echo csrf_field(); ?>
				<?php echo $__env->yieldContent('card-body'); ?>
			</div>
			
			<?php $__env->startSection('buttons'); ?>
				<div class="card-footer">
					<?php $__env->startSection('card-footer'); ?>
						<div class="d-flex justify-content-between">
							<?php echo $__env->make('layouts.forms.btnBack', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php echo $__env->make('layouts.forms.btnSubmitPage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						</div>
					<?php echo $__env->yieldSection(); ?>
				</div>
			<?php echo $__env->yieldSection(); ?>
		</div>
	</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/form.blade.php ENDPATH**/ ?>