<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Tổng cược</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div><link rel="stylesheet"
      href="<?php echo public_url() ?>/site/css/loggamethirdparty.css"><?php if($role == false): ?>
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
                <h6>Tổng cược</h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('report/tongcuoc') ?>" method="post">
                <div class="formRow">
                    <table>
                        <tr class="nickname">
                            <td><label>Nick name:</label></td>
                            <td><input type="text"
                                       id="nickName" value="<?php echo $this->input->post('nickName') ?>" name="nickName"></td>
                        </tr>
                    </table>
                </div>

                <div class="formRow">
                    <table>
                        <tr>
                            <td>
                                <label for="param_name" class="formLeft" id="nameuser">Từ ngày:</label></td>
                            <td class="item">
                                <div class="input-group date" id="datetimepicker1">
                                    <input type="text" id="fromDate" name="fromDate" value="<?php echo $this->input->post('fromDate') ?>"> <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                                </div>                            </td>
                            <td>
                                <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>
                            </td>
                            <td class="item">

                                <div class="input-group date" id="datetimepicker2">
                                    <input type="text" id="toDate" name="toDate" value="<?php echo $this->input->post('toDate') ?>"> <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td style="">
                                <input type="button" id="search_tran" value="Tìm kiếm" class="button blueB search">
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll" >
                <thead>
                <tr class="list-loggameslot">
                    <td>STT</td>
                    <td>MoneyLiveCasino</td>
                    <td>moneyWinCasino</td>
                    <td>MoneySport</td>
                    <td>moneyWinSport</td>
                    <td>MoneyMyGame</td>
                    <td>moneyWinMyGame</td>
                    <td>Tổng cược</td>
                    <td>Tổng thắng</td>
                </tr>
                </thead>
                <tbody id="logaction">
                <td id="stt"></td>
                <td id="moneyLiveCasino"></td>
                <td id="moneyWinCasino"></td>
                <td id="moneySport"></td>
                <td id="moneyWinSport"></td>
                <td id="moneyMyGame"></td>
                <td id="moneyWinMyGame"></td>
                <td id="tongCuoc"></td>
                <td id="tongThang"></td>
                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>

<script>
    $(document).ready(function () {
        $('#logaction').hide();
    });

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

    $("#search_tran").click(function () {
        var fromDatetime = $("#fromDate").val();
        var toDatetime = $("#toDate").val();
        if (fromDatetime > toDatetime) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }
        var fromdate;
        var todate;
        if ($("#toDate").val() != "") {
            var match = $("#toDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            todate = moment.unix(date.getTime() / 1000).format("YYYY-MM-DD HH:mm:ss")
        } else {
            todate = "";
        }
        if ($("#fromDate").val() != "") {
            var match = $("#fromDate").val().match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/)
            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6])
            fromdate = moment.unix(date.getTime() / 1000).format("YYYY-MM-DD HH:mm:ss")
        } else {
            fromdate = "";
        }
        if ($("#nickName").val() == '') {
            alert('Vui lòng nhập NickName');
        } else {
            $('#logaction').show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('report/tongcuocajax')?>",
                data: {
                    nickName: $("#nickName").val(),
                    toDate: todate,
                    fromDate: fromdate,
                },
                dataType: 'json',
                success: function (result) {
                    $("#stt").html('1');
                    $("#moneyLiveCasino").html($.number(result.data.moneyLiveCasino, undefined, '.', ','));
                    $("#moneyWinCasino").html($.number(result.data.moneyWinCasino, undefined, '.', ','));
                    $("#moneySport").html($.number(result.data.moneySport, undefined, '.', ','));
                    $("#moneyWinSport").html($.number(result.data.moneyWinSport, undefined, '.', ','));
                    $("#moneyMyGame").html($.number(result.data.moneyMyGame, undefined, '.', ','));
                    $("#moneyWinMyGame").html($.number(result.data.moneyWinMyGame, undefined, '.', ','));
                    $("#tongCuoc").html($.number(result.data.tongCuoc, undefined, '.', ','));
                    $("#tongThang").html($.number(result.data.tongThang, undefined, '.', ','));
                }, error: function () {
                    $('#logaction').html("");
                    $("#spinner").hide();
                    $("#error-popup").modal("show");
                }, timeout: 40000
            });
        }
    });

</script>