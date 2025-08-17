<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.home')); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo e(__('base.game_stats')); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e(__('base.game_stats')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-tabs">
                            <?php echo $__env->make('gameStatic.tab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                        <div class="card card-primary">
                                            <form method="get" action="<?php echo e(route('game', ['type' => $params['type']])); ?>">
                                                <div class="card-body row">
                                                    <div class="form-group col-4">
                                                        <label><?php echo e(__('base.since')); ?> :</label>
                                                        <div class="input-group date" id="fromDate" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input" data-target="#fromDate" name="ft" value="<?php echo e(request()->get('ft')); ?>">
                                                            <div class="input-group-append" data-target="#fromDate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-4">
                                                        <label><?php echo e(__('base.to')); ?> :</label>
                                                        <div class="input-group date" id="toDate" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input" data-target="#toDate"  name="et" value="<?php echo e(request()->get('et')); ?>">
                                                            <div class="input-group-append" data-target="#toDate" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-4">
                                                        <label><?php echo e(__('base.nick_name')); ?> :</label>
                                                        <input type="text" class="form-control "  name="nn" value="<?php echo e(request()->get('nn')); ?>">
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-body">

                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary"><?php echo e(__('base.search')); ?></button>
                                                    <a href="<?php echo e(route('game', ['type' => $params['type']])); ?>" class="btn btn-primary"><?php echo e(__('base.quit_search')); ?></a>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <?php if(isset($error)): ?>
                                                <div class="alert alert-info bg-danger"><?php echo e($error); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mb-2 text-right">
                                                <?php echo e(__('base.total_records')); ?> : <?php if(!empty($data)): ?> <?php echo e($data->total()); ?> <?php endif; ?>
                                            </div>
                                            <div class="col-12">
                                                <div class="card">
                                                    <!-- /.card-header -->
                                                    <div class="card-body table-responsive p-0">
                                                        <table class="table table-hover text-nowrap">
                                                            <thead>
                                                            <tr>
                                                                <th><?php echo e(__('base.no.')); ?></th>
                                                                <th><?php echo e(__('base.nick_name')); ?></th>
                                                                <th><?php echo e(__('base.time')); ?></th>
                                                                <th><?php echo e(__('base.live_casino_wm')); ?></th>
                                                                <th><?php echo e(__('base.live_casino_ag')); ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php if(!empty($data) && $data->total()): ?>
                                                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($firstItem); ?></td>
                                                                    <td><?php echo e($item['nick_name']); ?></td>
                                                                    <td><?php echo e($item['time_report']); ?></td>
                                                                    <td><?php echo e($item['wm']); ?></td>
                                                                    <td><?php echo e($item['ag']); ?></td>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
    $(function () {
        $(function () {
            //Date picker
            $('#fromDate').datetimepicker({
                format: 'Y-MM-DD',
                defaultDate: '<?php echo e(date("Y-m-d",strtotime("-7 days"))); ?>'
            });
            $('#toDate').datetimepicker({
                format: 'Y-MM-DD',
                defaultDate:new Date()
            });
        })
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/gameStatic/livecasino.blade.php ENDPATH**/ ?>