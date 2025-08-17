<!-- head -->
<?php $this->load->view('admin/config/head', $this->data) ?>
<div class="line"></div>
<?php if($role == false): ?>
    <div class="wrapper">
        <div class="widget">
            <div class="title">
                <h6>Bạn không được phân quyền</h6>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="wrapper">
        <ul class="tabs-menu">
            <li class="current"><a href="#tab-1">Minigame</a></li>
            <li><a href="#tab-2">SLOT</a></li>
            <li><a href="#tab-3">TLMN</a></li>
            <li><a href="#tab-4">Minigame Jackpot và Quỹ</a></li>
            <li><a href="#tab-5">Slot Jackpot và Quỹ</a></li>
            <li><a href="#tab-6">TLMN Jackpot và Quỹ</a></li>
            <li><a href="#tab-7">Xóc đĩa</li>
            <li><a href="#tab-8">Config tài xỉu</li>
        </ul>
        <div class="widget">
            <?php if($admin_info ->Status == "A"): ?>
                <div class="formRow">
                    <div class="container">
                        <div id="tabs-container">
                            <div id="tab-1" class="tab-content col-sm-12">
                                <!--  MINIGAME  -->
                                <div class="row">
                                    <div class="title">
                                        <h6>Danh sách game config minigame</h6>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                                        <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Tên config</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                        <tbody id="logaction">
                                        <tr>
                                            <td>1</td>
                                            <td>Minipoker config</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigame') ?>?t=0'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Slot3x3 config</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigame') ?>?t=2'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Multi jackpot config</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigame') ?>?t=4'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-content col-sm-12">
                                <!--  SLOT  -->
                                <div class="row">
                                    <div class="title">
                                        <h6>Danh sách game config slot</h6>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                                        <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Tên config</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                        <tbody id="logaction">
                                        <tr>
                                            <td>1</td>
                                            <td>Slot 7 icon</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslot') ?>?t=0'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Slot 7 wild</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslot') ?>?t=2'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Slot 9 icon</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslot') ?>?t=4'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Slot 1 icon wild</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslot') ?>?t=6'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Nhân hũ</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslot') ?>?t=8'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-content col-sm-12">
                                <!--  TLMN  -->
                                <div class="row">
                                    <div class="title">
                                        <h6>Danh sách game config tlmn</h6>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                                        <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Tên config</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                        <tbody id="logaction">
                                        <tr>
                                            <td>1</td>
                                            <td>Trạng thái bật / tắt bot</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/edittlmn') ?>?t=28'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-4" class="tab-content col-sm-12">
                                <!--  minigame jackpot và quỹ  -->
                                <div class="row">
                                    <div class="title">
                                        <h6>Danh sách game minigame jackpot và quỹ</h6>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                                        <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Tên config</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                        <tbody id="logaction">
                                        <tr>
                                            <td>1</td>
                                            <td>Jackpot minipoker</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=0'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jackpot slot 3x3</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=2'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Jackpot cao thấp</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=4'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Fund minipoker</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=6'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Fund slot 3x3</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=8'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Fund slot bầu cua</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=10'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Fund slot cao thấp</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=14'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Jackpot GALAXY</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=19'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Fund GALAXY</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=21'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-5" class="tab-content col-sm-12">
                                <!--  slot jackpot và quỹ  -->
                                <div class="row">
                                    <div class="title">
                                        <h6>Danh sách game slot jackpot và quỹ</h6>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                                        <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Tên config</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                        <tbody id="logaction">
                                        <tr>
                                            <td>1</td>
                                            <td>Jackpot slot bitcoin</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=0'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jackpot slot đua xe</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=2'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Jackpot slot chim điên</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=4'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Jackpot slot thần tài</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=6'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Jackpot slot thể thao</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=8'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>Jackpot slot Kim Bình Mai</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=10'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>Fund slot bitcoin</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=12'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>Fund slot đua xe</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=14'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>Fund slot chim điên</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=16'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>Fund slot thần tài</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=18'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>11</td>
                                            <td>Fund slot thể thao</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=20'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td>Fund slot kim bình mai</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=22'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>13</td>
                                            <td>Jackpot slot chiêm tinh</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=24'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>14</td>
                                            <td>Fund slot chiêm tinh</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=26'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td>Jackpot thần bài</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=28'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>16</td>
                                            <td>Fund thần bài</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=30'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>16</td>
                                            <td>Jackpot Bikini</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=32'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>17</td>
                                            <td>Fund Bikini</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editslothandle') ?>?t=34'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-6" class="tab-content col-sm-12">
                                <!--  tlmn jackpot và quỹ  -->
                                <div class="row">
                                    <div class="title">
                                        <h6>Danh sách game tlmn jackpot và quỹ</h6>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                                        <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Tên config</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                        <tbody id="logaction">
                                        <tr>
                                            <td>1</td>
                                            <td>Quỹ</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/edittlmnhandle') ?>?t=30'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-7" class="tab-content col-sm-12">
                                <!--  xóc dia -->
                           <div class="row">
                                    <div class="title">
                                        <h6>DANH SÁCH GAME CONFIG XÓC </h6>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                                        <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Tên config</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                        <tbody id="logaction">
                                        <tr>
                                            <td>1</td>
                                            <td>Config list fun</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editxdhandle') ?>?t=32'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-8" class="tab-content col-sm-12">
                                <!--  MINIGAME  -->
                                <div class="row">
                                    <div class="title">
                                        <h6>Danh sách game config tài xỉu</h6>
                                    </div>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                                        <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Tên config</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                        <tbody id="logaction">
                                        <tr>
                                            <td>1</td>
                                            <td>Fund tài xỉu</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editminigamehandle') ?>?t=12'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Fund Jackpot tài xỉu</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/edittaixiuhandle') ?>?t=23'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Set kết quả nổ hũ tài xỉu</td>
                                            <td>
                                                <a href='<?php echo admin_url('confignew/editnohutaixiu') ?>?t=28'>
                                                    <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="title">
                    <h6>Bạn không được phân quyền</h6>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif;?>
<div class="clear mt30"></div>
<style>
    #checkAll {
        border: 1px solid #ddd;
    }

    .tabs-menu {
        height: 30px;
        /*float: left;*/
        clear: both;
    }

    .tabs-menu li {
        height: 30px;
        line-height: 30px;
        float: left;
        margin-right: 10px;
        background-color: #ccc;
        border-top: 1px solid #d4d4d1;
        border-right: 1px solid #d4d4d1;
        border-left: 1px solid #d4d4d1;
    }

    .tabs-menu li.current {
        position: relative;
        background-color: #fff;
        border-bottom: 1px solid #fff;
        z-index: 5;
    }

    .tabs-menu li a {
        padding: 10px;
        text-transform: uppercase;
        color: #fff;
        text-decoration: none;
    }

    .tabs-menu .current a {
        color: #2e7da3;
    }

    .tab-content {
        width: 100%;
        padding: 20px;
        display: none;
    }

    #tab-1 {
        display: block;
    }

    td {
        word-break: break-all;
    }

    thead {
        font-size: 12px;
    }

</style>

<script>
    $(document).ready(function () {
        $(".tabs-menu a").click(function (event) {
            event.preventDefault();
            $(this).parent().addClass("current");
            $(this).parent().siblings().removeClass("current");
            var tab = $(this).attr("href");
            $(".tab-content").not(tab).css("display", "none");
            $(tab).fadeIn();
        });
    });
</script>
