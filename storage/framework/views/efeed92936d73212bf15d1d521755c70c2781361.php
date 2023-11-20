<?php if(request()->header('Base-Replace-Content')): ?>
	<script>
		window.location.reload();
	</script>
<?php else: ?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
        <title><?php echo e(!empty($title) ? $title.' | '.config('app.name') : config('app.name')); ?></title>
        <meta name="debug" content="<?php echo e(config('app.debug')); ?>">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="base-url" content="<?php echo e(yurl('/')); ?>">
        <meta name="replace" content="1">
        <meta name="author" content="PT Pragma Informatika" />
        <meta name="description" content="Aplication by PT Pragma Informatika" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link rel="shortcut icon" href="<?php echo e('/'.(config('base.logo.favicon'))); ?>" />
        <link rel="stylesheet" href="<?php echo e(('/assets/css/fonts/poppins/all.css')); ?>">
        <link rel="stylesheet" href="<?php echo e((('/assets/css/plugins.bundle.css'))); ?>">
        <link rel="stylesheet" href="<?php echo e((('/assets/css/theme.bundle.css'))); ?>">
        <link rel="stylesheet" href="<?php echo e((('/assets/css/theme.skins.bundle.css'))); ?>">
	</head>
	<body id="kt_body" class="header-fixed header-mobile-fixed">
		<?php echo $__env->yieldContent('content'); ?>

		<script src="<?php echo e((('/assets/js/plugins.bundle.js'))); ?>"></script>
		<?php echo $__env->yieldPushContent('scripts'); ?>
	</body>
	</html>
<?php endif; ?>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/errors.blade.php ENDPATH**/ ?>