<?php $this->load->view('admin/config/head', $this->data) ?>
<div class="line"></div>

<div class="wrapper">
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        <?php if ($admin_info->Status == "A"): ?>
            <div class="title">
                <h4>Set config nổ hũ tài xỉu<span style="color: #0000FF"></span></h4>
            </div>
            <div class="formRow">
                <div class="row">
                    <div class="col-sm-1 mr-2">
                        <select id="jp-option">
                            <option value="1">Jackpot xỉu</option>
                            <option value="0">Jackpot tài</option>
                        </select>
                    </div>
                    <div class="col-sm-1 ml-5">
                        <input type="button" id="no_hu" value="Duyệt" class="button blueB">
                    </div>
                </div>
            </div>


            <div class="modal fade" id="bsModal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            <p style="color: #0000ff">Bạn sửa config thành công</p>
                        </div>
                        <div class="modal-footer">
                            <input class="blueB logMeIn" type="button" value="Đóng" data-dismiss="modal"
                                   aria-hidden="true">
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="title">
                <h4>Bạn không được phân quyền</h4>
            </div>
        <?php endif; ?>
    </div>
</div>
<style>.spinner {
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
<div id="spinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
</div>

<script>
    $("#no_hu").click(function () {
        $("#spinner").show();
        var data;
        if ($('#jp-option').val() == 1) {
            data = '{"listFund":[1]}';
        } else {
            data = '{"listFund":[0]}';
        }
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('confignew/successEditTaiXiuHandleAjax')?>",
            data: {
                t: 28,
                message: JSON.stringify(JSON.parse(data))
            }, dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                $("#resultsearch").html("");
                window.location='<?php echo admin_url('confignew/configgame') ?>';
            }, error: function (xhr) {
                window.location='<?php echo admin_url('login') ?>';
            }
        });
    });

    $('#bsModal3').on('hidden.bs.modal', function () {
        location.reload();
    });
</script>