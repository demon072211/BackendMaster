<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">

        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<?php if ($role == false): ?>
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
            <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
            <div class="title">
                <h6>Danh sách giao dịch ngân hàng</h6>
            </div>
            <div id="error_text" class="alert alert-danger" style="display: none" role="alert">
                Thất bại. Ops
            </div>
            <div id="success_text" class="alert alert-success" style="display: none" role="alert">
                Thành công!
            </div>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                <thead>
                <tr style="height: 20px;">
                    <td>STT</td>
                    <td>Mã giao dịch</td>
                    <td>STK user</td>
                    <td>STK shipper</td>
                    <td>Tiền từ user</td>
                    <td>Trạng thái</td>
                    <td>Nội dung chuyển</td>
                    <td>Thời gian</td>
                    <td>Thêm</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['data'] as $index => $value) { ?>
                    <tr>
                        <td><?php echo($index + 1) ?></td>
                        <td><?php echo $value->transId ?></td>
                        <td><?php echo $value->bankNo ?></td>
                        <td><?php echo $value->bankCode ?></td>
                        <td><?php echo number_format($value->amount) ?></td>
                        <td><?php if ($value->status == 1) { ?> Đã thanh toán <?php } else { ?>Chưa thanh toán<?php } ?></td>
                        <td><?php echo $value->comment ?></td>
                        <td><?php echo $value->time ?></td>
                        <td data-toggle="tooltip" data-placement="left" title="Thanh toán giao dịch này">
                            <a
                                    data-value="<?php echo $value->transId ?>"
                                    data-toggle="modal" data-target="#modalPayTrans"
                                    class="actionPay"
                                    style="padding:5px 10px; cursor: pointer">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="modalPayTrans" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thanh toán giao dịch: <span id="title-trans-id"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nickname nhận:</label>
                                <input type="text" class="form-control" id="receiveNickname">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Số tiền chuyển:</label>
                                <input class="form-control" type="number" id="transAmount">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Nickname chuyển:</label>
                                <input class="form-control" value="<?php echo $admin_info->FullName?>" id="transNickname">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">OTP Nickname chuyển:</label>
                                <input class="form-control" id="transOTP">
                            </div>
                        </form>
                        <div id="errorValidate" class="alert alert-danger" style="display: none" role="alert">
                            Vui lòng nhập đủ thông tin
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" onclick="payTransaction()">Thực hiện</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<style>
    td {
        word-break: break-all;
    }

    thead {
        font-size: 12px;
    }

    .modal-backdrop {
        display: none;
    }

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
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>

</div>
<script>
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
    $(".actionPay").on("click",function () {
        $('#errorValidate').css("display", "none");
        $("#title-trans-id").html($(this).attr('data-value'))
    })    function payTransaction() {
        var transId = $("#title-trans-id").text();
        var receiveNickname = $("#receiveNickname").val();
        var transAmount = $("#transAmount").val();
        var transNickname = $("#transNickname").val();
        var transOTP = $("#transOTP").val();
        if (receiveNickname && transAmount && transNickname && transOTP) {
            $('#modalPayTrans').modal('hide');
            var data={
                transId:transId,
                receiveNickname:receiveNickname,
                transAmount:transAmount,
                transNickname:transNickname,
                transOTP:transOTP,
            };
            $('#spinner').show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('report/paytransactionAjax')?>",
                dataType: 'json',
                data: data,
                success: function (result) {
                    $('#spinner').hide();
                    if (result.errorCode === "0") {
                        $('#error_text').css("display", "none");
                        $('#success_text').css("display", "inherit");
                        $('#success_text').html("Thành công");
                        location.reload();
                    } else {
                        $('#error_text').css("display", "inherit");
                        $('#success_text').css("display", "none");
                    }
                },
                error:function () {
                    $('#spinner').hide();
                    $('#error_text').css("display", "inherit");
                    $('#success_text').css("display", "none");
                }
            });
        }else {
            $('#errorValidate').css("display", "inherit");
        }
    }

</script>