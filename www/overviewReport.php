
<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Báo cáo tổng quan</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<?php //if (!empty($uri)) { ?>
<!--    <div class="wrapper return-url">-->
<!--        <a class="" href="--><?//= admin_url('agency/listUserOfAgency') . '?' .$uri ?><!--">-->
<!--            <i class="fas fa-angle-double-left"></i> Quay lại-->
<!--        </a>-->
<!--    </div>-->
<?php //} ?>
<link rel="stylesheet"
      href="<?php echo public_url() ?>/site/css/loggamethirdparty.css"><?php if(false): ?>
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
                <h6>Báo cáo tổng quan</h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('report/overviewReport') ?>" method="post">
                <div class="formRow row">
                    <div class="col-sm-2">
                        <label for="giftCode">Tên : </label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="nn" value="<?php echo $this->input->post('nn') ?>" name="nn">
                    </div>

                </div>

                <div class="formRow row">
                    <div class="col-sm-2">
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

                    <div class="col-sm-2">
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
                        <input type="reset"  value="Reset" class="basic">
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
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered" id="checkAll">
                            <thead>
                            <tr class="list-loggameslot">
                                <td>STT</td>
                                <td>time</td>
                                <td>nick_name</td>
                                <td>wm</td>
                                <td>wm_win</td>
                                <td>ibc</td>
                                <td>ibc_win</td>
                                <td>ag</td>
                                <td>ag_win</td>
                                <td>tlmn</td>
                                <td>bacay</td>
                                <td>bacay_win</td>
                                <td>xocdia</td>
                                <td>xocdia_win</td>
                                <td>minipoker</td>
                                <td>minipoker_win</td>
                                <td>slot_pokemon</td>
                                <td>slot_pokemon_win</td>
                                <td>baucua</td>
                                <td>baucua_win</td>
                                <td>taixiu</td>
                                <td>taixiu_win</td>
                                <td>caothap</td>
                                <td>caothap_win</td>
                                <td>slot_bitcoin</td>
                                <td>slot_bitcoin_win</td>
                                <td>slot_taydu</td>
                                <td>slot_taydu_win</td>
                                <td>slot_angrybird</td>
                                <td>slot_angrybird_win</td>
                                <td>slot_thantai</td>
                                <td>slot_thantai_win</td>
                                <td>slot_thethao</td>
                                <td>slot_thethao_win</td>
                                <td>slot_bikini</td>
                                <td>slot_bikini_win</td>
                                <td>slot_galaxy</td>
                                <td>slot_galaxy_win</td>
                                <td>fish</td>
                                <td>fish_win</td>
                                <td>ebet</td>
                                <td>ebet_win</td>
                                <td>deposit</td>
                                <td>withdraw</td>
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
<?php endif;?>
<div class="container">
    <div id="spinner" class="spinner image-loggameslot">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>

<script>
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
        var url_string = window.location.href;
        var url = new URL(url_string);
        var oldpage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/overviewReportajax')?>",
            data: {
                nn: $('#nn').val(),
                fromDate: $('#fromDate').val(),
                toDate: $('#toDate').val()
            },
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if (result.data == "") {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    let totalPage = 1;
                    $("#resultsearch").html("");
                    stt = 1;
                    $.each(result.data, function (index, value) {
                        result += resultSearchTransction(stt,value);
                        stt ++;
                    });
                    $('#logaction').html(result);
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if(oldpage>0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('report/overviewReportajax')?>",
                                    data: {
                                        nn: $('#nn').val(),
                                        fromDate: $('#fromDate').val(),
                                        toDate: $('#toDate').val()
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#spinner").hide();
                                        stt = (page - 1) * 10 + 1;
                                        $.each(result.data, function (index, value) {
                                            result += resultSearchTransction(stt, value);
                                            stt++;
                                        });
                                        $('#logaction').html(result);
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
                }            }, error: function () {
                $('#logaction').html("");
                $("#spinner").hide();
                $("#error-popup").modal("show");
            }, timeout: 40000
        })
    });
    function resultSearchTransction(stt,value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + value.time + "</td>";
        rs += "<td title='" + value.nick_name + "'>" + value.nick_name + "</td>";
        rs += "<td>" + value.wm + "</td>";
        rs += "<td>" + value.wm_win + "</td>";
        rs += "<td>" + value.ibc + "</td>";
        rs += "<td>" + value.ibc_win + "</td>";
        rs += "<td>" + value.ag + "</td>";
        rs += "<td>" + value.ag_win + "</td>";
        rs += "<td>" + value.tlmn + "</td>";
        rs += "<td>" + value.bacay + "</td>";
        rs += "<td>" + value.bacay_win + "</td>";
        rs += "<td>" + value.xocdia + "</td>";
        rs += "<td>" + value.xocdia_win + "</td>";
        rs += "<td>" + value.minipoker + "</td>";
        rs += "<td>" + value.minipoker_win + "</td>";
        rs += "<td>" + value.slot_pokemon + "</td>";
        rs += "<td>" + value.slot_pokemon_win + "</td>";
        rs += "<td>" + value.baucua + "</td>";
        rs += "<td>" + value.baucua_win + "</td>";
        rs += "<td>" + value.taixiu + "</td>";
        rs += "<td>" + value.taixiu_win + "</td>";
        rs += "<td>" + value.caothap + "</td>";
        rs += "<td>" + value.caothap_win + "</td>";
        rs += "<td>" + value.slot_bitcoin + "</td>";
        rs += "<td>" + value.slot_bitcoin_win + "</td>";
        rs += "<td>" + value.slot_taydu + "</td>";
        rs += "<td>" + value.slot_taydu_win + "</td>";
        rs += "<td>" + value.slot_angrybird + "</td>";
        rs += "<td>" + value.slot_angrybird_win + "</td>";
        rs += "<td>" + value.slot_thantai + "</td>";
        rs += "<td>" + value.slot_thantai_win + "</td>";
        rs += "<td>" + value.slot_thethao + "</td>";
        rs += "<td>" + value.slot_thethao_win + "</td>";
        rs += "<td>" + value.slot_bikini + "</td>";
        rs += "<td>" + value.slot_bikini_win + "</td>";
        rs += "<td>" + value.slot_galaxy + "</td>";
        rs += "<td>" + value.slot_galaxy_win + "</td>";
        rs += "<td>" + value.fish + "</td>";
        rs += "<td>" + value.fish_win + "</td>";
        rs += "<td>" + value.ebet + "</td>";
        rs += "<td>" + value.ebet_win + "</td>";
        rs += "<td>" + value.deposit + "</td>";
        rs += "<td>" + value.withdraw + "</td>";
        rs += "</tr>";
        return rs;
    }

</script>