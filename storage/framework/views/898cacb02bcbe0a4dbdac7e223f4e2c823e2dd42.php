
<?php $permission = app('\App\Models\Auth\Permission'); ?>

<?php $__env->startSection('action', rut($routes . '.grant', $record->id)); ?>

<?php $__env->startSection('card-title'); ?>
    Assign Permission
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-body'); ?>
<?php echo method_field('PATCH'); ?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th class="text-center">Menu</th>
				<th class="text-center ">View</th>
				<th class="text-center ">Add</th>
				<th class="text-center ">Edit</th>
				<th class="text-center ">Delete</th>
				<?php if($record->name != 'Administrator'): ?>
				<th class="text-center ">Approve</th>
				<?php endif; ?>
				<th class="text-center "></th>
			</tr>
		</thead>
		<tbody>
			<?php $__currentLoopData = config('backendmenu'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if(empty($menu['section'])): ?>
			<?php
			$menu['perms'] = $menu['perms'] ?? '';
			$perms = $permission->when(!empty($menu['perms']), function ($q) use ($menu) {
			$q->where('name', 'like', $menu['perms'].'%');
			})
			->when(empty($menu['perms']), function ($q) use ($menu) {
			$q->whereNull('id');
			})->get();
			?>
			<?php if($record->id == 1 && $menu['title'] == 'Monitoring'): ?>
			<?php continue; ?>
			<?php endif; ?>
			<thead>
				<tr>
					<th>
						<h6 class="font-weight-bold"><?php echo $menu['title']; ?></h6>
					</th>
					<th class="text-center ">
						<?php if(!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master', 'report'])): ?>
						<button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all" data-check="view">
							<i class="far fa-check-circle fa-fw mr-1"></i>View All
						</button>
						<?php elseif($p = $perms->where('name', $menu['perms'].'.view')->first()): ?>
						<div class="d-inline-block">
							<label class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
								<?php if($menu['name'] == 'dashboard'): ?>
								<input type="checkbox" checked disabled><span></span>
								<input type="hidden" name="check[]" value="<?php echo e($p->id); ?>">
								<?php else: ?>
								<input type="checkbox" class="view check" name="check[]" value="<?php echo e($p->id); ?>"
									<?php if($record->hasPermissionTo($menu['perms'].'.view')): ?> checked <?php endif; ?> ><span></span>
								<?php endif; ?>
							</label>
						</div>
						<?php endif; ?>
					</th>
					<th class="text-center ">
						<?php if(!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master', 'report'])): ?>
						<button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all" data-check="create">
							<i class="far fa-check-circle fa-fw mr-1"></i>Create All
						</button>
						<?php elseif($p = $perms->where('name', $menu['perms'].'.create')->first()): ?>
						<div class="d-inline-block">
							<label class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
								<input type="checkbox" class="create check" name="check[]" value="<?php echo e($p->id); ?>"
									<?php if($record->hasPermissionTo($menu['perms'].'.create')): ?> checked <?php endif; ?>><span></span>
							</label>
						</div>
						<?php endif; ?>
					</th>
					<th class="text-center ">
						<?php if(!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master', 'report'])): ?>
						<button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all" data-check="edit">
							<i class="far fa-check-circle fa-fw mr-1"></i>Edit All
						</button>
						<?php elseif($p = $perms->where('name', $menu['perms'].'.edit')->first()): ?>
						<div class="d-inline-block">
							<label class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
								<input type="checkbox" class="edit check" name="check[]" value="<?php echo e($p->id); ?>"
									<?php if($record->hasPermissionTo($menu['perms'].'.edit')): ?> checked <?php endif; ?>><span></span>
							</label>
						</div>
						<?php endif; ?>
					</th>
					<th class="text-center ">
						<?php if(!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master', 'report'])): ?>
						<button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all" data-check="delete">
							<i class="far fa-check-circle fa-fw mr-1"></i>Delete All
						</button>
						<?php elseif($p = $perms->where('name', $menu['perms'].'.delete')->first()): ?>
						<div class="d-inline-block">
							<label class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
								<input type="checkbox" class="delete check" name="check[]" value="<?php echo e($p->id); ?>"
									<?php if($record->hasPermissionTo($menu['perms'].'.delete')): ?> checked <?php endif; ?>><span></span>
							</label>
						</div>
						<?php endif; ?>
					</th>
					<th class="text-center ">
						<?php if(!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master', 'report']) && !in_array($record->id,
						[1])): ?>
						<button type="button" class="btn btn-light-primary font-weight-bold mr-2 check all" data-check="approve">
							<i class="far fa-check-circle fa-fw mr-1"></i>Approve All
						</button>
						<?php elseif($p = $perms->where('name', $menu['perms'].'.approve')->first()): ?>
						<?php if(!in_array($record->id, [1])): ?>
						<div class="d-inline-block">
							<label class="checkbox checkbox-lg checkbox-light-primary checkbox-single flex-shrink-0">
								<input type="checkbox" class="approve check" name="check[]" value="<?php echo e($p->id); ?>"
									<?php if($record->hasPermissionTo($menu['perms'].'.approve')): ?> checked <?php endif; ?>><span></span>
							</label>
						</div>
						<?php endif; ?>
						<?php endif; ?>
					</th>
					<th class="text-right ">
						<?php if(empty($menu['submenu']) || in_array($menu['name'], ['setting', 'master', 'report'])): ?>
						<button type="button" class="btn btn-light-primary font-weight-bold select all"
							<?php if($menu['name']=='dashboard' ): ?> hidden <?php endif; ?>><i class="far fa-check-circle fa-fw mr-1"></i>Check
							All</button>
						<?php endif; ?>
					</th>
				</tr>
			</thead>
			<?php if(!empty($menu['submenu']) && !in_array($menu['name'], ['setting', 'master', 'report'])): ?>
		<tbody>
			<?php $__currentLoopData = $menu['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if(empty($child['submenu'])): ?>
			<?php
			$child['perms'] = $child['perms'] ?? '';
			$perms = $permission->when(!empty($child['perms']), function ($q) use ($child) {
			$q->where('name', 'like', $child['perms'].'%');
			})
			->when(empty($child['perms']), function ($q) use ($child) {
			$q->whereNull('id');
			})->get();
			?>
			<tr>
				<td class="align-middle"><span class="ml-2 font-weight-normal"><?php echo $child['title']; ?></span></td>
				<td class="text-center ">
					<?php if($p = $perms->where('name', $child['perms'].'.view')->first()): ?>
					<div class="d-inline-block">
						<label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
							<input type="checkbox" class="view check" name="check[]" value="<?php echo e($p->id); ?>"
								<?php if($record->hasPermissionTo($child['perms'].'.view')): ?> checked <?php endif; ?>><span></span>
						</label>
					</div>
					<?php endif; ?>
				</td>
				<td class="text-center ">
					<?php if(!in_array($record->id, [2,3])): ?>
					<?php if($p = $perms->where('name', $child['perms'].'.create')->first()): ?>
					<div class="d-inline-block">
						<label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
							<input type="checkbox" class="create check" name="check[]" value="<?php echo e($p->id); ?>"
								<?php if($record->hasPermissionTo($child['perms'].'.create')): ?> checked <?php endif; ?>><span></span>
						</label>
					</div>
					<?php endif; ?>
					<?php endif; ?>
				</td>
				<td class="text-center ">
					<?php if(!in_array($record->id, [2,3])): ?>
					<?php if($p = $perms->where('name', $child['perms'].'.edit')->first()): ?>
					<div class="d-inline-block">
						<label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
							<input type="checkbox" class="edit check" name="check[]" value="<?php echo e($p->id); ?>"
								<?php if($record->hasPermissionTo($child['perms'].'.edit')): ?> checked <?php endif; ?>><span></span>
						</label>
					</div>
					<?php endif; ?>
					<?php endif; ?>
				</td>
				<td class="text-center ">
					<?php if(!in_array($record->id, [2,3])): ?>
					<?php if($p = $perms->where('name', $child['perms'].'.delete')->first()): ?>
					<div class="d-inline-block">
						<label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
							<input type="checkbox" class="delete check" name="check[]" value="<?php echo e($p->id); ?>"
								<?php if($record->hasPermissionTo($child['perms'].'.delete')): ?> checked <?php endif; ?>><span></span>
						</label>
					</div>
					<?php endif; ?>
					<?php endif; ?>
				</td>
				<td class="text-center ">
					<?php if(!in_array($record->id, [1])): ?>
					<?php if($p = $perms->where('name', $child['perms'].'.approve')->first()): ?>
					<div class="d-inline-block">
						<label class="checkbox checkbox-lg checkbox-light-primary checkbox-sing">
							<input type="checkbox" class="approve check" name="check[]" value="<?php echo e($p->id); ?>"
								<?php if($record->hasPermissionTo($child['perms'].'.approve')): ?> checked <?php endif; ?>><span></span>
						</label>
					</div>
					<?php endif; ?>
					<?php endif; ?>
				</td>
				<td class="text-right ">
					<button type="button" class="btn btn-light-primary font-weight-bold select all"><i
							class="far fa-check-circle fa-fw mr-1"></i>Check All</button>
				</td>
			</tr>
			<?php else: ?>
			<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
		<?php endif; ?>
		<?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $('.content-page').on('click', '.select.all', function(e) {
            var container = $(this).closest('tr');
            var check = true;
            if (container.find('.check:checked').length == container.find('.check').length) {
                check = false;
            }
            container.find('.check').prop('checked', check);
        });

        $('.content-page').on('click', '.check.all', function(e) {
            var container = $(this).closest('thead').next('tbody');
            var target = $(this).data('check');
            var check = true;
            if (container.find('.' + target + '.check:checked').length == container.find('.' + target + '.check')
                .length) {
                check = false;
            }
            container.find('.' + target + '.check').prop('checked', check);
            // Check view
            if (target == 'view' && check == false) {
                container.find('.check').prop('checked', false);
            }
            if (target != 'view' && check == true) {
                container.find('.view.check').prop('checked', true);
            }
        });

        $('.content-page').on('change', 'input.check', function(e) {
            var me = $(this);
            var container = me.closest('tr');

            if (me.is(':checked')) container.find('.view').prop('checked', true);
            if (!me.is(':checked') && me.hasClass('view')) {
                container.find('.check').prop('checked', false);
            };
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/setting/role/permit.blade.php ENDPATH**/ ?>