<?php $this->load->view('admin/error')?>
<?php $this->load->view('admin/message', $this->data); ?>
<div class="">
    <h4 id="resultWithdraw"></h4>
    <div class="title">
        <h6>Thông tin rút</h6>
    </div>
    <form class="list_filter form">
        <div class="formRow">
            <table>
                <tr>
                    <td>
                        <label for="param_name" class="formLeft" id="nameuser">Từ ngày:</label></td>
                    <td class="item">
                        <div class="input-group date" id="dateWithDraw1">
                            <input type="text" id="withdrawFromDate" name="fromDate" value="<?php echo $this->input->post('fromDate') ?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </td>
                    <td>
                        <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>
                    </td>
                    <td class="item">
                        <div class="input-group date" id="dateWithDraw2">
                            <input type="text" id="withdrawToDate" name="toDate" value="<?php echo $this->input->post('toDate') ?>">
                            <span class="input-group-addon">
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
                    <td><label class="session-1">Money exchange&nbsp;&nbsp;>=</label></td>
                    <td><input type="text" class="session-2" id="withdrawMoneyExchange" value="<?php echo $this->input->post('moneyExchange') ?>" name="moneyExchange"></td>
                    <td><label class="money-type-1">Phế&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                    <td><input type="text" class="money-type-2" id="widthDrawFeeWin" value="<?php echo $this->input->post('fee_win') ?>" name="fee_win"></td>
                </tr>
            </table>
        </div>
        <div class="formRow">
            <table>
                <tr>
                    <td><label class="money-type-1" style="margin-left: 8px">Action name:</label></td>
                    <td><select class="money-type-2" id="wiDrawActionName" name="actionName">
                            <option value="" <?php if($this->input->post('actionName') == ""){echo "selected";} ?>>Chọn</option>
                            <option value="Admin" <?php if($this->input->post('actionName') == "Admin"){echo "selected";} ?>>Admin thực hiện</option>
                            <option value="REQUEST_CASHOUT" <?php if($this->input->post('actionName') == "REQUEST_CASHOUT"){echo "selected";} ?>>Yêu cầu rút</option>
                            <option value="CashOutByPrincePay" <?php if($this->input->post('actionName') == "CashOutByPaywell"){echo "selected";} ?>>Rút tiền từ Paywell</option>
                            <option value="CashOutByClickPay" <?php if($this->input->post('actionName') == "CashOutByClickPay"){echo "selected";} ?>>Rút tiền từ 1ClickPay</option>
                            <option value="CashOutByPrincePay" <?php if($this->input->post('actionName') == "CashOutByPrincePay"){echo "selected";} ?>>Rút tiền từ PrincePay</option>
                        </select></td>
                    <td><label class="money-type-1">Current<br>money&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                    <td><input type="text" class="money-type-2" id="withdrawCurrentMoney" value="<?php echo $this->input->post('currentMoney') ?>" name="currentMoney"></td>
                </tr>
            </table>
        </div>
        <div class="formRow">
            <table>
                <tr>
                    <td style="">
                        <input type="button" id="search_withdraw" value="Tìm kiếm" class="button blueB search">
                    </td>
                    <td>
                        <input type="button" id="reset_withdraw" value="Reset" class="basic">
                    </td>
                </tr>
            </table>
        </div>
    </form>
    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck">
        <thead>
        <tr class="list-loggameslot">
            <td>STT</td>
            <td>Phiên giao dịch</td>
            <td>Current money</td>
            <td>Money exchange</td>
            <td>Thời điểm giao dịch</td>
            <td>Action name</td>
        </tr>
        </thead>
        <tbody id="logactionWithdraw">
        </tbody>
    </table>
</div>
<div class="container">
    <h6 class="total-data">Tổng bản ghi:<span class="total-data-span" id="withDrawTotalData"></span></h6>
    <div id="withdrawSpinner" class="spinner image-loggameslot">
        <img id="withdrawImgSpinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-withdraw" class="pagination-lg"></ul>
    </div>
