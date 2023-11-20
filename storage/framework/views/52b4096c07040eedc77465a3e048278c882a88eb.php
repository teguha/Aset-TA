

<?php $__env->startSection('filters'); ?>
<div class="row">
	<div class="ml-6 pb-2" style="width: 300px">
		<select class="form-control base-plugin--select2-ajax filter-control" data-post="module_name"
			data-placeholder="<?php echo e(__('Modul')); ?>">
			<option value="" selected><?php echo e(__('Modul')); ?></option>
			<?php $__currentLoopData = \Base::getModulesMain(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<option value="<?php echo e($key); ?>"><?php echo e($val); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	</div>
	
	<div class="ml-4 pb-2" style="width: 300px">
		<select class="form-control filter-control base-plugin--select2-ajax"
			data-url="<?php echo e(rut('ajax.selectUser', ['search' => 'all', 'with_admin'=>1])); ?>" data-post="created_by" placeholder="Dibuat oleh">
			<option value="">User</option>
		</select>
	</div>
	<div class="ml-4 pb-2" style="width: 300px">
		<div class="input-group">
			<input type="text" data-post="date_start" class="form-control filter-control base-plugin--datepicker date-start"
				placeholder="<?php echo e(__('Mulai')); ?>" data-options='<?php echo json_encode([
						"format" => "dd/mm/yyyy", "startDate" => "", "endDate" => now()->format(' d/m/Y') ]) ?>'>
			<div class="input-group-append">
				<span class="input-group-text">
					<i class="la la-ellipsis-h"></i>
				</span>
			</div>
			<input type="text" data-post="date_end" class="form-control filter-control base-plugin--datepicker date-end"
				placeholder="<?php echo e(__('Selesai')); ?>" data-options='<?php echo json_encode([
						"format" => "dd/mm/yyyy", "startDate" => "", "endDate" => now()->format(' d/m/Y') ]) ?>' disabled>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttons'); ?>
<a href="<?php echo e(rut($routes.'.export')); ?>" target="_blank" class="btn btn-info ml-2 export-excel text-nowrap">
	<i class="far fa-file-excel mr-2"></i> Export
</a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
	$(function () {
			var toTime = function (date) {
				var ds = date.split('/');
				var year = ds[2];
				var month = ds[1];
				var day = ds[0];
				return new Date(year+'-'+month+'-'+day).getTime();
			}

			$('.content-page').on('changeDate', 'input.date-start', function (value) {
				var me = $(this),
					startDate = new Date(value.date.valueOf()),
					date_end = me.closest('.input-group').find('input.date-end');

				if (me.val()) {
					if (toTime(me.val()) > toTime(date_end.val())) {
						date_end.datepicker('update', '')
							.datepicker('setStartDate', startDate)
							.prop('disabled', false);
					}
					else {
						date_end.datepicker('update', date_end.val())
							.datepicker('setStartDate', startDate)
							.prop('disabled', false);
					}
				}
				else {
					date_end.datepicker('update', '')
						.prop('disabled', true);
				}
			});

			$('.content-page').on('click', '.export-excel', function (e) {
				e.preventDefault();
				var me = $(this);
				var url = me.attr('href');
				var filters = {
					module_name: $('.filter-control[data-post="module_name"]').val(),
					message: $('.filter-control[data-post="message"]').val(),
					created_by: $('.filter-control[data-post="created_by"]').val(),
					date_start: $('.filter-control[data-post="date_start"]').val(),
					date_end: $('.filter-control[data-post="date_end"]').val(),
				}
				filters = $.param(filters);
				url = url+'?'+filters;

				window.open(url);
			});
		});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.lists', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/setting/activity/index.blade.php ENDPATH**/ ?>