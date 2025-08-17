<div class="flash-message col-lg-12">
    <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session()->has('alert-' . $msg)): ?>
            <p class="alert alert-<?php echo e($msg); ?> p-2"><?php echo e(Session::get('alert-' . $msg)); ?></p>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /var/www/daily/resources/views/share/flash.blade.php ENDPATH**/ ?>