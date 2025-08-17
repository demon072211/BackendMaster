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
            <h6>Danh sách user thuộc đại lý</h6>
        </div>

        <form class="list_filter form" action="<?= admin_url('userAgency/player')?>" method="post">
            <div class="formRow row">
                <div class="col-sm-2">
                    <label for="giftCode">Nick name : </label>
                </div>
                <div class="col-sm-3">
                    <input type="text" id="nn" value="<?php echo $this->input->post('nn') ?>" name="nn">
                </div>

                <div class="col-sm-2">
                    <label for="giftCode" class="">Mã đại lý : </label>
                </div>
                <div class="col-sm-3">
                    <input class="" type="text" id="cd" value="<?= empty($cd) ? $this->input->post('cd') : $cd ?>" name="cd">
                </div>
            </div>
            <div class="formRow row">
                <div class="col-sm-2">
                    <label for="giftCode">Từ ngày : </label>
                </div>
                <div class="col-sm-3">
                    <div class="input-group" id="datetimepicker1">
                        <input type="text" id="from-date" name="ft" value="<?php echo $this->input->post('ft') ?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-sm-2">
                    <label for="giftCode">Đến ngày : </label>
                </div>
                <div class="col-sm-3">
                    <div class="input-group" id="datetimepicker2">
                        <input type="text" id="end-date" name="et" value="<?php echo $this->input->post('et') ?>">
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
                    <input type="reset" onclick="window.location.href = '<?= admin_url('userAgency/player') . "?cd=$cd" ?>';" value="Reset" class="basic">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="float-right">Tổng bản ghi:<span style="color:#0000ff" id="total"></span></h4>
                <h4 class="float-right"> Tổng khuyến mại : <span style="color:#0000ff" id="khuyenmai"></span> | </h4>
                <h4 class="float-right">Tổng nạp : <span style="color:#0000ff" id="tongnap"></span> | </h4>
                <h4 class="float-right">Tổng rút : <span style="color:#0000ff" id="tongrut"></span> | </h4>
                <h4 class="float-right">Tổng doanh thu : <span style="color:#0000ff" id="doanhthu"></span> | </h4>
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
                                <th>Nick name </th>
                                <th>Số dư</th>
                                <th>Số tiền rút</th>
                                <th>Số tiền nạp</th>
                                <th>Ngày đăng ký</th>
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
    var page_size = '<?= $this->input->post('page_size') ?>' || 10
    var list_data =[]
    $(document).ready(function (){
        initData()
    })
    function resultList(stt, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td>" + value.nick_name + "</td>";
        rs += "<td>" + value.vin + "</td>";
        rs += "<td>" + value.t_rut + "</td>";
        rs += "<td>" + value.t_nap + "</td>";
        rs += "<td>" + value.create_time + "</td>";
        return rs;
    }

    function writeTotal(response) {
        if (typeof(response.data) === "undefined" || response.data == null) {
            return;
        }
        $("#doanhthu").html(formatNumber(response.data.total_doanhthu));
        $("#tongrut").html(formatNumber(response.data.total_rut));
        $("#tongnap").html(formatNumber(response.data.total_nap));
        $("#khuyenmai").html(formatNumber(response.data.total_km));
    }
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function initData() {
        if ($("#from-date").val() > $("#end-date").val()) {
            alert('Ngày bắt đầu lớn hơn ngày kết thúc.')
            return;
        }
        var oldPage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('userAgency/playerAjax')?>",
            data: {
                nn: $('#nn').val(),
                ft: $('#from-date').val(),
                et: $('#end-date').val(),
                cd: $('#cd').val(),
                pages : 1,
                size: page_size
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                var totalRecords = response.totalRecords
                $("#total").html(totalRecords);
                writeTotal(response);
                $("#spinner").hide();
                if (totalRecords == 0) {
                    list_data = []
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                    return;
                }
                
                list_data = response.data.listData;
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
                                url: "<?= admin_url('userAgency/playerAjax')?>",
                                data: {
                                    nn: $('#nn').val(),
                                    ft: $('#from-date').val(),
                                    et: $('#end-date').val(),
                                    cd: $('#cd').val(),
                                    pages : page,
                                    size: page_size
                                },
                                dataType: 'json',
                                success: function (response) {
                                    $("#total").html(response.totalRecords);
                                    writeTotal(response);
                                    list_data = response.data.listData;
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

    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: "<?= date('Y-m-d')?>"
    });
    $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: "<?= date('Y-m-d')?>"
    });
</script>
<style>
    .border-danger {
        color: #dc3545;
    }
</style>