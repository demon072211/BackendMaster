<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.change_pass')); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo e(__('base.change_pass')); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo e(__('base.change_pass')); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php echo $__env->make('share.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card card-primary">
                    <form class="col-sm-6" action="<?php echo e(route('change-password')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('base.old_pass')); ?> (*)</label>
                                <input type="text" name="op" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('base.new_pass')); ?> (*)</label>
                                <input type="text" name="np" class="form-control" required>
                            </div>

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
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/userInfo/changePass.blade.php ENDPATH**/ ?>