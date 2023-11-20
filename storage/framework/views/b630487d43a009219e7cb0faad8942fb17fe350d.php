<form action="<?php echo $__env->yieldContent('action'); ?>" method="POST" autocomplete="<?php echo $__env->yieldContent('autocomplete', 'off'); ?>">
	<div class="modal-header">
		<h4 class="modal-title"><?php echo $__env->yieldContent('modal-title', $title); ?></h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<i aria-hidden="true" class="ki ki-close"></i>
		</button>
	</div>
	<div class="modal-body pt-3">
		<?php echo csrf_field(); ?>
		<?php echo $__env->yieldContent('modal-body'); ?>
	</div>
	<?php $__env->startSection('buttons'); ?>
		<div class="modal-footer">
			<?php $__env->startSection('modal-footer'); ?>
				<?php echo $__env->make('layouts.forms.btnSubmitModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php echo $__env->yieldSection(); ?>
		</div>
	<?php echo $__env->yieldSection(); ?>
</form>

<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/modal.blade.php ENDPATH**/ ?>