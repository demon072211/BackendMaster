<?php $this->load->view('admin/error') ?>
<?php $this->load->view('admin/message', $this->data); ?>
<div>
    <h4 id="balanceResultsearch"></h4>
    <div class="title">
        <h6>Biến động số dư</h6>
        <h6 class="total">Tổng cược:<span class="total-number" style="color:#0000ff" id="balanceTotalBet"></span></h6>
        <h6 class="total">Tổng phế:<span class="total-number" style="color:#0000ff" id="balanceTotalFee"></span></h6>
        <h6 class="total">Tổng vòng cược:<span class="total-number" id="balanceTotalSoVongcuoc"></span></h6>
    </div>
    <form class="list_filter form">

        <div class="formRow">
            <table>
                <tr>
                    <td>
                        <label for="param_name" class="formLeft" id="nameuser">Từ ngày:</label>
                    </td>
                    <td class="item">
                        <div class="input-group date" id="balanceDatetimepicker1">
                            <input type="text" id="balanceFromDate" name="fromDate" value="<?php echo $this->input->post('fromDate') ?>"> <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </td>
                    <td>
                        <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>
                    </td>
                    <td class="item">
                        <div class="input-group date" id="balanceDatetimepicker2">
                            <input type="text" id="balanceToDate" name="toDate" value="<?php echo $this->input->post('toDate') ?>"> <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="formRow">
            <table>
                <tr>
                    <td><label class="session-1">Money exchange&nbsp;&nbsp;>=</label></td>
                    <td><input type="text" class="session-2" id="balanceMoneyExchange" value="<?php echo $this->input->post('moneyExchange') ?>" name="moneyExchange"></td>
                    <td><label class="money-type-1">Phế&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>=</label>
                    </td>
                    <td><input type="text" class="money-type-2" id="balanceFee_win" value="<?php echo $this->input->post('fee_win') ?>" name="fee_win">
                    </td>
                </tr>
            </table>
        </div>
        <div class="formRow">
            <table>
                <tr>
                    <td><label class="money-type-1" style="margin-left: 8px">Action name:</label></td>
                    <td><select class="money-type-2" id="balanceActionName" name="actionName">
                            <option value="" <?php if ($this->input->post('actionName') == "") {
                                                    echo "selected";
                                                } ?>>Chọn
                            </option>
                            <option value="Admin" <?php if ($this->input->post('actionName') == "Admin") {
                                                        echo "selected";
                                                    } ?>>Admin
                            </option>
                            <option value="Audition" <?php if ($this->input->post('actionName') == "Audition") {
                                                            echo "selected";
                                                        } ?>>Slot Đua xe
                            </option>
                            <option value="BENLEY" <?php if ($this->input->post('actionName') == "BENLEY") {
                                                        echo "selected";
                                                    } ?>>Slot Bitcoin
                            </option>
                            <option value="BaCay" <?php if ($this->input->post('actionName') == "BaCay") {
                                                        echo "selected";
                                                    } ?>>Game bài ba cây
                            </option>
                            <option value="BauCua" <?php if ($this->input->post('actionName') == "BauCua") {
                                                        echo "selected";
                                                    } ?>>Bầu cua
                            </option>
                            <option value="CANDY" <?php if ($this->input->post('actionName') == "CANDY") {
                                                        echo "selected";
                                                    } ?>>Slot pokemon
                            </option>
                            <option value="CaoThap" <?php if ($this->input->post('actionName') == "CaoThap") {
                                                        echo "selected";
                                                    } ?>>Cao thấp
                            </option>
                            <option value="CashOutByClickPay" <?php if ($this->input->post('actionName') == "CashOutByClickPay") {
                                                                    echo "selected";
                                                                } ?>>Rút tiền từ ClickPay
                            </option>
                            <option value="CashOutByPrincePay" <?php if ($this->input->post('actionName') == "CashOutByPrincePay") {
                                                                    echo "selected";
                                                                } ?>>Rút tiền từ PrincePay
                            </option>
                            <option value="Exchange" <?php if ($this->input->post('actionName') == "Exchange") {
                                                            echo "selected";
                                                        } ?>>Đổi tiền
                            </option>
                            <option value="GIFT_CODE" <?php if ($this->input->post('actionName') == "GIFT_CODE") {
                                                            echo "selected";
                                                        } ?>>GIFT_CODE
                            </option>
                            <option value="GiftCode" <?php if ($this->input->post('actionName') == "GiftCode") {
                                                            echo "selected";
                                                        } ?>>GiftCode
                            </option>
                            <option value="MAYBACH" <?php if ($this->input->post('actionName') == "MAYBACH") {
                                                        echo "selected";
                                                    } ?>>Slot thể thao
                            </option>
                            <option value="MiniPoker" <?php if ($this->input->post('actionName') == "MiniPoker") {
                                                            echo "selected";
                                                        } ?>>Minipoker
                            </option>
                            <option value="RechargeByPaywell" <?php if ($this->input->post('actionName') == "RechargeByPaywell") {
                                                                    echo "selected";
                                                                } ?>>Nạp tiền bằng Paywell
                            </option>
                            <option value="RechargeByPrincePay" <?php if ($this->input->post('actionName') == "RechargeByPrincePay") {
                                                                    echo "selected";
                                                                } ?>>Nạp tiền bằng PrincePay
                            </option>
                            <option value="Spartan" <?php if ($this->input->post('actionName') == "Spartan") {
                                                        echo "selected";
                                                    } ?>>Slot Thần tài
                            </option>
                            <option value="TAMHUNG" <?php if ($this->input->post('actionName') == "TAMHUNG") {
                                                        echo "selected";
                                                    } ?>>Slot chim điên
                            </option>
                            <option value="TaiXiu" <?php if ($this->input->post('actionName') == "TaiXiu") {
                                                        echo "selected";
                                                    } ?>>Tài xỉu
                            </option>
                            <option value="Tlmn" <?php if ($this->input->post('actionName') == "Tlmn") {
                                                        echo "selected";
                                                    } ?>>Tiến lên miền nam
                            </option>
                            <option value="XocDia" <?php if ($this->input->post('actionName') == "XocDia") {
                                                        echo "selected";
                                                    } ?>>Xóc đĩa
                            </option>
                            <option value="ag" <?php if ($this->input->post('actionName') == "ag") {
                                                    echo "selected";
                                                } ?>>Game AG
                            </option>
                            <option value="ibc2" <?php if ($this->input->post('actionName') == "ibc2") {
                                                        echo "selected";
                                                    } ?>>Game IBC
                            </option>
                            <option value="wm" <?php if ($this->input->post('actionName') == "wm") {
                                                    echo "selected";
                                                } ?>>Game WM
                            </option>
                        </select></td>
                    <td><label class="money-type-1">Current<br>money&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                    <td><input type="text" class="money-type-2" id="balanceCurrentMoney" value="<?php echo $this->input->post('currentMoney') ?>" name="currentMoney"></td>
                </tr>
            </table>
        </div>
        <div class="formRow">
            <table>
                <tr>
                    <td style="">
                        <input type="button" id="balance" value="Tìm kiếm" class="button blueB search">
                    </td>
                    <td>
                        <input type="button" id="reset_balance" value="Reset" class="basic">
                    </td>
                    <td>
                        <span style="margin-left: 20px">
                            <?php $this->load->view('/admin/component/exportexcel', ['pre_file_name' => 'biendongsodu', 'columns_excel' => "0,1,2,3,4,5"]); ?>
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
                <td>Số phiên chơi game</td>
                <td>Current money</td>
                <td>Money exchange</td>
                <td>Trans time</td>
                <td>Action name</td>
            </tr>
        </thead>
        <tbody id="balanceLogaction">
        </tbody>
    </table>
