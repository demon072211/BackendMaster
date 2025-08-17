<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Log khuyến mãi</h5>
        </div>

        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<?php if ($role == false): ?>
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

        <div class="widget">
            <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
            <div class="title">
                <h6>Danh sách Khuyến mãi</h6>
                <h6 style="float:right;font-size:15px;text-transform:none;">Tổng khuyến mãi:<span style="color:#0000ff;padding-left:10px;font-size:initial;" id="totalAmount"></span></h6>
            </div>            <form class="list_filter form" action="<?php echo admin_url('report/logbonus') ?>" method="post">
                <div class="formRow">
                    <table>
                        <tr>
                            <td>
                                <label for="fromTime" class="formLeft"
                                       style="margin-left: 70px;margin-bottom:-2px;width: 100px">Tạo từ:</label></td>
                            <td class="item">
                                <div class="input-group date" id="datetimepicker1">
                                    <input type="text" id="fromTime" name="fromTime"
                                           value="<?php echo $this->input->post('fromTime') ?>"> <span
                                            class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                                </div>
                            </td>

                            <td>
                                <label for="endTime" style="margin-left: 20px;width: 100px;margin-bottom:-3px;"
                                       class="formLeft"> Đến ngày: </label>
                            </td>
                            <td class="item">
                                <div class="input-group date" id="datetimepicker2">
                                    <input type="text" id="endTime" name="endTime" value="<?php echo $this->input->post('endTime') ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <label for="endTime" style="margin-left: 20px;width: 50px;margin-bottom:-3px;" class="formLeft">
                                        IP:
                                </label>
                            </td>
                            <td>
                                <input type="text" style="margin-left: 20px;margin-bottom:-2px;width: 150px" value="<?php echo $this->input->post('ip') ?>" name="ip" id="ip">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="formRow">

                    <table>
                        <tr>
                            <td><label style="margin-left: 30px;margin-bottom:-2px;width: 120px">NickName:</label></td>
                            <td><input type="text" style="margin-left: 20px;margin-bottom:-2px;width: 150px"
                                       id="nickName" value="<?php echo $this->input->post('nickName') ?>"
                                       name="nickName">
                            </td>
                            <td><label style="margin-left: 50px;margin-bottom:-2px;width: 100px">Loại bonus:</label>
                            </td>
                            <td class="item"><select id="bonusType" name="bonusType"
                                                     style="margin-left: 27px;margin-bottom:-2px;width: 142px">
                                    <option value="">Chọn</option>
                                    <?php
                                    foreach($eventConfig as $item) { ?>
                                    <option value="<?= $item['id']?>" <?php if ($this->input->post('bonusType') == $item['id']) { echo "selected";} ?>>
                                        <?= $item['name']?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="formRow">
                    <table>
                        <tr>

                            <td style="">
                                <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB"
                                       style="margin-left: 70px">
                            </td>
                            <td>
                                <input type="reset"
                                       onclick="window.location.href = '<?php echo admin_url('report/logbonus') ?>'; "
                                       value="Reset" class="basic" style="margin-left: 20px">
                            </td>
                            <td>
                                <span style="margin-left: 20px">
                                    <?php $this->load->view('/admin/component/exportexcel', ['pre_file_name'=>'logbonus']); ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <div class="formRow">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                            <thead>
                            <tr style="height: 20px;">
                                <th width="40px">STT</th>
                                <th>Nickname</th>
                                <th>Số tiền</th>
                                <th>Bonus Type</th>
                                <th>Bonus Name</th>
                                <th>IP</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
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
<?php endif; ?>
<div class="container">
    <h6 class="total-data">Tổng bản ghi:<span class="total-data-span" id="totalData"></span></h6>
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>

<script>
    var page_size = '<?php echo $this->input->post('page_size') ?>' || 10
    $(document).ready(function(){
        initData()
    })

    $(function () {
        var startDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0)
        var endDate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59)

        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            // defaultDate: startDate,
            useCurrent : false,
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            // defaultDate: endDate,
            useCurrent : false,
        });
        // $('#datetimepicker1').data("DateTimePicker").maxDate(endDate);
        // $('#datetimepicker2').data("DateTimePicker").minDate(startDate);
        //
        // $("#datetimepicker1").on("dp.change", function (e) {
        //     $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        //
        // });
        // $("#datetimepicker2").on("dp.change", function (e) {
        //     $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        // });
    });
    $("#search_tran").click(function () {
        var fromDatetime = $("#fromTime").val();
        var toDatetime = $("#endTime").val();
        if (fromDatetime > toDatetime) {
            bootbox.alert({
                message: '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Ngày kết thúc phải lớn hơn ngày bắt đầu',
                backdrop: true,
                centerVertical: true
            })
            return false;
        }
    });

    function resultSearchTransction(stt, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td class=''>" + value.nick_name + "</td>";
        rs += "<td class=''>" + $.number(value.amount, undefined, '.', ',') + "</td>";
        rs += "<td class=''>" + (value.bonus_type || '-') + "</td>";
        rs += "<td class=''>" + (value.bonusName || '_') + "</td>";
        rs += "<td class=''>" + value.ip + "</td>";
        rs += "<td class=''>" + value.create_date + "</td>";
        /*rs += "<td>" + value.id_number + "</td>";*/
        rs += "<td>" + '<a href="<?php echo admin_url('giftcodes/giftcodeslist')?>?referral_code=${value.referral_code}" style="color: blue"> Chi tiết</a>' + "</td>";
        return rs;
    }

    function crPoppover(value) {
        return ' data-toggle="popover" data-title="Thông tin chi tiết" data-html=true data-trigger="hover" data-placement="left" ' +
            'data-content="' +
                Object.entries(value).map( ([x,y]) => `${x} : ${y}`).join("</br>")
            + '" '
    }

    function messageBody(value) {
        return '<table class="table"><tr><th>Trường dữ liệu<th/><th>Thuộc tính<th/></tr>' +
            '<tr><td>Nickname<td/><td>' + value.Nickname + '<td/></tr>' +
            '<tr><td>Số tiền<td/><td>' + $.number(value.Amount, undefined, '.', ',') + '<td/></tr>' +
            '<tr><td>Nhà CC<td/><td>' + value.ProviderName + '<td/></tr>' +
            '<tr><td>Order Id<td/><td>' + value.Id + '<td/></tr>' +
            '<tr><td>Transaction Id<td/><td>' + value.ReferenceId + '<td/></tr>' +
            '<tr><td>Ngân hàng<td/><td>' + value.BankCode + '<td/></tr>' +
            '<tr><td>Số tài khoản<td/><td>' + value.BankAccountNumber + '<td/></tr>' +
            '<tr><td>Tên chủ khoản<td/><td>' + value.BankAccountName + '<td/></tr>' +
            '<tr><td>Ngày tạo<td/><td>' + value.CreatedAt + '<td/></tr>' +
            '<tr><td>Trạng thái<td/><td>' + status_dict[value.Status].text + '<td/></tr>' +
            '</table>'
    }

    function handleActionListener() {
        $('.tipS.view-action').click( function (e){
            e.preventDefault()
        })
    }

    function initData() {
        var oldPage = 0;
        var result = "";
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/logbonusajax')?>",
            data: {
                nickName: $("#nickName").val(),
                bonusType: $("#bonusType").val(),
                fromTime: $("#fromTime").val(),
                endTime: $("#endTime").val(),
                fromAmount: $("#fromAmount").val(),
                toAmount: $("#toAmount").val(),
                ip: $("#ip").val(),
                pages: 1,
                size: page_size
            },

            dataType: 'json',
            success: function (response) {
                // $("#total_trans").html(result.TotalTrans);
                // $("#total_money").html($.number(result.TotalMoney, undefined, ',', '.'));
                // $("#total_success").html(result.TotalSuccess);
                $("#spinner").hide();

                if (!response.data.listData || response.data.listData.length == 0) {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    $("#totalData").html($.number(response.totalRecords, undefined, '.', ','));
                    $("#totalAmount").html($.number(response.data.totalAmount, undefined, '.', ','));
                    $("#resultsearch").html("");
                    var totalPage = Math.floor((response.totalRecords|| 100) / page_size) + ((response.totalRecords|| 100) % page_size ? 1 : 0);
                    stt = 1;

                    $.each(response.data.listData, function (index, value) {
                        result += resultSearchTransction(stt, value);
                        stt++;
                    });
                    $('#logaction').html(result);
                    handleActionListener();
                    $('[data-toggle="popover"]').popover()
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if (oldPage > 0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('report/logbonusajax')?>",
                                    data: {
                                        nickName: $("#nickName").val(),
                                        bonusType: $("#bonusType").val(),
                                        fromTime: $("#fromTime").val(),
                                        endTime: $("#endTime").val(),
                                        fromAmount: $("#fromAmount").val(),
                                        toAmount: $("#toAmount").val(),
                                        ip: $("#ip").val(),
                                        pages: page,
                                        size: page_size

                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        $("#resultsearch").html("");
                                        $("#spinner").hide();
                                        stt = (page - 1) * page_size + 1;
                                        let str = ''
                                        $.each(response.data.listData, function (index, value) {
                                            str += resultSearchTransction(stt, value);
                                            stt++;
                                        });
                                        $('#logaction').html(str);
                                        handleActionListener();
                                        $('[data-toggle="popover"]').popover()
                                    }, error: function (e) {
                                        console.error(e)
                                        $("#spinner").hide();
                                        $('#logaction').html("");
                                        $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                                    }, timeout: 20000
                                });
                            }
                            oldPage = page;
                        }
                    });
                }

            }, error: function (e) {
                console.error(e)
                $("#spinner").hide();
                $('#logaction').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            }, timeout: 20000
        })

    };
</script>
<script>
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
</script>