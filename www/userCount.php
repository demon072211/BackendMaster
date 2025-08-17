<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Số người chơi game</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="widget backaccount">
        <form class="list_filter form" action="<?php echo admin_url('report/userCount') ?>" method="post">
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
                    <input type="reset" onclick="window.location.href = '<?php echo admin_url('report/userCount') ?>';" value="Reset" class="basic">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="float-right">Tổng số người :<span style="color:#0000ff" id="total"></span></h3>
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
                        <tr >
                            <th>STT</th>
                            <th>nick_name</th>
                            <th>ag</th>
                            <th>bacay</th>
                            <th>baucua</th>
                            <th>caothap</th>
                            <th>cmd</th>
                            <th>ebet</th>
                            <th>fish</th>
                            <th>ibc</th>
                            <th>minipoker</th>
                            <th>sbo</th>
                            <th>slot_angrybird</th>
                            <th>slot_bikini</th>
                            <th>slot_bitcoin</th>
                            <th>slot_chiemtinh</th>
                            <th>slot_galaxy</th>
                            <th>slot_pokemon</th>
                            <th>slot_taydu</th>
                            <th>slot_thanbai</th>
                            <th>slot_thethao</th>
                            <th>taixiu</th>
                            <th>taixiu_st</th>
                            <th>tlmn</th>
                            <th>wm</th>
                            <th>xocdia</th>
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
    $(document).ready(function (){
        initData()
    })

    function resultList(stt, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td>" + value.nick_name + "</td>";
        rs += "<td>" + value.ag + "</td>";
        rs += "<td>" + value.bacay + "</td>";
        rs += "<td>" + value.baucua + "</td>";
        rs += "<td>" + value.caothap + "</td>";
        rs += "<td>" + value.cmd + "</td>";
        rs += "<td>" + value.ebet + "</td>";
        rs += "<td>" + value.fish + "</td>";
        rs += "<td>" + value.ibc + "</td>";
        rs += "<td>" + value.minipoker + "</td>";
        rs += "<td>" + value.sbo + "</td>";
        rs += "<td>" + value.slot_angrybird + "</td>";
        rs += "<td>" + value.slot_bikini + "</td>";
        rs += "<td>" + value.slot_bitcoin + "</td>";
        rs += "<td>" + value.slot_chiemtinh + "</td>";
        rs += "<td>" + value.slot_galaxy + "</td>";
        rs += "<td>" + value.slot_pokemon + "</td>";
        rs += "<td>" + value.slot_taydu + "</td>";
        rs += "<td>" + value.slot_thanbai + "</td>";
        rs += "<td>" + value.slot_thethao + "</td>";
        rs += "<td>" + value.taixiu + "</td>";
        rs += "<td>" + value.taixiu_st + "</td>";
        rs += "<td>" + value.tlmn + "</td>";
        rs += "<td>" + value.wm + "</td>";
        rs += "<td>" + value.xocdia + "</td>";
        return rs;
    }

    function initData() {
        var oldPage = 0;
        var result = "";
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/userCountAjax')?>",
            data: {
                nn: $('#nn').val(),
                ft: $('#fromDate').val(),
                et: $('#toDate').val(),
                pages : 1,
                size: page_size
            },
            dataType: 'json',
            success: function (response) {
                let result = response
                console.log(result);
                result.total = response.totalRecords
                $("#total").html(result.total);
                $("#spinner").hide();

                if (result.total == 0) {
                    list_data = []
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                }else {
                    list_data = result.data
                    $("#resultsearch").html("");
                    let totalPage = Math.floor(result.total/page_size) + (result.total%page_size?1:0);
                    stt = 1;
                    let str = ''
                    $.each(result.data, function (index, value) {
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
                                    url: "<?php echo admin_url('report/userCountAjax')?>",
                                    data: {
                                        nn: $('#nn').val(),
                                        ft: $('#fromDate').val(),
                                        et: $('#toDate').val(),
                                        pages : page,
                                        size: page_size
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        let result = response
                                        list_data = result.data
                                        $("#resultsearch").html("");
                                        $("#spinner").hide();
                                        stt = (page -1) * page_size + 1;
                                        let str = ''
                                        $.each(result.data, function (index, value) {
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
<script>
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
</script>