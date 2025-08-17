
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
                    <h6 class="total">Tổng Số người chơi:<span class="total-number" id="tong_player"></span></h6>
                </div>
                <form class="list_filter form" action="<?php echo admin_url('loggamethirdparty/wm') ?>" method="post">
                    <div class="formRow">

                        <table>
                            <tr>
                                <td><label class="flagtime-1">Flag time:</label></td>
                                <td><select class="flagtime-2" id="flagtime" name="flagtime">
                                        <option value="1" <?= ($this->input->post('flagtime') == "1" || $this->input->get('flagtime') == "1") ? "selected" : '' ?>>bettime</option>
                                        <option value="2" <?= ($this->input->post('flagtime') == "2" || $this->input->get('flagtime') == "2") ? "selected" : ''  ?>>settime</option>
                                        <option value="3" <?= ($this->input->post('flagtime') == "3" || $this->input->get('flagtime') == "3") ? "selected" : '' ?>>rootbettime</option>
                                        <option value="4" <?= ($this->input->post('flagtime') == "4" || $this->input->get('flagtime') == "4") ? "selected" : '' ?>>rootsettime</option>
                                    </select></td>
                                <td><label class="money-type-1">Nick Name:</label></td>
                                <td><input type="text" class="money-type-2"
                                           id="nickName" value="<?= empty($this->input->get('nickName')) ? $this->input->post('nickName') : $this->input->get('nickName') ?>" name="nickName"></td>

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
                                <td><label class="session-1">User:</label></td>
                                <td><input type="text" class="session-2"
                                           id="userId" value="<?= empty($this->input->get('userId')) ? $this->input->post('userId') : $this->input->get('userId')?>" name="userId"></td>
                                <td><label class="money-type-1">Bet Id:</label></td>
                                <td><input type="text" class="money-type-2"
                                           id="betId" value="<?= empty($this->input->get('betId')) ? $this->input->post('betId') : $this->input->get('betId') ?>" name="betId"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="flagtime-1">Game Name:</label></td>
                                <td><select class="flagtime-2" id="gameName" name="gameName">
                                        <option value="" <?= ($this->input->post('gameName') == "" || $this->input->get('gameName') == "" ) ? "selected" : "" ?>>All</option>
                                        <option value="Baccarat" <?= ($this->input->post('gameName') == "Baccarat" || $this->input->get('gameName') == "Baccarat" ) ? "selected" : "" ?>>Baccarat</option>
                                        <option value="Dragon and Tiger" <?= ($this->input->post('gameName') == "Dragon and Tiger" || $this->input->get('gameName') == "Dragon and Tiger" ) ? "selected" : "" ?>>Dragon and Tiger</option>
                                        <option value="Roulette" <?= ($this->input->post('gameName') == "Roulette" || $this->input->get('gameName') == "Roulette" ) ? "selected" : "" ?>>Roulette</option>
                                        <option value="Sic Bo" <?= ($this->input->post('gameName') == "Sic Bo" || $this->input->get('gameName') == "Sic Bo" ) ? "selected" : "" ?>>Sic Bo</option>
                                        <option value="NiuNiu" <?= ($this->input->post('gameName') == "NiuNiu" || $this->input->get('gameName') == "NiuNiu" ) ? "selected" : "" ?>>NiuNiu</option>
                                        <option value="SamGong" <?= ($this->input->post('gameName') == "SamGong" || $this->input->get('gameName') == "SamGong" ) ? "selected" : "" ?>>SamGong</option>
                                        <option value="Fantan" <?= ($this->input->post('gameName') == "Fantan" || $this->input->get('gameName') == "Fantan" ) ? "selected" : "" ?>>Fantan</option>
                                        <option value="Sedie" <?= ($this->input->post('gameName') == "Sedie" || $this->input->get('gameName') == "Sedie" ) ? "selected" : "" ?>>Sedie</option>
                                        <option value="Fish Shrimp Crab" <?= ($this->input->post('gameName') == "Fish Shrimp Crab" || $this->input->get('gameName') == "Fish Shrimp Crab" ) ? "selected" : "" ?>>Fish Shrimp Crab</option>
                                        <option value="Golden Flower" <?= ($this->input->post('gameName') == "Golden Flower" || $this->input->get('gameName') == "Golden Flower" ) ? "selected" : "" ?>>Golden Flower</option>
                                        <option value="Wenzhou Pai Gow" <?= ($this->input->post('gameName') == "Wenzhou Pai Gow" || $this->input->get('gameName') == "Wenzhou Pai Gow" ) ? "selected" : "" ?>>Wenzhou Pai Gow</option>
                                        <option value="Mahjong Tiles" <?= ($this->input->post('gameName') == "Mahjong Tiles" || $this->input->get('gameName') == "Mahjong Tiles" ) ? "selected" : "" ?>>Mahjong Tiles</option>
                                    </select></td>
                                <td><label class="money-type-1">Ip:</label></td>
                                <td><input type="text" class="money-type-2"
                                           id="userIp" value="<?= empty($this->input->get('userIp')) ? $this->input->post('userIp') : $this->input->get('userIp')?>" name="userIp"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="formRow">
                        <table>
                            <tr>
                                <td><label class="flagtime-1">Số dòng:</label></td>
                                <td><select class="flagtime-2" id="maxItem" name="maxItem">
                                        <option value="20" <?= ($this->input->post('maxItem') == "20" || $this->input->get('maxItem') == "20") ? "selected" : "" ?>>20</option>
                                        <option value="50" <?= ($this->input->post('maxItem') == "50" || $this->input->get('maxItem') == "50") ? "selected" : "" ?>>50</option>
                                        <option value="100" <?= ($this->input->post('maxItem') == "100" || $this->input->get('maxItem') == "100") ? "selected" : "" ?>>100</option>
                                    </select></td>
                                <td style="">
                                    <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB search">
                                </td>
                                <td>
                                    <input type="reset"
                                           onclick="window.location.href = '<?php echo admin_url('loggamethirdparty/wm') ?>'; "
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
                        <td>betid</td>
                        <td>nickname</td>
                        <td>user</td>
                        <td>bet</td>
                        <td>validbet</td>
                        <td>winloss</td>
                        <td>time</td>
                        <td>gamename</td>
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
            url: "<?php echo admin_url('loggamethirdparty/wmajax')?>",
            data: {
                nickName: $("#nickName").val(),
                userId: $("#userId").val(),
                betId: $("#betId").val(),
                userIp: $("#userIp").val(),
                gameName: $("#gameName").val(),
                toDate: todate,
                fromDate: fromdate,
                flagTime: $("#flagtime").val(),
                page: 1,
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
                    let    result = JSON.parse(response.data);
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
                                    url: "<?php echo admin_url('loggamethirdparty/wmajax')?>",
                                    data: {
                                        nickName: $("#nickName").val(),
                                        userId: $("#userId").val(),
                                        betId: $("#betId").val(),
                                        userIp: $("#userIp").val(),
                                        gameName: $("#gameName").val(),
                                        toDate: todate,
                                        fromDate: fromdate,
                                        flagTime: $("#flagtime").val(),
                                        page: page,
                                        maxItem: $("#maxItem").val()
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                            result = JSON.parse(response.data);
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
            rs += "<td><a href='<?= admin_url('loggamethirdparty/wmDetail') . '/'?>" + value.betid + query() +"' class='text-success'>" + value.betid + "</a></td>";
            rs += "<td>" + value.loginname + "</td>";
            rs += "<td>" + value.user + "</td>";
            rs += "<td>" + value.bet + "</td>";
            rs += "<td>" + value.validbet + "</td>";
            rs += "<td>" + value.winloss + "</td>";
            var flagtime = $('#flagtime').val();
            switch (flagtime) {
                case '1':
                    rs += "<td>" + value.bettime + "</td>";
                    break;
                case '2':
                    rs += "<td>" + value.settime + "</td>";
                    break;
                case '3':
                    rs += "<td>" + value.rootbettime + "</td>";
                    break;
                case '4':
                    rs += "<td>" + value.rootsettime + "</td>";
                    break;
            }
            rs += "<td>" + value.gamename + "</td>";
            rs += "</tr>";
            return rs;
        }

        function query() {
            let query = '?';
            if ($('#flagtime').val() != '') {
                query += 'flagtime=' + $('#flagtime').val() + '&'
            }
            if ($('#nickName').val() != '') {
                query += 'nickName=' + $('#nickName').val() + '&'
            }
            if ($('#fromDate').val() != '') {
                query += 'fromDate=' + $('#fromDate').val() + '&'
            }
            if ($('#toDate').val() != '') {
                query += 'toDate=' + $('#toDate').val() + '&'
            }

            if ($('#userId').val() != '') {
                query += 'userId=' + $('#userId').val() + '&'
            }
            if ($('#betId').val() != '') {
                query += 'betId=' + $('#betId').val() + '&'
            }

            if ($('#gameName').val() != '') {
                query += 'gameName=' + $('#gameName').val() + '&'
            }
            if ($('#userIp').val() != '') {
                query += 'userIp=' + $('#userIp').val() + '&'
            }
            if ($('#maxItem').val() != '') {
                query += 'maxItem=' + $('#maxItem').val() + '&'
            }
            return query;
        }
    </script>