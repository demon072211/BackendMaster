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
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>

        <link rel="stylesheet" href="<?php echo public_url() ?>/site/css/loggamethirdparty.css">
        <div class="title">
            <h6>Lịch sử bầu cua</h6>
            <h6 class="total">Tổng Số người chơi:<span class="total-number" id="totalPlayer"></span></h6>
        </div>
        <form class="list_filter form" action="<?php echo admin_url('logminigame/logbaucua') ?>" method="post">
            <div class="formRow">
            <table>
                <tr>
                    <td>
                        <label for="param_name" class="formLeft" id="nameuser">Từ ngày:</label></td>
                    <td class="item">
                        <div class="input-group date" id="datetimepicker1">
                            <input type="text" id="toDate" name="toDate" value="<?= empty($this->input->get('toDate')) ? $this->input->post('toDate') : $this->input->get('toDate')?>"> <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                        </div>
                    </td>
                    <td>
                        <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>
                    </td>
                    <td class="item">
                        <div class="input-group date" id="datetimepicker2">
                            <input type="text" id="fromDate" name="fromDate" value="<?= empty($this->input->get('fromDate')) ? $this->input->post('fromDate') : $this->input->get('fromDate')?>"> <span class="input-group-addon">
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
                        <td ><input type="text" class="session-2" id="phienbc" value="<?= empty($this->input->get('phienbc')) ? $this->input->post('phienbc') : $this->input->get('phienbc')?>" name="phienbc"></td>
                        <td><label  id = "labelvin" class="money-type-1" style="margin-left: 19px">Phòng win:</label></td>

                        <td><select id="menhgiavin" name="menhgiavin"
                                    class="money-type-2" style="margin-left: 1px;width: 212px;">
                                <option value="" <?= ($this->input->post('menhgiavin') == "" || $this->input->get('menhgiavin') == "") ? "selected": "" ?> >Chọn</option>
                                <option value="1000" <?= ($this->input->post('menhgiavin') == "1000" || $this->input->get('menhgiavin') == "1000") ? "selected" : "" ?>>1K Win</option>
                                <option value="10000" <?= ($this->input->post('menhgiavin') == "10000" || $this->input->get('menhgiavin') == "10000") ? "selected" : "" ?>>10K Win</option>
                                <option value="100000" <?= ($this->input->post('menhgiavin') == "100000" || $this->input->get('menhgiavin') == "100000") ? "selected": "" ?>>100K Win</option>
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
                                <option value="1000000" <?php if($this->input->post('menhgiaxu') == "1000000" ){echo "selected";} ?>>1000K Xu</option>

                            </select></td>
                        </tr>
                    </table>
                </div>
            <div class="formRow">
                <table>
                    <tr class="nickname">
                        <td><label >Nick name:</label></td>
                        <td ><input type="text" id="nickname" value="<?= empty($this->input->get('nickname')) ? $this->input->post('nickname') : $this->input->get('nickname')?>" name="nickname"></td>
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
                <td>Phòng</td>
                <td>Kết quả</td>
                <td>Tiền đặt bầu</td>
                <td>Tiền đặt cua</td>
                <td>Tiền đặt tôm</td>
                <td>Tiền đặt cá</td>
                <td>Tiền đặt gà</td>
                <td>Tiền đặt hưou</td>
                <td>Tiền thưởng bầu</td>
                <td>Tiền thưởng cua</td>
                <td>Tiền thưởng tôm</td>
                <td>Tiền thưởng cá</td>
                <td>Tiền thưởng gà</td>
                <td>Tiền thưởng hưou</td>
                <td>Tiền</td>
                <td>Ngày tạo</td>
            </tr>
            </thead>
            <tbody id="logaction">
            </tbody>
        </table>

    </div>
</div>
<?php endif; ?>
<div class="container">
    <h6 class="total-data">Tổng bản ghi:<span class="total-data-span" id="totalRecord"></span></h6>
    <div id="spinner" class="spinner image-logminigame">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>

