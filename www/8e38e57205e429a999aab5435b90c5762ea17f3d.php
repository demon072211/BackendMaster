<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.list_player')); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo e(__('base.list_player')); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e(__('base.list_player')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="get" action="<?php echo e(route('users')); ?>">
                    <div class="card-body row">
                        <div class="form-group col-4">
                            <label for="nn"><?php echo e(__('base.nick_name')); ?></label>
                            <input type="text" class="form-control" id="nn"  name="nn" autocomplete="off" value="<?php echo e(request()->get('nn')); ?>">
                        </div>
                        <!-- Date -->
                        <div class="form-group col-4">
                            <label><?php echo e(__('base.since')); ?> :</label>
                            <div class="input-group date" id="fromDate" data-target-input="nearest">
                                <input disabled type="text" class="form-control datetimepicker-input" data-target="#fromDate" name="ft" value="<?php echo e(request()->get('ft')); ?>">
                                <div class="input-group-append" data-target="#fromDate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <label><?php echo e(__('base.to')); ?> :</label>
                            <div class="input-group date" id="toDate" data-target-input="nearest">
                                <input disabled type="text" class="form-control datetimepicker-input" data-target="#toDate"  name="et" value="<?php echo e(request()->get('et')); ?>">
                                <div class="input-group-append" data-target="#toDate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><?php echo e(__('base.search')); ?></button>
                        <a href="<?php echo e(route('users')); ?>" class="btn btn-primary"><?php echo e(__('base.quit_search')); ?></a>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-info bg-danger"><?php echo e($error); ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-12 mb-2 text-right">
                    <span class="mr-3"><?php echo e(__('base.total_revenue')); ?> : <?php echo e(number_format($totalData['total_doanhthu'], 0, '.', ',')); ?></span>
                    <span class="mr-3"><?php echo e(__('base.total_draw')); ?> : <?php echo e(number_format($totalData['total_rut'], 0, '.', ',')); ?></span>
                    <span class="mr-3"><?php echo e(__('base.deposit_amount')); ?> : <?php echo e(number_format($totalData['total_nap'], 0, '.', ',')); ?></span>
                    <span class="mr-3"><?php echo e(__('base.total_promotion')); ?> : <?php echo e(number_format($totalData['total_km'], 0, '.', ',')); ?></span>
                    <span class="mr-3"><?php echo e(__('base.total_records')); ?> : <?php if(!empty($data)): ?> <?php echo e($data->total()); ?> <?php endif; ?></span>
                </div>

                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('base.no.')); ?></th>
                                        <th><?php echo e(__('base.nick_name')); ?></th>
                                        <th><?php echo e(__('base.balance')); ?></th>
                                        <th><?php echo e(__('base.withdrawal_amount')); ?></th>
                                        <th><?php echo e(__('base.deposit_amount')); ?></th>
                                        <th><?php echo e(__('base.registration_date')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($data)): ?>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($firstItem); ?></td>
                                            <td><?php echo e($item['nick_name']); ?></td>
                                            <td><?php echo e(number_format($item['vin'], 0, '.', ',')); ?></td>
                                            <td><?php echo e(number_format($item['t_rut'], 0, '.', ',')); ?></td>
                                            <td><?php echo e(number_format($item['t_nap'], 0, '.', ',')); ?></td>
                                            <td><?php echo e($item['create_time']); ?></td>
                                        </tr>
                                    <?php $firstItem++; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        //Date picker
        $('#fromDate').datetimepicker({
            format: 'Y-MM-DD',
            defaultDate: '<?php echo e($carbonNow->startOfMonth()->toDateString()); ?>'
        });
        $('#toDate').datetimepicker({
            format: 'Y-MM-DD',
            defaultDate:'<?php echo e($carbonNow->endOfMonth()->toDateString()); ?>'
        });
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/userInfo/index.blade.php ENDPATH**/ ?>