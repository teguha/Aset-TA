<div id="kt_aside" class="aside aside-left aside-fixed d-flex flex-column flex-row-auto page-with-light-sidebar">
    
    <div class="brand flex-column-auto pr-3" id="kt_brand">
        <div class="brand-logo m-auto">
            <a href="<?php echo e(yurl('/')); ?>">
                <img src="<?php echo e('/'.(config('base.logo.aside'))); ?>" alt="Image"
                    style="max-width: 170px; max-height: 40px;" />
            </a>
        </div>

        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <?php echo \Base::getSVG('assets/media/svg/icons/Navigation/Angle-double-left.svg', 'svg-icon-xl'); ?>

        </button>
    </div>

    <?php if(auth()->check()): ?>
        
        <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
            <div id="kt_aside_menu" class="aside-menu my-4" resize="true" data-menu-vertical="1" data-menu-scroll="1"
                data-menu-dropdown-timeout="250">

                <?php if(config('base.custom-menu')): ?>
                    
                    <div class="custom-menu">
                        <ul class="menu-nav nav">
                            <?php $__currentLoopData = config('backendmenu'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(
                                    !empty($menu['perms']) &&
                                        !auth()->user()->checkPerms($menu['perms'] . '.view')): ?>
                                    <?php continue; ?>;
                                <?php endif; ?>
                                <?php echo \Base::renderMenuTree($menu); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php else: ?>
                    
                    <ul class="menu-nav">
                        <?php $__currentLoopData = config('backendmenu'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($menu['permission']) &&
                                    !auth()->user()->checkPerms($menu['permission'])): ?>
                                <?php continue; ?>;
                            <?php endif; ?>
                            <?php echo \Base::renderAsideMenu($menu); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/base/aside.blade.php ENDPATH**/ ?>