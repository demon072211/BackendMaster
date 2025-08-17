<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Log game thirdparty</h5>
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
                <h6>Lịch sử game thirdparty</h6>
                <h6 class="total d-none">Tổng đặt cược:<span class="total-number" id="totalBet"></span></h6>
                <h6 class="total d-none">Tổng đặt cược hợp lệ:<span class="total-number" id="totalValidBet"></span></h6>
                <h6 class="total d-none">Tổng thanh toán:<span class="total-number" id="totalPayout"></span></h6>
                <h6 class="total d-none">Tổng Số người chơi:<span class="total-number" id="tong_player"></span></h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('loggamethirdparty/cmd') ?>" method="post">
                <div class="formRow row">
                    <div class="col-sm-2">
                        <label for="giftCode">referenceno : </label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="referenceno" value="<?= empty($this->input->get('referenceno')) ? $this->input->post('referenceno') : $this->input->get('referenceno')?>" name="referenceno">
                    </div>

                    <div class="col-sm-2">
                        <label for="giftCode">sourcename : </label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="sourcename" value="<?= empty($this->input->get('sourcename')) ? $this->input->post('sourcename') : $this->input->get('sourcename')?>" name="sourcename">
                    </div>

                    <div class="col-sm-2">
                        <label for="giftCode">betip : </label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="betip" value="<?= empty($this->input->get('betip')) ? $this->input->post('betip') : $this->input->get('betip')?>" name="betip">
                    </div>
                </div>
                <div class="formRow row">
                    <div class="col-sm-2">
                        <label for="giftCode">loginname : </label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="loginname" value="<?= empty($this->input->get('loginname')) ? $this->input->post('loginname') : $this->input->get('loginname')?>" name="loginname">
                    </div>
                </div>
                <div class="formRow row">
                    <div class="col-sm-2">
                        <label for="giftCode">Flag Type : </label>
                    </div>
                    <div class="col-sm-2">
                        <select id="fgt" name="fgt">
                            <option value="0" <?= ($this->input->post('fgt') == 0 || $this->input->get('fgt') == 0) ? 'selected' : '' ?>>Chọn</option>
                            <option value="1" <?= ($this->input->post('fgt') == 1 || $this->input->get('fgt') == 1) ? 'selected' : '' ?>>transdate</option>
                            <option value="2" <?= ($this->input->post('fgt') == 2 || $this->input->get('fgt') == 2) ? 'selected' : '' ?>>betdate</option>
                            <option value="3" <?= ($this->input->post('fgt') == 3 || $this->input->get('fgt') == 3) ? 'selected' : ''?>>settleddate</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label for="giftCode">Từ ngày : </label>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group" id="frompicker">
                            <input type="text" id="fromDate" name="fromDate" value="<?= empty($this->input->get('fromDate')) ? $this->input->post('fromDate') : $this->input->get('fromDate')?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="giftCode">Đến ngày : </label>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group" id="topicker">
                            <input type="text" id="toDate" name="toDate" value="<?= empty($this->input->get('toDate')) ? $this->input->post('toDate') : $this->input->get('toDate')?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td><label class="flagtime-1">Số dòng:</label></td>
                            <td><select class="flagtime-2" id="maxItem" name="maxItem">
                                    <option value="20" <?= ($this->input->post('maxItem') == "20" || $this->input->get('maxItem') == "20") ? "selected" : "" ?>>20</option>
                                    <option value="50" <?= ($this->input->post('maxItem') == "50" || $this->input->get('maxItem') == "50") ? "selected" : "" ?>>50</option>
                                    <option value="100" <?= ($this->input->post('maxItem') == "100" || $this->input->get('maxItem') == "100") ? "selected" : "" ?>>100</option>
                                </select></td>
                            <td style="">
                                <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB search">
                            </td>
                            <td>
                                <input type="reset"
                                       onclick="window.location.href = '<?php echo admin_url('loggamethirdparty/cmd') ?>'; "
                                       value="Reset" class="basic">
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                <thead>
                <tr class="list-loggameslot">
                    <td>STT</td>
                    <td>id</td>
                    <td>sourcename</td>
                    <td>referenceno</td>
                    <td>soctransid</td>
                    <td>loginname </td>
                    <td>betamount</td>
                    <td>outstanding</td>
                    <td>betip</td>
                    <td>betdate</td>
                    <td>settleddate</td>
                    <td>transdate</td>
                </tr>
                </thead>
                <tbody id="logaction">
                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>
<div class="container">
    <h6 class="total-data">Tổng bản ghi:<span class="total-data-span" id="totalRecord"></span></h6>
    <div id="spinner" class="spinner image-loggameslot">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>

