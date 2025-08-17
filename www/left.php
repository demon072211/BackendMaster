<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="<?php echo base_url('admin') ?>">CMS Admin</a>
            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-header">
            <div class="user-pic">
                <img class="img-responsive img-rounded" src="<?php echo public_url('admin') ?>/images/logo_login.png"
                     alt="User picture">
            </div>
            <div class="user-info">
            <span class="user-name"><?php echo $admin_info->UserName?>
            <a title="Đổi mật khẩu" style="margin: -30px; padding: 30px;"
               class="tipS" data-toggle="modal"
               data-target="#changePassword-modal">
                        <img src="<?php echo public_url('admin') ?>/images/icons/key.png"/>
            </a>
          </span>
                <span class="user-role"><?php echo $admin_info->FullName?></span>
                <span class="user-status" style="display: none">
                    <i class="fa fa-circle"></i>
                    người chơi</span>
                </span>
            </div>
        </div>
        <!-- sidebar-header  -->

        <div class="sidebar-menu">
            <ul>
                <li class="header-menu">
                    <span>General</span>
                </li>
                <?php echo $menu_list; ?>
            </ul>
        </div>
        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
        <a href="<?php echo base_url('admin') ?>">
            <i class="fa fa-home" aria-hidden="true"></i>
<!--            <span class="badge badge-pill badge-warning notification">3</span>-->
        </a>
<!--        <a href="#">-->
<!--            <i class="fa fa-envelope"></i>-->
<!--            <span class="badge badge-pill badge-success notification">7</span>-->
<!--        </a>-->
<!--        <a href="#">-->
<!--            <i class="fa fa-cog"></i>-->
<!--            <span class="badge-sonar"></span>-->
<!--        </a>-->
        <a href="<?php echo admin_url('admin/logout') ?>">
            <i class="fa fa-power-off"></i>
        </a>
    </div>
</nav>
<div class="modal fade" id="changePassword-modal" tabindex="-1" role="dialog"
     aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="changePasswordModalLabel"> Đổi mật khẩu </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 id="resultSubmitUser" style="color: red;margin-left: 20px"></h4>
                <form class="tagForm needs-validation" enctype="multipart/form-data" method="post"
                      action="">
                    <div class="form-group">
                        <label for="inputOldPassUser" class="col-form-label">Mật khẩu cũ:</label>
                        <input _autocheck="true" id="inputOldPassUser" type="text" class="form-control">
                        <span class="autocheck" name="name_autocheck"></span>
                        <div class="clear error" name="name_error"><?php echo form_error('inputOldPassUser') ?></div>
                    </div>
                    <div class="form-group">
                        <label for="inputNewPassUser" class="col-form-label">Mật khẩu mới:</label>
                        <input _autocheck="true" id="inputNewPassUser" type="password" class="form-control">
                        <span class="autocheck" name="name_autocheck"></span>
                        <div class="clear error" name="name_error"><?php echo form_error('inputNewPassUser') ?></div>
                    </div>
                    <div class="form-group">
                        <label for="inputRetypePassUser" class="col-form-label">Nhập lại mật khẩu mới:</label>
                        <input _autocheck="true" id="inputRetypePassUser" type="password" class="form-control" >
                        <span class="autocheck" name="name_autocheck"></span>
                        <div class="clear error" name="name_error"><?php echo form_error('inputRetypePassUser') ?></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="password-tag-form-submit">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#changePassword-modal').on('hidden.bs.modal', function (e) {
            $("#resultSubmitUser").html("")
            $(this).find("input").val('')
        })

        $('#password-tag-form-submit').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('user/changePassword')?>",
                data: {
                    inputOldPassUser: $("#inputOldPassUser").val(),
                    inputNewPassUser: $("#inputNewPassUser").val(),
                    inputRetypePassUser: $("#inputRetypePassUser").val()
                },
                dataType: 'json',
                success: function (response) {
                    $("#spinner").hide();
                    if (response.success) {
                        $("#resultSubmitUser").html("");
                        $('#changePassword-modal').modal('hide')
                        showPopupConfirmRelogin()
                    } else {
                        $("#resultSubmitUser").html(response.errorCode + ": " + response.message);
                    }

                }, error: function () {
                    $("#spinner").hide();
                    $("#resultSubmitUser").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                },timeout : 20000
            });
            return false;
        });

        function showPopupConfirmRelogin() {
            bootbox.confirm({
                message: "Bạn có muốn đăng nhập lại",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result) {
                        window.location = "<?php echo admin_url('admin/logout')?>";
                    }
                }
            });
        }

    })
</script>