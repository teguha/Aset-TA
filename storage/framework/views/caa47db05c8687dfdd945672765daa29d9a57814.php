<div class="col-12">
	<div class="row card-progress-wrapper" data-url="<?php echo e(rut($routes.'.progress')); ?>">
		<?php
			$cards = collect(json_decode(json_encode($progress)));
			$length = count($cards);
		?>
		<?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="col-xl-<?php echo e($length > 2 ? '3' : '6'); ?> col-md-6 col-sm-12">
				<div class="card card-custom gutter-b card-stretch wave wave-<?php echo e($card->color); ?>"
					data-name="<?php echo e($card->name); ?>">
					<div class="card-body">
						<div class="d-flex flex-wrap align-items-center py-1">
							<div class="symbol symbol-40 symbol-light-<?php echo e($card->color); ?> mr-5">
								<span class="symbol-label shadow">
									<i class="<?php echo e($card->icon); ?> align-self-center text-<?php echo e($card->color); ?> font-size-h5"></i>
								</span>
							</div>
							<div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
								<div class="text-dark font-weight-bolder font-size-h5">
									<?php echo e(__($card->title)); ?>

								</div>
								<div class="text-muted font-weight-bold font-size-lg">
									<div class="d-flex justify-content-between">
										<span class="text-nowrap">Completed/Total</span>
										<span class="text-nowrap">
											<span class="completed">0</span>/<span class="total">0</span>
										</span>
									</div>
								</div>
							</div>
							<div class="d-flex flex-column w-100 mt-5">
								<div class="text-dark mr-2 font-size-lg font-weight-bolder pb-3">
									<div class="d-flex justify-content-between">
										<span class="percent-text">0%</span>
									</div>
								</div>
								<div class="progress progress-xs w-100">
									<div class="progress-bar percent-bar"
										role="progressbar"
										style="width: 0%;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
</div>

<?php $__env->startPush('scripts'); ?>
	<script>
		$(function () {
			initCardProgress();
		});

		var initCardProgress = function () {
			var wrapper = $('.card-progress-wrapper');
			$.ajax({
				url: wrapper.data('url'),
				type: 'POST',
				data: {
					_token: BaseUtil.getToken(),
				},
				success: function (resp) {
					if (resp.data && resp.data.length) {
						$.each(resp.data, function (i, item) {
							var card = wrapper.find('.card[data-name="'+item.name+'"]');
							card.find('.completed').html(item.completed);
							card.find('.total').html(item.total);
							card.find('.percent-text').html(item.percent+'%');
							card.find('.percent-bar').css('width', item.percent+'%');
						});
					}
				},
				error: function (resp) {
					console.log(resp);
                    // window.location = '<?php echo e(yurl('login')); ?>';
				},
			});
		}
	</script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\PROJECT WEB\project-asset\resources\views/dashboard/_card-progress.blade.php ENDPATH**/ ?>