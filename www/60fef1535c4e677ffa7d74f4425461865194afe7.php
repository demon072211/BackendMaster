<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.add_new_bank')); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo e(__('base.add_new_bank')); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo e(__('base.add_new_bank')); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form class="col-sm-6" action="<?php echo e(route('bank-store')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('base.bank_account')); ?> (*)</label>
                                <input type="text" name="ba" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('base.bank_code')); ?> (*)</label>
                                <select class="form-control" name="bc" required>
                                    <?php $__currentLoopData = $listCodeBank; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item['code']); ?>"><?php echo e($item['code']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('base.account_number')); ?> (*)</label>
                                <input type="text" name="bn" class="form-control"  required>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('base.branch')); ?> (*)</label>
                                <input type="text" name="br" class="form-control" required>
                            </div>

                        <!-- /.card-body -->
                        <div class="col-12">
                            <?php if(isset($error)): ?>
                                <div class="alert alert-info bg-danger"><?php echo e($error); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('base.confirm')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/daily/resources/views/bank/create.blade.php ENDPATH**/ ?>