<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.agent_list')); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo e(__('base.agent_list')); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo e(__('base.agent_list')); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="get" action="<?php echo e(route('agent')); ?>">
                        <div class="card-body row">
                            <!-- Date -->
                            <div class="form-group col-4">
                                <label><?php echo e(__('base.agent_name')); ?> :</label>
                                <div class="input-group date" id="fromDate" data-target-input="nearest">
                                    <input  type="text" class="form-control" name="key" value="<?php echo e(request()->get('key')); ?>" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group col-4">
                                <label><?php echo e(__('base.level')); ?> :</label>
                                <div class="input-group date" id="fromDate" data-target-input="nearest">
                                    <input  type="number" class="form-control" name="level" value="<?php echo e(request()->get('level')); ?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-body">

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('base.search')); ?></button>
                            <a href="<?php echo e(route('agent')); ?>" class="btn btn-primary"><?php echo e(__('base.quit_search')); ?></a>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-info bg-danger"><?php echo e($error); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-12">
                        <?php echo $__env->make('share.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th><?php echo e(__('base.no.')); ?></th>
                                        <th><?php echo e(__('base.user_name')); ?></th>
                                        <th><?php echo e(__('base.agent_name')); ?></th>
                                        <th><?php echo e(__('base.phone_number')); ?></th>
                                        <th>Email</th>
                                        <th><?php echo e(__('base.address')); ?></th>
                                        <th><?php echo e(__('base.bank_name')); ?></th>
                                        <th><?php echo e(__('base.code')); ?></th>
                                        <th><?php echo e(__('base.date_created')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($data) && $data->total()): ?>
                                        <?php $i = $data->firstItem();?>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php echo e($i); ?>

                                                </td>
                                                <td><?php echo e($item['username']); ?></td>
                                                <td><?php echo e($item['nameagent']); ?></td>
                                                <td><?php echo e($item['phone']); ?></td>
                                                <td><?php echo e($item['email']); ?></td>
                                                <td><?php echo e($item['address']); ?></td>
                                                <td><?php echo e(empty($item['namebank']) ? '': $item['namebank']); ?></td>
                                                <td><?php echo e($item['code']); ?></td>
                                                <td><?php echo e(empty($item['createtime']) ? '': $item['createtime']); ?></td>
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
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/agent/index.blade.php ENDPATH**/ ?>