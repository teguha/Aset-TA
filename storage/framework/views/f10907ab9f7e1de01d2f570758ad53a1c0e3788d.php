

<?php $__env->startSection('content'); ?>
    <div class="login-form login-signin">
        <form class="form" method="POST" action="<?php echo e(rut('login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="font-weight-bolder"><?php echo e(__('Username / Email')); ?></label>
                <input type="text" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(session('remember_username') ?? old('username')); ?>"
                    placeholder="<?php echo e(__('Masukkan Username / Email')); ?>" name="username" autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label class="font-weight-bolder"><?php echo e(__('Password')); ?></label>
                <div class="input-group">
                    <input class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="pwCtrl" type="password"
                        placeholder="<?php echo e(__('Masukkan Password')); ?>" name="password" autocomplete="off" />
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()" tabindex="-1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label class="font-weight-bolder">Captcha</label>
                
                <?php echo getCaptchaBox('captcha'); ?>

                
                
                
                
                <?php if($errors->get('captcha')[0] ?? null): ?>
                    
                    <span style="color: #F64E60; font-weight: 400; font-size: 10.8px">
                        <strong><?php echo e($errors->get('captcha')[0] ?? ''); ?></strong>
                    </span>
                    
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="checkbox">
                    <input type="checkbox" name="remember"
                        <?php echo e(session('remember_username') != '' || old('remember') ? 'checked' : ''); ?>>
                    <span class="mr-2"></span><?php echo e(\Base::trans('Remember Me')); ?>

                </label>
            </div>

            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                <button type="submit" class="btn btn-info btn-block font-weight-bold my-3 py-3">
                    <?php echo e(\Base::trans('Masuk')); ?>

                </button>
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(rut('password.request')); ?>"
                        class="w-100 text-center text-dark-50 text-hover-danger my-3 mr-2">
                        <?php echo e(\Base::trans('Lupa Password?')); ?>

                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php if(session('remember_username') != ''): ?>
    <?php $__env->startPush('scripts'); ?>
        <script>
            $(document).ready(function() {
                $('#pwCtrl').focus();
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('pwCtrl');
        const togglePassword = document.getElementById('togglePassword');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/auth/login.blade.php ENDPATH**/ ?>