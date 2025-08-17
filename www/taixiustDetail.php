<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Log mini game</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>

    <div class="widget backaccount">
        <div class="title">
            <h6>Chi tiết tài xỉu siêu tốc :</h6>
        </div>

        <form class="list_filter form" action="<?= admin_url('logminigame/taixiustDetail') ?>" method="post">
            <div class="formRow row">
                <div class="col-sm-1">
                    <label for="giftCode">Từ ngày : </label>
                </div>
                <div class="col-sm-2">
                    <div class="input-group" id="frompicker">
                        <input type="text" id="fromDate" name="ft" value="<?php echo $this->input->post('ft') ?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Đến ngày : </label>
                </div>
                <div class="col-sm-2">
                    <div class="input-group" id="topicker">
                        <input type="text" id="toDate" name="et" value="<?php echo $this->input->post('et') ?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">nickname : </label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="nn" name="nn" value="<?php echo $this->input->post('nn') ?>">
                </div>
            </div>
            <div class="formRow row">
                <div class="col-sm-1">
                    <label for="giftCode">Trạng thái : </label>
                </div>
                <div class="col-sm-2">
                    <select id="st" name="st" class="money-type-2">
                        <option value="" <?php if($this->input->post('st') == ""){echo "selected";} ?>>Chọn</option>
                        <option value="1" <?php if($this->input->post('st') == "1"){echo "selected";} ?>>Active</option>
                        <option value="0" <?php if($this->input->post('st') == "0"){echo "selected";} ?>>Deactive</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <label for="giftCode">Bot / người chơi : </label>
                </div>
                <div class="col-sm-2">
                    <select id="user-type" name="ut" class="money-type-2">
                        <option value="" <?php if($this->input->post('ut') == ""){echo "selected";} ?>>Chọn</option>
                        <option value="1" <?php if($this->input->post('ut') == "1"){echo "selected";} ?>>Người chơi</option>
                        <option value="0" <?php if($this->input->post('ut') == "0"){echo "selected";} ?>>Bot</option>
                    </select>
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Cửa : </label>
                </div>
                <div class="col-sm-2">
                    <select id="type" name="t" class="money-type-2">
                        <option value="" <?php if($this->input->post('t') == ""){echo "selected";} ?>>Chọn</option>
                        <option value="1" <?php if($this->input->post('t') == "1"){echo "selected";} ?>>Tài</option>
                        <option value="0" <?php if($this->input->post('t') == "2"){echo "selected";} ?>>Xỉu</option>
                    </select>
                </div>
            </div>
            <div class="formRow row">
                <div class="col-sm-1">
                    <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB">
                </div>
                <div class="col-sm-1">
                    <input type="reset" onclick="window.location.href = '<?= admin_url('logminigame/taixiustDetail')?>';" value="Reset" class="basic">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="float-right"> | Tổng bản ghi:<span style="color:#0000ff" id="total"></span></h3>
                <h3 class="float-right">Tổng người chơi:<span style="color:#0000ff" id="totalPlayer"></span></h3>
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
                            <th>nickname</th>
                            <th>Tiền cược </th>
                            <th>Tiền thắng</th>
                            <th>Cửa</th>
                            <th>Thời gian cược</th>
                            <th>Trang thái</th>
                            <th>Kết quả</th>
                            <th>Mô tả</th>
                            <th>Hoàn trả</th>
                            <th>ip</th>
                            <th>Thời gian log</th>
                            <th>Bot/Người</th>
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
        var startDate = $('#fromDate').val();
        var endDate = $('#toDate').val();
        if (startDate > endDate) {
            alert("Ngày bắt đầu lớn hơn ngày kết thúc.");
        }
        initData();
    })

    function resultList(stt, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td>" + value.nickname + "</td>";
        rs += "<td>" + value.betAmount + "</td>";
        rs += "<td>" + value.winAmount + "</td>";
        rs += "<td>" + maskedType(value.typed) + "</td>";
        rs += "<td>" + value.betTime + "</td>";
        rs += "<td>" + value.status + "</td>";
        rs += "<td>" + value.result + "</td>";
        rs += "<td>" + value.description + "</td>";
        rs += "<td>" + value.refundAmount + "</td>";
        rs += "<td>" + maskedIp(value.ip) + "</td>";
        rs += "<td>" + maskUpdate(value.updateDate) + "</td>";
        rs += "<td>" + maskedUserType(value.userType) + "</td>";
        return rs;
    }

    function initData() {
        var oldPage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('logminigame/taixiustDetailAjax')?>",
            data: {
                et: $('#toDate').val(),
                ft: $('#fromDate').val(),
                st: $('#st').val(),
                t: $('#type').val(),
                ut: $('#user-type').val(),
                nn: $('#nn').val(),
                rid: "<?= empty($rid) ? '': $rid?>",
                pg : 1,
                mi: page_size
            },
            dataType: 'json',
            success: function (response) {
                let result = response
                result.total = response.totalRecords
                $("#total").html($.number(result.total, undefined, '.', ','));
                $("#totalPlayer").html($.number(result.data.totalPlayer, undefined, '.', ','));
                $("#spinner").hide();

                if (result.data == undefined) {
                    list_data = []
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                    return;
                }

                list_data = result.data.details
                $("#resultsearch").html("");
                var totalPage = Math.floor(result.total/page_size) + (result.total%page_size?1:0);
                console.log(Math.floor(result.total/page_size));
                console.log(result.total%page_size?1:0);
                stt = 1;
                let str = ''
                $.each(list_data, function (index, value) {
                    str += resultList(stt, value);
                    stt++;
                });
                $('#logaction').html(str);
                if (!totalPage) {
                    return;
                }
                $('#pagination-demo').twbsPagination({
                    totalPages: totalPage,
                    visiblePages: 5,
                    onPageClick: function (event, page) {
                        if (oldPage > 0) {
                            $("#spinner").show();
                            $.ajax({
                                type: "POST",
                                url: "<?php echo admin_url('logminigame/taixiustDetailAjax')?>",
                                data: {
                                    et: $('#toDate').val(),
                                    ft: $('#fromDate').val(),
                                    st: $('#st').val(),
                                    t: $('#type').val(),
                                    ut: $('#user-type').val(),
                                    nn: $('#nn').val(),
                                    rid: "<?= empty($rid) ? '': $rid?>",
                                    pg : page,
                                    mi: page_size
                                },
                                dataType: 'json',
                                success: function (response) {
                                    let result = response
                                    list_data = result.data.details
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

    function maskedType(val) {
        switch (val) {
            case 1:
                return 'Tài';
            case 2:
                return 'Xỉu';
            default:
                return val;
        }
    }

    function maskedUserType(val) {
        switch (val) {
            case 0:
                return 'Bot';
            case 1:
                return 'Người chơi';
            default:
                return val;
        }
    }

    function maskedIp(val) {
        switch (val) {
            case null:
                return '';
            default:
                return val;
        }
    }

    function maskUpdate(val) {
        if(val == null) {
            return '';
        }
        return val;
    }
</script>
<script>
    $('#frompicker').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: "<?= date('Y-m-d')?>"
    });
    $('#topicker').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: "<?= date('Y-m-d')?>"
    });
</script>
