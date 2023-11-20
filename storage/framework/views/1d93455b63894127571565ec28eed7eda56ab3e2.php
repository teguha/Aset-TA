<div class="card card-custom">
	<div class="card-body">
		<?php $__env->startSection('dataFilters'); ?>
			<table id="dataFilters" class="width-full">
				<tbody>
					<tr>
						<td class="pb-2 valign-top td-filter-reset width-80px">
							<div class="reset-filter mr-1 hide">
								<button class="btn btn-secondary btn-icon width-full reset button" data-toggle="tooltip" data-original-title="Reset Filter"><i class="fas fa-sync"></i></button>
							</div>
							<div class="label-filter mr-1">
								<button class="btn btn-secondary btn-icon width-full filter button" data-toggle="tooltip" data-original-title="Filter"><i class="fas fa-filter"></i></button>
							</div>
						</td>
						<td>
							<input type="hidden" class="form-control filter-control" data-post="ids" value="<?php echo e(request()->get('ids')); ?>">
							<?php $__env->startSection('filters'); ?>
								<?php echo $filters ?? ''; ?>

							<?php echo $__env->yieldSection(); ?>
						</td>
						<td class="text-right td-btn-create text-nowrap">
							<?php echo $__env->yieldContent('buttons-before'); ?>
							
							<?php echo $__env->yieldContent('buttons-after'); ?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php echo $__env->yieldSection(); ?>
		<div class="table-responsive">
		    <?php if(isset($tableStruct['datatable_1'])): ?>
			    <table id="datatable_1" class="table table-bordered table-hover is-datatable" style="width: 100%;" data-url="<?php echo e(isset($tableStruct['url']) ? $tableStruct['url'] : rut($routes.'.grid')); ?>" data-paging="<?php echo e($paging ?? true); ?>" data-info="<?php echo e($info ?? true); ?>">
			        <thead>
			            <tr>
			                <?php $__currentLoopData = $tableStruct['datatable_1']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $struct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                	<th class="text-center v-middle"
			                		data-columns-name="<?php echo e($struct['name'] ?? ''); ?>"
			                		data-columns-data="<?php echo e($struct['data'] ?? ''); ?>"
			                		data-columns-label="<?php echo e($struct['label'] ?? ''); ?>"
			                		data-columns-sortable="<?php echo e($struct['sortable'] === true ? 'true' : 'false'); ?>"
			                		data-columns-width="<?php echo e($struct['width'] ?? ''); ?>"
			                		data-columns-class-name="<?php echo e($struct['className'] ?? ''); ?>"
			                		style="<?php echo e(isset($struct['width']) ? 'width: '.$struct['width'].'; ' : ''); ?>">
			                		<?php echo e($struct['label']); ?>

			                	</th>
			                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			            </tr>
			        </thead>
			        <tbody>
			            <?php echo $__env->yieldContent('tableBody'); ?>
			        </tbody>
			    </table>
			<?php endif; ?>
		</div>
		<?php echo $__env->yieldContent('card-bottom-table'); ?>
	</div>
</div>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/layouts/partials/datatable.blade.php ENDPATH**/ ?>