<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.my_income')); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo e(__('base.my_income')); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e(__('base.my_income')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="get" action="<?php echo e(route('income')); ?>">
                    <div class="card-body row">
                        <!-- Date -->
                        <div class="form-group col-4">
                            <label><?php echo e(__('base.month')); ?> :</label>
                            <div class="input-group date" id="fromDate" data-target-input="nearest">
                                <input disabled type="text" class="form-control datetimepicker-input" data-target="#fromDate" name="t" value="<?php echo e(request()->get('t')); ?>" autocomplete="off">
                                <div class="input-group-append" data-target="#fromDate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">

                    </div>
                    <!-- /.card-body -->
                    
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php if(isset($error)): ?>
                    <div class="alert alert-info bg-danger"><?php echo e($error); ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th><?php echo e(__('base.total_charge')); ?></th>
                                    <th><?php echo e(__('base.total_draw')); ?></th>
                                    <th><?php echo e(__('base.total_refund')); ?></th>
                                    <th><?php echo e(__('base.total_promotion')); ?></th>
                                    <th><?php echo e(__('base.fee')); ?></th>
                                    <th><?php echo e(__('base.profit')); ?></th>
                                    <th><?php echo e(__('base.discount')); ?></th>
                                    <th><?php echo e(__('base.active_members')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($data) && $data->total()): ?>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <span class="<?php echo e(($item['totalDeposit'] < 0) ? 'text-danger': 'text-green'); ?>">
                                                <?php echo e($item['totalDeposit']); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="<?php echo e(($item['totalWithdraw'] < 0) ? 'text-danger': 'text-green'); ?>">
                                                <?php echo e($item['totalWithdraw']); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="<?php echo e(($item['totalFund'] < 0) ? 'text-danger': 'text-green'); ?>">
                                            <?php echo e($item['totalFund']); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="<?php echo e(($item['totalBonus'] < 0) ? 'text-danger': 'text-green'); ?>">
                                            <?php echo e($item['totalBonus']); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="<?php echo e(($item['feeGameThrd'] < 0) ? 'text-danger': 'text-green'); ?>">
                                            <?php echo e($item['feeGameThrd']); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="<?php echo e(($item['profit'] < 0) ? 'text-danger': 'text-green'); ?>">
                                            <?php echo e($item['profit']); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="<?php echo e(($item['commission'] < 0) ? 'text-danger': 'text-green'); ?>">
                                            <?php echo e($item['commission']); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($item['memberActives']); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td>
                                            <?php echo e(__('base.not_found')); ?>

                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="float-right mt-3">
                                <?php if(!empty($data)): ?>
                                    <?php echo e($data->appends($params)->links()); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $(function () {
        //$.datetimepicker.setLocale('pl');
        //Date picker
            $('#fromDate').datetimepicker({
            format: 'Y-MM',
            defaultDate: '<?php echo e(date("Y-m")); ?>'
        });

    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/income/index.blade.php ENDPATH**/ ?>