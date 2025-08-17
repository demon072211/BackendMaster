<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Đồng bộ dữ liệu</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>

    <div class="widget">
        <div class="title">
            <h6>Đồng bộ dữ liệu</h6>
        </div>
        <div class="list_filter form">
            <div class="formRow row" style="height: 250px">
                <div class="col-sm-1">
                    <label for="giftCode">Game name : </label>
                </div>
                <div class="col-sm-2">
                    <select id="gn" name="gt">
                        <option value="ibc" <?php if ($this->input->post('gn') == 'ibc') { echo "selected";} ?>>IBC</option>
                        <option value="wm" <?php if ($this->input->post('gn') == 'wm') { echo "selected";} ?>>WM</option>
                        <option value="ag" <?php if ($this->input->post('gn') == 'ag') { echo "selected";} ?>>AG</option>
                    </select>
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Từ ngày : </label>
                </div>
                <div class="col-sm-2">
                    <div class="input-group" id="datetimepicker1">
                        <input type="text" id="from-date" name="ft" value="<?php echo $this->input->post('ft') ?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-sm-1">
                    <label for="giftCode">Đến ngày : </label>
                </div>
                <div class="col-sm-2">
                    <div class="input-group" id="datetimepicker2">
                        <input type="text" id="end-date" name="et" value="<?php echo $this->input->post('et') ?>">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-1">
                    <button type="button" id="sync" class="btn btn-primary">Đồng bộ</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12" style="display: none" id="result-context">
                    Đồng bộ dữ liệu : <span id="result-records"></span> bản ghi.
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?= public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#sync").click(function() {
            if ($('#gn').val() == '' || $('#from-date').val() == '' || $('#end-date').val() == '') {
                alert('Nhập game name và ngày')
                return;
            }
            if ($('#from-date').val() > $('#end-date').val()) {
                alert('Ngày bắt đầu lớn hơn ngày kết thúc')
                return;
            }
            $("#sync").prop("disabled",true);
            $("#spinner").show();
            $.ajax({
                type: "POST",
                url: "<?= admin_url("usergame/syncDataAjax") ?>",
                data: {
                    gn: $('#gn').val(),
                    ft: $('#from-date').val(),
                    et: $('#end-date').val()
                },
                dataType: 'json',
                success: function (result) {
                    console.log(result);
                    $("#spinner").hide();
                    $("#sync").prop("disabled", false);
                    document.getElementById("result-context").style.display = "block";
                    $("#result-records").html(result.totalData);
                }
            })
        });
    })

    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: "<?= date('Y-m-d')?>"
    });
    $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: "<?= date('Y-m-d')?>"
    });
</script>
<style>
</style>