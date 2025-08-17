    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle">
                <h5>Log game thirdparty</h5>
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
                    <h6>Lịch sử game thirdparty</h6>
                    <h6 class="total">Tổng đặt cược:<span class="total-number" id="totalBet"></span></h6>
                    <h6 class="total">Tổng đặt cược hợp lệ:<span class="total-number" id="totalValidBet"></span></h6>
                    <h6 class="total">Tổng thanh toán:<span class="total-number" id="totalPayout"></span></h6>
                    <h6 class="total">Tổng số người chơi:<span class="total-number" id="tong_player"></span></h6>
                </div>
                <form class="list_filter form" action="<?php echo admin_url('loggamethirdparty/ag') ?>" method="post">
                    <div class="formRow">

                        <table>
                            <tr>
                                <td><label class="flagtime-1">Flag time:</label></td>
                                <td>
                                    <select class="flagtime-2" id="flagtime" name="flagtime">
                                        <option value="1" <?php if($this->input->post('flagtime') == "1" || $this->input->get('flagtime') == "1"){echo "selected";} ?>>bettime</option>
                                        <option value="0" <?php if($this->input->post('flagtime') == "0"  || $this->input->get('flagtime') == "0"){echo "selected";} ?>>payouttime</option>
                                    </select>
                                </td>
                                <td><label class="money-type-1">Bill no:</label></td>
                                <td>
                                    <input type="text" class="money-type-2"
                                           id="billNo" value="<?= empty($this->input->get('billNo')) ? $this->input->post('billNo') : $this->input->get('billNo') ?>" name="billNo">
                                </td>
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
                                        <input type="text" id="fromDate" name="fromDate" value="<?= empty($this->input->get('fromDate')) ? $this->input->post('fromDate') : $this->input->get('fromDate')?>">
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
                                        <input type="text" id="toDate" name="toDate" value="<?= empty($this->input->get('toDate')) ? $this->input->post('toDate') : $this->input->get('toDate')?>">
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
                                <td><label class="session-1">Game type:</label></td>
                                <td>
                                    <input type="text" class="session-2"
                                           id="gameType" value="<?= empty($this->input->get('gameType')) ? $this->input->post('gameType') : $this->input->get('gameType') ?>" name="gameType">
                                </td>
                                <td><label class="money-type-1">Bet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>=</label></td>
                                <td>
                                    <input type="text" class="money-type-2"
                                           id="bet" value="<?= empty($this->input->get('bet')) ? $this->input->post('bet') : $this->input->get('bet')?>" name="bet">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="formRow">
                        <table>
                            <tr class="nickname">
                                <td><label>Nick name:</label></td>
                                <td>
                                    <input type="text"
                                           id="nickName" value="<?= empty($this->input->get('nickName')) ? $this->input->post('nickName') : $this->input->get('nickName') ?>" name="nickName">
                                </td>
                                <td><label class="session-1">Payout&nbsp;&nbsp;&nbsp;>=</label></td>
                                <td><input type="text" class="session-2"
                                           id="payOut" value="<?= empty($this->input->get('payOut')) ? $this->input->post('payOut') : $this->input->get('payOut') ?>" name="payOut"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="session-1">Game code:</label></td>
                                <td>
                                    <input type="text" class="session-2"
                                           id="gameCode" value="<?= empty($this->input->get('gameCode')) ? $this->input->post('gameCode') : $this->input->get('gameCode')?>" name="gameCode">
                                </td>
                                <td><label class="money-type-1">BetIp:</label></td>
                                <td>
                                    <input type="text" class="money-type-2"
                                           id="betIp" value="<?= empty($this->input->get('betIp')) ? $this->input->post('betIp') : $this->input->get('betIp') ?>" name="betIp">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="session-1">UserName:</label></td>
                                <td>
                                    <input type="text" class="session-2"
                                           id="username" value="<?= empty($this->input->get('username')) ? $this->input->post('username') : $this->input->get('username') ?>" name="username">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="flagtime-1">Số dòng:</label></td>
                                <td><select class="flagtime-2" id="maxItem" name="maxItem">
                                        <option value="20" <?php if($this->input->post('maxItem') == "20" || $this->input->get('maxItem') == "20"){echo "selected";} ?>>20</option>
                                        <option value="50" <?php if($this->input->post('maxItem') == "50" || $this->input->get('maxItem') == "20"){echo "selected";} ?>>50</option>
                                        <option value="100" <?php if($this->input->post('maxItem') == "100" || $this->input->get('maxItem') == "20"){echo "selected";} ?>>100</option>
                                    </select></td>
                                <td style="">
                                    <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB search">
                                </td>
                                <td>
                                    <input type="reset"
                                           onclick="window.location.href = '<?php echo admin_url('loggamethirdparty/ag') ?>'; "
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
                        <td>billno</td>
                        <td>username</td>
                        <td>nickname</td>
                        <td>bet</td>
                        <td>validbet</td>
                        <td>payout</td>
                        <td>time</td>
                        <td>gamecode</td>
                        <td>gametype</td>
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
                url: "<?php echo admin_url('loggamethirdparty/agajax')?>",
                data: {
                    nickName: $("#nickName").val(),
                    billNo: $("#billNo").val(),
                    gameCode: $("#gameCode").val(),
                    toDate: todate,
                    fromDate: fromdate,
                    flagTime: $("#flagtime").val(),
                    gameType: $("#gameType").val(),
                    bet: $("#bet").val(),
                    payOut: $("#payOut").val(),
                    betIp: $("#betIp").val(),
                    username: $("#username").val(),
                    page : 1,
                    maxItem: $("#maxItem").val()
                },
                dataType: 'json',
                success: function (response) {
                    $("#spinner").hide();
                    let result = JSON.parse(response.data);
                    if (result.listTrans == "") {
                        $('#pagination-demo').css("display", "none");
                        $("#resultsearch").html("Không tìm thấy kết quả");
                    } else {
                            let result = JSON.parse(response.data);
                        let totalPage = Math.floor(result.totalRecord/10) + (result.totalRecord%10?1:0);
                        $("#totalRecord").html($.number(result.totalRecord, undefined, '.', ','));
                        $("#totalBet").html($.number(result.totalBet, undefined, '.', ','));
                        $("#totalValidBet").html($.number(result.totalValidBet, undefined, '.', ','));
                        $("#totalPayout").html($.number(result.totalPayout, undefined, '.', ','));
                        $("#tong_player").html($.number(result.totalPlayer, undefined, '.', ','));
                        $("#resultsearch").html("");
                        stt = 1;
                        let str = '';
                        $.each(result.listTrans, function (index, value) {
                            str += resultSearchTransction(stt,value);
                            stt ++;
                        });
                        $('#logaction').html(str);
                        $('#pagination-demo').twbsPagination({
                            totalPages: totalPage,
                            visiblePages: 5,
                            onPageClick: function (event, page) {
                                if(oldpage>0) {
                                    $("#spinner").show();
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo admin_url('loggamethirdparty/agajax')?>",
                                        data: {
                                            nickName: $("#nickName").val(),
                                            billNo: $("#billNo").val(),
                                            gameCode: $("#gameCode").val(),
                                            toDate: todate,
                                            fromDate: fromdate,
                                            flagTime: $("#flagtime").val(),
                                            gameType: $("#gameType").val(),
                                            bet: $("#bet").val(),
                                            payOut: $("#payOut").val(),
                                            betIp: $("#betIp").val(),
                                            username: $("#username").val(),
                                            page : page,
                                            maxItem: $("#maxItem").val()
                                        },
                                        dataType: 'json',
                                        success: function (response) {
                                           let      result = JSON.parse(response.data);
                                            $("#spinner").hide();
                                             stt = 1;
                                             let str = ''
                                            $.each(result.listTrans, function (index, value) {
                                                str += resultSearchTransction(stt, value);
                                                stt++;
                                            });
                                            $('#logaction').html(str);
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
            rs += "<td><a href='<?= admin_url('loggamethirdparty/agDetail') . '/'?>" + value.billno + query() +"' class='text-success'>" + value.billno + "</a></td>";
            rs += "<td>" + value.username + "</td>";
            rs += "<td title='" + value.nickname + "'>" + value.nickname + "</td>";
            rs += "<td>" + value.bet + "</td>";
            rs += "<td>" + value.validbet + "</td>";
            rs += "<td>" + value.payout + "</td>";
            var flagtime = $('#flagtime').val();
            if (flagtime == 1) {
                rs += "<td>" + value.bettime + "</td>";
            } else if(flagtime == 0){
                rs += "<td>" + value.payouttime + "</td>";
            }

            rs += "<td title='" + value.gamecode + "'>" + (value.gamecode  || '-') + "</td>";
            rs += "<td>" + value.gametype + "</td>";
            rs += "</tr>";
            return rs;
        }
        function query() {
            let query = '?';
            if ($('#flagtime').val() != '') {
                query += 'flagtime=' + $('#flagtime').val() + '&'
            }
            if ($('#billNo').val() != '') {
                query += 'billNo=' + $('#billNo').val() + '&'
            }
            if ($('#fromDate').val() != '') {
                query += 'fromDate=' + $('#fromDate').val() + '&'
            }
            if ($('#toDate').val() != '') {
                query += 'toDate=' + $('#toDate').val() + '&'
            }
            if ($('#gameType').val() != '') {
                query += 'gameType=' + $('#gameType').val() + '&'
            }
            if ($('#bet').val() != '') {
                query += 'bet=' + $('#bet').val() + '&'
            }
            if ($('#nickName').val() != '') {
                query += 'nickName=' + $('#nickName').val() + '&'
            }
            if ($('#payOut').val() != '') {
                query += 'payOut=' + $('#payOut').val() + '&'
            }
            if ($('#gameCode').val() != '') {
                query += 'gameCode=' + $('#gameCode').val() + '&'
            }
            if ($('#betIp').val() != '') {
                query += 'betIp=' + $('#betIp').val() + '&'
            }
            if ($('#username').val() != '') {
                query += 'username=' + $('#username').val() + '&'
            }
            if ($('#maxItem').val() != '') {
                query += 'maxItem=' + $('#maxItem').val() + '&'
            }
            return query;
        }
    </script>