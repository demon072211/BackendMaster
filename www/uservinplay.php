<?php $this->load->view('admin/usergame/uservinplayhead', $this->data) ?>
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
                <h6>Danh sách tài khoản thường</h6>
                <h6 style="float: right">Tổng số tài khoản:<span style="color:#0000ff" id="numuser"></span></h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('usergame/uservinplay') ?>" method="post">
                <div class="formRow">
                    <table>
                        <tr>
                            <td>
                                <label for="fromDate" class="formLeft">Từ ngày:</label>
                            </td>
                            <td class="item">
                                <div class="input-group date" id="datetimepicker1">
                                    <input type="text" id="fromDate" name="fromDate"
                                           value="<?= empty($this->input->post('fromDate')) ? (empty($this->input->get('fromDate')) ? '' : $this->input->get('fromDate')) : $this->input->post('fromDate') ?>">
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                </div>
                            </td>
                            <td>
                                <label for="toDate" class="formLeft"> Đến ngày: </label>
                            </td>
                            <td class="item">
                                <div class="input-group date" id="datetimepicker2">
                                    <input type="text" id="toDate" name="toDate"
                                           value="<?= empty($this->input->post('toDate')) ? (empty($this->input->get('toDate')) ? '' : $this->input->get('toDate')) : $this->input->post('toDate') ?>">
                                            <span class="input-group-addon">
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
                            <td><label class="formLeft">Nickname:</label></td>
                            <td><input type="text" class="my-input-class"
                                       id="nickname" value="<?= empty($this->input->post('nickname')) ? (empty($this->input->get('nickname')) ? '' : $this->input->get('nickname')) : $this->input->post('nickname') ?>"
                                       name="nickname">
                            </td>
                            <td><label class="formLeft">Mã đại lý:</label>
                            </td>
                            <td><input type="text" class="my-input-class"
                                       id="refcode" value="<?= empty($this->input->post('refcode')) ? (empty($this->input->get('refcode')) ? '' : $this->input->get('refcode')) : $this->input->post('refcode') ?>" name="refcode">
                            </td>
                        </tr>
                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td>
                                <label class="formLeft"> Loại: </label>
                            </td>
                            <td class="item">
                                <select id="typetaikhoan" name="typetaikhoan" class="my-input-class">
                                    <option value="0" <?php if ($this->input->post('typetaikhoan') == "0") {
                                        echo "selected";
                                    } ?>>Tài khoản thường
                                    </option>
                                </select>
                            </td>
                            <td>
                                <label
                                        class="formLeft"> Hiển thị: </label>
                            </td>
                            <td class="item">
                                <select id="record" name="record" class="my-input-class">
                                    <option value="50" <?php if ($this->input->post('record') == 50 || $this->input->get('record') == 50) {echo "selected";} ?>>
                                        50
                                    </option>
                                    <option value="100" <?php if ($this->input->post('record') == 100 || $this->input->get('record') == 100) {
                                        echo "selected";
                                    } ?>>100
                                    </option>
                                    <option value="200" <?php if ($this->input->post('record') == 200 || $this->input->get('record') == 200) {
                                        echo "selected";
                                    } ?>>200
                                    </option>
                                    <option value="500" <?php if ($this->input->post('record') == 500 || $this->input->get('record') == 500) {
                                        echo "selected";
                                    } ?>>500
                                    </option>
                                    <option value="1000" <?php if ($this->input->post('record') == 1000 || $this->input->get('record') == 1000) {
                                        echo "selected";
                                    } ?>>1000
                                    </option>
                                    <option value="2000" <?php if ($this->input->post('record') == 2000 || $this->input->get('record') == 2000) {
                                        echo "selected";
                                    } ?>>2000
                                    </option>
                                    <option value="5000" <?php if ($this->input->post('record') == 5000 || $this->input->get('record') == 5000) {
                                        echo "selected";
                                    } ?>>5000
                                    </option>
                                </select>
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="formRow">
                    <table>
                        <tr>
                            <td><label class="formLeft">Điện thoại:</label>
                            </td>
                            <td><input type="text" class="my-input-class"
                                       id="phone" value="<?= empty($this->input->post('phone')) ? (empty($this->input->get('phone')) ? '' : $this->input->get('phone')) : $this->input->post('phone') ?>" name="phone"></td>
                            <td><label class="formLeft">Email:</label></td>
                            <td><input type="text" class="my-input-class"
                                       id="txtemail" value="<?= empty($this->input->post('txtemail')) ? (empty($this->input->get('txtemail')) ? '' : $this->input->get('txtemail')) : $this->input->post('txtemail') ?>"
                                       name="txtemail"></td>
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
                                       onclick="window.location.href = '<?php echo admin_url('usergame/uservinplay') ?>'; "
                                       value="Reset" class="basic" style="margin-left: 20px">
                            </td>
                            <td>
                                <input hidden type="text" value="0" name="isEx" id="isEx">
                                <button  class="button blueB" id="export" style="margin-left: 20px">
                                    Xuất dữ liệu
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <input type="hidden" value="<?php echo $admin_info->Status ?>" id="status">
            <div class="formRow">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                            <thead>
                            <tr style="height: 20px;">
                                <td style="width: 50px">STT</td>
                                <!--                            <td>Username</td>-->
                                <td>Nickname</td>
                                <td>Số dư Win</td>
                                <!--                            <td>Số Win két sắt</td>-->
                                <!--                            <td>Vippoint hiện tại</td>-->
                                <!--                            <td>Vippoint tích lũy</td>-->
                                <!--                            <td>Vippoint event</td>-->
                                <td>Bậc vippoint</td>
                                <!--                            <td>Tổng tiền nạp</td>-->
                                <!--                            <td>Birthday</td>-->
                                <!--                            <td>OTP</td>-->
                                <td>SĐT</td>
                                <!--                            <td>An toàn qua SĐT</td>-->
                                <td>Mã giới thiệu</td>
                                <td>Ngày tạo</td>
                                <td>Hành động</td>
                                <!--                            <td>FB_GG_ID</td>-->
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
<style>
</style>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>
<div class="modal fade" id="agent-bootstrap-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Cập nhật mã đại lý cho user</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 id="resultSubmit" style="color: red;margin-left: 20px"></h4>
                <form class="tagForm needs-validation" action="" novalidate>
                    <input id="nickname-invisible" type="text" value="" hidden>
                    <div class="form-group">
                        <label for="inputNickName" class="col-form-label">Nick Name : <span id="nickname-visible"></span></label>
                    </div>
                    <div class="form-group">
                        <label for="inputCustomerName" class="col-form-label">Mã đại lý : </label>
                        <input id="code-agent" type="text" class="form-control" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="agent-form-submit">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    var page_size = '<?php echo $this->input->post('page_size') ?>' || 50
    var list_data = []

    $(document).ready(function(){
        initData()
    })

    $(function () {
        // var startDate = moment(new Date()).hours(0).minutes(0).seconds(0).milliseconds(0)
        // var endDate = moment(new Date()).hours(23).minutes(59).seconds(59).milliseconds(59)

        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            // defaultDate: startDate,
            useCurrent: false,
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            // defaultDate: endDate,
            useCurrent: false,
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
        var fromDatetime = $("#fromDate").val();
        var toDatetime = $("#toDate").val();
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
        let uri = getUri();
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        
        rs += "<td>" +
            `<a href="<?php echo admin_url('useraggregate')?>?nn=${value.nickname}&us=${value.username}&st=${value.status}&${uri}" style="color: blue">${value.nickname}</a>` + "</td>";
        rs += "<td>" + commaSeparateNumber(value.vinTotal) + "</td>";
        rs += "<td>" + bacVippoint(value.vippointSave) + "</td>";
        rs += "<td>" + (value.mobile || '-') + "</td>";
        rs += "<td>" + (value.referral_code || '-') + "</td>";
        rs += "<td>" + (value.createTime || '-') + "</td>";
        rs += "<td class='option'>" +
            '<div class="tipS view-action text-info btn-circle pop-option" title="Xem tổng cược"> Tổng cược </div>' +
            '<div class="tipS change-password-user-action mt-2 pop-option" title="Đổi mật khẩu user">' +
                    '<img src="<?php echo public_url('admin') ?>/images/icons/key.png"/>' +
            '</div>' +
            `<div class="pop-option mt-2" title="Cập nhật mã đại lý" onclick="openModel('${value.nickname}')">` +
                'Cập nhật mã đại lý' +
            '</div>' +
            "</td>";
        return rs;
    }

    function openModel(nn) {
        $("#nickname-visible").html(nn);
        $("#nickname-invisible").val(nn);
        $('#agent-bootstrap-modal').modal('show');
        $('#code-agent').val('');
    }

    $("#agent-form-submit").click(function () {
        $("#spinner").show();
        $('#agent-bootstrap-modal').modal('hide');
        $.ajax({
            type: "POST",
            url: "<?= admin_url('usergame/alertUserAgentCodeAjax')?>",
            data: {
                cd: $('#code-agent').val(),
                nn: $('#nickname-invisible').val()
            },
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                console.log(result);
                if (result.errorCode == '0') {
                    alert('Cập nhật mã đại lý thành công.');
                    return;
                }
                alert(result.message);
            },
            error: function () {
                $("#spinner").hide();
                alert('Cập nhật thất bại.');
            },
            timeout: 40000
        });
    });

    function getUri()
    {
        let uri = ``;
        let nickname = $("#nickname").val();
        if (nickname != undefined && nickname.length) {
            uri = uri + `nickname=${nickname}&`;
        }

        let refcode = $("#refcode").val();
        if (refcode != undefined && refcode.length) {
            uri = uri + `refcode=${refcode}&`;
        }

        let typetaikhoan = $("#typetaikhoan").val();
        if (typetaikhoan != undefined && typetaikhoan.length) {
            uri = uri + `typetaikhoan=${typetaikhoan}&`;
        }

        let record = $("#record").val();
        if (record != undefined && record.length) {
            uri = uri + `record=${record}&`;
        }

        let phone = $("#phone").val();
        if (phone != undefined && phone.length) {
            uri = uri + `phone=${phone}&`;
        }

        let txtemail = $("#txtemail").val();
        if (txtemail != undefined && txtemail.length) {
            uri = uri + `txtemail=${txtemail}&`;
        }

        let fromDate = $("#fromDate").val();
        if (fromDate != undefined && fromDate.length) {
            uri = uri + `fromDate=${fromDate}&`;
        }

        let toDate = $("#toDate").val();
        if (toDate != undefined  && toDate.length) {
            uri = uri + `toDate=${toDate}&`;
        }

        return uri.length ? encodeURI(uri) : '';
    }

    function handleActionListener() {
        $('.tipS.view-action').click( function (e){
            let item_index = $(this).closest('td').siblings('.stt').text()
            let value = list_data[(item_index -1)%page_size]

            e.preventDefault()

            $("#spinner").show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('withdraw/list_provider_support_ajax')?>",
                data: {
                    "orderId":  value.Id
                },
                dataType: 'json',
                success: function (response) {
                    $("#spinner").hide();
                    if (response.success) {
                        $("#resultsearch").html("");

                        if(response.data == "" ||  response.data == "[ ]" || response.data.length == 0 ) {
                            bootbox.alert({
                                message: `<i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Không có nhà cung cấp thỏa mãn <b>orderId ${value.Id}</b>`,
                                backdrop: true,
                                centerVertical: true
                            })
                        } else {
                            // call data get provider to show
                            bootbox.prompt({
                                title: "Chấp nhận giao dịch!",
                                message: messageBody(value) + '</br><p><b>Chọn 1 trong các tài khoản dưới để hoàn thành giao dịch:</b</p>',
                                inputType: 'radio',
                                inputOptions: JSON.parse(response.data).map(x => ({
                                    'text': x,
                                    'value': x
                                })),
                                callback: function (result) {
                                    if (result) {
                                        $("#spinner").show();
                                        // call to send data
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo admin_url('withdraw/accept_ajax')?>",
                                            data: {
                                                "orderId":  value.Id,
                                                "nickName": value.Nickname,
                                                "providerName": result,
                                            },
                                            dataType: 'json',
                                            success: function (response) {
                                                $("#spinner").hide();
                                                if (response.success) {
                                                    $("#resultsearch").html("");
                                                    initData()
                                                } else {
                                                    bootbox.alert({
                                                        message: `<i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Đã có lỗi xảy ra ${response.errorCode} : ${response.message}`,
                                                        backdrop: true,
                                                        centerVertical: true
                                                    })
                                                    initData()
                                                }

                                            }, error: function (e) {
                                                console.error(e.message)
                                                $("#spinner").hide();
                                                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                                            }, timeout: 20000
                                        })
                                    }
                                }
                            });
                        }

                    } else {
                        bootbox.alert({
                            message: `<i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Đã có lỗi xảy ra ${response.errorCode} : ${response.message}`,
                            backdrop: true,
                            centerVertical: true
                        })
                        initData()
                    }

                }, error: function (e) {
                    console.error(e.message)
                    $("#spinner").hide();
                    $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                }, timeout: 20000})
        })
        $('.tipS.change-password-user-action').click( function (e){
            e.preventDefault()

            let item_index = $(this).closest('td').siblings('.stt').text()
            let value = list_data[(item_index -1)%page_size]
            let nickname = value ? value.nickname : undefined
            if (!nickname) {
                bootbox.alert({
                    message: `<i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Không tìm thấy nickname`,
                    backdrop: true,
                    centerVertical: true
                })
                return false;
            } else {
                bootbox.prompt({
                    title: `Reset password user <b>${nickname}</b>!`,
                    message: `<p>Nhập lại chính xác <b>${nickname}</b> để thực hiện hành động.</br>Password sau reset mặc định là <b>123456</b>:</p>`,
                    callback: function (result) {
                        if(result.trim() == nickname) {
                            $("#spinner").show();
                            $.ajax({
                                type: "POST",
                                url: "<?php echo admin_url('usergame/pwd_uservinplayajax')?>",
                                data: {
                                    "reason": result.trim()
                                },
                                dataType: 'json',
                                success: function (response) {
                                    $("#spinner").hide();
                                    if (response.success) {
                                        $("#resultsearch").html("");

                                        bootbox.alert({
                                            message: `<i class="fa fa-times-circle text-success" aria-hidden="true"></i> Reset mật khẩu ${nickname} thành công. Mật khẩu mới: <b>123456</b>.`,
                                            backdrop: true,
                                            centerVertical: true
                                        })
                                    } else {
                                        bootbox.alert({
                                            message: `<i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Đã có lỗi xảy ra ${response.errorCode} : ${response.message}`,
                                            backdrop: true,
                                            centerVertical: true
                                        })
                                    }

                                }, error: function (e) {
                                    console.error(e.message)
                                    $("#spinner").hide();
                                    $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                                }, timeout: 20000})
                        } else {
                            bootbox.alert({
                                message: `<i class="fa fa-times-circle" aria-hidden="true"></i> Nhập lại nickname đi cưng`,
                                backdrop: true,
                                centerVertical: true
                            })
                        }
                    }
                });
            }
        })
    }

    function initData() {
        var oldPage = 0;
        var result = "";
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('usergame/uservinplayajax')?>",
            data: {
                username: $("#username").val(),
                nickname: $("#nickname").val(),
                phone: $("#phone").val(),
                fieldname: $("#fieldname").val(),
                timkiemtheo: $("#timkiemtheo").val(),
                toDate: $("#toDate").val(),
                fromDate: $("#fromDate").val(),
                typetaikhoan: $("#typetaikhoan").val(),
                pages: 1,
                size: page_size,
                record: $("#record").val(),
                typetk: $("#typetimkiem").val(),
                email: $("#txtemail").val(),
                refcode: $("#refcode").val(),
            },
            dataType: 'json',
            success: function (response) {
                $("#numuser").html(response.totalRecord);
                $("#spinner").hide();
                if (response.transactions == "") {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    $("#resultsearch").html("");
                    var totalPage = response.total;
                    list_data = response.transactions
                    stt = 1;
                    let str = ''
                    $.each(list_data, function (index, value) {
                        str += resultSearchTransction(stt, value);
                        stt++;
                    });
                    $('#logaction').html(str);
                    handleActionListener()
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if (oldPage > 0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('usergame/uservinplayajax')?>",
                                    data: {
                                        username: $("#username").val(),
                                        nickname: $("#nickname").val(),
                                        phone: $("#phone").val(),
                                        fieldname: $("#fieldname").val(),
                                        timkiemtheo: $("#timkiemtheo").val(),
                                        toDate: $("#toDate").val(),
                                        fromDate: $("#fromDate").val(),
                                        typetaikhoan: $("#typetaikhoan").val(),
                                        pages: page,
                                        size: page_size,
                                        record: $("#record").val(),
                                        typetk: $("#typetimkiem").val(),
                                        email: $("#txtemail").val(),
                                        refcode: $("#refcode").val(),
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        $("#resultsearch").html("");
                                        $("#spinner").hide();
                                        list_data = response.transactions
                                        stt = (page - 1) * page_size + 1;
                                        let str = ''
                                        $.each(list_data, function (index, value) {
                                            str += resultSearchTransction(stt, value);
                                            stt++;
                                        });
                                        $('#logaction').html(str);
                                        handleActionListener();
                                        $('[data-toggle="popover"]').popover()
                                    }, error: function (e) {
                                        list_data = []
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
                list_data = []
                console.error(e)
                $("#spinner").hide();
                $('#logaction').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            }, timeout: 20000
        })

    };
</script>
<script>
    function bacVippoint(strVip) {
        let strresult;
        if (strVip >= 0 && strVip <= 80) {
            strresult = "Đá";
        } else if (strVip >= 0 && strVip <= 800) {
            strresult = "Đồng";
        } else if (strVip > 800 && strVip <= 4500) {
            strresult = "Bạc";
        } else if (strVip > 4500 && strVip <= 8600) {
            strresult = "Vàng";
        } else if (strVip > 8600 && strVip <= 50000) {
            strresult = "Bạch Kim";
        } else if (strVip > 50000) {
            strresult = "Kim Cương";
        }
        return strresult;
    }

    function commaSeparateNumber(val) {
        if (val == undefined) {
            return '-'
        }
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
    $("#export").click(function () {
        $('#isEx').val(1);
        return;
    });
</script>
<style>
    .pop-option {
        color : #17a2b8;
        cursor: pointer;
    }
</style>
