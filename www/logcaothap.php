<?php $this->load->view('admin/logminigame/head', $this->data) ?>
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
    

    <link rel="stylesheet"
          href="<?php echo public_url() ?>/site/css/logminigame.css">

    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        <div class="title">
            <h6>Lịch sử cao thấp </h6>
            <div class="num f12">Tổng số: <b id="num"></b></div>
        </div>

        <form class="list_filter form" action="<?php echo admin_url('logminigame/logcaothap') ?>" method="post">
            <div class="formRow">
                <table>
                    <tr>
                        <td>
                            <label for="param_name" class="formLeft" id="nameuser">Từ ngày:</label></td>
                        <td class="item">
                            <div class="input-group date" id="datetimepicker1">
                                <input type="text" id="toDate" name = "toDate" value="<?php echo $this->input->post('toDate') ?>"> <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                            </div>
                        </td>
                        <td>
                            <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>
                        </td>
                        <td class="item">
                            <div class="input-group date" id="datetimepicker2">
                                <input type="text" id="fromDate" name="fromDate" value="<?php echo $this->input->post('fromDate') ?>"> <span class="input-group-addon">
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
                        <td><label class="session-1">Phiên:</label></td>
                        <td ><input type="text" class="session-2" id="phienbc" value="<?php echo $this->input->post('phienbc') ?>" name="phienbc"></td>
                        <td><label  id = "labelvin" class="money-type-1" style="margin-left: 19px">Phòng win:</label></td>

                        <td><select id="menhgiavin" name="menhgiavin"
                                    class="money-type-2" style="margin-left: 1px;width: 212px;">
                                <option value="" <?php if($this->input->post('menhgiavin') == "" ){echo "selected";} ?>>Chọn</option>
                                <option value="1000" <?php if($this->input->post('menhgiavin') == "1000" ){echo "selected";} ?>>1K Win</option>
                                <option value="10000" <?php if($this->input->post('menhgiavin') == "10000" ){echo "selected";} ?>>10K Win</option>
                                <option value="50000" <?php if($this->input->post('menhgiavin') == "50000" ){echo "selected";} ?>>50K Win</option>
                                <option value="100000" <?php if($this->input->post('menhgiavin') == "100000" ){echo "selected";} ?>>100K Win</option>
                                <option value="500000" <?php if($this->input->post('menhgiavin') == "500000" ){echo "selected";} ?>>500K Win</option>
                            </select></td>
                        <td hidden><label class="money-type-1">Tiền:</label></td>
                        <td hidden>
                            <select id="money" name="money"
                                    class="money-type-2">
                                <option value="1" <?php if($this->input->post('money') == "1" ){echo "selected";} ?>>Vin</option>
                                <option value="0" <?php if($this->input->post('money') == "0" ){echo "selected";} ?>>Xu</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="formRow">
                <table>
                    <tr>
                        <td hidden><label  id = "labelxu" class="money-type-1">Phòng xu:</label></td>
                        <td hidden><select id="menhgiaxu" name="menhgiaxu"
                                    class="money-type-2">
                                <option value="" <?php if($this->input->post('menhgiaxu') == "" ){echo "selected";} ?>>Chọn</option>
                                <option value="10000" <?php if($this->input->post('menhgiaxu') == "10000" ){echo "selected";} ?>>10K Xu</option>
                                <option value="100000" <?php if($this->input->post('menhgiaxu') == "100000" ){echo "selected";} ?>>100K Xu</option>
                                <option value="500000" <?php if($this->input->post('menhgiaxu') == "500000" ){echo "selected";} ?>>500K Xu</option>
                                <option value="1000000" <?php if($this->input->post('menhgiaxu') == "1000000" ){echo "selected";} ?>>1M Xu</option>
                                <option value="5000000" <?php if($this->input->post('menhgiaxu') == "5000000" ){echo "selected";} ?>>5M Xu</option>
                            </select></td>
                    </tr>
                    </table>
                </div>
            <div class="formRow">
                <table>
                    <tr class="nickname">
                        <td><label >Nick name:</label></td>
                        <td ><input type="text" id="nickname" value="<?php echo $this->input->post('nickname') ?>" name="nickname"></td>
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
                                   onclick="window.location.href = '<?php echo admin_url('logminigame/logbaucua') ?>'; "
                                   value="Reset" class="basic">
                        </td>
                    </tr>
                </table>
            </div>
        </form>
        <div class="formRow"></div>
        <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
            <thead>
            <tr class="list-logminigame">
                <td>Phiên</td>
                <td>Nick name</td>
                <td>Cửa đặt</td>
                <td>Bước</td>
                <td>Phòng chơi</td>
                <td>Kết quả</td>
                <td>Số tiền nhận được</td>
                <td>Quân bài</td>
                <td>Hũ hiện tại</td>
                <td>Quỹ hiện tại</td>
                <td>Loại tiền</td>
                <td>Ngày tạo</td>
            </tr>
            </thead>
            <tbody id="logaction">
            </tbody>
        </table>
    </div>
</div>
<?php endif;?>
<div class="container">
    <div id="spinner" class="spinner image-logminigame">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>