</div>
<div class="container">
    <h6 class="total-data">Tổng bản ghi:<span class="total-data-span" id="balanceTotalData"></span></h6>
    <div id="balanceSpinner" class="spinner image-loggameslot">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading" />
    </div>
    <div class="text-center">
        <ul id="balancePagination" class="pagination-lg"></ul>
    </div>
</div>
<script>
    var page_size = '<?php echo $this->input->post('page_size') ?>' || 10;

    $(function() {
        var startDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0);
        var endDate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59);
        $('#balanceDatetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: startDate,
            useCurrent: false,
        });
        $('#balanceDatetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: endDate,
            useCurrent: false,
        });

    });

    $("#balance").click(function() {
        var fromDatetime = $("#balanceFromDate").val();
        var toDatetime = $("#balanceToDate").val();
        if (fromDatetime > toDatetime) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }
        initData()
    });

    $('#reset_balance').click(function() {
        var fromDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0).format("YYYY-MM-DD HH:mm:ss");
        $('#balanceFromDate').val(fromDate);
        var todate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59).format("YYYY-MM-DD HH:mm:ss");
        $('#balanceToDate').val(todate);
        initData()
    });

    $(document).ready(function() {
        initData()
    });

    function initData() {
        var oldpage = 0;
        $('#balancePagination').css("display", "block");
        $("#balanceSpinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/userwinajax') ?>",
            data: {
                nickName: '<?= !empty($nn) ? $nn : '' ?>',
                actionName: $("#balanceActionName").val(),
                serviceName: '',
                toDate: getDateTo(),
                fromDate: getDateFrom(),
                transId: '',
                userId: '',
                currentMoney: $("#balanceCurrentMoney").val(),
                moneyExchange: $("#balanceMoneyExchange").val(),
                fee: $("#balanceFee_win").val(),
                page: 1,
                maxItem: page_size
            },
            dataType: 'json',
            success: function(result) {
                $("#balanceSpinner").hide();
                if (result.data == "" || !result.data) {
                    $('#balancePagination').css("display", "none");
                    $("#balanceResultsearch").html("Không tìm thấy kết quả");
                    $("#balanceLogaction").html("");
                    $("#balanceTotalData").html("");
                } else {
                    var totalPage = Math.floor(result.totalData / 10) + (result.totalData % 10 ? 1 : 0);
                    $("#balanceTotalData").html($.number(result.totalData, undefined, '.', ','));
                    $("#balanceTotalBet").html($.number(result.totalBet, undefined, '.', ','));
                    $("#balanceTotalFee").html($.number(result.totalFee, undefined, '.', ','));
                    $("#balanceTotalSoVongcuoc").html($.number(result.totalSoVongcuoc, undefined, '.', ','));
                    $("#balanceResultsearch").html("");
                    stt = 1;
                    $.each(result.data, function(index, value) {
                        result += balanceResultSearchTransction(stt, value);
                        stt++;
                    });
                    $('#balanceLogaction').html(result);
                    $('#balancePagination').twbsPagination('destroy');
                    $('#balancePagination').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function(event, page) {
                            if (oldpage > 0) {
                                $("#balanceSpinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('report/userwinajax') ?>",
                                    data: {
                                        nickName: '<?= !empty($nn) ? $nn : '' ?>',
                                        actionName: $("#balanceActionName").val(),
                                        serviceName: '',
                                        toDate: getDateTo(),
                                        fromDate: getDateFrom(),
                                        transId: '',
                                        userId: '',
                                        currentMoney: $("#balanceCurrentMoney").val(),
                                        moneyExchange: $("#balanceMoneyExchange").val(),
                                        fee: $("#balanceFee_win").val(),
                                        page: page,
                                        maxItem: page_size
                                    },
                                    dataType: 'json',
                                    success: function(result) {
                                        $("#balanceSpinner").hide();
                                        stt = (page - 1) * page_size + 1;
                                        $.each(result.data, function(index, value) {
                                            result += balanceResultSearchTransction(stt, value);
                                            stt++;
                                        });
                                        $('#balanceLogaction').html(result);
                                    },
                                    error: function() {
                                        $('#balanceLogaction').html("");
                                        $("#balanceSpinner").hide();
                                    },
                                    timeout: 40000
                                });
                            }
                            oldpage = page;
                        }
                    });
                }
            },
            error: function() {
                $('#balanceLogaction').html("");
                $("#balanceSpinner").hide();
            },
            timeout: 40000
        })
    }

    function getDateTo() {
        let todate;
        if ($("#balanceToDate").val() != "") {
            var match = $("#balanceToDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            todate = moment.unix(date.getTime() / 1000).format("YYYY-MM-DD HH:mm:ss")
        } else {
            todate = "";
        }
        return todate;
    }

    function getDateFrom() {
        let fromdate;
        if ($("#balanceFromDate").val() != "") {
            var match = $("#balanceFromDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            fromdate = moment.unix(date.getTime() / 1000).format("YYYY-MM-DD HH:mm:ss")
        } else {
            fromdate = "";
        }
        return fromdate;
    }

    function balanceResultSearchTransction(stt, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + value.trans_id + "</td>";
        rs += "<td>" + $.number(value.current_money, undefined, '.', ',') + "</td>";
        rs += "<td>" + $.number(value.money_exchange, undefined, '.', ',') + "</td>";
        rs += "<td>" + value.trans_time + "</td>";
        var actionName = $("#balanceActionName").val();
        switch (actionName) {
            case 'Admin':
                rs += "<td>" + 'Admin' + "</td>";
                break;
            case 'Audition':
                rs += "<td>" + 'Slot Đua xe' + "</td>";
                break;
            case 'BENLEY':
                rs += "<td>" + 'Slot Bitcoin' + "</td>";
                break;
            case 'BaCay':
                rs += "<td>" + 'Game bài ba cây' + "</td>";
                break;
            case 'BauCua':
                rs += "<td>" + 'Bầu cua' + "</td>";
                break;
            case 'CANDY':
                rs += "<td>" + 'Slot pokemon' + "</td>";
                break;
            case 'CaoThap':
                rs += "<td>" + 'Cao thấp' + "</td>";
                break;
            case 'CashOutByClickPay':
                rs += "<td>" + 'Rút tiền từ ClickPay' + "</td>";
                break;
            case 'CashOutByPrincePay':
                rs += "<td>" + 'Rút tiền từ PrincePay' + "</td>";
                break;
            case 'Exchange':
                rs += "<td>" + 'Đổi tiền' + "</td>";
                break;
            case 'GIFT_CODE':
                rs += "<td>" + 'GIFT_CODE' + "</td>";
                break;
            case 'GiftCode':
                rs += "<td>" + 'GiftCode' + "</td>";
                break;
            case 'MAYBACH':
                rs += "<td>" + 'Slot thể thao' + "</td>";
                break;
            case 'MiniPoker':
                rs += "<td>" + 'Minipoker' + "</td>";
                break;
            case 'RechargeByPaywell':
                rs += "<td>" + 'Nạp tiền bằng Paywell' + "</td>";
                break;
            case 'RechargeByPrincePay':
                rs += "<td>" + 'Nạp tiền bằng PrincePay' + "</td>";
                break;
            case 'Spartan':
                rs += "<td>" + 'Slot Thần tài' + "</td>";
                break;
            case 'TAMHUNG':
                rs += "<td>" + 'Slot chim điên' + "</td>";
                break;
            case 'TaiXiu':
                rs += "<td>" + 'Tài xỉu' + "</td>";
                break;
            case 'Tlmn':
                rs += "<td>" + 'Tiến lên miền nam' + "</td>";
                break;
            case 'XocDia':
                rs += "<td>" + 'Xóc đĩa' + "</td>";
                break;
            case 'ag':
                rs += "<td>" + 'Game AG' + "</td>";
                break;
            case 'ibc2':
                rs += "<td>" + 'Game IBC' + "</td>";
                break;
            case 'wm':
                rs += "<td>" + 'Game WM' + "</td>";
                break;
            default:
                switch (value.action_name) {
                    case 'Admin':
                        rs += "<td>" + 'Admin' + "</td>";
                        break;
                    case 'Audition':
                        rs += "<td>" + 'Slot Đua xe' + "</td>";
                        break;
                    case 'BENLEY':
                        rs += "<td>" + 'Slot Bitcoin' + "</td>";
                        break;
                    case 'BaCay':
                        rs += "<td>" + 'Game bài ba cây' + "</td>";
                        break;
                    case 'BauCua':
                        rs += "<td>" + 'Bầu cua' + "</td>";
                        break;
                    case 'CANDY':
                        rs += "<td>" + 'Slot pokemon' + "</td>";
                        break;
                    case 'CaoThap':
                        rs += "<td>" + 'Cao thấp' + "</td>";
                        break;
                    case 'CashOutByClickPay':
                        rs += "<td>" + 'Rút tiền từ ClickPay' + "</td>";
                        break;
                    case 'CashOutByPrincePay':
                        rs += "<td>" + 'Rút tiền từ PrincePay' + "</td>";
                        break;
                    case 'Exchange':
                        rs += "<td>" + 'Đổi tiền' + "</td>";
                        break;
                    case 'GIFT_CODE':
                        rs += "<td>" + 'GIFT_CODE' + "</td>";
                        break;
                    case 'GiftCode':
                        rs += "<td>" + 'GiftCode' + "</td>";
                        break;
                    case 'MAYBACH':
                        rs += "<td>" + 'Slot thể thao' + "</td>";
                        break;
                    case 'MiniPoker':
                        rs += "<td>" + 'Minipoker' + "</td>";
                        break;
                    case 'RechargeByPaywell':
                        rs += "<td>" + 'Nạp tiền bằng Paywell' + "</td>";
                        break;
                    case 'RechargeByPrincePay':
                        rs += "<td>" + 'Nạp tiền bằng PrincePay' + "</td>";
                        break;
                    case 'Spartan':
                        rs += "<td>" + 'Slot Thần tài' + "</td>";
                        break;
                    case 'TAMHUNG':
                        rs += "<td>" + 'Slot chim điên' + "</td>";
                        break;
                    case 'TaiXiu':
                        rs += "<td>" + 'Tài xỉu' + "</td>";
                        break;
                    case 'Tlmn':
                        rs += "<td>" + 'Tiến lên miền nam' + "</td>";
                        break;
                    case 'XocDia':
                        rs += "<td>" + 'Xóc đĩa' + "</td>";
                        break;
                    case 'ag':
                        rs += "<td>" + 'Game AG' + "</td>";
                        break;
                    case 'ibc2':
                        rs += "<td>" + 'Game IBC' + "</td>";
                        break;
                    case 'wm':
                        rs += "<td>" + 'Game WM' + "</td>";
                        break;
                    default:
                        rs += "<td>" + value.action_name + "</td>";
                }
        }
        rs += "</tr>";
        return rs;
    }
</script>