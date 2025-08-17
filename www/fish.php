<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Bắn cá</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="widget backaccount">
        <form class="list_filter form" action="<?php echo admin_url('loggamethirdparty/fish') ?>" method="post">
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
                    <input type="reset" onclick="window.location.href = '<?php echo admin_url('loggamethirdparty/fish') ?>';" value="Reset" class="basic">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="float-right"> | Tổng bản ghi:<span style="color:#0000ff" id="total"></span></h3>
                <h3 class="float-right">Tổng người chơi:<span style="color:#0000ff" id="players"></span></h3>
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
                            <th style="width:40px">STT</th>
                            <th style=>aid </th>
                            <th>betcoin</th>
                            <th>bp</th>
                            <th>choushui</th>
                            <th>codeamount</th>
                            <th>coin</th>
                            <th>coinenter</th>
                            <th>coinquit</th>
                            <th>gameno</th>
                            <th>grade</th>
                            <th>groups</th>
                            <th>coin</th>
                            <th>muid</th>
                            <th>roomid</th>
                            <th>sync</th>
                            <th>uid</th>
                            <th>wlcoin</th>
                            <th>endtime</th>
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
        rs += "<td>" + value.aid + "</td>";
        rs += "<td>" + value.betcoin + "</td>";
        rs += "<td>" + value.bp + "</td>";
        rs += "<td>" + value.choushui + "</td>";
        rs += "<td>" + value.codeamount + "</td>";
        rs += "<td>" + value.coin + "</td>";
        rs += "<td>" + value.coinenter + "</td>";
        rs += "<td>" + value.coinquit + "</td>";
        rs += "<td>" + value.gameno + "</td>";
        rs += "<td>" + value.grade + "</td>";
        rs += "<td>" + value.groups + "</td>";
        rs += "<td>" + value.coin + "</td>";
        rs += "<td>" + value.muid + "</td>";
        rs += "<td>" + value.roomid + "</td>";
        rs += "<td>" + value.sync + "</td>";
        rs += "<td>" + value.uid + "</td>";
        rs += "<td>" + value.wlcoin + "</td>";
        rs += "<td>" + value.endtime + "</td>";
        return rs;
    }

    function initData() {
        var oldPage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('loggamethirdparty/fishAjax')?>",
            data: {
                nn: $("#nn").val(),
                ft: $("#fromDate").val(),
                et : $("#toDate").val(),
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
                }
                $("#spinner").hide();

                if (result.total == 0) {
                    list_data = []
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    list_data = result.data.fishgamerecords;
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
                                    url: "<?php echo admin_url('loggamethirdparty/fishAjax')?>",
                                    data: {
                                        nn: $("#nn").val(),
                                        ft: $("#fromDate").val(),
                                        et : $("#toDate").val(),
                                        pages : page,
                                        size: page_size
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        list_data = response.data.fishgamerecords
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