<?php if(isset($notifications) && count($notifications)): ?>
    <div class="navi navi-hover scroll my-4 user-notification-items"
        data-count="<?php echo e(auth()->user()->notifications()->wherePivot('readed_at', null)->count()); ?>" data-scroll="true"
        style="min-height: 100px; max-height: 300px;">
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(rut('ajax.userNotificationRead', $item->id)); ?>"
                class="navi-item base-content--replace <?php echo e($loop->last ? 'mb-7' : ''); ?>"
                data-url="<?php echo e(rut('ajax.userNotificationRead', $item->id)); ?>">
                <div class="navi-link">
                    <div class="navi-icon mr-2 v-align-top">
                        <i class="flaticon2-notification <?php echo e($item->pivot->readed_at ? '' : 'text-success'); ?>"></i>
                    </div>
                    <div class="navi-text">
                        <div class="text-bold text-app"><?php echo \Base::getModules($item->module); ?></div>
                        <div class="text-normal"><?php echo $item->message; ?></div>
                        <div class="text-muted">Created By: <?php echo e($item->from_name); ?></div>
                        <div class="text-muted">Created At: <?php echo e($item->creationDate(false)); ?></div>
                    </div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="text-center">
        <div class="separator separator-solid  my-5"></div>
        <a href="<?php echo e(rut('setting.profile.notification')); ?>" class="btn btn-light-primary mb-3 base-content--replace">
            <?php echo e(__('Baca Semua')); ?> <i class="fas fa-angle-right ml-2"></i>
        </a>
    </div>
<?php else: ?>
    <div class="d-flex flex-center text-center text-muted min-h-200px">
        <?php echo e(__('Data tidak tersedia!')); ?>

    </div>
<?php endif; ?>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/base/notification.blade.php ENDPATH**/ ?>