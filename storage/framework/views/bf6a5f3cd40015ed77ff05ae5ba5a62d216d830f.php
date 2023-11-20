

<?php $__env->startSection('action', rut($routes.'.store')); ?>

<?php $__env->startSection('modal-body'); ?>
	<?php echo method_field('POST'); ?>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Nama')); ?></label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" class="form-control" placeholder="<?php echo e(__('Nama')); ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('NPP')); ?></label>
		<div class="col-sm-8 parent-group">
			<input type="number" name="npp" class="form-control" placeholder="<?php echo e(__('NPP')); ?>" maxlength="16">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Username')); ?></label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="username" class="form-control" placeholder="<?php echo e(__('Username')); ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Email')); ?></label>
		<div class="col-sm-8 parent-group">
			<input type="email" name="email" class="form-control" placeholder="<?php echo e(__('Email')); ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Struktur')); ?></label>
		<div class="col-sm-8 parent-group">
			<select name="location_id" class="form-control base-plugin--select2-ajax"
				id="strukturCtrl"
				data-url="<?php echo e(route('ajax.selectStruct', ['search' => 'position_with_req'])); ?>"
                data-url-origin="<?php echo e(route('ajax.selectStruct', ['search' => 'position_with_req'])); ?>"
				placeholder="<?php echo e(__('Pilih Salah Satu')); ?>">
				<option value=""><?php echo e(__('Pilih Salah Satu')); ?></option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Jabatan')); ?></label>
		<div class="col-sm-8 parent-group">
			<select name="position_id" id="jabatanCtrl" class="form-control base-plugin--select2-ajax"
				placeholder="<?php echo e(__('Pilih Salah Satu')); ?>">
				<option value=""><?php echo e(__('Pilih Salah Satu')); ?></option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Hak Akses')); ?></label>
		<div class="col-sm-8 parent-group">
			<select name="roles[]" class="form-control base-plugin--select2-ajax"
				data-url="<?php echo e(rut('ajax.selectRole', 'all')); ?>"
				placeholder="<?php echo e(__('Pilih Salah Satu')); ?>">
				<option value=""><?php echo e(__('Pilih Salah Satu')); ?></option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Password')); ?></label>
		<div class="col-sm-8 parent-group">
			<div class="input-group">
				<input type="password" name="password" class="form-control" id="pwCtrl" placeholder="<?php echo e(__('Password')); ?>">
				<button type="button" id="togglePassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()" tabindex="-1">
					<i class="fas fa-eye"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Konfirmasi Password')); ?></label>
		<div class="col-sm-8 parent-group">
			<div class="input-group">
				<input type="password" name="password_confirmation" id="pwCtrlConfirmation" class="form-control" placeholder="<?php echo e(__('Konfirmasi Password')); ?>">
				<button type="button" id="togglePasswordConfirmation" class="btn btn-outline-secondary" onclick="togglePasswordVisibilityConfirmation()" tabindex="-1">
					<i class="fas fa-eye"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label"><?php echo e(__('Status')); ?></label>
		<div class="col-sm-8 parent-group">
			<select name="status" class="form-control base-plugin--select2"
				placeholder="<?php echo e(__('Pilih Salah Satu')); ?>">
				<option value="active" selected>Active</option>
				<option value="nonactive">Non Active</option>
			</select>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
	<script>
		$(function () {
			$('.content-page')
			.on('change', '#strukturCtrl', function(){
                $.ajax({
                    method: 'GET',
                    url: '<?php echo e(yurl('/ajax/jabatan-options')); ?>',
                    data: {
                        location_id: $(this).val()
                    },
                    success: function(response, state, xhr) {
                        // let options = `<option value='' selected disabled></option>`;
                        let options = `<option disabled selected value=''>Pilih Salah Satu</option>`;
                        for (let item of response) {
                            options += `<option value='${item.id}'>${item.name}</option>`;
                        }
                        $('#jabatanCtrl').select2('destroy');
                        $('#jabatanCtrl').html(options);
                        $('#jabatanCtrl').select2();
                        console.log(54, response, options);
                    },
                    error: function(a, b, c) {
                        console.log(a, b, c);
                    }
                });
            });
		});
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
		function togglePasswordVisibilityConfirmation() {
			const passwordInputConfirmation = document.getElementById('pwCtrlConfirmation');
			const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');

			if (passwordInputConfirmation.type === 'password') {
				passwordInputConfirmation.type = 'text';
				togglePasswordConfirmation.innerHTML = '<i class="fas fa-eye-slash"></i>';
			} else {
				passwordInputConfirmation.type = 'password';
				togglePasswordConfirmation.innerHTML = '<i class="fas fa-eye"></i>';
			}
		}
	</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/setting/user/create.blade.php ENDPATH**/ ?>