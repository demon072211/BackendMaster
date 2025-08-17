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
                <h6>Ngân hàng rút tiền</h6>
            </div>
            <form class="list_filter form" style="margin-bottom: 20px;" action="<?php echo admin_url('report/bankwithdraw') ?>" method="post">
                <div class="formRow">
                    <input type="text" style="display: none;"
                           id="page" value="1" name="page">
                    <table>
                        <tr>
                            <td><label style="margin-left: 30px;margin-bottom:-2px;width: 100px">Nick name:</label></td>
                            <td><input type="text" style="margin-left: 20px;margin-bottom:-2px;width: 150px"
                                       id="nick_name" value="<?php echo $this->input->post('nick_name') ?>" name="nick_name"></td>
                            <td><label style="margin-left: 30px;margin-bottom:-2px;width: 100px">Trạng thái: </label></td>
                            <td><select name="status" id="status">
                                    <option value="30">
                                        Chờ xác nhận
                                    </option>
                                    <option value="1">
                                        Đã xác nhận
                                    </option>
                                    <option value="98">
                                        Đã huỷ
                                    </option>
                                    <option value="99">
                                        Thất bại
                                    </option>
                                    <option value="0">
                                        Tất cả
                                    </option>
                                </select></td>

                            <td style="">
                                <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB"
                                       style="margin-left: 70px">
                            </td>
                        </tr>

                    </table>

                </div>
            </form>

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
                    <td style="width: 10%;">Mã giao dịch</td>
                    <td>Nick name</td>
                    <td>Account</td>
                    <td>Tên</td>
                    <td>Số tiền</td>
                    <td>Trạng thái</td>
                    <td style="width: 12%;">Nội dung chuyển</td>
                    <td style="width: 10%;">Thời gian</td>
                    <td>Xác nhận</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['data'] as $index => $value) { ?>
                    <tr>
                        <td><?php echo($index + 1) ?></td>
                        <td><?php echo $value->reference_id ?></td>
                        <td><?php echo $value->nick_name ?></td>
                        <td><?php echo $value->account ?></td>
                        <td><?php echo $value->name ?></td>
                        <td><?php echo number_format($value->amount) ?></td>
                        <td>
                            <?php if ($value->status == 1) { ?> Đã xác nhận <?php }
                            else if ($value->status == 98) { ?>Đã huỷ<?php }
                            else if ($value->status == 99) { ?>Thất bại<?php } else { ?>Chờ xác nhận<?php } ?>
                        </td>
                        <td><?php echo $value->description ?></td>
                        <td><?php echo $value->time_log ?></td>
                        <td>
                            <div data-toggle="tooltip" data-placement="left" title="Xác nhận giao dịch này">
                                <a
                                        data-value="<?php echo $value->reference_id?>"
                                        data-toggle="modal" data-target="#modalPayTrans"
                                        class="actionPay"
                                        style="padding:5px 10px; cursor: pointer">
                                    <span style="background: green" class="badge badge-pill badge-success">Xác nhận</span>
                                </a>
                            </div>
                            <div data-toggle="tooltip" style="margin-top: 7px;" data-placement="left" title="Huỷ giao dịch này">
                                <a

                                        data-value="<?php echo $value->reference_id?>"
                                        data-toggle="modal" data-target="#modalPayTrans"
                                        class="actionCancel"
                                        style="padding:5px 10px; cursor: pointer">
                                    <span style="background: red" class="badge badge-pill badge-danger">Huỷ</span>

                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="text-center">
                <ul id="pagination-demo" style="display: block" class="pagination-lg"></ul>
            </div>
        </div>
        <div class="modal fade" id="modalPayTrans" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="title-trans-name"></span><span id="title-trans-id"></span> hay
                            không?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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

    var firstPageClick=true;    $(".actionPay").on("click", function () {
        $('#errorValidate').css("display", "none");
        $("#title-trans-id").html($(this).attr('data-value'))
        $("#title-trans-name").html("Bạn có đồng ý xác nhận: ");
    })

    $(".actionCancel").on("click", function () {
        $('#errorValidate').css("display", "none");
        $("#title-trans-id").html($(this).attr('data-value'))
        $("#title-trans-name").html("Bạn có đồng ý huỷ: ");
    })

    function payTransaction() {
        if ($("#title-trans-name").text().includes("huỷ")){
            var transId = $("#title-trans-id").text();
            $('#modalPayTrans').modal('hide');
            var data = {
                transId: transId,
            };
            $('#spinner').show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('report/cancelBankTransaction')?>",
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
                error: function () {
                    $('#spinner').hide();
                    $('#error_text').css("display", "inherit");
                    $('#success_text').css("display", "none");
                }
            });
        }else{
            var transId = $("#title-trans-id").text();
            $('#modalPayTrans').modal('hide');
            var data = {
                transId: transId,
            };
            $('#spinner').show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('report/confirmBankTransaction')?>",
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
                error: function () {
                    $('#spinner').hide();
                    $('#error_text').css("display", "inherit");
                    $('#success_text').css("display", "none");
                }
            });
        }

    }
    var page="<?php echo $this->input->post('page')?>";

    $('#pagination-demo').twbsPagination({
        totalPages: 200,
        visiblePages: 5,
        initiateStartPageClick: false,
        startPage:page?parseInt(page):1,
        onPageClick: function (event, page) {
            // if(firstPageClick) {
            //     firstPageClick = false;
            //     return;
            // }
            $("#page").val((page)+"");
            $(".list_filter").submit();
        }
    });

    $(document).ready(function () {
        var status="<?php echo $this->input->post('status') ?>";
        console.log("status",status);
        if (status){
            $("#status").val(status);
        }else {
            $("#status").val("30");
        }
    })</script>