<script>
    $("#search_tran").click(function () {
        var fromDatetime = $("#fromDate").val();
        var toDatetime = $("#toDate").val();
        if (fromDatetime > toDatetime) {
            alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
            return false;
        }
    });
    $(document).ready(function () {
        var oldpage = 0;
        var startDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0);
        var endDate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59);
        $('#frompicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: startDate,
            useCurrent : false
        });
        $('#topicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            defaultDate: endDate,
            useCurrent : false
        });
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('loggamethirdparty/cmdajax')?>",
            data: {
                rn : $("#referenceno").val(),
                sn: $("#sourcename").val(),
                bip: $("#betip").val(),
                fgt: $("#fgt").val(),
                et: $("#toDate").val(),
                ft: $("#fromDate").val(),
                ln: $("#loginname").val(),
                page: 1,
                maxItem: $("#maxItem").val()
            },
            dataType: 'json',
            success: function (response) {
                $("#spinner").hide();
                let result = JSON.parse(response.data);
                if (result.listTrans == "") {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    let    result = JSON.parse(response.data);
                    let totalPage = Math.floor(result.totalRecord/10) + (result.totalRecord%10?1:0);
                    $("#totalRecord").html($.number(result.totalRecord, undefined, '.', ','));
                    $("#totalBet").html($.number(result.totalBet, undefined, '.', ','));
                    $("#totalValidBet").html($.number(result.totalValidBet, undefined, '.', ','));
                    $("#totalPayout").html($.number(result.totalPayout, undefined, '.', ','));
                    $("#tong_player").html($.number(result.totalPlayer, undefined, '.', ','));
                    $("#resultsearch").html("");
                    stt = 1;
                    let str = '';
                    $.each(result.listTrans, function (index, value) {
                        str += resultSearchTransction(stt,value);
                        stt ++;
                    });
                    $('#logaction').html(str);
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if(oldpage>0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('loggamethirdparty/cmdajax')?>",
                                    data: {
                                        rn : $("#referenceno ").val(),
                                        sn: $("#sourcename").val(),
                                        bip: $("#betip").val(),
                                        ln: $("#loginname").val(),
                                        fgt: $("#fgt").val(),
                                        et: $("#toDate").val(),
                                        ft: $("#fromDate").val(),
                                        page: page,
                                        maxItem: $("#maxItem").val()
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        result = JSON.parse(response.data);
                                        $("#spinner").hide();
                                        stt = 1;
                                        let str = ''
                                        $.each(result.listTrans, function (index, value) {
                                            str += resultSearchTransction(stt, value);
                                            stt++;
                                        });
                                        $('#logaction').html(str);
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
                }
            }, error: function () {
                $('#logaction').html("");
                $("#spinner").hide();
                $("#error-popup").modal("show");
            }, timeout: 40000
        })

    })
    function resultSearchTransction(stt,value) {
        let tranDate = Math.floor(value.transdate / 1000000)
        tranDate = new Date(tranDate);
        let dateFormat = String(tranDate.getFullYear()).padStart(2, "0") + '-' + String(tranDate.getMonth() + 1).padStart(2, "0") + '-' + String(tranDate.getDate()).padStart(2, "0") + ' ' + String(tranDate.getHours()).padStart(2, "0") + ':' + String(tranDate.getMinutes()).padStart(2, "0") + ':' + String(tranDate.getSeconds()).padStart(2, "0");
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td><a href='<?= admin_url('loggamethirdparty/cmdDetail') . '/'?>" + value.id + query() + "' class='text-success'>" + value.id + "</a></td>";
        rs += "<td>" + value.sourcename + "</td>";
        rs += "<td>" + value.referenceno + "</td>";
        rs += "<td>" + value.soctransid + "</td>";
        rs += "<td>" + value.loginname + "</td>";
        rs += "<td>" + value.betamount + "</td>";
        rs += "<td>" + value.outstanding + "</td>";
        rs += "<td>" + value.betip + "</td>";
        rs += "<td>" + value.betdate + "</td>";
        rs += "<td>" + value.settleddate + "</td>";
        rs += "<td>" + dateFormat + "</td>";
        rs += "</tr>";
        return rs;
    }

    function query() {
        let query = '?';
        if ($('#referenceno').val() != '') {
            query += 'referenceno=' + $('#referenceno').val() + '&'
        }
        if ($('#sourcename').val() != '') {
            query += 'sourcename=' + $('#sourcename').val() + '&'
        }
        if ($('#fromDate').val() != '') {
            query += 'fromDate=' + $('#fromDate').val() + '&'
        }
        if ($('#toDate').val() != '') {
            query += 'toDate=' + $('#toDate').val() + '&'
        }
        if ($('#betip').val() != '') {
            query += 'betip=' + $('#betip').val() + '&'
        }
        if ($('#loginname').val() != '') {
            query += 'loginname=' + $('#loginname').val() + '&'
        }
        if ($('#fgt').val() != '') {
            query += 'fgt=' + $('#fgt').val() + '&'
        }
        return query;
    }
</script>