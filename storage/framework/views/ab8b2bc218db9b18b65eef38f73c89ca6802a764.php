<?php if(!request()->header('Base-Replace-Content')): ?>
    <!DOCTYPE html>
    <html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>
        <meta charset="utf-8" />
        <title><?php echo e(!empty($title) ? $title . ' | ' . config('app.name') : config('app.name')); ?></title>
        <meta name="debug" content="<?php echo e(config('app.debug')); ?>">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="base-url" content="<?php echo e(yurl('/')); ?>">
        <meta name="replace" content="1">
        <meta name="author" content="PT Pragma Informatika" />
        <meta name="description" content="Aplication by PT Pragma Informatika" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link rel="shortcut icon" href="<?php echo e('/' . config('base.logo.favicon')); ?>" />
        <link rel="stylesheet" href="<?php echo e('/assets/css/fonts/poppins/all.css'); ?>">
        <link rel="stylesheet" href="<?php echo e('/assets/css/plugins.bundle.css'); ?>">
        <link rel="stylesheet" href="<?php echo e('/assets/css/theme.bundle.css'); ?>">
        <link rel="stylesheet" href="<?php echo e('/assets/css/theme.skins.bundle.css'); ?>">
        <link rel="stylesheet" href="<?php echo e('/assets/css/base.bundle.css'); ?>">
        <link rel="stylesheet" href="<?php echo e('/assets/css/modules.bundle.css'); ?>">

        <script src="<?php echo e('/assets/js/plugins.bundle.js'); ?>"></script>
    </head>

    <body id="kt_body"
        class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable <?php echo e(!empty($sidebarMini) ? 'aside-minimize' : ''); ?> page-loading">

        <div class="no-body-clear page-loader page-loader-default fade-out">
            <div class="blockui">
                <span>Please wait...</span>
                <span>
                    <div class="spinner spinner-primary"></div>
                </span>
            </div>
        </div>

        <div id="kt_header_mobile" class="no-body-clear header-mobile align-items-center header-mobile-fixed">
            <a href="index.html">
                <img src="<?php echo e('/' . config('base.logo.aside')); ?>" height="30px" alt="logo">
            </a>
            <div class="d-flex align-items-center">
                <button class="btn burger-icon burger-icon-left p-0" id="kt_aside_mobile_toggle">
                    <span></span>
                </button>
                <?php if(auth()->check()): ?>
                    <button class="btn btn-hover-text-primary ml-2 p-0" id="kt_header_mobile_topbar_toggle">
                        <img src="<?php echo e('/' . auth()->user()->image_path); ?>" class="img-circle" height="30px">
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="no-body-clear d-flex flex-column flex-root">
            <div class="d-flex flex-column-fluid flex-row">
                <?php echo $__env->make('layouts.base.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div id="wrapper" class="d-flex flex-column flex-row-fluid wrapper">
                    <?php echo $__env->make('layouts.base.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div id="content" class="content d-flex flex-column flex-column-fluid">
                        <div id="content-page" class="content-page" data-sidebar-mini="<?php echo e($sidebarMini ?? 0); ?>"
                            data-module="<?php echo e($module ?? ''); ?>">
                            <?php echo $__env->yieldPushContent('styles'); ?>
                            <?php echo $__env->yieldContent('content'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="kt_scrolltop" class="no-body-clear scrolltop">
            <?php echo Base::getSVG('assets/media/svg/icons/Navigation/Up-2.svg'); ?>

        </div>
        <div id="base_script" class="no-body-clear">
            <script>
                BaseAppLang = <?php echo json_encode(__('base'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>;
            </script>
            <script src="<?php echo e('/assets/js/theme.bundle.js'); ?>"></script>
            <script src="<?php echo e('/assets/js/base.bundle.js'); ?>"></script>
            <script src="<?php echo e('/assets/js/modules.bundle.js'); ?>"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                $(function() {
                    $('body').removeClass('content-loading');
                });
            </script>
        </div>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>

    </html>
<?php else: ?>
    <div id="content-page" class="content-page" data-sidebar-mini="<?php echo e($sidebarMini ?? 0); ?>"
        data-module="<?php echo e($module ?? ''); ?>">
        <?php echo $__env->yieldPushContent('styles'); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <div class="base-content--state"
            data-title="<?php echo e(!empty($title) ? $title . ' | ' . config('app.name') : config('app.name')); ?>"
            data-url="<?php echo e(in_array(env('APP_ENV'), ['production', 'staging']) ? str_replace('10.11.12.219', 'audit.spi.tirtapatriot.net', ) : url()->full()); ?>"
            data-csrf-token="<?php echo e(csrf_token()); ?>"
            data-last-user-notification="<?php echo e(auth()->user()->getLastNotificationId()); ?>">
            <script>
                if (!document.getElementById('kt_body')) {
                    document.getElementById("content-page").style.display = "none";
                    window.location.reload();
                }
            </script>
        </div>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </div>
<?php endif; ?>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/app.blade.php ENDPATH**/ ?>