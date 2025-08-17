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
    <link rel="stylesheet" href="<?php echo public_url() ?>/site/css/loggamethirdparty.css">
    <div class="widget">
        <h4 id="resultsearch"></h4>
        <div class="title">
            <h6>Lịch sử tài khoản chơi tài xỉu</h6>
            <h6 class="total">Tổng Số người chơi:<span class="total-number" id="totalPlayer"></span></h6>
        </div>
        <form class="list_filter form" action="<?php echo admin_url('logminigame/accounttaixiu') ?>" method="post">
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
                            </div>                        </td>

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
                        <td>
                            <label for="param_name" class="session-1">Phiên: </label>
                        </td>
                        <td><input type="text" class="session-2"
                                   id="phientx" value="<?= empty($this->input->get('phientx')) ? $this->input->post('phientx') : $this->input->get('phientx') ?>"
                                   name="phientx"></td>
                        <td><label class="money-type-1">Lọc bot:</label></td>
                        <td>
                            <select id="bot_type" name="bot_type"
                                    class="money-type-2">
                                <option value="1" <?php if($this->input->post('bot_type') == "1" || $this->input->get('bot_type') == "1"){echo "selected";} ?>>Người chơi</option>
                                <option value="0" <?php if($this->input->post('bot_type') == "0" || $this->input->get('bot_type') == "0"){echo "selected";} ?>>Bot</option>
                            </select>
                        </td>

                    </tr>
                </table>
            </div>
            <div class="formRow">
                <table>
                    <tr>
                        <td hidden><label class="money-type-3">Tiền:</label></td>
                        <td hidden>
                            <select id="money_type" name="money" class="money-type-4">
                                <option value="1" <?php if($this->input->post('money') == "1"){echo "selected";} ?>>Win</option>
                                <option value="0" <?php if($this->input->post('money') == "0"){echo "selected";} ?>>Xu</option>
                            </select>
                        </td>
                        <td><label class="session-1">Nick name:</label></td>
                        <td><input class="session-2" type="text" id="filter_iname" value="<?= empty($this->input->get('name')) ? $this->input->post('name') : $this->input->get('name')?>" name="name"></td>
                        <td>
                            <label for="param_name" class="money-type-1">Cửa đặt: </label>
                        </td>
                        <td><select id="cuadatid" name="cuadatid" class="money-type-2">
                                <option value="" <?php if($this->input->post('cuadatid') == "" || $this->input->get('cuadatid') == ""){echo "selected";} ?>>Tất cả</option>
                                <option value="1" <?php if($this->input->post('cuadatid') == "1" || $this->input->get('cuadatid') == "1"){echo "selected";} ?>>Tài</option>
                                <option value="0" <?php if($this->input->post('cuadatid') == "0" || $this->input->get('cuadatid') == "0"){echo "selected";} ?>>Xỉu</option>
                            </select>
                        </td>
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
                                   onclick="window.location.href = '<?php echo admin_url('logminigame/accounttaixiu') ?>'; "
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
                <td>Tiền đặt</td>
                <td>Cửa đặt</td>
                <td>Thưởng</td>
                <td>Hoàn trả</td>
                <td>Tiền thay đổi</td>
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
    <div id="spinner" class="spinner image-logminigame" >
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
    function resultSearchtaixiu(referenceId, user_name, bet_value, bet_side, total_prize, total_refund, total_exchange, time_log,money_type) {
        var rs = "";
        rs += "<tr>";
        rs += "<td><a style='color: #0000FF' href='detailphientaixiu/"+referenceId+ "/detail" + query() +"'>"+referenceId+"</a></td>";
        rs += "<td>" + user_name + "</td>";
        rs += "<td>" + commaSeparateNumber(bet_value) + "</td>";
        if(bet_side == 1){
            rs += "<td>" + "Tài" + "</td>";
        }else  if(bet_side == 0){
            rs += "<td>" + "Xỉu" + "</td>";
        }
        rs += "<td>" + commaSeparateNumber(total_prize) + "</td>";
        rs += "<td>" + commaSeparateNumber(total_refund) + "</td>";
        rs += "<td>" + commaSeparateNumber(total_exchange) + "</td>";
        if(money_type == 1){
            rs += "<td>" + "Win" + "</td>";
        }else  if(money_type == 0){
            rs += "<td>" + "Xu" + "</td>";
        }
        rs += "<td>" + time_log + "</td>";
        rs += "</tr>";
        return rs;
    }
    $(document).ready(function () {
        var result = "";
        var oldPage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('logminigame/accounttaixiuajax')?>",
            data: {
                phientx: $("#phientx").val(),
                nickname: $("#filter_iname").val(),
                cuadat : $("#cuadatid").val(),
                toDate: $("#toDate").val(),
                fromDate: $("#fromDate").val(),
                money: $("#money_type").val(),
                bot_type: $("#bot_type").val(),
                pages : 1
            },

            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if (result.transactions == "") {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                }else {
                    $("#totalRecord").html($.number(result.totalRecord, undefined, '.', ','));
                    $("#totalPlayer").html($.number(result.totalPlayer, undefined, '.', ','));
                    $("#resultsearch").html("");
                    var totalPage = result.total;
                    $.each(result.transactions, function (index, value) {
                        result += resultSearchtaixiu(value.referenceId, value.user_name, value.bet_value, value.bet_side, value.total_prize, value.total_refund, value.total_exchange, value.time_log, value.money_type)
                    });
                    $('#logaction').html(result);
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if (oldPage > 0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('logminigame/accounttaixiuajax')?>",
                                    data: {
                                        phientx: $("#phientx").val(),
                                        nickname: $("#filter_iname").val(),
                                        cuadat : $("#cuadatid").val(),
                                        toDate: $("#toDate").val(),
                                        fromDate: $("#fromDate").val(),
                                        money: $("#money_type").val(),
                                        bot_type: $("#bot_type").val(),
                                        pages : page
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#resultsearch").html("");
                                        $("#spinner").hide();
                                        $.each(result.transactions, function (index, value) {
                                            result += resultSearchtaixiu(value.referenceId, value.user_name, value.bet_value, value.bet_side, value.total_prize, value.total_refund, value.total_exchange, value.time_log, value.money_type)
                                        });
                                        $('#logaction').html(result);

                                    }, error: function (request, status, error) {
                                        $("#spinner").hide();
                                        $('#logaction').html("");
                                        $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages.");
                                    },timeout : 180000
                                });
                            }
                            oldPage = page;
                        }

                    });

                }

            }, error: function (request, status, error) {
                $("#spinner").hide();
                $('#logaction').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages.");
            },timeout : 180000
        })

    });
</script>
<script>
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
        if ($('#phientx').val() != '') {
            query += 'phientx=' + $('#phientx').val() + '&';
        }
        if ($('#bot_type').val() != '') {
            query += 'bot_type=' + $('#bot_type').val() + '&';
        }
        if ($('#filter_iname').val() != '') {
            query += 'name=' + $('#filter_iname').val() + '&';
        }
        if ($('#cuadatid').val() != '') {
            query += 'cuadatid=' + $('#cuadatid').val() + '&';
        }
        return query;
    }
</script>