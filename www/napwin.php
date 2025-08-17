<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Nạp Win</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div><link rel="stylesheet"
      href="<?php echo public_url() ?>/site/css/loggamethirdparty.css"><?php if($role == false): ?>
    <div class="wrapper">
        <div class="widget">
            <div class="title">
                <h6>Bạn không được phân quyền</h6>
            </div>
        </div>
    </div>
<?php else: ?>
	<?php $this->load->view('admin/error')?>
    <div class="wrapper">
			<?php $this->load->view('admin/message', $this->data); ?>
        <div class="widget">
            <h4 id="resultsearch"></h4>
            <div class="title">
                <h6>Nạp Win</h6>
                <h6 class="total">Tổng nạp:<span class="total-number" style="color:#0000ff" id="totalNap"></span></h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('report/napwin') ?>" method="post">
                <div class="formRow">
                    <table>
                        <tr class="nickname">
                            <td><label>Nick name:</label></td>
                            <td><input type="text"
                                       id="nickName" value="<?php echo $this->input->post('nickName') ?>" name="nickName"></td>
                            <td><label class="session-1">Số phiên chơi game:</label></td>
                            <td><input type="text" class="session-2"
                                       id="transId" value="<?php echo $this->input->post('transId') ?>" name="transId"></td>
                        </tr>
                    </table>
                </div>

                <div class="formRow">
                    <table>
                        <tr>
                            <td>
                                <label for="param_name" class="formLeft" id="nameuser">Từ ngày:</label></td>
                            <td class="item">
                                <div class="input-group date" id="datetimepicker1">
                                    <input type="text" id="fromDate" name="fromDate" value="<?php echo $this->input->post('fromDate') ?>"> <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                                </div>                            </td>
                            <td>
                                <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>
                            </td>
                            <td class="item">

                                <div class="input-group date" id="datetimepicker2">
                                    <input type="text" id="toDate" name="toDate" value="<?php echo $this->input->post('toDate') ?>"> <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td><label class="session-1">User id:</label></td>
                            <td><input type="text" class="session-2"
                                       id="userId" value="<?php echo $this->input->post('userId') ?>" name="userId"></td>
                            <td><label class="money-type-1">Current<br>money&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                            <td><input type="text" class="money-type-2"
                                       id="currentMoney" value="<?php echo $this->input->post('currentMoney') ?>" name="currentMoney"></td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td><label class="session-1">Money exchange&nbsp;&nbsp;>=</label></td>
                            <td><input type="text" class="session-2"
                                       id="moneyExchange" value="<?php echo $this->input->post('moneyExchange') ?>" name="moneyExchange"></td>
                            <td><label class="money-type-1">Phế&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                            <td><input type="text" class="money-type-2"
                                       id="fee_win" value="<?php echo $this->input->post('fee_win') ?>" name="fee_win"></td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td><label class="money-type-1" style="margin-left: 7px">Action name:</label></td>
                            <td><select class="money-type-2" style="margin-left: 1px; width: 213px!important;" id="actionName" name="actionName">
                                    <option value="" <?php if($this->input->post('actionName') == ""){echo "selected";} ?>>Chọn</option>
                                    <option value="Admin" <?php if($this->input->post('actionName') == "Admin"){echo "selected";} ?>>Admin thực hiện</option>
                                    <option value="RefundRecharge" <?php if($this->input->post('actionName') == "RefundRecharge"){echo "selected";} ?>>Hoàn trả từ hệ thống</option>
                                    <option value="RechargeByPaywell" <?php if($this->input->post('actionName') == "RechargeByPaywell"){echo "selected";} ?>>Nạp tiền từ Paywell</option>
                                    <option value="RechargeByClickPay" <?php if($this->input->post('actionName') == "RechargeByClickPay"){echo "selected";} ?>>Nạp tiền từ 1ClickPay</option>
                                    <option value="RechargeByPrincePay" <?php if($this->input->post('actionName') == "RechargeByPrincePay"){echo "selected";} ?>>Nạp tiền từ PrincePay</option>
                                </select></td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td style="">
                                <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB search">
                            </td>
                            <td>
                                <input type="reset"
                                       onclick="window.location.href = '<?php echo admin_url('report/napwin') ?>'; "
                                       value="Reset" class="basic">
                            </td>
                            <td>
                            <span style="margin-left: 20px">
                                <?php $this->load->view('/admin/component/exportexcel', ['pre_file_name'=>'napwin', 'columns_excel' => "0,1,2,3,4,5,6"]); ?>
                            </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                <thead>
                <tr class="list-loggameslot">
                    <td>STT</td>
                    <td>Phiên giao dịch</td>
                    <td>Nick name</td>
                    <td>Current money</td>
                    <td>Money exchange</td>
                    <td>Thời điểm giao dịch</td>
                    <td>Action name</td>
                </tr>
                </thead>
                <tbody id="logaction">
                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>
