

<?php $__env->startSection('content'); ?>
	<div class="d-flex flex-column flex-root">
		<!--begin::Error-->
		<div class="error error-3 d-flex flex-row-fluid bgi-size-cover bgi-position-center"
			style="background-image: url('<?php echo e(('/assets/media/error/bg3.jpg')); ?>');">
			<div class="px-10 px-md-30 py-10 py-md-0 d-flex flex-column justify-content-md-center">
				<h1 class="error-title text-stroke text-light-danger">Coming Soon</h1>
				<p class="display-4 font-weight-boldest text-white mb-12">404 | NOT FOUND</p>
				<p class="font-size-h1 font-weight-boldest text-dark-75">There may be on progress development, or a misspelling in the URL entered.</p>
				
				<p class="font-size-h4 line-height-md">Sorry we can't seem to find the page you're looking for.</p>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/errors/404.blade.php ENDPATH**/ ?>