</div>
<script>
    $("#search_withdraw").click(function () {
        var fromDatetime = $("#withdrawFromDate").val();
        var toDatetime = $("#withdrawToDate").val();
        if (fromDatetime > toDatetime) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }
        ajaxWithdraw();
    });

    $(function () {
        var startDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0);
        var endDate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59);
        $('#dateWithDraw1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: startDate,
            useCurrent : false
        });
        $('#dateWithDraw2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: endDate,
            useCurrent : false
        });
    });

    $('#reset_withdraw').click(function () {
        var fromDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0).format("YYYY-MM-DD HH:mm:ss");
        $('#withdrawFromDate').val(fromDate);
        var todate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59).format("YYYY-MM-DD HH:mm:ss");
        $('#withdrawToDate').val(todate);
        ajaxWithdraw()
    });

    $(document).ready(function () {
        ajaxWithdraw();
    });

    function ajaxWithdraw() {
        var fromdate;
        var todate;
        var oldpage = 0;
        if($("#withdrawToDate").val()!=""){
            var match = $("#withdrawToDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            todate = moment.unix(date.getTime()/1000).format("YYYY-MM-DD HH:mm:ss")
        }
        else{
            todate =  "";
        }
        if($("#withdrawFromDate").val()!=""){
            var match = $("#withdrawFromDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            fromdate = moment.unix(date.getTime()/1000).format("YYYY-MM-DD HH:mm:ss")
        }
        else{
            fromdate =  "";
        }
        $('#pagination-withdraw').css("display", "block");
        $("#withdrawSpinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/tieuwinajax')?>",
            data: {
                nickName: '<?= $nn?>',
                actionName: $("#wiDrawActionName").val(),
                serviceName: '',
                toDate: todate,
                fromDate: fromdate,
                transId : '',
                userId: '',
                currentMoney: $("#withdrawCurrentMoney").val(),
                moneyExchange: $("#withdrawMoneyExchange").val(),
                fee: $("#widthDrawFeeWin").val(),
                page : 1,
                maxItem: 10
            },
            dataType: 'json',
            success: function (result) {
                $("#withdrawSpinner").hide();
                if (result.data.listData == "") {
                    $('#pagination-withdraw').css("display", "none");
                    $("#resultWithdraw").html("Không tìm thấy kết quả");
                    $("#logactionWithdraw").html("");
                    $("#withDrawTotalData").html("");
                } else {
                    let totalPage = Math.floor(result.totalRecords/10) + (result.totalRecords%10?1:0);
                    $("#withDrawTotalData").html(result.totalRecords);
                    $("#resultWithdraw").html("");
                    stt = 1;
                    $.each(result.data.listData, function (index, value) {
                        result += resultWithDraw(stt,value);
                        stt ++;
                    });
                    $('#logactionWithdraw').html(result);
                    $('#pagination-withdraw').twbsPagination('destroy');
                    $('#pagination-withdraw').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if(oldpage>0) {
                                $("#withdrawSpinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('report/tieuwinajax')?>",
                                    data: {
                                        nickName: '<?= $nn?>',
                                        actionName: $("#actionName").val(),
                                        serviceName: '',
                                        toDate: todate,
                                        fromDate: fromdate,
                                        transId : '',
                                        userId: '',
                                        currentMoney: $("#currentMoney").val(),
                                        moneyExchange: $("#withdrawMoneyExchange").val(),
                                        fee: $("#fee_win").val(),
                                        page : page,
                                        maxItem: 10
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#withdrawSpinner").hide();
                                        stt = (page - 1) * 10 + 1;
                                        $.each(result.data.listData, function (index, value) {
                                            result += resultWithDraw(stt, value);
                                            stt++;
                                        });
                                        $('#logactionWithdraw').html(result);
                                    }, error: function () {
                                        $('#logactionWithdraw').html("");
                                        $("#withdrawSpinner").hide();
                                        $("#error-popup").modal("show");
                                    }, timeout: 40000
                                });
                            }
                            oldpage = page;
                        }
                    });
                }
            }, error: function () {
                $('#logactionWithdraw').html("");
                $("#withdrawSpinner").hide();
                $("#error-popup").modal("show");
            }, timeout: 40000
        })
    }

    function resultWithDraw(stt,value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + value.trans_id + "</td>";
        rs += "<td>" + $.number(value.current_money, undefined, '.', ',') + "</td>";
        rs += "<td>" + $.number(value.money_exchange, undefined, '.', ',') + "</td>";
        rs += "<td>" + value.trans_time + "</td>";
        switch (value.action_name) {
            case 'Admin':
                rs += "<td>" + 'Admin thực hiện' + "</td>";
                break;
            case 'REQUEST_CASHOUT':
                rs += "<td>" + 'Yêu cầu rút' + "</td>";
                break;
            case 'CashOutByPaywell':
                rs += "<td>" + 'Rút tiền bằng Paywell' + "</td>";
                break;
            case 'CashOutByClickPay':
                rs += "<td>" + 'Rút tiền bằng 1ClickPay' + "</td>";
                break;
            case 'CashOutByPrincePay':
                rs += "<td>" + 'Rút tiền bằng PrincePay' + "</td>";
                break;
            default:
                rs += "<td>" + value.action_name + "</td>";
        }
        rs += "</tr>";
        return rs;
    }
</script>