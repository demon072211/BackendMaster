<?php $this->load->view('admin/usergame/head', $this->data) ?>
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
        <?php $this->load->view('admin/message', $this->data); ?>
        
        

        
        
        
        <script
            src="<?php echo public_url() ?>/site/bootstrap/bootstrap-datetimepicker.min.js"></script>
        <div class="widget">
            <div class="title">
                <h6>Reset Hũ</h6>
            </div>
            <form class="list_filter form" action="" method="">
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4"><label id="errorname" style="color: #e72929;"></label></div>
                    </div>
                </div>
               
                
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-2"><label>Chọn Game</label></div>
                       
                        <div class="col-sm-2">
                        <select id="gamename">
                                <option value="Audition">Audition</option>
                                <option value="RANGE_ROVER">Range Rover</option>
                                <option value="MAYBACH">Maybach</option>
                                <option value="Spartan">SPARTAN</option>
                                <option value="ROLL_ROYE">ROLLS ROYCE</option>
                                <option value="TAMHUNG">TAM HUNG</option>
                                <option value="BENLEY">BENLEY</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-1">
                            <input type="button" id="congxu" value="Reset" class="button blueB">
                        </div>
                        
                       
                    </div>
                </div>
                
            </form>
            <div class="formRow"></div>
            <div class="modal fade" id="bsModal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            <p style="color: #7a6fbe">Bạn Set Thành công</p>
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
<?php endif; ?>
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
    }</style>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/loading.gif') ?>" alt="Loading"/>
    </div>
</div>
<script>
    $("#congxu").click(function () {
        if($("#filter_iname").val() == ""){
            $("#errorname").html("Bạn chưa nhập nick name");
            return false;
        }
        if($("#gamename").val() == ""){
            $("#errorname").html("Bạn chưa chọn game");
            return false;
        }
        
        // if($("#txtotp").val() == ""){
        //     $("#errorname").html("Bạn chưa nhập OTP");
        //     return false;
        // }        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('usergame/resetjackpotajax')?>",
            data: {
                
                gamename : $("#gamename").val(),
                
            },

            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if(result.success){
                    $("#errorname").html("");
                    $("#gamename").val("");
                    $("#bsModal3").modal("show");
                }else {
                    $("#errorname").html("Set Lỗi");
                }
            }, error: function () {
                $("#spinner").hide();
                $("#errorname").html("Hệ thống quá tải.  Vui long thử lại sau");
            },timeout : 20000
        });
    });
    
    $(document).ready(function () {
        $("#txtmoney").keydown(function (e) {
            checkTxtMoney(e);
        });

        $('#txtmoney').on('paste', function (e) {
            let pastedData = e.originalEvent.clipboardData.getData('text');
            let money = parseInt(pastedData);
            if(isNaN(money) || money <= 0) {
                alert("Vui lòng nhập số lớn hơn 0");
                e.preventDefault();
            }
        });
    });

    function checkTxtMoney(e) {
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
    }

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
    $("#txtmoney").keyup(function (e) {
        $(this).val(($(this).val()));
        $("#numchuyen").text(format($(this).val()));

    });
</script>