<div class="clear mt30"></div>
<script>
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
    $("#search_tran").click(function () {
        var fromDatetime = $("#toDate").val();
        var toDatetime = $("#fromDate").val();
        if (fromDatetime > toDatetime) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }

    });

    function resultlogcaothap(tran_id,nickName,pot_bet,step,bet_value,result,prize,cards,current_pot,current_fund,money_type,time_log) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>"+tran_id+"</td>";
        rs += "<td>" + nickName + "</td>";
        if(pot_bet == 0){
            rs += "<td>" +"Dưới"+ "</td>";
        }else if(pot_bet == 1){
            rs += "<td>" +"Trên"+ "</td>";
        }
        rs += "<td>" + step + "</td>";
        rs += "<td>" + commaSeparateNumber(bet_value) + "</td>";
        if(result == 4){
            rs += "<td>" + "Thắng" + "</td>";
        }else if(result == 5){
            rs += "<td>" + "Thua" + "</td>";
        }else if(result == 7){
            rs += "<td>" + "Nổ hũ" + "</td>";
        }
        else{
            rs += "<td>" + " " + "</td>";
        }
        rs += "<td>" + commaSeparateNumber(prize) + "</td>";
        rs += "<td>" + cards + "</td>";
        rs += "<td>" + commaSeparateNumber(current_pot) + "</td>";
        rs += "<td>" + commaSeparateNumber(current_fund) + "</td>";
        if(money_type == 0){
            rs += "<td>" + "xu" + "</td>";
        }else if(money_type == 1){
            rs += "<td>" + "Win" + "</td>";
        }
        rs += "<td>" + time_log + "</td>";
        rs += "</tr>";
        return rs;
    }
    $(document).ready(function () {
        var oldpage = 0;
        $('#pagination-demo').css("display","block");
        $("#spinner").show();
        if($("#money").val()==1) {
            $("#spinner").show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('logminigame/logcaothapajax')?>",
                data: {
                    nickname: $("#nickname").val(),
                    phienbc: $("#phienbc").val(),
                    roomvin: $("#menhgiavin").val(),
                    toDate: $("#toDate").val(),
                    fromDate: $("#fromDate").val(),
                    money : $("#money").val(),
                    pages :1
                },
                dataType: 'json',
                success: function (result) {
                    $("#spinner").hide();
                    var totalPage = result.total;
                    var countrow = result.totalRecord;
                    $("#num").html(countrow);
                    if (result.transactions == "") {
                        $('#pagination-demo').css("display","none");
                        $("#resultsearch").html("Không tìm thấy kết quả");
                    } else {
                        $("#resultsearch").html("");
                        $.each(result.transactions, function (index, value) {
                            result += resultlogcaothap(value.tran_id,value.nickName,value.pot_bet,value.step,value.bet_value,value.result,value.prize,value.cards,value.current_pot,value.current_fund,value.money_type,value.time_log);
                        });
                        $('#logaction').html(result);
                        $('#pagination-demo').twbsPagination({
                            totalPages: totalPage,
                            visiblePages: 5,
                            onPageClick: function (event, page) {
                                if(oldpage > 0) {
                                    $("#spinner").show();
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo admin_url('logminigame/logcaothapajax')?>",
                                        data: {
                                            nickname: $("#nickname").val(),
                                            phienbc: $("#phienbc").val(),
                                            roomvin: $("#menhgiavin").val(),
                                            toDate: $("#toDate").val(),
                                            fromDate: $("#fromDate").val(),
                                            money : $("#money").val(),
                                            pages : page
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $("#spinner").hide();
                                            $.each(result.transactions, function (index, value) {
                                                result += resultlogcaothap(value.tran_id, value.nickName, value.pot_bet, value.step, value.bet_value, value.result, value.prize, value.cards, value.current_pot, value.current_fund, value.money_type, value.time_log);
                                            });
                                            $('#logaction').html(result);
                                        }
                                    });
                                }
                                oldpage = page;
                            }
                        });
                    }

                }
            })
        }else if($("#money").val()== 0){
            $("#spinner").show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('logminigame/logcaothapajax')?>",
                data: {
                    nickname: $("#nickname").val(),
                    phienbc: $("#phienbc").val(),
                    roomxu: $("#menhgiaxu").val(),
                    toDate: $("#toDate").val(),
                    fromDate: $("#fromDate").val(),
                    money : $("#money").val(),
                    pages :1
                },
                dataType: 'json',
                success: function (result) {
                    var totalPage = result.total;
                    var countrow = result.totalRecord;
                    $("#num").html(countrow);
                    $("#spinner").hide();
                    if (result.transactions == "") {
                        $('#pagination-demo').css("display","none");
                        $("#resultsearch").html("Không tìm thấy kết quả");
                    } else {
                        $("#resultsearch").html("");
                        $.each(result.transactions, function (index, value) {
                            result += resultlogcaothap(value.tran_id,value.nickName,value.pot_bet,value.step,value.bet_value,value.result,value.prize,value.cards,value.current_pot,value.current_fund,value.money_type,value.time_log);
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
                                        url: "<?php echo admin_url('logminigame/logcaothapajax')?>",
                                        data: {
                                            nickname: $("#nickname").val(),
                                            phienbc: $("#phienbc").val(),
                                            roomxu: $("#menhgiaxu").val(),
                                            toDate: $("#toDate").val(),
                                            fromDate: $("#fromDate").val(),
                                            money : $("#money").val(),
                                            pages: page
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $("#spinner").hide();
                                            $.each(result.transactions, function (index, value) {
                                                result += resultlogcaothap(value.tran_id, value.nickName, value.pot_bet, value.step, value.bet_value, value.result, value.prize, value.cards, value.current_pot, value.current_fund, value.money_type, value.time_log);
                                            });
                                            $('#logaction').html(result);
                                        }
                                    });
                                }
                                oldpage = page;
                            }
                        });
                    }

                }
            })
        }
    });    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
</script>
