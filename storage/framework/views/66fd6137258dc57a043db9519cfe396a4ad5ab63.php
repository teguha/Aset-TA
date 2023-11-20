<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-2">
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                <?php $__env->startSection('content-title'); ?>
                    <?php echo e($title); ?>

                <?php echo $__env->yieldSection(); ?>
            </h5>
            <?php $__env->startSection('content-breadcrumb'); ?>
                <?php if(count($breadcrumb) > 1): ?>
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2">
                        <li class="breadcrumb-item text-muted">
                            <a href="<?php echo e(yurl('/')); ?>" class="text-muted base-content--replace">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $show => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!in_array(strtolower($show), ['home', 'dashboard'])): ?>
                                <li class="breadcrumb-item text-muted">
                                    <a href="<?php echo e($link); ?>" class="text-muted base-content--replace">
                                        <?php echo __($show); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            <?php echo $__env->yieldSection(); ?>
        </div>

        <div class="d-flex align-items-center pr-8">
            
        </div>
    </div>
</div>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/base/subheadernobuttons.blade.php ENDPATH**/ ?>