<div class="container">
    <h6 class="total-data">Tổng bản ghi:<span class="total-data-span" id="totalData"></span></h6>
    <div id="spinner" class="spinner image-loggameslot">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>

<script>
    var page_size = '<?php echo $this->input->post('page_size') ?>' || 10;
    $("#search_tran").click(function () {
        var fromDatetime = $("#fromDate").val();
        var toDatetime = $("#toDate").val();
        if (fromDatetime > toDatetime) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }

    });

    $(function () {
        var startDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0);
        var endDate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59);
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: startDate,
            useCurrent : false,
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: endDate,
            useCurrent : false,
        });

    });

    $(document).ready(function () {
        initData()
    });

    function initData() {

        var fromdate;
        var todate;
        var oldpage = 0;
        if($("#toDate").val()!=""){
            var match = $("#toDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            todate = moment.unix(date.getTime()/1000).format("YYYY-MM-DD HH:mm:ss")
        }
        else{
            todate =  "";
        }
        if($("#fromDate").val()!=""){
            var match = $("#fromDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            fromdate = moment.unix(date.getTime()/1000).format("YYYY-MM-DD HH:mm:ss")
        }
        else{
            fromdate =  "";
        }
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/napwinajax')?>",
            data: {
                nickName: $("#nickName").val(),
                actionName: $("#actionName").val(),
                serviceName: $("#serviceName").val(),
                toDate: todate,
                fromDate: fromdate,
                transId : $("#transId").val(),
                userId: $("#userId ").val(),
                currentMoney: $("#currentMoney").val(),
                moneyExchange: $("#moneyExchange").val(),
                fee: $("#fee_win").val(),
                page : 1,
                maxItem: page_size
            },
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if (result.data.listData == "") {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    let totalPage = Math.floor(result.totalRecords/10) + (result.totalRecords%10?1:0);
                    $("#totalData").html($.number(result.totalRecords, undefined, '.', ','));
                    $("#totalNap").html($.number(result.data.totalNap, undefined, '.', ','));
                    $("#resultsearch").html("");
                    stt = 1;
                    $.each(result.data.listData, function (index, value) {
                        result += resultSearchTransction(stt,value);
                        stt ++;
                    });
                    $('#logaction').html(result);
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if(oldpage>0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('report/napwinajax')?>",
                                    data: {
                                        nickName: $("#nickName").val(),
                                        actionName: $("#actionName").val(),
                                        serviceName: $("#serviceName").val(),
                                        toDate: todate,
                                        fromDate: fromdate,
                                        transId : $("#transId").val(),
                                        userId: $("#userId ").val(),
                                        currentMoney: $("#currentMoney").val(),
                                        moneyExchange: $("#moneyExchange").val(),
                                        fee: $("#fee_win").val(),
                                        page : page,
                                        maxItem: page_size
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#spinner").hide();
                                        stt = (page - 1) * 10 + 1;
                                        $.each(result.data.listData, function (index, value) {
                                            result += resultSearchTransction(stt, value);
                                            stt++;
                                        });
                                        $('#logaction').html(result);
                                    }, error: function () {
                                        $('#logaction').html("");
                                        $("#spinner").hide();
                                        $("#error-popup").modal("show");
                                    }, timeout: 40000
                                });
                            }
                            oldpage = page;
                        }
                    });
                }
            }, error: function () {
                $('#logaction').html("");
                $("#spinner").hide();
                $("#error-popup").modal("show");
            }, timeout: 40000
        })
    }

    function resultSearchTransction(stt,value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + value.trans_id + "</td>";
        rs += "<td>" + value.nick_name + "</td>";
        rs += "<td>" + $.number(value.current_money, undefined, '.', ',') + "</td>";
        rs += "<td>" + $.number(value.money_exchange, undefined, '.', ',') + "</td>";
        rs += "<td>" + value.trans_time + "</td>";
                switch (value.action_name) {
                    case 'Admin':
                        rs += "<td>" + 'Admin thực hiện' + "</td>";
                        break;
                    case 'RefundRecharge':
                        rs += "<td>" + 'Hoàn trả từ hệ thống' + "</td>";
                        break;
                    case 'RechargeByPaywell':
                        rs += "<td>" + 'Nạp tiền từ Paywell' + "</td>";
                        break;
                    case 'RechargeByClickPay':
                        rs += "<td>" + 'Nạp tiền từ 1ClickPay' + "</td>";
                        break;
                    case 'RechargeByPrincePay':
                        rs += "<td>" + 'Nạp tiền từ PrincePay' + "</td>";
                        break;
                    default:
                        rs += "<td>" + value.action_name + "</td>";
                }
        rs += "</tr>";
        return rs;
    }
</script>