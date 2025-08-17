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

        <link rel="stylesheet" href="<?php echo public_url() ?>/site/bootstrap/bootstrap.min.css">
        <link rel="stylesheet"
              href="<?php echo public_url() ?>/site/bootstrap/bootstrap-datetimepicker.css">
        <script src="<?php echo public_url() ?>/site/bootstrap/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo public_url() ?>/js/jquery.twbsPagination.js"></script>
        <script src="<?php echo public_url() ?>/site/bootstrap/moment.js"></script>
        <script src="<?php echo public_url() ?>/site/bootstrap/bootstrap.min.js"></script>
        <script
                src="<?php echo public_url() ?>/site/bootstrap/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo public_url() ?>/js/jquery.table2excel.js"></script>
        <div class="widget">
            <div>
                <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
                <div class="title">
                    <h6>Cấu hình tài xỉu</h6>
                </div>
                <div style="display: flex;">
                    <div style="flex: 1">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">vui lòng đặt kq 1 là tài  0 là xỉu</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="input_win">
                            </div>
                        </div>
                    </div>
                    
                    <button style="margin-left: 10px;" id="btn_submit1" type="button" class="btn btn-primary" >Cập nhật</button>
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
<div class=" container" style="margin-right:20px;">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>"
             alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>

</div>
<script>


    var data = [];

    $("#btn_submit1").click(function (e) {
        $("#spinner").show();

        var request={
            win:$("#input_win").val(),
            lose:$("#input_lose").val(),
            b:1
        };
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/updatetaixiuconfigAjax')?>",
            dataType: 'json',
            data: request,
            success: function (result) {
                $('#spinner').hide();
                if (result.errorCode === "0") {
                } else {
                }
            },
            error:function () {
                $('#spinner').hide();
            }
        });
    });

    $("#btn_submit2").click(function (e) {
        $("#spinner").show();

        var request={
            win:$("#input_win2").val(),
            lose:$("#input_lose2").val(),
            b:2
        };
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/updatetaixiuconfigAjax')?>",
            dataType: 'json',
            data: request,
            success: function (result) {
                $('#spinner').hide();
                if (result.errorCode === "0") {
                } else {
                }
            },
            error:function () {
                $('#spinner').hide();
            }
        });
    });





    function loadData() {
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('report/taixiuconfigAjax')?>",
            data: {},
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if (result.data){
                    $("#input_win").val(result.data.txFollow1);
                    $("#input_lose").val(result.data.txNotFollow1);
                    $("#input_win2").val(result.data.txFollow2);
                    $("#input_lose2").val(result.data.txNotFollow2);
                }
            }, error: function () {
                $("#spinner").hide();
                $('#logaction').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            }, timeout: 20000
        });
    }

    $(document).ready(function () {
        $("#spinner").show();
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