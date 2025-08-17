<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
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

        
        

        
        
        
        <script
                src="<?php echo public_url() ?>/site/bootstrap/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo public_url() ?>/js/jquery.table2excel.js"></script>
        <div class="widget">
            <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
            <div class="title">
                <h6>Cấu hình hũ</h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('transaction/logtranfer') ?>" method="post">
                <div class="formRow">

                    <table>
                        <tr>

                            <td><label style="margin-left: 30px;margin-bottom:-2px;width: 100px">Thể loại:</label></td>
                            <td><select id="type" name="type"
                                        style="margin-left: 20px;margin-bottom:-2px;width: 145px;">
                                    <option value="0">Tài xỉu</option>
                                    <option value="1">Pot</option>
                                    <option value="2">Fund</option>
                                </select></td>
                        </tr>

                    </table>

                </div>

            </form>
            <div class="formRow"></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                <thead>
                <tr style="height: 20px;">
                    <td>STT</td>
                    <td>Key</td>
                    <td>Value</td>
                    <td style="width: 10%;">Action</td>
                </tr>
                </thead>
                <tbody id="tableResult">
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modalChange" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thay đổi cấu hình:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="display: flex;">
                        <div style="flex: 1">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Key</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="key_input_m">
                                </div>
                            </div>
                        </div>
                        <div style="width: 20px;"></div>
                        <div style="flex: 1">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Value</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="value_input_m">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="payTransaction()">Thực hiện</button>
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
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>

</div>
<script>
    $("#search_tran").click(function () {

    });

    var request={};

    var data = [];

    function payTransaction() {
        $('#modalChange').modal('hide');
        var index=parseInt($("#modalChange").attr("data-value"));
        var item = data[index];
        if (item){
            request.action="update";
            request.key=$("#key_input_m").val();
            request.value=$("#value_input_m").val();
            request.type=item.type;
            $("#spinner").show();
            loadData();
        }
    }

    $('#type').on('change', function () {
        $('#spinner').show();
        request={
            type:$("#type").val()
        }
        loadData();
    });    function loadData() {
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('config/fundpotconfigAjax')?>",
            data: request,
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                $("#tableResult").html("");
                if (result.errorCode === "0") {
                    data = result.data;
                    var tr = [];
                    data.map((item, index) => {
                        tr.push('<tr>');
                        tr.push("<td>" + (index + 1) + "</td>");
                        tr.push("<td>" + item.key + "</td>");
                        tr.push("<td>" + item.value + "</td>");
                        tr.push(' <td data-toggle="tooltip" data-placement="left" title="Sửa thông tin">\n' +
                            '                            <a\n' +
                            '\n' +
                            '                                    data-value="' + index + '"\n' +
                            '                                    data-toggle="modal" data-target="#modalChange"\n' +
                            '                                    class="actionEditInfo"\n' +
                            '                                    style="padding:5px 10px; cursor: pointer">\n' +
                            '                                <i class="fa fa-rocket" aria-hidden="true"></i>\n' +
                            '                            </a>\n' +
                            '                        </td>');
                        tr.push('</tr>');
                    });
                    $('#tableResult').append($(tr.join('')));
                    $(".actionEditInfo").on("click", function () {
                        const index = $(this).attr("data-value");
                        const item = data[parseInt(index)];
                        $("#key_input_m").val(item.key);
                        $("#value_input_m").val(item.value);
                        $("#modalChange").attr("data-value",index);
                    });
                }

            }, error: function () {
                $("#spinner").hide();
                $('#logaction').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            }, timeout: 20000
        });
    }

    $(document).ready(function () {
        var oldPage = 0;
        var result = "";
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        request.type=$("#type").val();
        loadData();
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
<style>
    .modal-backdrop {
        display: none;
    }
</style>