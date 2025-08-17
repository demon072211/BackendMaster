
<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Chi tiết giao dịch</h5>
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
                <h6>Chi tiết giao dịch</h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('report/chitietgiaodich') ?>" method="post">
                <div class="formRow">
                    <table>
                        <tr>
                            <td><label class="flagtime-1">Flag time:</label></td>
                            <td><select style="width: 219px !important;" class="flagtime-2" id="flagtime" name="flagtime">
                                    <option value="1" <?php if($this->input->post('flagtime') == "1"){echo "selected";} ?>>Create time</option>
                                    <option value="2" <?php if($this->input->post('flagtime') == "2"){echo "selected";} ?>>Time log</option>
                                </select></td>
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
                        <tr class="nickname">
                            <td><label>Nick name:</label></td>
                            <td><input type="text"
                                       id="nickName" value="<?php echo $this->input->post('nickName') ?>" name="nickName"></td>
                            <td><label class="money-type-1" style="margin-left: 22px;">Action<br>name:</label></td>
                            <td><select class="money-type-2" style="margin-left:18px;width: 219px !important;" id="actionName" name="actionName">
                                    <option value="" <?php if($this->input->post('actionName') == ""){echo "selected";} ?>>Chọn</option>
                                    <option value="Admin" <?php if($this->input->post('actionName') == "Admin"){echo "selected";} ?>>Admin</option>
                                    <option value="Audition" <?php if($this->input->post('actionName') == "Audition"){echo "selected";} ?>>Slot Đua xe</option>
                                    <option value="BENLEY" <?php if($this->input->post('actionName') == "BENLEY"){echo "selected";} ?>>Slot Bitcoin</option>
                                    <option value="BaCay" <?php if($this->input->post('actionName') == "BaCay"){echo "selected";} ?>>Game bài ba cây</option>
                                    <option value="BauCua" <?php if($this->input->post('actionName') == "BauCua"){echo "selected";} ?>>Bầu cua</option>
                                    <option value="CANDY" <?php if($this->input->post('actionName') == "CANDY"){echo "selected";} ?>>Slot pokemon</option>
                                    <option value="CaoThap" <?php if($this->input->post('actionName') == "CaoThap"){echo "selected";} ?>>Cao thấp</option>
                                    <option value="CashOutByClickPay" <?php if($this->input->post('actionName') == "CashOutByClickPay"){echo "selected";} ?>>Rút tiền từ ClickPay</option>
                                    <option value="CashOutByPrincePay" <?php if($this->input->post('actionName') == "CashOutByPrincePay"){echo "selected";} ?>>Rút tiền từ PrincePay</option>
                                    <option value="Exchange" <?php if($this->input->post('actionName') == "Exchange"){echo "selected";} ?>>Đổi tiền</option>
                                    <option value="GIFT_CODE" <?php if($this->input->post('actionName') == "GIFT_CODE"){echo "selected";} ?>>GIFT_CODE</option>
                                    <option value="GiftCode" <?php if($this->input->post('actionName') == "GiftCode"){echo "selected";} ?>>GiftCode</option>
                                    <option value="MAYBACH" <?php if($this->input->post('actionName') == "MAYBACH"){echo "selected";} ?>>Slot thao</option>
                                    <option value="MiniPoker" <?php if($this->input->post('actionName') == "MiniPoker"){echo "selected";} ?>>Minipoker</option>
                                    <option value="RechargeByPaywell" <?php if($this->input->post('actionName') == "RechargeByPaywell"){echo "selected";} ?>>Nạp tiền bằng Paywell</option>
                                    <option value="RechargeByPrincePay" <?php if($this->input->post('actionName') == "RechargeByPrincePay"){echo "selected";} ?>>Nạp tiền bằng PrincePay</option>
                                    <option value="Spartan" <?php if($this->input->post('actionName') == "Spartan"){echo "selected";} ?>>Slot Thần tài</option>
                                    <option value="TAMHUNG" <?php if($this->input->post('actionName') == "TAMHUNG"){echo "selected";} ?>>Slot chim điên</option>
                                    <option value="TaiXiu" <?php if($this->input->post('actionName') == "TaiXiu"){echo "selected";} ?>>Tài xỉu</option>
                                    <option value="Tlmn" <?php if($this->input->post('actionName') == "Tlmn"){echo "selected";} ?>>Tiến lên miền nam</option>
                                    <option value="XocDia" <?php if($this->input->post('actionName') == "XocDia"){echo "selected";} ?>>Xóc đĩa</option>
                                    <option value="ag" <?php if($this->input->post('actionName') == "ag"){echo "selected";} ?>>Game AG</option>
                                    <option value="ibc2" <?php if($this->input->post('actionName') == "ibc2"){echo "selected";} ?>>Game IBC</option>
                                    <option value="wm" <?php if($this->input->post('actionName') == "wm"){echo "selected";} ?>>Game WM</option>
                                    <option value="cmd" <?php if($this->input->post('actionName') == "cmd"){echo "selected";} ?>>Game CMD</option>
                                    <option value="CHIEMTINH" <?php if($this->input->post('actionName') == "CHIEMTINH"){echo "selected";} ?>>Chiêm tinh</option>
                                    <option value="taixiusieutoc" <?php if($this->input->post('actionName') == "taixiusieutoc"){echo "selected";} ?>>Tài xỉu siêu tốc</option>
                                    <option value="ROLL_ROYE" <?php if($this->input->post('actionName') == "ROLL_ROYE"){echo "selected";} ?>>Thần bài</option>
                                    <option value="BIKINI" <?php if($this->input->post('actionName') == "wm"){echo "BIKINI";} ?>>Bikini</option>
                                    <option value="GALAXY" <?php if($this->input->post('actionName') == "GALAXY"){echo "selected";} ?>>Galaxy</option>
                                    <option value="sbo" <?php if($this->input->post('actionName') == "sbo"){echo "selected";} ?>>Sbo</option>
                                    <option value="fish" <?php if($this->input->post('actionName') == "fish"){echo "selected";} ?>>Bắn cá</option>
                                    <option value="ebet" <?php if($this->input->post('actionName') == "ebet"){echo "selected";} ?>>ebet</option>
                                    <option value="DIEM_DANH" <?php if($this->input->post('actionName') == "DIEM_DANH"){echo "selected";} ?>>Điểm danh</option>
                                </select></td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td><label class="session-1">Fee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                            <td><input type="text" class="session-2"
                                       id="fee_win" value="<?php echo $this->input->post('fee_win') ?>" name="fee_win"></td>
                            <td><label class="money-type-1">Money<br>lost&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                            <td><input type="text" class="money-type-2"
                                       id="moneyLost" value="<?php echo $this->input->post('moneyLost') ?>" name="moneyLost"></td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td><label class="session-1">Money<br>other&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                            <td><input type="text" class="session-2"
                                       id="moneyOther" value="<?php echo $this->input->post('moneyOther') ?>" name="moneyOther"></td>
                            <td><label class="money-type-1">Money<br>win&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                            <td><input type="text" class="money-type-2"
                                       id="moneyWin" value="<?php echo $this->input->post('moneyWin') ?>" name="moneyWin"></td>
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
                                       onclick="window.location.href = '<?php echo admin_url('report/chitietgiaodich') ?>'; "
                                       value="Reset" class="basic">
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                <thead>
                <tr class="list-loggameslot">
                    <td>STT</td>
                    <td>Action name</td>
                    <td>Date</td>
                    <td>Nick name</td>
                    <td>Time</td>
                    <td>Fee</td>
                    <td>Money lost</td>
                    <td>Money other</td>
                    <td>Money win</td>
                </tr>
                </thead>
                <tbody id="logaction">
                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>
