<table class="table table-bordered">
    <tbody>
    <tr>
        <th class="background-sliver">Tên tài khoản : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['user_name'] : '' ?></td>
        <th class="background-sliver">Cấp bậc : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['user_name'] : '' ?></td>
    </tr>
    <tr>
        <th class="background-sliver">Email : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['email'] : '' ?></td>
        <th class="background-sliver">Tổng số user thuộc đại lý : </th>
        <td<?= $dataInfoUser ? $dataInfoUser['totalUserOfAgency'] : '' ?></td>
    </tr>
    <tr>
        <th class="background-sliver">Số điện thoại : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['mobile'] : '' ?></td>
        <th class="background-sliver">Tổng nạp : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['t_nap'] : '' ?></td>
    </tr>
    <tr>
        <th class="background-sliver">Ngày sinh : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['birthday'] : '' ?></td>
        <th class="background-sliver">Tổng rút : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['t_rut'] : '' ?></td>
    </tr>
    <tr>
        <th class="background-sliver">Địa chỉ : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['address'] : '' ?></td>
        <th class="background-sliver">Mã đại lý : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['referral_code'] : '' ?></td>
    </tr>
    <tr>
        <th class="background-sliver">Chứng minh thư : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['identification'] : '' ?></td>
        <th class="background-sliver">Số lần nạp : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['nap_times'] : '' ?></td>
    </tr>
    <tr>
        <th class="background-sliver">Xác thực sđt : </th>
        <td><?= $dataInfoUser ? ($dataInfoUser['is_verify_mobile'] ? "yes" : "no") : '' ?></td>
        <th class="background-sliver">Số lần rút : </th>
        <td><?= $dataInfoUser ? $dataInfoUser['rut_times'] : '' ?></td>
    </tr>
    <tr>
        <th class="background-sliver">All games</th>
        <td></td>
        <th class="background-sliver"></th>
        <td></td>
    </tr>
    <tr>
        <th class="background-sliver2">
            <button type="button" class="btn btn-secondary mr-3 shadow-nonek" onclick="getThreeBalance(this,'AG')">AG</button>
            <span>(BO) : </span>
            <span id="AG" class="ml-1"></span>
            | <span id="AG-USER" class="ml-1"></span>
        </th>
        <td></td>
        <th class="background-sliver2">
            <button type="button" class="btn btn-secondary  mr-3 shadow-none" onclick="getThreeBalance(this, 'IBC2')">IBC</button>
            <span>(BO) : </span>
            <span id="IBC" class="ml-1"></span>
            | <span id="IBC-USER" class="ml-1"></span>
        </th>
        <td></td>
    </tr>
    <tr>
        <th class="background-sliver2">
            <button type="button" class="btn btn-secondary  mr-3 shadow-none" onclick="getThreeBalance(this, 'WM')">WM</button>
            <span>(BO) : </span>
            <span id="WM" class="ml-1"></span>
            | <span id="WM-USER" class="ml-1"></span>
        </th>
        <td></td>
        <th class="background-sliver2">
            <button type="button" class="btn btn-secondary  mr-3 shadow-none" onclick="getThreeBalance(this, 'CMD')">CMD</button>
            <span>(BO) : </span>
            <span id="CMD" class="ml-1"></span>
            | <span id="CMD-USER" class="ml-1"></span>
        </th>
        <td></td>
    </tr>
    <tr>
        <th class="background-sliver2">
            <button type="button" class="btn btn-secondary  mr-3 shadow-none" onclick="getThreeBalance(this, 'SBO')">SBO</button>
            <span>(SBO) : </span>
            <span id="SBO" class="ml-1"></span>
            | <span id="SBO-USER" class="ml-1"></span>
        </th>
        <td></td>
        <th class="background-sliver2">
            <button type="button" class="btn btn-secondary  mr-3 shadow-none" onclick="getFishBalance(this)">FISH</button>
            <span>(BO) : </span>
            <span id="FISH" class="ml-1"></span>
        </th>
        <td></td>
    </tr>
    <tr>
        <th class="background-sliver2">
            <button type="button" class="btn btn-secondary  mr-3 shadow-none" onclick="getThreeBalance(this, 'EBET')">EBET</button>
            <span>(EBET) : </span>
            <span id="EBET" class="ml-1"></span>
            | <span id="EBET-USER" class="ml-1"></span>
        </th>
        <td></td>
    </tr>
    </tbody>
</table>
<script>
    function getThreeBalance(elmnt, threeRd)
    {
        elmnt.disabled = true;
        switch (threeRd) {
            case 'AG':
                $('#AG').html('loading ...');
                $('#AG-USER').html('loading ...');
                break;
            case 'IBC2':
                $('#IBC').html('loading ...');
                $('#IBC-USER').html('loading ...');
                break;
            case 'WM':
                $('#WM').html('loading ...');
                $('#WM-USER').html('loading ...');
                break;
            case 'CMD':
                $('#CMD').html('loading ...');
                $('#CMD-USER').html('loading ...');
                break;
            case 'SBO':
                $('#SBO').html('loading ...');
                $('#SBO-USER').html('loading ...');
                break;
            case 'EBET':
                $('#EBET').html('loading ...');
                $('#EBET-USER').html('loading ...');
                break;
        }
         $.ajax({
             type: "POST",
             url: "<?= admin_url('useraggregate/getBalanceUserThird')?>",
             data: {
                nickname: '<?= $nn?>',
                type: threeRd
             },
             dataType: 'json',
             success: function (result) {
                 switch(threeRd) {
                     case 'AG':
                         $('#AG').html(result.balance);
                         $('#AG-USER').html(result.userThirdParty);
                         break;
                     case 'IBC2':
                         $('#IBC').html(result.balance);
                         $('#IBC-USER').html(result.userThirdParty);
                         break;
                     case 'WM':
                         $('#WM').html(result.balance);
                         $('#WM-USER').html(result.userThirdParty);
                         break;
                     case 'CMD':
                         $('#CMD').html(result.balance);
                         $('#CMD-USER').html(result.userThirdParty);
                         break;
                     case 'SBO':
                         $('#SBO').html(result.balance);
                         $('#SBO-USER').html(result.userThirdParty);
                         break;
                     case 'EBET':
                         $('#EBET').html(result.balance);
                         $('#EBET-USER').html(result.userThirdParty);
                         break;
                 }
                 console.log(result);
                 elmnt.disabled = false;
             }, error: function () {
                 elmnt.disabled = false;
                 alert("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
             }, timeout: 20000
         });
    }
    
    function getFishBalance(el) {
        el.disabled = true;
        $('#FISH').html('loading ...');
        $.ajax({
            type: "POST",
            url: "<?= admin_url('useraggregate/getBalanceFishThird')?>",
            data: {
                nn: '<?= $nn?>'
            },
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    $('#FISH').html(result.balance);
                } else {
                    $('#FISH').html(result.message);
                }

                console.log(result);
                el.disabled = false;
            }, error: function () {
                el.disabled = false;
                $('#FISH').html('');
                alert("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            }, timeout: 20000
        });
    }
</script>