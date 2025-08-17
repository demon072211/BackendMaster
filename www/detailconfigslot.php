<?php $this->load->view('admin/config/head', $this->data) ?>
<div class="line"></div>

<div class="wrapper">
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        

        
        <?php if ($admin_info->Status == "A"): ?>
            <div class="title">
                <h4>Sửa config <span style="color: #0000FF"></span></h4>
            </div>
            <div class="formRow">
                <div class="row">
                    <div class="col-sm-1">
                        <input type="button" id="search_tran" value="Lưu config" class="button blueB">
                    </div>
                </div>
            </div>

            <div class="formRow">
                <div class="row">
                    <div class="col-sm-4">
                        <textarea id="myTextArea" cols=100 rows=30 style="color: #0000ff;font-size: 20px"></textarea>
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

<script>    $("#search_tran").click(function () {
            var url_string = window.location.href;
            var url = new URL(url_string);
            var c = url.searchParams.get("t");
            var data = $("#myTextArea").val();
            var myJSONString = data.replace(/\n/g, ' ').replace(/\t/g, ' ').replace(/  +/g, "");
            if (isValidJSON(myJSONString) == false) {
                $("#message").html("");
                $("#resultsearch").html("Không phải dữ liệu json");
                return false;
            }
            $("#spinner").show();
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('confignew/successeditslotajax')?>",
                data: {
                    t: c,
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
    $(document).ready(function () {
        var url_string = window.location.href;
        var url = new URL(url_string);
        var c = url.searchParams.get("t");
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('confignew/editslotajax')?>",
            data: {
                t: c
            },
            dataType: 'json',
            success: function (result) {
                obj = JSON.parse(result.message);
                var str = JSON.stringify(obj, undefined, 40);
                document.getElementById('myTextArea').innerHTML = str;
            }
        });
    });

    function isValidJSON(string) {
        try {
            JSON.parse(string);
        } catch (e) {
            return false;
        }

        return true;
    }
</script>