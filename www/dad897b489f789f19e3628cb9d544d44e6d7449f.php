<div class="modal fade bd-example-modal-lg" id="approveModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content background-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Phê duyệ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo e(__('base.close')); ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form-approve" action="">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div class="form-group row">
                            <input type="text" hidden id="approve-modal" value="" name="id">
                            <div class="col-sm-10" id="approve-content">
                            </div>
                            <div class="form-group col-12">
                                <label><?php echo e(__('base.receiver')); ?> :</label>
                                <div class="input-group date" id="toDate" data-target-input="nearest">
                                    <select class="form-control" name="bn" required>
                                        <?php $__currentLoopData = $bankFrom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if(request()->get('fbn') == $value['bank_number']): ?> <?php endif; ?> value="<?php echo e($value['bank_number']); ?>"><?php echo e($value['bank_acount']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-light px-5" data-dismiss="modal"><?php echo e(__('base.close')); ?></button>
                        <button type="submit" class="btn btn-light px-5" id="create-modal"><?php echo e(__('base.confirm')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/app/www/daily/resources/views/topup/approveWithDraw.blade.php ENDPATH**/ ?>