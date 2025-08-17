

    <div class="wrapper">
        <?php $this->load->view('admin/message', $this->data); ?>
        
        

        
        
        
        <script
            src="<?php echo public_url() ?>/site/bootstrap/bootstrap-datetimepicker.min.js"></script>
        <div class="widget">
            <div class="title">
                <h6>Cập nhật bảo mật </h6>
            </div>
            <form class="list_filter form" action="" method="">
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4"><label id="errorname" style="color: #e72929;"></label></div>
                    </div>
                </div>
                
                <?php if($this->session->userdata('isAppSecure') != 1) { ?>
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        
                        <div class="col-sm-2">
                        <input class="button blueB" id="getQr" value="lấy mã QR"  type="button">
                        <input type="hidden" id="secKey" value="" />
                        </div>

                    </div>

                </div>

                <div class="formRow  hide_group">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2"><label>Qr Image</label></div>
                        <div class="col-sm-2">
                            <img id="image_qr" src="" />
                        </div>

                    </div>

                </div>

                <div class="formRow  hide_group">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2"><label>Qr Secret</label></div>
                        <div class="col-sm-2">
                        <label id="secKeyText"></label>
                        </div>

                    </div>

                </div>

                <div class="formRow  hide_group">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2"><label>OTP</label></div>
                        <div class="col-sm-2">
                        <input class="form-control" id="otpText" value=""  type="text">
                        
                        </div>

                    </div>

                </div>

                <div class="formRow  hide_group">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        
                        <div class="col-sm-2">
                        <input class="button blueB" id="updateOtp" value="Cập nhật"  type="button">
                        <input type="hidden" id="secKey" value="" />
                        </div>

                    </div>

                </div>
                
                
                <?php } else { ?>

                    <div class="formRow  ">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2"><label>OTP</label></div>
                        <div class="col-sm-2">
                        <input class="form-control" id="otpText" value=""  type="text">
                        
                        </div>

                    </div>

                </div>

                <div class="formRow  ">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        
                        <div class="col-sm-2">
                        <input class="button blueB" id="cancleSec" value="Huỷ bảo mật"  type="button">
                        
                        </div>

                    </div>

                </div>

                <?php } ?>                <div class="formRow" hidden>
                    <div class="row">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-2"><label>Mã otp</label></div>
                        <div class="col-sm-1"><input class="form-control" id="txtotp"  type="text" placeholder="Nhập OTP" value="1"></div>
                        <div class="col-sm-1">
                            <select id="txttypeotp">
                                <option value="0">SMS OTP</option>
                                <option value="1">APP OTP</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="formRow">
                    <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-1">
                            <input type="button" id="congxu" value="Công xu" class="button blueB">
                        </div>
                        <div class="col-sm-1">
                            <input type="button" id="truxu" value="Trừ xu" class="button blueB">
                        </div>
                    </div>
                </div> -->
            </form>
            <div class="formRow"></div>
            <div class="modal fade" id="bsModal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            <p style="color: #7a6fbe">cập nhật bảo mật thành công!</p>
                        </div>
                        <div class="modal-footer">
                            <input class="blueB logMeIn" type="button" value="Đóng" data-dismiss="modal"
                                   aria-hidden="true">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

<style>.spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-left: -50px; /* half width of the spinner gif */
        margin-top: -50px; /* half height of the spinner gif */
        text-align: center;
        z-index: 1234;
        overflow: auto;
        width: 100px; /* width of the spinner gif */
        height: 102px; /*hight of the spinner gif +2px to fix IE8 issue */
    }
    .hide_group{
        display:none;
    }
    </style>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/loading.gif') ?>" alt="Loading"/>
    </div>
</div>
<script>
   $(document).ready(function(){
    $("#getQr").click(function(){
        $.ajax({
        type: "POST",
            url: "<?php echo base_url("/admin/user/getqrajax") ?>",
            dataType: 'json',
            success: function (res) {
                if(res.success && res.secret != ""){
                    $("#image_qr").attr("src","https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/"+res.nickname+"%3Fsecret%3D"+res.secret)
                    $("#qr_group").show();
                    $("#secKey").val(res.secret);
                    $("#secKeyText").html(res.secret);
                    $(".hide_group").show();
                    $("#getQr").hide();
                }else{
                    $("#errorname").html("Không thể lấy mã QR");
                }
            }
        });
    });

    $("#updateOtp").click(function(){ 
        var otp =  $("#otpText").val();
        if(otp === ''){
            $("#errorname").html("Vui lòng nhập otp");
            return;
        } 
        $.ajax({
        type: "POST",
            url: "<?php echo base_url("/admin/user/updateotpajax") ?>",
            data: {
                otp: $("#otpText").val(),
                sec: $("#secKey").val()
            },
            dataType: 'json',
            success: function (res) {
                if (res.errorCode == 0) {
                        $("#bsModal3").modal("show");
                        $("#errorname").html("");
                        location.reload();
                    }
                else{
                    $("#errorname").html("Otp không đúng hoặc bạn đã kích hoạt otp");
                }
            }
        });
    });

    $("#cancleSec").click(function(){
        var otp =  $("#otpText").val();
        if(otp === ''){
            $("#errorname").html("Vui lòng nhập otp");
            return;
        } 
        $.ajax({
        type: "POST",
            url: "<?php echo base_url("/admin/user/updateotpajax") ?>",
            data: {
                otp: otp,
                act: 'rm'
            },
            dataType: 'json',
            success: function (res) {
                if (res.errorCode == 0) {
                        $("#bsModal3").modal("show");
                        $("#errorname").html("");
                        location.reload();
                    }
                else{
                    $("#errorname").html("Otp không đúng hoặc bạn đã kích hoạt otp");
                }
            }
        });
    });

   });
</script>
