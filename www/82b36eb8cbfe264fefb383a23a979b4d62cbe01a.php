<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.history')); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo e(__('base.history')); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo e(__('base.history')); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="get" action="<?php echo e(route('transactions')); ?>">
                        <div class="card-body row">
                            <!-- Date -->
                            <div class="form-group col-3">
                                <label><?php echo e(__('base.since')); ?> :</label>
                                <div class="input-group date" id="fromDate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#fromDate" name="ft" value="<?php echo e(request()->get('ft')); ?>">
                                    <div class="input-group-append" data-target="#fromDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-3">
                                <label><?php echo e(__('base.to')); ?> :</label>
                                <div class="input-group date" id="toDate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#toDate"  name="et" value="<?php echo e(request()->get('et')); ?>">
                                    <div class="input-group-append" data-target="#toDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-3">
                                <label><?php echo e(__('base.status')); ?> :</label>
                                <div class="input-group date" id="toDate" data-target-input="nearest">
                                    <select class="form-control" name="st">
                                        <option <?php if(request()->get('st') === ''): ?> selected <?php endif; ?> value="">Chọn</option>
                                        <option <?php if(request()->get('st') === '0'): ?> selected <?php endif; ?> value="0">Pending</option>
                                        <option <?php if(request()->get('st') == '3'): ?> selected <?php endif; ?> value="3">Failed</option>
                                        <option <?php if(request()->get('st') == '2'): ?> selected <?php endif; ?> value="2">Success</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-body">

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('base.search')); ?></button>
                            <a href="<?php echo e(route('transactions')); ?>" class="btn btn-primary"><?php echo e(__('base.quit_search')); ?></a>
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
                                <table class="table table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('base.no.')); ?></th>
                                            <th><?php echo e(__('base.user')); ?></th>
                                            <th><?php echo e(__('base.agent_code')); ?></th>
                                            <th><?php echo e(__('base.point')); ?></th>
                                            <th><?php echo e(__('base.amount')); ?></th>
                                            <th><?php echo e(__('base.fee')); ?></th>
                                            <th><?php echo e(__('base.bonus')); ?></th>
                                            <th><?php echo e(__('base.status')); ?></th>
                                            <th><?php echo e(__('base.transferr')); ?></th>
                                            <th><?php echo e(__('base.receiver')); ?></th>
                                            <th><?php echo e(__('base.content')); ?></th>
                                            <th><?php echo e(__('base.verifier')); ?></th>
                                            <th><?php echo e(__('base.description')); ?></th>
                                            <th><?php echo e(__('base.request_time')); ?></th>
                                            <th><?php echo e(__('base.act')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($data) && $data->total()): ?>
                                        <?php $i = $data->firstItem();?>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i); ?></td>
                                                <td><?php echo e($item['Username']); ?></td>
                                                <td><?php echo e($item['AgentCode']); ?></td>
                                                <td><?php echo e($item['Point']); ?></td>
                                                <td>
                                                    <?php if(!empty($item['Money'])): ?>
                                                        <?php echo e(number_format($item['Money'])); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($item['Fee']); ?></td>
                                                <td><?php echo e($item['Bonus']); ?></td>
                                                <td><?php echo e(maskStatusPoint($item['Status'])); ?></td>
                                                <td><?php echo e($item['FromBankNumber']); ?></td>
                                                <td><?php echo e($item['ToBankNumber']); ?></td>
                                                <td><?php echo e($item['Content']); ?></td>
                                                <td><?php echo e($item['UserApprove']); ?></td>
                                                <td><?php echo e($item['Description']); ?></td>
                                                <td><?php echo e($item['RequestTime']); ?></td>
                                                <td>
                                                    <?php if($item['Status'] == 0): ?>
                                                    <span style="color:#007bff;cursor:pointer" onclick="deleteAction(<?php echo e($item['Id']); ?>, '<?php echo e($item['Money']); ?>')"><?php echo e(__('base.cancel')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                            <?php $i++;?>
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
    <!-- Modal -->
    <?php echo $__env->make("transaction.delete", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        function deleteAction(id, bn) {
            $('#deleteModalCenter').modal('show')
            $('#delete-content').html('<?php echo e(__('base.are_you_sure_you_want_to_decline_the_transaction')); ?> : ' + bn);
            $('#delete-modal-bank').val(id);
        }

        $("#form-delete").submit(function( event ) {
            var data = $(this).serializeArray();
            $.ajax({
                    type: 'post',
                    url: '<?php echo e(route('transaction-reject')); ?>',
                    data: data,
                    success: function (response) {
                        $('#deleteModalCenter').modal('hide');
                        console.log(response);
                        location.reload()
                    },
                    error: function (error) {
                        $('#deleteModalCenter').modal('hide');
                        console.log(error);
                        alert('<?php echo e(__('base.fail')); ?>');
                    }
                }
            );
            event.preventDefault();
        });

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
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/transaction/index.blade.php ENDPATH**/ ?>