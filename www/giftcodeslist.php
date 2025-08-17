<?php $this->load->view('admin/giftcodes/giftcodeslisthead', $this->data) ?>
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

        <div class="widget backaccount">
            <div class="title">
                <h6>Danh sách Giftcode</h6>
            </div>

            <form class="list_filter form" action="<?php echo admin_url('giftcodes/giftcodeslist') ?>" method="post">
                <div class="formRow row">
                    <div class="col-sm-1">
                        <label for="giftCode">Gift Code:</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="giftCode" value="<?php echo $this->input->post('giftCode') ?>" name="giftCode">
                    </div>

                    <div class="col-sm-1">
                        <label for="giftCode">Nick Name dành riêng:</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" id="userName" value="<?php echo $this->input->post('userName') ?>" name="userName">
                    </div>

                    <div class="col-sm-1">
                        <label for="giftCode">Từ ngày :</label>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group date" id="datetimepicker1">
                            <input type="text" id="fromTime" name="fromTime" value="<?php echo $this->input->post('fromTime') ?>" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-1">
                        <label for="giftCode">Đến ngày :</label>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group date" id="datetimepicker2">
                            <input type="text" id="endTime" name="endTime" value="<?php echo $this->input->post('endTime') ?>" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-1">
                        <label for="giftCode">Người tạo :</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="createdBy" id="createdBy" value="<?php echo $this->input->post('createdBy')?>">
                    </div>

                    <div class="col-sm-1">
                        <label for="giftCode">Sự kiện :</label>
                    </div>
                    <div class="col-sm-2">
                        <select id="bonusType" name="bonusType">
                            <option value="">Chọn</option>
                            <?php
                            foreach($eventConfig as $item) {?>
                                <option value="<?= $item['id']?>" <?php if ($this->input->post('bonusType') == $item['id']) { echo "selected";} ?>>
                                    <?= $item['name']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="formRow row">
                    <div class="col-sm-1">
                        <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB">
                    </div>
                    <div class="col-sm-1">
                        <input type="reset" onclick="window.location.href = '<?php echo admin_url('giftcodes/giftcodeslist') ?>';" value="Reset" class="basic">
                    </div>
                    <div class="col-sm-2">
                        <?php $this->load->view('/admin/component/exportexcel', ['pre_file_name'=>'giftcodes']); ?>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="float-right"> | Tổng bản ghi:<span style="color:#0000ff" id="total"></span></h3>
                    <h3 class="float-right">Tổng giá: <span style="color:#0000ff" id="sum-price"></span></h3>
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
                                <th style="width:40px" hidden>Id</th>
                                <th style="width: 250px">Mã <i class="fas fa-info-circle"
                                          data-toggle="tooltip"
                                          data-html="true"
                                          data-placement="right"
                                          title="
<div style='text-align: left;'>
Loại 0:	Sử dụng cho chính user đó, dùng duy nhất 1 lần<br/>
Loại 1:	Sử dụng cho tất cả user, mỗi user dùng 1 lần<br/>
Loại 2:	User nào cũng có thể dùng, duy nhất 1 lần<br/>
Loại 3:	Một user chỉ được sử dụng 1 Giftcode trong event, gift code dùng tối đa 1 lần
</div>
                                "></i></th>
                                <th>Loại</th>
                                <th>Giá</th>
                                <th>Số lần sử dụng</th>
                                <th>Hiệu lực từ</th>
                                <th>Hạn</th>
                                <th>Ngày tạo</th>
                                <th>Người tạo</th>
                                <th>Sự kiện</th>
                                <th>Nick Name dành riêng</th>
                                <th hidden>Hành động</th>
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
        let fromDatetime = $("#fromTime").val();
        let toDatetime = $("#endTime").val();
        if (fromDatetime > toDatetime) {
            bootbox.alert({
                message: '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Ngày kết thúc phải lớn hơn ngày bắt đầu',
                backdrop: true,
                centerVertical: true
            })
            return false;
        }
        initData()
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    })

    function resultSearchTransction(stt, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td style='display: none'>" + value.id + "</td>";
        rs += "<td>" + value.giftcode + "</td>";
        rs += "<td>" + value.type + "</td>";
        rs += "<td class='text-right'>" + $.number(value.money, undefined, '.', ',') + "</td>";
        rs += "<td>" + `${value.time_used}/${value.max_use}` + "</td>";
        rs += "<td>" + value.from + "</td>";
        rs += "<td>" + value.expired + "</td>";
        rs += "<td>" + value.created_at + "</td>";
        rs += "<td>" + (value.created_by || '-') + "</td>";
        rs += "<td>" + value.event + "</td>";
        rs += "<td>" + (value.user_name|| '-') + "</td>";
        rs += "<td hidden class='option'>" +
            `<a href="<?php echo admin_url('giftcodes/giftcodesused')?>?id=${value.id}" style="color: blue"> Chi tiết</a>` +
            "</td>";
        return rs;
    }

    function initData() {
        var oldPage = 0;
        var result = "";
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('giftcodes/giftcodeslistajax')?>",
            data: {
                giftCode: $('#giftCode').val(),
                userName: $('#userName').val(),
                fromTime: $('#fromTime').val(),
                endTime: $('#endTime').val(),
                createdBy: $('#createdBy').val(),
                bonusType: $('#bonusType').val(),
                pages : 1,
                size: page_size
            },

            dataType: 'json',
            success: function (response) {
                // result = JSON.parse(response.data)
                let result = response
                result.total = response.totalRecords
                $("#total").html(result.total);
                if (result.statistic != undefined && result.statistic.totalValue != undefined) {
                    let sum = parseInt(result.statistic.totalValue);
                    sum = new Intl.NumberFormat().format(sum);
                    $("#sum-price").html(sum);
                } else {
                    $("#sum-price").html(0);
                }

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
                        str += resultSearchTransction(stt, value);
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
                                    url: "<?php echo admin_url('giftcodes/giftcodeslistajax')?>",
                                    data: {
                                        giftCode: $('#giftCode').val(),
                                        userName: $('#userName').val(),
                                        fromTime: $('#fromTime').val(),
                                        endTime: $('#endTime').val(),
                                        createdBy: $('#createdBy').val(),
                                        bonusType: $('#bonusType').val(),
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
                                            str += resultSearchTransction(stt, value);
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
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent : false
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent : false
        });
    });
</script>