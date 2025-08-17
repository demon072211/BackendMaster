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
        <div class="widget">
            <?php if($admin_info ->Status == "A"): ?>
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
                            <a href='<?php echo admin_url('confignew/edittlmnhandle') ?>?t=0'>
                                <img src="<?php echo public_url('admin') ?>/images/icons/color/edit.png">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="title">
                    <h6>Bạn không được phân quyền</h6>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif;?>
<div class="clear mt30"></div>

<script>
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
</script>
