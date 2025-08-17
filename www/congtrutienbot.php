<?php if($role == false): ?>
    <section class="content-header">
        <h1>
            Bạn chưa được phân quyền
        </h1>
    </section>
<?php else: ?>
    <section class="content-header">
        <h1>
            Cộng trừ tiền bot
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <label class="col-sm-2  control-label" style="color: red" id="errorvin"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <label class="col-sm-1 control-label">Hành động:</label>
                                <div class="col-sm-2">
                                    <select  id="actionname" class="form-control" >
                                        <option value="1">Bán Win</option>
                                        <option value="0">Mua Win</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <label class="col-sm-1 control-label">Nick name:</label>
                                <input id="checknickname" type="hidden">
                                <div class="col-sm-2">
                                    <input type="text" id="nickname" class="form-control"  onblur="myFunction()">
                                </div>
                                <label id="lblnickname" style="color: blueviolet"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <label class="col-sm-1 control-label">Số tiền:</label>

                                <div class="col-sm-2">
                                    <input type="text" id="tienchuyen" class="form-control">
                                </div>
                                <label id="numchuyen" style="color: blueviolet"></label>
                            </div>
                        </div>
                        <?php if($this->session->userdata('isMobileSecure') == 1) { ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <label class="col-sm-1 control-label">OTP:</label>

                                <div class="col-sm-1">
                                    <select  id="typeotp" class="form-control" >
                                        <option value="1">APP OTP</option>
                                        <option value="0">SMS OTP</option>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" id="txt_otp" class="form-control" placeholder="Nhập OTP">
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-1">
                                    <input type="button" id="chuyentien"
                                           value="Bán Win" class="btn btn-primary pull-left">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <div class="modal fade" id="bsModal3" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <p style="color: #0000ff" id="statusmoney"></p>
                </div>
                <div class="modal-footer">
                    <input class="blueB logMeIn" type="button" value="Đóng" data-dismiss="modal"
                           aria-hidden="true">
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<style>
    .spinner {
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

</style>

<script>
$(document).ready(function () {

    $('#bsModal3').on('hidden.bs.modal', function () {
        window.location.href = '<?php echo admin_url("user/congtrutienbot") ?>';
    });
    var  money = $("#tienchuyen").val();
    $( "#actionname" ).change(function() {
        if($("#actionname").val() == 1){
            $("#chuyentien").val("Bán Win");
            money = $("#tienchuyen").val();
        }else {
            $("#chuyentien").val("Mua Win");
            money = -$("#tienchuyen").val();
        }
    });

    $("#chuyentien").click(function () {
        var  money = $("#tienchuyen").val();
        if($("#actionname").val() == 1){
            money = $("#tienchuyen").val();
        }else {
            money = -$("#tienchuyen").val();
        }
        if ($("#nickname").val() == "") {
            $("#errorvin").html("Bạn chưa nhập nickname");
            return false;
        }
        else if ($("#tienchuyen").val() == "" || $("#tienchuyen").val() == 0 ) {
            $("#errorvin").html("Bạn chưa nhập số tiền");
            return false;
        }
        else if ($("#txt_otp").val() == "") {
            $("#errorvin").html("Bạn chưa nhập OTP");
            return false;
        }
        else if($("#checknickname").val() == -1) {
            $("#errorvin").html("Nickname không tồn tại");
            return false;
        }
        else if($("#checknickname").val() == -2) {
            $("#errorvin").html("Hệ thống gián đoạn");
            return false;
        }
        else {
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url("user/congtrutienbotajax") ?>",
                data: {
                    nickname: $("#nickname").val(),
                    tienchuyen: money,
                    otp:  $("#txt_otp").val(),
                    typeotp :  $("#typeotp").val()
                },
                dataType: 'json',
                success: function (result) {
                    $("#errorvin").html(result);
                }, error: function(error) {
                    $("#errorvin").html(error.responseText);
                }
            })
        }

    })    $('#tienchuyen').on('paste', function (e) {
        let pastedData = e.originalEvent.clipboardData.getData('text');
        let money = parseInt(pastedData);
        if(isNaN(money) || money <= 0) {
            alert("Vui lòng nhập số lớn hơn 0");
            e.preventDefault();
        }
    });

    $("#tienchuyen").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
var format = function(num){
    var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ",") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};
$("#tienchuyen").keyup(function (e) {
    $(this).val(($(this).val()));
    $("#numchuyen").text(format($(this).val()));

});
function myFunction() {
    $.ajax({
        type: "POST",
        url: "<?php echo admin_url("user/getnicknameajax") ?>",
        data: {
            nickname: $("#nickname").val()
        },
        dataType: 'json',
        success: function (res) {
            $("#checknickname").val(res);
            if (res == -2) {
                $("#lblnickname").text("Hệ thống gián đoạn");
                $("#errorvin").html("");
            }
            else if (res == -1) {
                $("#lblnickname").text("Nickname không tồn tại");
                $("#errorvin").html("");
            }
            else if (res == 0) {
                $("#lblnickname").text("Tài khoản tồn tại");
                $("#errorvin").html("");
            }
            else if (res == 1) {
                $("#lblnickname").text("Tài khoản đại lý cấp 1");
                $("#errorvin").html("");
            }
            else if (res == 2) {
                $("#lblnickname").text("Tài khoản đại lý cấp 2");
                $("#errorvin").html("");
            }
            else if (res == 100) {
                $("#lblnickname").text("Tài khoản admin");
                $("#errorvin").html("");
            }
        }
    })
}
</script>