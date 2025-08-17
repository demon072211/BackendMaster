
    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle">
                <h5>Log game thirdparty</h5>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="line"></div>

    <link rel="stylesheet"
          href="<?php echo public_url() ?>/site/css/loggamethirdparty.css">
    <?php if($role == false): ?>
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
                    <h6 class="total">Tổng Số người chơi:<span class="total-number" id="tong_player"></span></h6>
                </div>
                <form class="list_filter form" action="<?php echo admin_url('loggamethirdparty/ibc') ?>" method="post">
                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="flagtime-1">Flag time:</label></td>
                                <td><select style="width: 219px !important;" class="flagtime-2" id="flagtime" name="flagtime">
                                        <option value="1" <?php if($this->input->post('flagtime') == "1" || $this->input->get('flagtime') == "1"){echo "selected";} ?>>transactiontime</option>
                                        <option value="2" <?php if($this->input->post('flagtime') == "2" || $this->input->get('flagtime') == "2"){echo "selected";} ?>>matchdatetime</option>
                                        <option value="3" <?php if($this->input->post('flagtime') == "3" || $this->input->get('flagtime') == "3"){echo "selected";} ?>>winlostdatetime</option>
                                    </select></td>
                                <td><label class="money-type-1">Refund<br>amount:</label></td>
                                <td><input type="text" class="money-type-2"
                                           id="refundamount" value="<?= empty($this->input->get('refundamount')) ? $this->input->post('refundamount') : $this->input->get('refundamount')?>" name="refundamount"></td>
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
                                        <input type="text" id="fromDate" name="fromDate" value="<?= empty($this->input->get('fromDate')) ? $this->input->post('fromDate') : $this->input->get('fromDate')?>"> <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
    </span>
                                    </div>                            </td>
                                <td>
                                    <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>
                                </td>
                                <td class="item">

                                    <div class="input-group date" id="datetimepicker2">
                                        <input type="text" id="toDate" name="toDate" value="<?= empty($this->input->get('toDate')) ? $this->input->post('toDate') : $this->input->get('toDate')?>"> <span class="input-group-addon">
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
                                <td><label class="flagtime-1">Ticket status:</label></td>
                                <td><select style="width: 219px !important;" class="flagtime-2" id="ticketstatus" name="ticketstatus">
                                        <option value="" <?= ($this->input->post('ticketstatus') == "" || $this->input->get('ticketstatus') == "") ? "selected" : ''?>>All</option>
                                        <option value="finished" <?= ($this->input->post('ticketstatus') == "finished" || $this->input->get('ticketstatus') == "finished") ? "selected" : '' ?>>Finished</option>
                                        <option value="waiting" <?= ($this->input->post('ticketstatus') == "waiting" || $this->input->get('ticketstatus') == "waiting") ? "selected" : '' ?>>Waiting</option>
                                        <option value="running" <?= ($this->input->post('ticketstatus') == "running" || $this->input->get('ticketstatus') == "running") ? "selected" : '' ?>>Running</option>
                                        <option value="won" <?= ($this->input->post('ticketstatus') == "won" || $this->input->get('ticketstatus') == "won") ? "selected" : '' ?>>Won</option>
                                        <option value="lose" <?= ($this->input->post('ticketstatus') == "lose" || $this->input->get('ticketstatus') == "lose") ? "selected" : '' ?>>Lose</option>
                                        <option value="draw" <?= ($this->input->post('ticketstatus') == "draw" || $this->input->get('ticketstatus') == "draw") ? "selected" : '' ?>>Draw</option>
                                        <option value="reject" <?= ($this->input->post('ticketstatus') == "reject" || $this->input->get('ticketstatus') == "reject") ? "selected" : '' ?>>Reject</option>
                                        <option value="void" <?= ($this->input->post('ticketstatus') == "void" || $this->input->get('ticketstatus') == "void") ? "selected" : '' ?>>Void</option>
                                        <option value="half won" <?= ($this->input->post('ticketstatus') == "half won" || $this->input->get('ticketstatus') == "half won") ? "selected" : '' ?>>Half Won</option>
                                        <option value="half lose" <?= ($this->input->post('ticketstatus') == "half lose" || $this->input->get('ticketstatus') == "half lose") ? "selected" : '' ?>>Half Lose</option>
                                        <option value="refund" <?= ($this->input->post('ticketstatus') == "refund" || $this->input->get('ticketstatus') == "refund") ? "selected" : '' ?>>Refund</option>
                                    </select></td>
                                <td><label class="money-type-1">TransID:</label></td>
                                <td><input type="text" class="money-type-2"
                                           id="transid" value="<?= empty($this->input->get('transid')) ? $this->input->post('transid') : $this->input->get('transid') ?>" name="transid"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="session-1">MatchID:</label></td>
                                <td><input type="text" class="session-2"
                                           id="matchid" value="<?= empty($this->input->get('matchid')) ? $this->input->post('matchid') : $this->input->get('matchid')?>" name="matchid"></td>
                                <td><label class="money-type-1">HomeID:</label></td>
                                <td><input type="text" class="money-type-2"
                                           id="homeid" value="<?= empty($this->input->get('homeid')) ? $this->input->post('homeid') : $this->input->get('homeid') ?>" name="homeid"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="session-1">Stake:</label></td>
                                <td><input type="text" class="session-2"
                                           id="stake" value="<?= empty($this->input->get('stake')) ? $this->input->post('stake') : $this->input->get('stake')?>" name="stake"></td>
                                <td><label class="money-type-1">Winlose<br>amount:</label></td>
                                <td><input type="text" class="money-type-2"
                                           id="winloseamount" value="<?= empty($this->input->get('winloseamount')) ? $this->input->post('winloseamount') : $this->input->get('winloseamount') ?>" name="winloseamount"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="formRow">
                        <table>
                            <tr class="nickname">
                                <td><label>Nick name:</label></td>
                                <td><input type="text"
                                           id="nickName" value="<?= empty($this->input->get('nickName')) ? $this->input->post('nickName') : $this->input->get('nickName')?>" name="nickName"></td>
                                <td><label class="session-1">Player name:</label></td>
                                <td><input type="text" class="session-2"
                                           id="playername" value="<?= empty($this->input->get('playername')) ? $this->input->post('playername') : $this->input->get('playername')?>" name="playername"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="flagtime-1">Số dòng:</label></td>
                                <td><select class="flagtime-2" id="maxItem" name="maxItem">
                                        <option value="20" <?php if($this->input->post('maxItem') == "20" || $this->input->get('maxItem') == "20"){echo "selected";} ?>>20</option>
                                        <option value="50" <?php if($this->input->post('maxItem') == "50" ||  $this->input->get('maxItem') == "50"){echo "selected";} ?>>50</option>
                                        <option value="100" <?php if($this->input->post('maxItem') == "100" || $this->input->get('maxItem') == "100"){echo "selected";} ?>>100</option>
                                    </select></td>
                                <td style="">
                                    <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB search">
                                </td>
                                <td>
                                    <input type="reset"
                                           onclick="window.location.href = '<?php echo admin_url('loggamethirdparty/ibc') ?>'; "
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
                        <td>Transid</td>
                        <td>Nick_name</td>
                        <td>Playername</td>
                        <td>Odds</td>
                        <td>Stake</td>
                        <td>Actual_stake</td>
                        <td>Refund_amount</td>
                        <td>Winloseamount</td>
                        <td>Ticketstatus</td>
                        <td>Matchid</td>
                        <td>Leagueid</td>
                        <td>Time</td>
                        <td>Islive</td>
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
            url: "<?php echo admin_url('loggamethirdparty/ibcajax')?>",
            data: {
                nickName: $("#nickName").val(),
                playerName: $("#playername").val(),
                ticketStatus : $("#ticketstatus").val(),
                transID : $("#transid").val(),
                matchID : $("#matchid").val(),
                homeID : $("#homeid").val(),
                stake : $("#stake").val(),
                toDate: todate,
                fromDate: fromdate,
                flagTime: $("#flagtime").val(),
                winloseAmount : $("#winloseamount").val(),
                refundAmount : $("#refundamount").val(),
                page : 1,
                maxItem : $("#maxItem").val()
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
                                    url: "<?php echo admin_url('loggamethirdparty/ibcajax')?>",
                                    data: {
                                        nickName: $("#nickName").val(),
                                        playerName: $("#playername").val(),
                                        ticketStatus : $("#ticketstatus").val(),
                                        transID : $("#transid").val(),
                                        matchID : $("#matchid").val(),
                                        homeID : $("#homeid").val(),
                                        stake : $("#stake").val(),
                                        toDate: todate,
                                        fromDate: fromdate,
                                        flagTime: $("#flagtime").val(),
                                        winloseAmount : $("#winloseamount").val(),
                                        refundAmount : $("#refundamount").val(),
                                        page : page,
                                        maxItem : $("#maxItem").val()
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
            let date1 = new Date(value.transactiontime);
            let transactiontime = String(date1.getFullYear()).padStart(2, "0") + '-' + String(date1.getMonth() + 1).padStart(2, "0") + '-' + String(date1.getDate()).padStart(2, "0") + ' ' + String(date1.getHours()).padStart(2, "0") + ':' + String(date1.getMinutes()).padStart(2, "0") + ':' + String(date1.getSeconds()).padStart(2, "0");
            let date2 = new Date(value.matchdatetime);
            let matchdatetime = String(date2.getFullYear()).padStart(2, "0") + '-' + String(date2.getMonth() + 1).padStart(2, "0") + '-' + String(date2.getDate()).padStart(2, "0") + ' ' + String(date2.getHours()).padStart(2, "0") + ':' + String(date2.getMinutes()).padStart(2, "0") + ':' + String(date2.getSeconds()).padStart(2, "0");
            let date3 = new Date(value.winlostdatetime);
            let winlostdatetime = String(date3.getFullYear()).padStart(2, "0") + '-' + String(date3.getMonth() + 1).padStart(2, "0") + '-' + String(date3.getDate()).padStart(2, "0") + ' ' + String(date3.getHours()).padStart(2, "0") + ':' + String(date3.getMinutes()).padStart(2, "0") + ':' + String(date3.getSeconds()).padStart(2, "0");
            var rs = "";
            rs += "<tr>";
            rs += "<td>" + stt + "</td>";
            rs += "<td><a class='text-success' href='<?= admin_url('loggamethirdparty/ibcDetail') . '/'?>" + value.transid + query() + "'>" + value.transid + "</a></td>";
            rs += "<td title='" + value.nick_name + "'>" + value.nick_name + "</td>";
            rs += "<td>" + value.playername + "</td>";
            rs += "<td>" + value.odds + "</td>";
            rs += "<td>" + value.stake + "</td>";
            rs += "<td>" + value.actual_stake + "</td>";
            rs += "<td>" + value.refund_amount + "</td>";
            rs += "<td>" + value.winloseamount + "</td>";
            rs += "<td>" + value.ticketstatus + "</td>";
            rs += "<td>" + value.matchid + "</td>";
            rs += "<td>" + value.leagueid + "</td>";
            var flagtime = $('#flagtime').val();
            switch (flagtime) {
                case '1':
                    rs += "<td title='" + transactiontime + "'>" + transactiontime + "</td>";
                    break;
                case '2':
                    rs += "<td title='" + matchdatetime + "'>" + matchdatetime + "</td>";
                    break;
                case '3':
                    rs += "<td title='" + winlostdatetime + "'>" + winlostdatetime + "</td>";
                    break;
            }
            rs += "<td>" + value.islive + "</td>";
            rs += "</tr>";
            return rs;
        }
        function query() {
            let query = '?';
            if ($('#flagtime').val() != '') {
                query += 'flagtime=' + $('#flagtime').val() + '&'
            }
            if ($('#refundamount').val() != '') {
                query += 'refundamount=' + $('#refundamount').val() + '&'
            }
            if ($('#fromDate').val() != '') {
                query += 'fromDate=' + $('#fromDate').val() + '&'
            }
            if ($('#toDate').val() != '') {
                query += 'toDate=' + $('#toDate').val() + '&'
            }
            if ($('#ticketstatus').val() != '') {
                query += 'ticketstatus=' + $('#ticketstatus').val() + '&'
            }
            if ($('#transid').val() != '') {
                query += 'transid=' + $('#transid').val() + '&'
            }
            if ($('#matchid').val() != '') {
                query += 'matchid=' + $('#matchid').val() + '&'
            }
            if ($('#homeid').val() != '') {
                query += 'homeid=' + $('#homeid').val() + '&'
            }
            if ($('#stake').val() != '') {
                query += 'stake=' + $('#stake').val() + '&'
            }
            if ($('#winloseamount').val() != '') {
                query += 'winloseamount=' + $('#winloseamount').val() + '&'
            }
            if ($('#nickName').val() != '') {
                query += 'nickName=' + $('#nickName').val() + '&'
            }
            if ($('#playername').val() != '') {
                query += 'playername=' + $('#playername').val() + '&'
            }
            if ($('#maxItem').val() != '') {
                query += 'maxItem=' + $('#maxItem').val() + '&'
            }
            return query;
        }
    </script>