

<?php $__env->startSection('title', __($title)); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('content-header'); ?>
    <?php echo $__env->make('layouts.base.subheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldSection(); ?>
<?php $__env->startSection('content-body'); ?>
    <div class="d-flex flex-column-fluid">
        <div class="<?php echo e(empty($container) ? 'container-fluid' : $container); ?>">
            <?php echo $__env->yieldContent('start-list'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $__env->renderWhen(empty($tableStruct['tabs']), 'layouts.partials.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
                    <?php echo $__env->renderWhen(!empty($tableStruct['tabs']), 'layouts.partials.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
                </div>
            </div>
            <?php echo $__env->yieldContent('end-list'); ?>
        </div>
    </div>
<?php echo $__env->yieldSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/lists.blade.php ENDPATH**/ ?>