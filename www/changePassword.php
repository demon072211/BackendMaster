<!-- head -->
<?php $this->load->view('admin/admin/head', $this->data) ?>
<div class="line"></div>
<div class="wrapper">
    <div class="widget">
        <?php if($admin_info->Status == "A"): ?>
            <div class="title">
                <h6>Đổi mật khẩu quản trị viên</h6>
            </div>
            <form id="form" class="form" enctype="multipart/form-data" method="post" action="">
                <fieldset>

                    <div class="formRow">
                        <label for="oldPassword" class="formLeft">Mật khẩu cũ:<span class="req">*</span></label>
                        <div class="formRight">
                            <span class="oneTwo"><input  _autocheck="true" type="text" id="oldPassword" name="oldPassword"></span>
                            <span class="autocheck" name="name_autocheck"></span>
                            <div class="clear error" name="name_error"><?php echo form_error('oldPassword') ?></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label for="newPassword" class="formLeft">Mật khẩu mới:<span class="req">*</span></label>
                        <div class="formRight">
                            <span class="oneTwo"><input _autocheck="true"  type="password" id="newPassword" name="newPassword"></span>
                            <span class="autocheck" name="name_autocheck"></span>
                            <div class="clear error" name="name_error"><?php echo form_error('newPassword') ?></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label for="retypePassword" class="formLeft">Nhắc lại mật khẩu:<span class="req">*</span></label>
                        <div class="formRight">
                            <span class="oneTwo"><input _autocheck="true" type="password" id="retypePassword" name="retypePassword"></span>
                            <span class="autocheck" name="name_autocheck"></span>
                            <div class="clear error" name="name_error"><?php echo form_error('retypePassword') ?></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formSubmit">
                        <input type="submit" class="redB" value="Cập nhật">
                    </div>
                </fieldset>
            </form>
        <?php else: ?>
            <div class="title">
                <h6>Bạn không được phân quyền</h6>
            </div>
        <?php endif; ?>
    </div>
</div>
