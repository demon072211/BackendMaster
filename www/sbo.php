<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>SBO</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="widget backaccount">
        <form class="list_filter form" action="<?php echo admin_url('loggamethirdparty/sbo') ?>" method="post">
            <div class="formRow row">
                <div class="col-sm-1">
                    <label for="giftCode">Nick name : </label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="nn" value="<?php echo $this->input->post('nn') ?>" name="nn">
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Từ ngày : </label>
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
                    <label for="giftCode">Đến ngày : </label>
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
                    <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB">
                </div>
                <div class="col-sm-1">
                    <input type="reset" onclick="window.location.href = '<?php echo admin_url('loggamethirdparty/sbo') ?>';" value="Reset" class="basic">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="float-right">Tổng đặt cược:<span style="color:#0000ff" id="totalBet"></span></h4>
                <h4 class="float-right"> Tổng đặt cược hợp lệ : <span style="color:#0000ff" id="totalValidBet"></span> | </h4>
                <h4 class="float-right"> Tổng thanh toán : <span style="color:#0000ff" id="totalPayout"></span> | </h4>
                <h4 class="float-right">Tổng số người chơi : <span style="color:#0000ff" id="totalPlayer"></span> | </h4>
            </div>
            <div class="col-sm-12">
                <h4 class="float-right">Tổng bản ghi:<span style="color:#0000ff" id="total"></span></h4>
            </div>
            <div class="col-sm-12">
                <div id="resultsearch" class="float-left text-danger"></div>
            </div>
        </div>
        <div class="formRow">
            <div class="row">
                <div class="col-xs-12">
                    <table id="checkAll" class="table table-bordered" style="">
                        <thead>
                        <tr style="height: 20px;">
                            <th>STT</th>
                            <th>nick_name</th>
                            <th>player_name</th>
                            <th>stake</th>
                            <th>odds</th>
                            <th>actualstake </th>
                            <th>winlose</th>
                            <th>payout</th>
                            <th>ordertime</th>
                            <th>betoption</th>
                            <th>currency</th>
                            <th>effective_bet</th>
                            <th>ftscore</th>
                            <th>hdp</th>
                            <th>htscore</th>
                            <th>ip</th>
                            <th>ishalfwonlose</th>
                            <th>islive</th>
                            <th>league</th>
                            <th>livescore</th>
                            <th>markettype</th>
                            <th>match</th>
                            <th>maxwin</th>
                            <th>modifydate</th>
                            <th>oddsstyle</th>
                            <th>refno</th>
                            <th>sporttype</th>
                            <th>status</th>
                            <th>turnover</th>
                            <th>valid_stake</th>
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
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: '<?= date("Y-m-d") . " 00:00:00"?>',
            useCurrent: false,
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: '<?= date("Y-m-d") . " 23:59:59"?>',
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
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + value.nick_name + "</td>";
        rs += "<td>" + value.player_name + "</td>";
        rs += "<td>" + value.stake + "</td>";
        rs += "<td>" + value.odds + "</td>";
        rs += "<td>" + value.actualstake + "</td>";
        rs += "<td>" + value.winlose + "</td>";
        rs += "<td>" + value.payout + "</td>";
        rs += "<td>" + value.ordertime + "</td>";
        rs += "<td>" + value.betoption + "</td>";
        rs += "<td>" + value.currency + "</td>";
        rs += "<td>" + value.effective_bet + "</td>";
        rs += "<td>" + value.ftscore + "</td>";
        rs += "<td>" + value.hdp + "</td>";
        rs += "<td>" + value.htscore + "</td>";
        rs += "<td>" + (value.ip || '')+ "</td>";
        rs += "<td>" + value.ishalfwonlose + "</td>";
        rs += "<td>" + value.islive + "</td>";
        rs += "<td>" + value.league + "</td>";
        rs += "<td>" + value.livescore + "</td>";
        rs += "<td>" + value.markettype + "</td>";
        rs += "<td>" + value.match + "</td>";
        rs += "<td>" + value.maxwinwithoutactualstakerecord + "</td>";
        rs += "<td>" + value.modifydate + "</td>";
        rs += "<td>" + value.oddsstyle + "</td>";
        rs += "<td>" + value.refno + "</td>";
        rs += "<td>" + value.sporttype + "</td>";
        rs += "<td>" + value.status + "</td>";
        rs += "<td>" + value.turnover + "</td>";
        rs += "<td>" + value.valid_stake + "</td>";
        return rs;
    }

    function initData() {
        var oldPage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('loggamethirdparty/sboAjax')?>",
            data: {
                nn: $("#nn").val(),
                ft: $("#fromDate").val(),
                et : $("#toDate").val(),
                pg : 1,
                size: page_size
            },
            dataType: 'json',
            success: function (response) {
                let result = JSON.parse(response.data);
                writeData(result);
                result.total = result.totalRecord;
                $("#total").html(result.total);
                $("#spinner").hide();

                if (result.total == 0) {
                    list_data = []
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    list_data = result.listTrans;
                    console.log(list_data);
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
                                    url: "<?php echo admin_url('loggamethirdparty/sboAjax')?>",
                                    data: {
                                        nn: $("#nn").val(),
                                        ft: $("#fromDate").val(),
                                        et : $("#toDate").val(),
                                        pages : page,
                                        size: page_size
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        let result = JSON.parse(response.data);
                                        writeData(result);
                                        list_data = result.listTrans;
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

    function writeData(data) {
        $('#totalPlayer').html(data.totalPlayer);
        $('#totalBet').html(data.totalBet);
        $('#totalValidBet').html(data.totalValidBet);
        $('#totalPayout').html(data.totalPayout);
    }
</script>
<style>
</style>