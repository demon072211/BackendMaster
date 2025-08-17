<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<?php if($role == false): ?>
    <div class="wrapper">
        <div class="widget">
            <div class="title">
                <h6>Bạn không được phân quyền</h6>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="wrapper">
        <?php $this->load->view('admin/message', $this->data); ?>
        <form class="list_filter form" action="<?php echo admin_url('marketing/rechargevnd') ?>" method="post">
            <div class="formRow">
                <table>
                    <tr>
                        <td>
                            <label for="param_name" class="formLeft" id="nameuser"
                                   style="margin-left: 70px;margin-bottom:-2px;width: 100px">Từ ngày:</label></td>
                        <td class="item">
                            <div class="input-group date" id="datetimepicker1">
                                <input type="text" id="toDate" name="toDate"
                                       value="<?php echo $this->input->post('toDate') ?>"> <span
                                        class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                            </div>                        </td>

                        <td>
                            <label for="param_name" style="margin-left: 20px;width: 100px;margin-bottom:-3px;"
                                   class="formLeft"> Đến ngày: </label>
                        </td>
                        <td class="item">

                            <div class="input-group date" id="datetimepicker2">
                                <input type="text" id="fromDate" name="fromDate"
                                       value="<?php echo $this->input->post('fromDate') ?>"> <span
                                        class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                            </div>
                        </td>
                        <td style="">
                            <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB"
                                   style="margin-left: 70px">
                        </td>
                        <td>
                            <input type="reset"
                                   onclick="window.location.href = '<?php echo admin_url('marketing/rechargevnd') ?>'; "
                                   value="Reset" class="basic" style="margin-left: 20px">
                        </td>
                        <td>
                            <span style="margin-left: 20px">
                                <?php $this->load->view('/admin/component/baocaoexcel', ['pre_file_name'=>'tiennapvaogame', 'columns_excel' => "0,1,2,3,4"]); ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </form>

        <div class="widget">
            <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
            <div id="widget">
                <input type="hidden" value="<?php echo $admin_info->Status ?>" id="status">                <div class="formRow">
                    <div class="row">
                        <h4 id="" style="color: red;margin-left: 20px">Tiền nạp game (VNĐ)</h4>
                    </div>
                </div>
                <div class="formRow">
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                                <thead>
                                <tr style="height: 20px;">
                                    <td>Nạp qua Princepay</td>
                                    <td>Nạp qua Oneclickpay</td>
                                    <td>Nạp qua Paywell</td>
                                    <td>Nạp qua Ngân hàng</td>
                                    <td>Tổng tiền</td>
                                </tr>
                                </thead>
                                <tbody id="logrecharge">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<style>
    td {
        word-break: break-all;
    }

    thead {
        font-size: 12px;
    }

    .spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-left: -50px; /* half width of the spinner gif */
        margin-top: -50px; /* half height of the spinner gif */
        text-align: center;
        z-index: 1234;
        overflow: auto;
        width: 100px; /* width of the spinner gif */
        height: 102px; /*hight of the spinner gif +2px to fix IE8 issue */
    }</style>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
</div>
<script>
    $(function () {
        $('#datetimepicker1').datetimepicker({
            defaultDate:moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0),
            useCurrent : false,
            format: 'YYYY-MM-DD HH:mm:ss'
        });
        $('#datetimepicker2').datetimepicker({
            defaultDate:moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59),
            useCurrent : false,
            format: 'YYYY-MM-DD HH:mm:ss'
        });
        $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);

        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
    });
    $("#search_tran").click(function () {
        var fromDatetime = $("#toDate").val();
        var toDatetime = $("#fromDate").val();
        if (fromDatetime > toDatetime) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }
    });

    function resulttotalrecharge(rechargeiap,rechargecard,rechargevincard,rechargebank,rechargesms,rechargemega,rechargevtc,total) {
        var rs = "";
        rs += "<tr>";
        rs += "<td style='color: #0000ff'>" + commaSeparateNumber(rechargeiap) + "</td>";
        rs += "<td style='color: #0000ff'>" + commaSeparateNumber(rechargecard) + "</td>";
        rs += "<td style='color: #0000ff'>" + commaSeparateNumber(rechargevincard) + "</td>";
        rs += "<td style='color: #0000ff'>" + commaSeparateNumber(rechargebank) + "</td>";
        rs += "<td style='color: #0000ff'>" + commaSeparateNumber(rechargesms) + "</td>";
/*        rs += "<td style='color: #0000ff'>" + commaSeparateNumber(rechargemega) + "</td>";
        rs += "<td style='color: #0000ff'>" + commaSeparateNumber(rechargevtc) + "</td>";
        rs += "<td style='color: #0000ff'>" + commaSeparateNumber(total) + "</td>";*/
        rs += "</tr>";
        return rs;
    }

    $(document).ready(function () {
        var result10 = "";
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('marketing/rechargevndajax')?>",
            data: {
                toDate: $("#toDate").val(),
                fromDate: $("#fromDate").val()
            },

            dataType: 'json',
            success: function (res) {
                $("#spinner").hide();
                var total1 = 0;
                var total2 = 0;
                var total3 = 0;
                var total4 = 0;
                var total5 = 0;
                var total6 = 0;
                var total7 = 0;
                var total = 0;
                if ($.isEmptyObject(res.vinInUser)) {
                    result10 = resulttotalrecharge(0,0,0,0,0);
                    $('#logrecharge').html(result10);
                } else {
                    if (res.vinInUser.RechargeByCard != null || res.vinInUser.RechargeByCard != null) {
                        total1 = res.vinInUser.RechargeByCard;
                    }
                    if (res.vinInUser.RechargeByIAP != null || res.vinInUser.RechargeByIAP != null) {
                        total2 = Math.round(res.vinInUser.RechargeByIAP * (22000/15));
                    }
                    if (res.vinInUser.RechargeBySMS != null || res.vinInUser.RechargeBySMS != null) {
                        total3 = res.vinInUser.RechargeBySMS * 2;
                    }
                    if (res.vinInUser.RechargeByBank != null || res.vinInUser.RechargeByBank != null) {

                        total4 = Math.round(res.vinInUser.RechargeByBank / 1.1);
                    }
                    if (res.vinInUser.RechargeByVinCard != null || res.vinInUser.RechargeByVinCard != null) {
                        total5 = Math.round(res.vinInUser.RechargeByVinCard / 1.05);
                    }
                    if (res.vinInUser.RechargeByMegaCard != null || res.vinInUser.RechargeByMegaCard != null) {
                        total6 =(res.vinInUser.RechargeByMegaCard / 1.05);
                    }
                    if (res.vinInUser.TopupVTCPay != null || res.vinInUser.TopupVTCPay != null) {
                        total7 =(res.vinInUser.TopupVTCPay);
                    }
                }
                total = total1 + total2 + total3 + total4 + total5 + total6 +total7;
                result10 = resulttotalrecharge(total2,total1,total5,total4,total3,total6,total7,total);
                $('#logrecharge').html(result10);

            }, error: function () {
                $("#spinner").hide();
                $('#widget').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            }, timeout: 20000

        })
    });
</script>
<script>
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
</script>
