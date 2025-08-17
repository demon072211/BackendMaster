
    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle">
                <h5>Log game bài</h5>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="line"></div><link rel="stylesheet"
          href="<?php echo public_url() ?>/site/css/loggamebai.css"><?php if($role == false): ?>
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
                    <h6>Lịch sử game bài</h6>
                </div>
                <form class="list_filter form" action="<?php echo admin_url('loggamebai/sam') ?>" method="post">
                    <div class="formRow row">
                        <div class="col-sm-1">
                            <label for="param_name" class="formLeft">Từ ngày:</label>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group date" id="datetimepicker1">
                                <input type="text" id="fromDate" name="fromDate" value="<?php echo $this->input->post('fromDate') ?>">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <label for="param_name" class="formLeft">Đến ngày:</label>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group date" id="datetimepicker2">
                                <input type="text" id="toDate" name="toDate" value="<?php echo $this->input->post('toDate') ?>">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="formRow row">
                        <div class="col-sm-1">
                            <label class="session-1">Tran id:</label>
                        </div>
                        <div class="col-sm-2">
                            <input class="session-2" type="text" id="tranId" value="<?php echo $this->input->post('tranId') ?>" name="tranId">
                        </div>

                        <div class="col-sm-1">
                            <label class="session-1" >Nick name:</label>
                        </div>
                        <div class="col-sm-2">
                            <input class="session-2" type="text" id="filter_iname" value="<?php echo $this->input->post('name') ?>" name="name">
                        </div>

                        <div class="col-sm-1">
                            <label class="session-1" >Loại tiền:</label>
                        </div>
                        <div class="col-sm-2">
                            <input class="session-2" type="text" id="moneyType" value="<?php echo $this->input->post('moneyType') ?>" name="moneyType">
                        </div>
                    </div>
                    <div class="formRow row">
                        <div class="col-sm-1">
                            <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB search">
                        </div>
                        <div class="col-sm-1">
                            <input type="reset"
                                   onclick="window.location.href = '<?php echo admin_url('loggamebai/sam') ?>'; "
                                   value="Reset" class="basic">
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <h6 style="display: inline"><strong>Tổng người chơi:</strong><span class="total-data-span" id="totalPlayer"></span></h6>
                        <h6 style="display: inline"><strong> | Tổng bản ghi:</strong><span class="total-data-span" id="totalData"></span></h6>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                    <thead>
                    <tr class="list-loggamebai">
                        <td>STT</td>
                        <td>Tran id</td>
                        <td>Nick name</td>
                        <td>Tiền cược</td>
                        <td>Thẻ bài</td>
                        <td>Quỹ hiện tại</td>
                        <td>Pot hiện tại</td>
                        <td>Loại tiền</td>
                        <td>Ô cược</td>
                        <td>Thưởng</td>
                        <td>Kết quả</td>
                        <td>Step</td>
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
        <div id="spinner" class="spinner image-loggamebai">
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
            var oldpage = 0;
            $('#pagination-demo').css("display", "block");
            $("#spinner").show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('loggamebai/samajax')?>",
                data: {
                    nickname: $("#filter_iname").val(),
                    namegame: 'Sam',
                    toDate : $("#toDate").val(),
                    fromDate : $("#fromDate").val(),
                    pages : 1,
                    tid : $("#tranId").val(),
                    moneyType : $("#moneyType").val()
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
                        $("#totalPlayer").html($.number(result.totalPalyers, undefined, '.', ','));
                        $("#resultsearch").html("");
                        stt = 1;
                        $.each(result.transactions, function (index, value) {
                            result += resultSearchTransction(stt, value);
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
                                        url: "<?php echo admin_url('loggamebai/samajax')?>",
                                        // url: "http://192.168.0.251:8082/api_backend",
                                        data: {
                                            nickname: $("#filter_iname").val(),
                                            namegame: 'Sam',
                                            toDate : $("#toDate").val(),
                                            fromDate : $("#fromDate").val(),
                                            pages : page,
                                            sid : $("#session_name").val(),
                                            money : $("#moneytype").val()
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
        function resultSearchTransction(stt,value) {
            var rs = "";
            rs += "<tr>";
            rs += "<td>" + stt + "</td>";
            rs += "<td width='50' >" + value.tran_id + "</td>";
            rs += "<td>" + value.nickName + "</td>";
            rs += "<td width='50' >" + value.bet_value + "</td>";
            rs += "<td width='50' >" + value.cards + "</td>";
            rs += "<td width='50' >" + value.current_fund + "</td>";
            rs += "<td width='50' >" + value.current_pot + "</td>";
            rs += "<td width='50' >" + value.money_type + "</td>";
            rs += "<td width='50' >" + value.pot_bet + "</td>";
            rs += "<td width='50' >" + value.prize + "</td>";
            rs += "<td width='50' >" + value.result + "</td>";
            rs += "<td width='50' >" + value.step + "</td>";
            rs += "<td width='50' >" + value.time_log + "</td>";
            rs += "</tr>";
            return rs;
        }
    </script>