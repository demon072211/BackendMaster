<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Báo cáo</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>

    <div class="widget backaccount">
        <div class="title">
            <h6>Người chơi mới</h6>
        </div>

        <form class="list_filter form" action="<?php echo admin_url('report/firstDeposit') ?>" method="post">
            <div class="formRow row">
                <div class="col-sm-1">
                    <label for="giftCode">Mã đại lý : </label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="code" value="<?php echo $this->input->post('code') ?>" name="code">
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Nick name : </label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="nn" value="<?php echo $this->input->post('nn') ?>" name="nn">
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Ngày : </label>
                </div>
                <div class="col-sm-2">
                    <div class="input-group date" id="datetimepicker2">
                        <input type="text" id="toDate" name="t" value="<?php echo $this->input->post('t') ?>">
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
                    <input type="reset" onclick="window.location.href = '<?php echo admin_url('report/firstDeposit') ?>';" value="Reset" class="basic">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="float-right">Tổng bản ghi:<span style="color:#0000ff" id="total"></span></h3>
            </div>
            <div class="col-sm-12">
                <div id="resultsearch" class="float-left text-danger"></div>
            </div>
        </div>
        <div class="formRow">
            <div class="row">
                <div class="col-xs-12">
                    <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                        <thead>
                        <tr style="height: 20px;">
                            <th style="width:40px">STT</th>
                            <th>Nick name</th>
                            <th>Số lần nạp</th>
                            <th>Mã đại lý</th>
                            <th>Thời gian</th>
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
        rs += "<td>" + value.nickName + "</td>";
        rs += "<td>" + value.depositCount + "</td>";
        rs += "<td>" + value.code + "</td>";
        rs += "<td>" + value.timeReport + "</td>";
        return rs;
    }

    function initData() {
        var oldPage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/firstDepositAjax')?>",
            data: {
                t: $('#toDate').val(),
                code: $('#code').val(),
                nn: $('#nn').val(),
                pg : 1,
                mi: page_size
            },
            dataType: 'json',
            success: function (response) {
                let result = response
                result.total = response.total
                $("#total").html(result.total);
                $("#spinner").hide();
                if (result.success === false) {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả.");
                    return;
                }
                if (result.data == undefined || result.data.length == 0) {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                    return;
                }
                list_data = result.data;
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
                                url: "<?php echo admin_url('report/firstDepositAjax')?>",
                                data: {
                                    t: $('#toDate').val(),
                                    code: $('#code').val(),
                                    nn: $('#nn').val(),
                                    pg : page,
                                    mi: page_size
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
    $('#toDate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: "<?= date('Y-m-d')?>"
    });
</script>