<div class="container">
    <h6 class="total-data">Tổng bản ghi:<span class="total-data-span" id="totalRecord"></span></h6>
    <div id="spinner" class="spinner image-loggameslot">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>

<script>
    $("#search_tran").click(function () {        var fromDatetime = $("#fromDate").val();
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
            url: "<?php echo admin_url('report/chitietgiaodichajax')?>",
            data: {
                nickName: $("#nickName").val(),
                actionName: $("#actionName").val(),
                toDate : todate,
                fromDate : fromdate,
                fee: $("#fee_win").val(),
                flagTime: $("#flagtime").val(),
                moneyLost: $("#moneyLost").val(),
                moneyOther: $("#moneyOther").val(),
                moneyWin: $("#moneyWin").val(),
                page : 1,
                maxItem: 10
            },
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if (result.data == "") {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    let totalPage = Math.floor(result.totalData/10) + (result.totalData%10?1:0);
                    $("#totalRecord").html($.number(result.totalData, undefined, '.', ','));
                    $("#resultsearch").html("");
                    stt = 1;
                    $.each(result.data, function (index, value) {
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
                                    url: "<?php echo admin_url('report/chitietgiaodichajax')?>",
                                    data: {
                                        nickName: $("#nickName").val(),
                                        actionName: $("#actionName").val(),
                                        toDate : todate,
                                        fromDate : fromdate,
                                        fee: $("#fee_win").val(),
                                        flagTime: $("#flagtime").val(),
                                        moneyLost: $("#moneyLost").val(),
                                        moneyOther: $("#moneyOther").val(),
                                        moneyWin: $("#moneyWin").val(),
                                        page : page,
                                        maxItem: 10
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#spinner").hide();
                                        stt = (page - 1) * 10 + 1;
                                        $.each(result.data, function (index, value) {
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

    })
    function resultSearchTransction(stt,value) {
        let date = new Date(value.create_time);
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        var actionName = $("#actionName").val();
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
            case 'cmd':
                rs += "<td>" + 'Game CMD' + "</td>";
                break;
            case 'CHIEMTINH':
                rs += "<td>" + 'Chiêm tinh' + "</td>";
                break;
            case 'taixiusieutoc':
                rs += "<td>" + 'Tài xỉu siêu tốc' + "</td>";
                break;
            case 'ROLL_ROYE':
                rs += "<td>" + 'Thần bài' + "</td>";
                break;
            case 'BIKINI':
                rs += "<td>" + 'Bikini' + "</td>";
                break;
            case 'GALAXY':
                rs += "<td>" + 'Galaxy' + "</td>";
                break;
            case 'sbo':
                rs += "<td>" + 'Sbo' + "</td>";
                break;
            case 'fish':
                rs += "<td>" + 'Bắn cá' + "</td>";
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
                    case 'cmd':
                        rs += "<td>" + 'Game CMD' + "</td>";
                        break;
                    case 'CHIEMTINH':
                        rs += "<td>" + 'Chiêm tinh' + "</td>";
                        break;
                    case 'taixiusieutoc':
                        rs += "<td>" + 'Tài xỉu siêu tốc' + "</td>";
                        break;
                    case 'ROLL_ROYE':
                        rs += "<td>" + 'Thần bài' + "</td>";
                        break;
                    case 'BIKINI':
                        rs += "<td>" + 'Bikini' + "</td>";
                        break;
                    case 'GALAXY':
                        rs += "<td>" + 'Galaxy' + "</td>";
                        break;
                    case 'sbo':
                        rs += "<td>" + 'Sbo' + "</td>";
                        break;
                    case 'fish':
                        rs += "<td>" + 'Bắn cá' + "</td>";
                        break;
                    default:
                        rs += "<td>" + value.action_name + "</td>";
                }
        }
        rs += "<td>" + value.date + "</td>";
        rs += "<td>" + value.nick_name + "</td>";
        var flagtime = $('#flagtime').val();
        if(flagtime == 1){
            rs += "<td>" + String(date.getFullYear()).padStart(2, "0") + '-' + String(date.getMonth() + 1).padStart(2, "0") + '-' + String(date.getDate()).padStart(2, "0") + ' ' + String(date.getHours()).padStart(2, "0") + ':' + String(date.getMinutes()).padStart(2, "0") + ':' + String(date.getSeconds()).padStart(2, "0") + "</td>";
        }else if(flagtime == 2){
            rs += "<td>" + value.time_log + "</td>";
        }
        rs += "<td>" + $.number(value.fee, undefined, '.', ',') + "</td>";
        rs += "<td>" + $.number(value.money_lost, undefined, '.', ',')  + "</td>";
        rs += "<td>" + $.number(value.money_other, undefined, '.', ',') + "</td>";
        rs += "<td>" + $.number(value.money_win, undefined, '.', ',') + "</td>";
        rs += "</tr>";
        return rs;
    }</script>