<?php $this->load->view('admin/useraggregate/head_bank', $this->data) ?>
<?php $this->load->view('admin/error') ?>
<?php $this->load->view('admin/message', $this->data); ?>
<div>
    <h4 id="bankResultsearch" style="color: red;margin-left: 20px"></h4>
    <div class="title">
        <h6>Thông tin Tài khoản ngân hàng</h6>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck">
        <thead>
        <tr style="height: 20px;">
            <td>STT</td>
            <td>Nick Name</td>
            <td>Tên</td>
            <td>Chi nhánh</td>
            <td>Tên ngân hàng</td>
            <td>Tài khoản</td>
            <td>Active</td>
            <td>Người sửa cuối cùng</td>
            <td>Ngày chỉnh sửa cuối cùng</td>
            <td>Hành động</td>
        </tr>
        </thead>
        <tbody id="bankLogaction">
        </tbody>
    </table>
</div>
<div class="container">
    <h6 class="total-data">Tổng bản ghi:<span class="total-data-span" id="bankTotalData"></span></h6>
    <div id="bankSpinner" class="spinner image-loggameslot">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="bankPagination" class="pagination-lg"></ul>
    </div>
</div>
<script>
    var page_size = '<?php echo $this->input->post('page_size') ?>' || 10;
    var list_data = [];
    $(document).ready(function () {
        $("#inputStatus").bootstrapToggle();
        bankInitData()
    });

    function bankResultSearchTransction(stt, value) {
        var date_ob = new Date(value.updateDate);

        var date = ("0" + date_ob.getDate()).slice(-2);

        var month = ("0" + (date_ob.getMonth() + 1)).slice(-2);

        var year = date_ob.getFullYear();

        if (date_ob.getHours() < 10) {
            var hours = ("0" + date_ob.getHours());
        } else {
            var hours = date_ob.getHours();
        }

        if (date_ob.getMinutes() < 10) {
            var minutes = ("0" + date_ob.getMinutes());
        } else {
            var minutes = date_ob.getMinutes();
        }

        if (date_ob.getSeconds() < 10) {
            var seconds = ("0" + date_ob.getSeconds());
        } else {
            var seconds = date_ob.getSeconds();
        }

        var updateDate = (year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds);

        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td class='' style='display: none'>" + value.id + "</td>";
        rs += "<td class=''>" + value.nickName + "</td>";
        rs += "<td class=''>" + value.customerName + "</td>";
        rs += "<td >" + (value.branch || '-') + "</td>";
        rs += "<td class=''>" + value.bankName + "</td>";
        rs += "<td class=''>" + value.bankNumber + "</td>";
        rs += "<td class='' style='text-align: center;'><i class='" + (value.status == 1 ? 'fa fa-check' : '') + "' aria-hidden='true'></i></td>";
        rs += "<td class=''>" + (value.lastEditor || '-') + "</td>";
        rs += "<td class=''>" + (updateDate) + "</td>";
        rs += "<td class='option'>" +
            "<a href='' title='Chỉnh sửa' class='tipS edit-action'> <img src=' <?php echo public_url('admin') ?>/images/icons/color/edit.png'/></a>" +
            "<a href='' title='Xóa' class='tipS delete-action verify_action'> <img src='<?php echo public_url('admin') ?>/images/icons/color/delete.png'/></a>" +
            "</td>";
        return rs;
    }

    function handleActionListener() {
        $('.tipS.edit-action').click(function (e) {
            e.preventDefault()

            $('#my-bootstrap-modal').modal('show')

            let item_index = $(this).closest('td').siblings('.stt').text()
            let value = list_data[(item_index - 1) % page_size]
            $("#inputId").val(value.id)
            $("#inputType").val(1) // edit
            $("#inputNickName").val(value.nickName)
            $("#inputCustomerName").val(value.customerName)
            $("#inputBankNumber").val(value.bankNumber)
            $("#inputBankName").val(value.bankName)
            $("#inputBranchName").val(value.branch)
            $("#inputStatus").bootstrapToggle(value.status === 1 ? 'on' : 'off')
        });

        $('.tipS.delete-action').click(function (e) {
            e.preventDefault();

            let item_index = $(this).closest('td').siblings('.stt').text();
            let value = list_data[(item_index - 1) % page_size]

            bootbox.confirm({
                message: 'Bạn có chắc chắn xóa <b>' + value.nickName + '</b></br>' + messageBody(value),
                backdrop: true,
                centerVertical: true,
                callback: function (result) {
                    if (result) {
                        // call to send data
                        $.ajax({
                            type: "POST",
                            url: "<?php echo admin_url('bankaccount/delete_ajax')?>",
                            data: {
                                "id": value.id,
                            },
                            dataType: 'json',
                            success: function (response) {
                                $("#bankSpinner").hide();
                                if (response.success) {
                                    $("#bankResultsearch").html("");
                                    bankInitData()
                                } else {
                                    bootbox.alert({
                                        message: `<i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Đã có lỗi xảy ra ${response.errorCode} : ${response.message}`,
                                        backdrop: true,
                                        centerVertical: true
                                    })
                                    bankInitData()
                                }

                            }, error: function (e) {
                                console.error(e.message)
                                $("#bankSpinner").hide();
                                $("#bankResultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                            }, timeout: 20000
                        })
                    }
                }
            });
        })
    }

    function messageBody(value) {
        return '<table class="table"><tr><th>Trường dữ liệu<th/><th>Thuộc tính<th/></tr>' +
            '<tr><td>Số tài khoản<td/><td>' + value.bankNumber + '<td/></tr>' +
            '<tr><td>Nickname<td/><td>' + value.nickName + '<td/></tr>' +
            '<tr><td>Tên<td/><td>' + value.customerName + '<td/></tr>' +
            '<tr><td>Ngân hàng<td/><td>' + value.bankName + '<td/></tr>' +
            '<tr><td>Chi nhánh<td/><td>' + (value.branch || '-') + '<td/></tr>' +
            '</table>'
    }

    function bankInitData() {
        var oldPage = 0;
        var result = "";
        $('#bankPagination').css("display", "block");
        $("#bankSpinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('bankaccount/indexajax')?>",
            data: {
                nickName: '<?= !empty($nn) ? $nn : ''?>',
                bankName: '',
                bankNumber: '',
                customerName: '',
                pages: 1,
                size: page_size
            },

            dataType: 'json',
            success: function (response) {
                let     result = JSON.parse(response.data)
                $("#bankSpinner").hide();
                if (result.total == 0 || result.data.length == 0) {
                    list_data = []
                    $('#bankPagination').css("display", "none");
                    $("#bankResultsearch").html("Không tìm thấy kết quả");
                    $("#bankLogaction").html("");
                    $("#bankTotalData").html("");
                } else {
                    list_data = result.data;
                    $("#bankTotalData").html($.number(result.total, undefined, '.', ','));
                    $("#bankResultsearch").html("");
                    let totalPage = Math.floor(result.total / page_size) + (result.total % page_size ? 1 : 0);
                    stt = 1;
                    let str = '';
                    $.each(result.data, function (index, value) {
                        str += bankResultSearchTransction(stt, value);
                        stt++;
                    });
                    $('#bankLogaction').html(str);
                    handleActionListener();

                    $('#bankPagination').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if (oldPage > 0) {
                                $("#bankSpinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo admin_url('bankaccount/indexajax')?>",
                                    data: {
                                        nickName: '<?= !empty($nn) ? $nn : ''?>',
                                        bankName: '',
                                        bankNumber: '',
                                        customerName: '',
                                        pages: 1,
                                        size: page_size
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        let     result = JSON.parse(response.data)
                                        list_data = result.data
                                        $("#bankResultsearch").html("");
                                        $("#bankSpinner").hide();
                                        stt = (page - 1) * page_size + 1;
                                        let str = ''
                                        $.each(result.data, function (index, value) {
                                            str += bankResultSearchTransction(stt, value);
                                            stt++;
                                        });
                                        $('#bankLogaction').html(str);
                                        handleActionListener()
                                    }, error: function () {
                                        list_data = []
                                        $("#bankSpinner").hide();
                                        $('#bankLogaction').html("");
                                        $("#bankResultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                                    }, timeout: 20000
                                });
                            }
                            oldPage = page;
                        }
                    });
                }

            }, error: function () {
                list_data = []
                $("#bankSpinner").hide();
                $('#bankLogaction').html("");
                $("#bankResultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            }, timeout: 20000
        })

    };
</script>