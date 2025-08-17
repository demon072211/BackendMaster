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
        
    <div class="widget">
        <div class="title">
            <h6>Gửi tin nhắn đại lý</h6>
        </div>
        <div class="formRow">
            <div class="row">
                <div class="col-sm-2"></div>
                <label class="col-sm-2" style="color: red" id="errocode">
                </label>

            </div>
        </div>
        <div class="formRow">
            <div class="row">
                <div class="col-sm-1"></div>
                <label class="col-sm-1">
                    Điện thoại:
                </label>

                <div class="col-sm-4">
                    <input type="text" id="mobiledaily" class="form-control">
                </div>
                <div class="col-sm-1">
                    <input type="checkbox" id="checkdaily" value="0" class="pull-right" >
                </div>
                <div class="col-sm-3">
                    <label style="color: #0000ff"> Chọn gửi tất cả cho đại lý cấp 1</label>
                    <input type="hidden" id="mobilehidden">
                </div>
            </div>
        </div>
        <div class="formRow">
            <div class="row">
                <div class="col-sm-1"></div>
                <label class="col-sm-1">
                    Nội dung:
                </label>

                <div class="col-sm-4">
                    <textarea id="content" row="100" class="form-control" style="height: 400px" placeholder="Bạn chỉ được nhập ký tự không dấu" maxlength="459"></textarea>
                </div>
                <div class="col-sm-3">
                    <label id = "lenghsms" style="color: #0000ff"></label>
                </div>
            </div>
        </div>
        <div class="formRow">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <input type="button" value="Gửi tin nhắn" name="submit" class="button blueB" id="sendmail">
                </div>

            </div>
        </div>

        <div class="modal fade" id="bsModal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <p style="color: #0000ff">Bạn gửi tin nhăn thành công</p>
                    </div>
                    <div class="modal-footer">
                        <input class="blueB logMeIn" type="button" value="Đóng" data-dismiss="modal" aria-hidden="true">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="clear mt30"></div>
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
    }</style>
<div id="spinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
</div>
<script>    $( document ).ready(function() {
        var arrmobile = [];
        $("#mobilehidden").val($('#checkdaily').val());
    $('#checkdaily').on('change', function(){
        this.value = this.checked ? 1 : 0;
        $("#mobilehidden").val(this.value);

        if( $("#mobilehidden").val() == 1) {
            //$("#checkdaily").prop({ disabled: true });
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('mail/getmobiledaily')?>",
                data: {
                },
                dataType: 'json',
                success: function (res) {
                    $.each(res.transactions, function (index, value) {
                        if(value.mobile != null){
                            arrmobile.push((value.mobile));
                        }                    });
                    $("#mobiledaily").val(arrmobile.join());
                }
            });
        }else{
            arrmobile = [];
            $("#mobiledaily").val("");
        }
    }).change();

        $('#content').keypress(function(){

            if(this.value.length <= 160 && this.value.length > 0){
                $("#lenghsms").html("Bạn đã nhập 1 tin nhắn");
            }
            else if(this.value.length > 160 && this.value.length <= 306  ){
                $("#lenghsms").html("Bạn đã  nhập 2 tin nhắn");
            }else if(this.value.length > 306 && this.value.length <= 459  ){
                $("#lenghsms").html("Bạn đã nhập 3 tin nhắn");
            }else if(this.value.length == 0){
                $("#lenghsms").html("");
            }
        });
    })
    $("#sendmail").click(function () {

        if($("#mobiledaily").val() == ""){
            $("#errocode").html("Bạn chưa nhập điện thoại");
            return false;
        } if($("#content").val() == ""){
            $("#errocode").html("Bạn chưa nhập nội dung");
            return false;
        }
        $("#spinner").show();
        sendmessage();

    });
    function sendmessage(){
        $("#spinner").show();
    $.ajax({
        type: "POST",
        url: "<?php echo admin_url('mail/messageagentajax')?>",
        data: {
            mobile : $("#mobiledaily").val(),
            content :$("#content").val()
        },
        dataType: 'json',
        success: function (res) {
            $("#spinner").hide();
            if(res == 0){
                $("#bsModal3").modal("show");
                $("#errocode").html("");
                $("#content").val("");
                $("#mobiledaily").val("");
                $("#lenghsms").html("");
                $('input:checkbox').removeAttr('checked');
            }else if(res == 1){
                $("#errocode").html("Hệ thống gián đoạn");
            }else if(res == 2){
                $("#errocode").html("Số điện thoại không hợp lệ");
            }
        }
    });
}
</script>