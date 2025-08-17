<!-- Stored in resources/views/child.blade.php -->

<?php $__env->startSection('title', __('base.list_banks')); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo e(__('base.list_banks')); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('base.home')); ?></a></li>
                            <li class="breadcrumb-item active"><?php echo e(__('base.list_banks')); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <form method="get" action="<?php echo e(route('banks')); ?>">
                        <div class="card-body row">
                            <!-- Date -->
                            <div class="form-group col-4">
                                <label><?php echo e(__('base.bank_code')); ?> :</label>
                                <div class="input-group date" id="fromDate" data-target-input="nearest">
                                    <input  type="text" class="form-control" name="key" value="<?php echo e(request()->get('key')); ?>" autocomplete="off">
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-body">

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('base.search')); ?></button>
                            <a href="<?php echo e(route('banks')); ?>" class="btn btn-primary"><?php echo e(__('base.quit_search')); ?></a>
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
                                        <th><?php echo e(__('base.bank_account')); ?></th>
                                        <th><?php echo e(__('base.bank_code')); ?></th>
                                        <th><?php echo e(__('base.account_number')); ?></th>
                                        <th><?php echo e(__('base.branch')); ?></th>
                                        <th></th>
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
                                                <td><?php echo e($item['bank_acount']); ?></td>
                                                <td><?php echo e($item['bank_code']); ?></td>
                                                <td><?php echo e($item['bank_number']); ?></td>
                                                <td><?php echo e($item['bank_branch']); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('bank-edit', $item['id'])); ?>" class="mr-4">Sửa</a>

                                                    <span style="color:#007bff;cursor:pointer" onclick="deleteAction(<?php echo e($item['id']); ?>, '<?php echo e($item['bank_acount']); ?>')">Xóa</span>
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
    <?php echo $__env->make("bank.delete", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Modal -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        function deleteAction(id, bn) {
            $('#deleteModalCenter').modal('show')
            $('#delete-content').html('Bạn có chắc chắn muốn xóa : ' + bn);
            $('#delete-modal-bank').val(id);
        }

        $("#form-delete").submit(function( event ) {
            var data = $(this).serializeArray();
            $.ajax({
                    type: 'post',
                    url: '<?php echo e(route('bank-delete')); ?>',
                    data: data,
                    success: function (response) {
                        $('#deleteModalCenter').modal('hide');
                        console.log(response);
                        location.reload()
                    },
                    error: function (error) {
                        $('#deleteModalCenter').modal('hide');
                        console.log(error);
                        alert('Xóa thất bại');
                    }
                }
            );
            event.preventDefault();
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/www/daily/resources/views/bank/index.blade.php ENDPATH**/ ?>