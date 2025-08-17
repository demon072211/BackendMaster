<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Ebet</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="widget backaccount">
        <form class="list_filter form" action="<?php echo admin_url('loggamethirdparty/ebet') ?>" method="post">
            <div class="formRow row">
                <div class="col-sm-1">
                    <label for="giftCode">Nick name : </label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="nn" value="<?php echo $this->input->post('nn') ?>" name="nn">
                </div>


            </div>
            <div class="formRow row">
                <div class="col-sm-1">
                    <label for="giftCode">Flag type : </label>
                </div>
                <div class="col-sm-2">
                    <div class="input-group">
                        <select id="fgt" name="fgt">
                            <option value="1" <?= ($this->input->post('fgt') == 1) ? 'selected' : '' ?>>createtime</option>
                            <option value="2" <?= ($this->input->post('fgt') == 2) ? 'selected' : '' ?>>payouttime</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Từ ngày : </label>
                </div>
                <div class="col-sm-3">
                    <div class="input-group" id="datetimepicker1">
                        <input type="text" id="fromDate" name="fromDate" value="<?php echo $this->input->post('fromDate') ?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-1">
                    <label for="giftCode">Đến ngày : </label>
                </div>
                <div class="col-sm-3">
                    <div class="input-group" id="datetimepicker2">
                        <input type="text" id="toDate" name="toDate" value="<?php echo $this->input->post('toDate') ?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="formRow row">
                <div class="col-sm-1">
                    <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB">
                </div>
                <div class="col-sm-1">
                    <input type="reset" onclick="window.location.href = '<?php echo admin_url('loggamethirdparty/ebet') ?>';" value="Reset" class="basic">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="float-right"> | Tổng bản ghi:<span style="color:#0000ff" id="total"></span></h3>
                <h3 class="float-right"> | Tổng người chơi:<span style="color:#0000ff" id="players"></span></h3>
                <h3 class="float-right"> | Tổng cược:<span style="color:#0000ff" id="bet"></span></h3>
                <h3 class="float-right">Tổng cược hợp lệ:<span style="color:#0000ff" id="valid-bet"></span></h3>
            </div>
            <div class="col-sm-12">
                <div id="resultsearch" class="float-left text-danger"></div>
            </div>
        </div>
        <div class="formRow">
            <div class="row">
                <div class="col-xs-12">
                    <table id="checkAll" class="table table-bordered">
                        <thead>
                        <tr style="height: 20px;">
                            <th>STT</th>
                            <th>nick_name </th>
                            <th>userid</th>
                            <th>validbet</th>
                            <th>tigercard</th>
                            <th>roundno</th>
                            <th>playercards</th>
                            <th>platform</th>
                            <th>payouttime</th>
                            <th>payout</th>
                            <th>judgeresult</th>
                            <th>gametype</th>
                            <th>gamename</th>
                            <th>ebetnumber</th>
                            <th>dragoncard</th>
                            <th>createtime</th>
                            <th>bethistoryid</th>
                            <th>bet</th>
                            <th>bankercards</th>
                            <th>alldices</th>
                            <th>ebetid</th>
                        </tr>
                        </thead>
                        <tbody id="logaction">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>
<script>
    var page_size = '<?php echo $this->input->post('page_size') ?>' || 10
    var list_data =[]
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: '<?= date("Y-m-d", strtotime('-30 days'))?>',
            useCurrent: false,
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: '<?= date("Y-m-d")?>',
            useCurrent: false,
        });
        if ($("#fromDate").val() > $("#toDate").val()) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }
        initData()
    })
    function resultList(stt, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td>" + value.nick_name + "</td>";
        rs += "<td>" + value.userid + "</td>";
        rs += "<td>" + value.validbet + "</td>";
        rs += "<td>" + value.tigercard + "</td>";
        rs += "<td>" + value.roundno + "</td>";
        rs += "<td>" + value.playercards + "</td>";
        rs += "<td>" + value.platform + "</td>";
        rs += "<td>" + value.payouttime + "</td>";
        rs += "<td>" + value.payout + "</td>";
        rs += "<td>" + value.judgeresult + "</td>";
        rs += "<td>" + value.gametype + "</td>";
        rs += "<td>" + value.gamename + "</td>";
        rs += "<td>" + value.ebetnumber + "</td>";
        rs += "<td>" + value.dragoncard + "</td>";
        rs += "<td>" + value.createtime + "</td>";
        rs += "<td>" + value.bethistoryid + "</td>";
        rs += "<td>" + value.bet + "</td>";
        rs += "<td>" + value.bankercards + "</td>";
        rs += "<td>" + value.alldices + "</td>";
        rs += "<td>" + value.ebetid + "</td>";
        return rs;
    }

    function initData() {
        var oldPage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('loggamethirdparty/ebetAjax')?>",
            data: {
                nn: $("#nn").val(),
                ft: $("#fromDate").val(),
                et : $("#toDate").val(),
                fgt : $("#fgt").val(),
                pg : 1,
                size: page_size
            },
            dataType: 'json',
            success: function (response) {
                let result = response

                result.total = response.totalRecords
                $("#total").html(result.total);
                if (result.total) {
                    $("#players").html(result.data.totalPlayer);
                    $("#bet").html($.number(result.data.totalBet, undefined, '.', ','));
                    $("#valid-bet").html($.number(result.data.totalValidbet, undefined, '.', ','));
                }
                $("#spinner").hide();

                if (result.total == 0) {
                    list_data = []
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    list_data = result.data.ebetrecords;
                    $("#resultsearch").html("");
                    let totalPage = Math.floor(result.total/page_size) + (result.total%page_size?1:0);
                    stt = 1;
                    let str = ''
                    $.each(list_data, function (index, value) {
                        str += resultList(stt, value);
                        stt++;
                    });
                    $('#logaction').html(str);

                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if (oldPage > 0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('loggamethirdparty/ebetAjax')?>",
                                    data: {
                                        nn: $("#nn").val(),
                                        ft: $("#fromDate").val(),
                                        et : $("#toDate").val(),
                                        fgt : $("#fgt").val(),
                                        pages : page,
                                        size: page_size
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        list_data = response.data.ebetrecords
                                        $("#resultsearch").html("");
                                        $("#spinner").hide();
                                        stt = (page -1) * page_size + 1;
                                        let str = ''
                                        $.each(list_data, function (index, value) {
                                            str += resultList(stt, value);
                                            stt++;
                                        });
                                        $('#logaction').html(str);
                                    }, error: function () {
                                        list_data = []
                                        $("#spinner").hide();
                                        $('#logaction').html("");
                                        $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                                    },timeout : 20000
                                });
                            }
                            oldPage = page;
                        }
                    });
                }

            }, error: function () {
                list_data = []
                $("#spinner").hide();
                $('#logaction').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            },timeout : 20000
        })
    };
</script>
<style>
</style>