</div>
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
function resultlogbaucua(referid,nickname,room,dice,bet_bau,bet_cua,bet_tom,bet_ca,bet_ga,bet_huou,prize_bau,prize_cua,prize_tom,prize_ca,prize_ga,prize_huou,money_type,time_log) {
    var rs = "";
    rs += "<tr>";
    rs += "<td><a style='color: #0000FF' href='detailbaucua/"+referid+ query() +"'>"+referid+"</a>" + "</td>";
    rs += "<td>" + nickname + "</td>";
    rs += "<td>" + commaSeparateNumber(room) + "</td>";
    rs += "<td>" + dice + "</td>";
    rs += "<td>" + commaSeparateNumber(bet_bau) + "</td>";
    rs += "<td>" + commaSeparateNumber(bet_cua) + "</td>";
    rs += "<td>" + commaSeparateNumber(bet_tom) + "</td>";
    rs += "<td>" + commaSeparateNumber(bet_ca) + "</td>";
    rs += "<td>" + commaSeparateNumber(bet_ga) + "</td>";
    rs += "<td>" + commaSeparateNumber(bet_huou) + "</td>";
    rs += "<td>" + commaSeparateNumber(prize_bau) + "</td>";
    rs += "<td>" + commaSeparateNumber(prize_cua) + "</td>";
    rs += "<td>" + commaSeparateNumber(prize_tom) + "</td>";
    rs += "<td>" + commaSeparateNumber(prize_ca) + "</td>";
    rs += "<td>" + commaSeparateNumber(prize_ga) + "</td>";
    rs += "<td>" + commaSeparateNumber(prize_huou) + "</td>";
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
    var result = "";
    var oldpage = 0;
    $('#pagination-demo').css("display","block");
    $("#spinner").show();
    if($("#money").val()==1) {
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('logminigame/logbaucuaajax')?>",
            data: {
                phienbc: $("#phienbc").val(),
                nickname: $("#nickname").val(),
                roomvin : $("#menhgiavin").val(),
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
                    $("#totalRecord").html($.number(result.totalRecord, undefined, '.', ','));
                    $("#totalPlayer").html($.number(result.totalPlayer, undefined, '.', ','));
                    $("#resultsearch").html("");
                    $.each(result.transactions, function (index, value) {
                        result += resultlogbaucua(value.referent_id,value.user_name,value.room,replacedice(value.dices),value.bet_bau,value.bet_cua,value.bet_tom,value.bet_ca,value.bet_ga,value.bet_huou,value.prize_bau,value.prize_cua,value.prize_tom,value.prize_ca,value.prize_ga,value.prize_huou,value.money_type,value.time_log);
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
                                    url: "<?php echo admin_url('logminigame/logbaucuaajax')?>",
                                    data: {
                                        phienbc: $("#phienbc").val(),
                                        nickname: $("#nickname").val(),
                                        roomvin : $("#menhgiavin").val(),
                                        toDate: $("#toDate").val(),
                                        fromDate: $("#fromDate").val(),
                                        money : $("#money").val(),
                                        pages : page
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#spinner").hide();
                                        $.each(result.transactions, function (index, value) {
                                            result += resultlogbaucua(value.referent_id, value.user_name, value.room, replacedice(value.dices), value.bet_bau, value.bet_cua, value.bet_tom, value.bet_ca, value.bet_ga, value.bet_huou, value.prize_bau, value.prize_cua, value.prize_tom, value.prize_ca, value.prize_ga, value.prize_huou, value.money_type, value.time_log);
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
            url: "<?php echo admin_url('logminigame/logbaucuaajax')?>",
            data: {
                phienbc: $("#phienbc").val(),
                nickname: $("#nickname").val(),
                roomxu : $("#menhgiaxu").val(),
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
                        result += resultlogbaucua(value.referent_id,value.user_name,value.room,replacedice(value.dices),value.bet_bau,value.bet_cua,value.bet_tom,value.bet_ca,value.bet_ga,value.bet_huou,value.prize_bau,value.prize_cua,value.prize_tom,value.prize_ca,value.prize_ga,value.prize_huou,value.money_type,value.time_log);
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
                                    url: "<?php echo admin_url('logminigame/logbaucuaajax')?>",
                                    data: {
                                        phienbc: $("#phienbc").val(),
                                        nickname: $("#nickname").val(),
                                        roomxu : $("#menhgiaxu").val(),
                                        toDate: $("#toDate").val(),
                                        fromDate: $("#fromDate").val(),
                                        money : $("#money").val(),
                                        pages :page
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#spinner").hide();
                                        $.each(result.transactions, function (index, value) {
                                            result += resultlogbaucua(value.referent_id, value.user_name, value.room, replacedice(value.dices), value.bet_bau, value.bet_cua, value.bet_tom, value.bet_ca, value.bet_ga, value.bet_huou, value.prize_bau, value.prize_cua, value.prize_tom, value.prize_ca, value.prize_ga, value.prize_huou, value.money_type, value.time_log);
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
});
function replacedice(str){
   return str.replace(/0/g,"bầu").replace(/1/g,"cua").replace(/2/g,"tôm").replace(/3/g,"cá").replace(/4/g,"gà").replace(/5/g,"hưou");
}
function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
    }
    return val;
}

function query() {
    let query = '?';
    if ($('#toDate').val() != '') {
        query += 'toDate=' + $('#toDate').val()+ '&';
    }
    if ($('#fromDate').val() != '') {
        query += 'fromDate=' + $('#fromDate').val() + '&';
    }
    if ($('#phienbc').val() != '') {
        query += 'phienbc=' + $('#phienbc').val() + '&';
    }
    if ($('#menhgiavin').val() != '') {
        query += 'menhgiavin=' + $('#menhgiavin').val() + '&';
    }
    if ($('#nickname').val() != '') {
        query += 'nickname=' + $('#nickname').val() + '&';
    }
    return query;
}
</script>
