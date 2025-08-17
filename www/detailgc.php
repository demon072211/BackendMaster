
<section class="content-header">
    <h1>
       Sử dụng giftcode
    </h1>
</section>
<h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <input id="nickname" type=hidden value="<?php echo $nickname ?>">

                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Giftcode</th>
                                        <th>Nickname</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày sử dụng</th>
                                    </tr>
                                    </thead>
                                    <tbody id="logaction">

                                    </tbody>
                                </table>

                                <div id="spinner" class="spinner" style="display:none;">
                                    <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>"
                                         alt="Loading"/>
                                </div>
                                <div class="text-center pull-right">
                                    <ul id="pagination-demo" class="pagination-sm"></ul>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</section>
<style>
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
<script>

    function resultgiftcodevin(stt,giftcode,nickname,createtime,usetime) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + giftcode + "</td>";
        rs += "<td>" + nickname + "</td>";
        rs += "<td>" + createtime + "</td>";
        rs += "<td>" + usetime + "</td>";
        rs += "</tr>";
        return rs;
    }
    $(document).ready(function () {
        var result = "";
        var oldpage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();

            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('usergame/detailgcajax') ?>",
                data: {
                    nickname: $("#nickname").val()
                },

                dataType: 'json',
                success: function (result) {
                    $("#spinner").hide();
                    if(result.transactions == ""){
                        $("#resultsearch").html("Không tìm thấy kết quả")
                    }else {
                        var totalPage = result.total;
                        var countrow = result.totalRecord;
                        $("#num").html(countrow);
                        stt = 1;
                        $.each(result.transactions, function (index, value) {
                            result += resultgiftcodevin(stt,value.giftCode, value.nickName,value.createTime,value.updateTime);
                            stt++;
                        });
                        $('#logaction').html(result);
                        $('#pagination-demo').twbsPagination({
                            totalPages: totalPage,
                            visiblePages: 5,
                            onPageClick: function (event, page) {
                                if (oldpage > 0) {
                                    $("#spinner").show();
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo admin_url('usergame/detailgcajax') ?>",
                                        data: {
                                            nickname: $("#nickname").val()
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $("#spinner").hide();
                                            stt = 1;
                                            $.each(result.transactions, function (index, value) {
                                                result += resultgiftcodevin(stt,value.giftCode, value.nickName,value.createTime,value.updateTime);
                                                stt++;
                                            });
                                            $('#logaction').html(result);
                                        }, error: function () {
                                            $("#spinner").hide();
                                            $('#logaction').html("");
                                            $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698");
                                        },timeout : 20000
                                    });
                                }
                                oldpage = page;
                            }
                        });
                    }
                }, error: function () {
                    $("#spinner").hide();
                    $('#logaction').html("");
                    $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698");
                },timeout : 20000
            });
    });
</script>