<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Log game slot</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<link rel="stylesheet"
      href="<?php echo public_url() ?>/site/css/loggameslot.css">
    <?php $this->load->view('admin/error') ?>
    <div class="wrapper">
        <?php $this->load->view('admin/message', $this->data); ?>
        <div class="widget">
            <h4 id="resultsearch"></h4>
            <div class="title">
                <h6>Game slot galaxy</h6>
                <h6 class="total">Tổng thắng:<span class="total-number" id="tong_thang"></span></h6>
                <h6 class="total">Tổng cược:<span class="total-number" id="tong_cuoc"></span></h6>
                <h6 class="total">Tổng Số người chơi:<span class="total-number" id="tong_player"></span></h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('loggameslot/galaxy') ?>" method="post">
                <div class="formRow">
                    <table>
                        <tr>
                            <td>
                                <label for="param_name" class="formLeft" id="nameuser">Từ ngày:</label></td>
                            <td class="item">
                                <div class="input-group date" id="datetimepicker1">
                                    <input type="text" id="fromDate" name="fromDate" value="<?php echo $this->input->post('fromDate') ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>
                            </td>
                            <td class="item">
                                <div class="input-group date" id="datetimepicker2">
                                    <input type="text" id="toDate" name="toDate" value="<?php echo $this->input->post('toDate') ?>">
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
                            <td><label class="session-1">Phiên:</label></td>
                            <td><input type="text" class="session-2"
                                       id="transId" value="<?php echo $this->input->post('transId') ?>" name="transId">
                            </td>
                            <td><label class="money-type-1">Tiền cược:</label></td>
                            <td><input type="text" class="money-type-2"
                                       id="bet_value" value="<?php echo $this->input->post('bet_value') ?>"
                                       name="bet_value"></td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr class="nickname">
                            <td><label>Nick name:</label></td>
                            <td><input type="text"
                                       id="nickName" value="<?php echo $this->input->post('nickName') ?>"
                                       name="nickName"></td>
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
                                       onclick="window.location.href = '<?php echo admin_url('loggameslot/galaxy') ?>'; "
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
                    <td>Phiên</td>
                    <td>Nick name</td>
                    <td>Tiền cược</td>
                    <td>Ô đặt cược</td>
                    <td>Các ô thắng</td>
                    <td>Phần thưởng trên các ô</td>
                    <td>Tiền thưởng</td>
                    <td>Kết quả</td>
                    <td>Ngày tạo</td>
                </tr>
                </thead>
                <tbody id="logaction">
                </tbody>
            </table>
        </div>
    </div>
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
            useCurrent: false,
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: endDate,
            useCurrent: false,
        });

    });

    $(document).ready(function () {

        var fromdate;
        var todate;
        var oldpage = 0;
        if ($("#toDate").val() != "") {
            var match = $("#toDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            todate = moment.unix(date.getTime() / 1000).format("YYYY-MM-DD HH:mm:ss")
        } else {
            todate = "";
        }
        if ($("#fromDate").val() != "") {
            var match = $("#fromDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            fromdate = moment.unix(date.getTime() / 1000).format("YYYY-MM-DD HH:mm:ss")
        } else {
            fromdate = "";
        }
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('loggameslot/galaxyAjax')?>",
            data: {
                nickName: $("#nickName").val(),
                transId: $("#transId").val(),
                bet_value: $("#bet_value").val(),
                toDate: todate,
                fromDate: fromdate,
                page: 1
            },
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                var totalPage = result.total;
                if (result.transactions == "") {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    $("#totalData").html($.number(result.totalRecord, undefined, '.', ','));
                    $("#tong_thang").html($.number(result.tong_thang, undefined, '.', ','));
                    $("#tong_cuoc").html($.number(result.tong_cuoc, undefined, '.', ','));
                    $("#tong_player").html($.number(result.tong_player, undefined, '.', ','));
                    $("#resultsearch").html("");
                    stt = 1;
                    $.each(result.transactions, function (index, value) {
                        result += resultSearchTransction(stt, value);
                        stt++;
                    });
                    $('#logaction').html(result);
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if (oldpage > 0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('loggameslot/galaxyAjax')?>",
                                    data: {
                                        nickName: $("#nickName").val(),
                                        transId: $("#transId").val(),
                                        bet_value: $("#bet_value").val(),
                                        toDate: todate,
                                        fromDate: fromdate,
                                        page: page
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#spinner").hide();
                                        stt = (page - 1) * 50 + 1;
                                        $.each(result.transactions, function (index, value) {
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

    function resultSearchTransction(stt, value) {
        var rs = "";
        let date = new Date(value.create_time);
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + value.reference_id + "</td>";
        rs += "<td>" + value.user_name + "</td>";
        rs += "<td>" + Intl.NumberFormat().format(value.bet_value) + "</td>";
        rs += "<td>" + (value.line_betting || '-') + "</td>";
        rs += "<td title='" + value.lines_win + "'>" + value.lines_win.replace(/,/g, ", ") + "</td>";
        rs += "<td title='" + value.prizes_on_line + "'>" + value.prizes_on_line.replace(/,/g, ", ") + "</td>";
        rs += "<td>" + Intl.NumberFormat().format(value.prize) + "</td>";
        rs += "<td>" + value.result + "</td>";
        rs += "<td>" + String(date.getFullYear()).padStart(2, "0") + '-' + String(date.getMonth() + 1).padStart(2, "0") + '-' + String(date.getDate()).padStart(2, "0") + ' ' + String(date.getHours()).padStart(2, "0") + ':' + String(date.getMinutes()).padStart(2, "0") + ':' + String(date.getSeconds()).padStart(2, "0") + "</td>";
        rs += "</tr>";
        return rs;
    }
</script>