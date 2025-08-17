<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.day_report')); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo e(__('base.day_report')); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e(__('base.day_report')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="get" action="<?php echo e(route('daily-report')); ?>">
                    <div class="card-body row">
                        <div class="form-group col-4">
                            <label><?php echo e(__('base.day')); ?> :</label>
                            <div class="input-group date" id="fromDate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#fromDate" name="t" value="<?php echo e(request()->get('t')); ?>">
                                <div class="input-group-append" data-target="#fromDate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><?php echo e(__('base.search')); ?></button>
                        <a href="<?php echo e(route('daily-report')); ?>" class="btn btn-primary"><?php echo e(__('base.quit_search')); ?></a>
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
                    <?php echo e(__('base.total_records')); ?> : <?php if(!empty($data)): ?> <?php echo e($data->total()); ?> <?php endif; ?>
                </div>
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th><?php echo e(__('base.no.')); ?></th>
                                    <th><?php echo e(__('base.day')); ?></th>
                                    <th><?php echo e(__('base.nick_name')); ?></th>
                                    <th><?php echo e(__('base.total_charge')); ?></th>
                                    <th><?php echo e(__('base.total_draw')); ?></th>
                                    <th><?php echo e(__('base.total_refund')); ?></th>
                                    <th><?php echo e(__('base.total_bonus')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($data) && $data->total()): ?>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($firstItem); ?></td>
                                            <td><?php echo e($item['time_report']); ?></td>
                                            <td><?php echo e($item['nick_name']); ?></td>
                                            <td><?php echo e($item['deposit']); ?></td>
                                            <td><?php echo e($item['withdraw']); ?></td>
                                            <td><?php echo e($item['t_refund']); ?></td>
                                            <td><?php echo e($item['t_bonus']); ?></td>
                                        </tr>
                                        <?php $firstItem++; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="float-right mt-3">
                                <?php if(!empty($data)): ?>
                                <?php echo e($data->links()); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
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
            defaultDate: '<?php echo e(date("Y-m-d",strtotime("-30 days"))); ?>'
        });
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/dailyReport/index.blade.php ENDPATH**/ ?>