<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.recharge_history')); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo e(__('base.recharge_history')); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e(__('base.recharge_history')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="get" action="<?php echo e(route('deposit')); ?>">
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
                            <label><?php echo e(__('base.nick_name')); ?> :</label>
                            <div class="input-group date" id="toDate" data-target-input="nearest">
                                <input type="text" class="form-control "   name="nn" value="<?php echo e(request()->get('nn')); ?>">
                            </div>
                        </div>

                        <div class="form-group col-3">
                            <label><?php echo e(__('base.status')); ?> :</label>
                            <div class="input-group date" id="toDate" data-target-input="nearest">
                                <select class="form-control" name="st">
                                    <option <?php if(request()->get('st') === ''): ?> selected <?php endif; ?> value="">Chọn</option>
                                    <option <?php if(request()->get('st') === '0'): ?> selected <?php endif; ?> value="0">Pending</option>
                                    <option <?php if(request()->get('st') == '3'): ?> selected <?php endif; ?> value="3">Failed</option>
                                    <option <?php if(request()->get('st') == '4'): ?> selected <?php endif; ?> value="4">Success</option>
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
                        <a href="<?php echo e(route('deposit')); ?>" class="btn btn-primary"><?php echo e(__('base.quit_search')); ?></a>
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
                                        <th><?php echo e(__('base.nick_name')); ?></th>
                                        <th><?php echo e(__('base.bank_code')); ?></th>
                                        <th><?php echo e(__('base.type')); ?></th>
                                        <th><?php echo e(__('base.amount')); ?></th>
                                        <th><?php echo e(__('base.status')); ?></th>
                                        <th><?php echo e(__('base.account_number')); ?></th>
                                        <th><?php echo e(__('base.account_name')); ?></th>
                                        <th><?php echo e(__('base.transaction_id')); ?></th>
                                        <th><?php echo e(__('base.date_created')); ?></th>
                                        <th><?php echo e(__('base.act')); ?></th>
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
                                    <td><?php echo e($item['Nickname']); ?></td>
                                    <td><?php echo e($item['BankCode']); ?></td>
                                    <td>
                                        <?php if($item['ProviderName'] == "manual"): ?>
                                            <?php echo e(__('base.transfera')); ?>

                                        <?php else: ?>
                                            <?php echo e($item['ProviderName']); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($item['Amount'])): ?>
                                            <?php echo e(number_format($item['Amount'])); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($item['Status'] == 0): ?>
                                            Pending
                                        <?php elseif($item['Status'] == 3): ?>
                                            Failed
                                        <?php elseif($item['Status'] == 4): ?>
                                            Success
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($item['BankAccountNumber']); ?></td>
                                    <td><?php echo e($item['BankAccountName']); ?></td>
                                    <td><?php echo e($item['CreatedAt']); ?></td>
                                    <td>
                                        <?php if($item['Status'] == 0): ?>
                                            <span style="color:#007bff;cursor:pointer" onclick="rejectAction(<?php echo e($item['Id']); ?>, '<?php echo e($item['Amount']); ?>')" class="mr-2">
                                                <?php echo e(__('base.cancel')); ?>

                                            </span>

                                            <span style="color:#007bff;cursor:pointer" onclick="approveAction(<?php echo e($item['Id']); ?>, '<?php echo e($item['Amount']); ?>')">
                                                <?php echo e(__('base.approve')); ?>

                                            </span>
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
<?php echo $__env->make("topup.reject", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make("topup.approve", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Modal -->
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

        function rejectAction(id, bn) {
            $('#rejectModalCenter').modal('show')
            $('#delete-content').html('<?php echo e(__('base.are_you_sure_you_want_to_decline_the_transaction')); ?> : ' + bn);
            $('#reject-modal').val(id);
        }

        $("#form-reject").submit(function( event ) {
            var data = $(this).serializeArray();
            $.ajax({
                    type: 'post',
                    url: '<?php echo e(route('deposit-reject')); ?>',
                    data: data,
                    success: function (response) {
                        $('#rejectModalCenter').modal('hide');
                        console.log(response);
                        location.reload()
                    },
                    error: function (error) {
                        $('#rejectModalCenter').modal('hide');
                        console.log(error);
                        alert('<?php echo e(__('base.fail')); ?>');
                    }
                }
            );
            event.preventDefault();
        });


        function approveAction(id, bn) {
            $('#approveModalCenter').modal('show')
            $('#approve-content').html('<?php echo e(__('base.are_you_sure_you_want_to_approve_the_transaction')); ?> : ' + bn);
            $('#approve-modal').val(id);
        }

        $("#form-approve").submit(function( event ) {
            var data = $(this).serializeArray();
            $.ajax({
                    type: 'post',
                    url: '<?php echo e(route('deposit-approve')); ?>',
                    data: data,
                    success: function (response) {
                        $('#approveModalCenter').modal('hide');
                        console.log(response);
                        location.reload()
                    },
                    error: function (error) {
                        $('#approveModalCenter').modal('hide');
                        console.log(error);
                        alert('<?php echo e(__('base.fail')); ?>');
                    }
                }
            );
            event.preventDefault();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/topup/index.blade.php ENDPATH**/ ?>