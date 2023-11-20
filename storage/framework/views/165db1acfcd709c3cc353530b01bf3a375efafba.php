
<?php $__env->startSection('filters'); ?>
	<div class="row">
        <div class="col-12 col-sm-6 col-xl-3 pb-2 mr-n6">
            <input type="text" class="form-control filter-control" data-post="nama_akun" placeholder="<?php echo e(__('Nama Akun')); ?>">
        </div>
        <div class="col-12 col-sm-6 col-xl-3 pb-2 mr-n6">
            <select class="form-control filter-control base-plugin--select2" name="tipe_akun"
                data-post="tipe_akun"
                data-placeholder="<?php echo e(__('Tipe Akun Utama')); ?>"
            >
            <option value="">Pilih Salah Satu</option>
            <option value="laba rugi">Laba Rugi</option>
            <option value="pendapatan">Pendapatan</option>
            <option value="biaya">Biaya</option>
            <option value="neraca">Neraca</option>
            <option value="aset">Aset</option>
            <option value="kewajiban">Kewajiban</option>
            <option value="ekuitas">Ekuitas</option>
            </select>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttons'); ?>
	<?php if(auth()->user()->checkPerms($perms.'.create')): ?>
        <a href="<?php echo e($urlAdd ?? (\Route::has($routes.'.create') ? route($routes.'.create') : 'javascript:;')); ?>"
            class="btn btn-info base-modal--render"
            data-modal-size="<?php echo e($modalSize ?? 'modal-lg'); ?>"
            data-modal-backdrop="false"
            data-modal-v-middle="false">
            <i class="fa fa-plus"></i> Data
        </a>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lists', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROJECT WEB\project-asset\resources\views/master/coa/index.blade.php ENDPATH**/ ?>