<div class="card-header p-0 pt-1 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?php if($params['type']== 'MINIGAME'): ?> <?php echo e('active'); ?> <?php endif; ?>" href="<?php echo e(route('game', ['type' => 'MINIGAME'])); ?>">Mini game</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($params['type']== 'POKER'): ?> <?php echo e('active'); ?> <?php endif; ?>" href="<?php echo e(route('game', ['type' => 'POKER'])); ?>">Poker</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($params['type']== 'LIVECASINO'): ?> <?php echo e('active'); ?> <?php endif; ?>" href="<?php echo e(route('game', ['type' => 'LIVECASINO'])); ?>">Live casino</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($params['type']== 'SPORT'): ?> <?php echo e('active'); ?> <?php endif; ?>" href="<?php echo e(route('game', ['type' => 'SPORT'])); ?>">Sport</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($params['type']== 'NOHU'): ?> <?php echo e('active'); ?> <?php endif; ?>" href="<?php echo e(route('game', ['type' => 'NOHU'])); ?>">Nổ hũ</a>
        </li>
    </ul>
</div><?php /**PATH /var/www/daily/resources/views/gameStatic/tab.blade.php ENDPATH**/ ?>