<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Quản lý đại lý</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>

    <div class="widget backaccount">
        <div class="title">
            <h6>Danh sách lợi nhuận đại lý</h6>
        </div>

        <form class="list_filter form" action="<?= admin_url('userAgency/profit')?>" method="post">
            <div class="formRow row">
                <div class="col-sm-1">
                    <label for="giftCode" class="">Mã đại lý : </label>
                </div>
                <div class="col-sm-2">
                    <input class="" type="text" id="code" value="<?= $this->input->post('code') ?>" name="code">
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Tháng : </label>
                </div>
                <div class="col-sm-2">
                    <select class="form-control" id="month" name="month" value="<?= $this->input->post('month') ?>">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= $i?>" <?php if($i == $this->input->post('month')  || $i == date("m")) {echo "selected";}?>>Tháng <?= $i?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Năm:</label>
                </div>
                <div class="col-sm-2">
                    <select class="form-control" id="year" name="year" value="<?= $this->input->post('year') ?>">
                        <?php for ($i = 2019; $i <= 2023; $i++) { ?>
                            <option value="<?= $i?>" <?php if($i == $this->input->post('year') || $i == date("Y")) {echo "selected";}?>><?= $i?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="formRow row">
                <div class="col-sm-1">
                    <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB">
                </div>
                <div class="col-sm-1">
                    <input type="reset" onclick="window.location.href = '<?= admin_url('userAgency/profit') ?>';" value="Reset" class="basic">
                </div>
            </div>
        </form>
        <div class="row">
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
                    <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                        <thead>
                        <tr style="height: 20px;">
                            <th>STT</th>
                            <th>Tên đại lý</th>
                            <th>Code</th>
                            <th>Tổng nạp</th>
                            <th>Tổng rút</th>
                            <th>Tổng hoàn trả</th>
                            <th>Tổng khuyến mại</th>
                            <th>Phí</th>
                            <th>Lợi nhuận</th>
                            <th>Hoa hồng</th>
                            <th>Số thành viên hoạt động</th>
                            <th>Ngày đăng ký</th>
                        </tr>
                        </thead>
                        <tbody id="logaction">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered" style="table-layout: fixed">
                    <thead>
                    <tr style="height: 20px;">
                        <th>Tổng thuộc đại lý:</th>
                        <th>Tổng nạp</th>
                        <th>Tổng rút</th>
                        <th>Tổng hoàn trả</th>
                        <th>Tổng khuyến mại</th>
                        <th>Phí</th>
                        <th>Lợi nhuận</th>
                        <th>Hoa hồng</th>
                        <th>Số thành viên hoạt động</th>
                    </tr>
                    </thead>
                    <tr style="height: 20px;">
                        <th></th>
                        <th id="ag-totalDeposit"></th>
                        <th id="ag-totalWithdraw"></th>
                        <th id="ag-totalFund"></th>
                        <th id="ag-totalBonus"></th>
                        <th id="ag-totalFeeGameThrd"></th>
                        <th id="ag-toalProfit"></th>
                        <th id="ag-totalCommission"></th>
                        <th id="ag-memberActives"></th>
                    </tr>
                    <tbody>
                    <tr style="height: 20px;">
                        <th>Tổng không thuộc đại lý:</th>
                        <th>Tổng nạp</th>
                        <th>Tổng rút</th>
                        <th>Tổng hoàn trả</th>
                        <th>Tổng khuyến mại</th>
                        <th>Phí</th>
                        <th>Lợi nhuận</th>
                        <th>Hoa hồng</th>
                        <th>Số thành viên hoạt động</th>
                    </tr>
                    <tr style="height: 20px;">
                        <th></th>
                        <th id="free-totalDeposit"></th>
                        <th id="free-totalWithdraw"></th>
                        <th id="free-totalFund"></th>
                        <th id="free-totalBonus"></th>
                        <th id="free-totalFeeGameThrd"></th>
                        <th id="free-toalProfit"></th>
                        <th id="free-totalCommission"></th>
                        <th id="free-memberActives"></th>
                    </tr>
                    </tbody>
                </table>
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
<div class="container">

</div>
<script>
    var page_size = '<?= $this->input->post('page_size') ?>' || 10
    var list_data =[]
    $(document).ready(function (){
        initData()
    })
    function resultList(stt, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td>" + value.nameAgent + "</td>";
        rs += "<td>" + value.code + "</td>";
        rs += "<td>" + value.totalDeposit + "</td>";
        rs += "<td>" + value.totalWithdraw + "</td>";
        rs += "<td>" + value.totalFund + "</td>";
        rs += "<td>" + value.totalBonus + "</td>";
        rs += "<td>" + value.feeGameThrd + "</td>";
        rs += "<td>" + value.profit + "</td>";
        rs += "<td>" + value.commission + "</td>";
        rs += "<td>" + value.memberActives + "</td>";
        rs += "<td>" + value.createTime + "</td>";
        return rs;
    }

    function writeTotal(response) {
        if (typeof(response.data) != "undefined" && typeof(response.data[0]) != "undefined" && typeof(response.data[0].sumaryAgency) != "undefined") {
            let agency = response.data[0].sumaryAgency;
            $('#ag-totalDeposit').html(agency.totalDeposit);
            $('#ag-totalWithdraw').html(agency.totalWithdraw);
            $('#ag-totalFeeGameThrd').html(agency.totalFeeGameThrd);
            $('#ag-totalBonus').html(agency.totalBonus);
            $('#ag-totalFund').html(agency.totalFund);
            $('#ag-totalCommission').html(agency.totalCommission);
            $('#ag-toalProfit').html(agency.toalProfit);
            $('#ag-memberActives').html(agency.memberActives);
        }

        if (typeof(response.data) != "undefined" && typeof(response.data[1]) != "undefined" && typeof(response.data[1].sumaryNotAgency) != "undefined") {
            let freeAgency = response.data[1].sumaryNotAgency;
            $('#free-totalDeposit').html(freeAgency.totalDeposit);
            $('#free-totalWithdraw').html(freeAgency.totalWithdraw);
            $('#free-totalFeeGameThrd').html(freeAgency.totalFeeGameThrd);
            $('#free-totalBonus').html(freeAgency.totalBonus);
            $('#free-totalFund').html(freeAgency.totalFund);
            $('#free-totalCommission').html(freeAgency.totalCommission);
            $('#free-toalProfit').html(freeAgency.toalProfit);
            $('#free-memberActives').html(freeAgency.memberActives);
        }
    }

    function initData() {
        var oldPage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('userAgency/profitAjax')?>",
            data: {
                month: $('#month').val(),
                year: $('#year').val(),
                code: $('#code').val(),
                pages : 1,
                size: page_size
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                var totalRecords = response.total
                $("#total").html(totalRecords);
                writeTotal(response);
                $("#spinner").hide();
                if (totalRecords == 0) {
                    list_data = []
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                    return;
                }

                list_data = response.data[2].agencies;
                $("#resultsearch").html("");
                let totalPage = Math.floor(totalRecords/page_size) + (totalRecords%page_size?1:0);
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
                                url: "<?= admin_url('userAgency/profitAjax')?>",
                                data: {
                                    month: $('#month').val(),
                                    year: $('#year').val(),
                                    code: $('#code').val(),
                                    pages : page,
                                    size: page_size
                                },
                                dataType: 'json',
                                success: function (response) {
                                    $("#total").html(response.total);
                                    writeTotal(response);
                                    list_data = response.data[2].agencies;
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
            }, error: function () {
                list_data = []
                $("#spinner").hide();
                $('#logaction').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            },timeout : 20000
        })

    };

    $('#date').datetimepicker({
        format: 'YYYY-MM',
        defaultDate: "<?= date('Y-m')?>"
    });
</script>
<style>
    .border-danger {
        color: #dc3545;
    }
</style>