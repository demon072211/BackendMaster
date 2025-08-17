<?php if (!$dataGameUser) { ?>
<h4 class="text-danger">Không tìm thấy kết quả</h4>
<?php } ?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">Tên game</th>
        <?php foreach($gameName as $key => $element) {?>
            <th scope="col"><?= $element?></th>
        <?php }?>
    </tr>
    </thead>
    <tbody>
    <?php if ($dataGameUser) { ?>
        <tr>
            <th scope="row">bet/win</th>
            <?php foreach ($gameName as $key => $value) {?>
                <td>
                    <?php
                    $bet = empty($dataGameUser[$key]) ? 0 : number_format($dataGameUser[$key]);
                    $win = empty($dataGameUser[$key . '_win']) ? 0 : number_format($dataGameUser[$key . '_win']);
                    echo "$bet/$win";
                    ?>
                </td>
            <?php }?>
        </tr>
    <?php } ?>
    </tbody>
</table>