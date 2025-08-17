<div class="line"></div>
<div class="wrapper">
    <p id="message" style="color: #0000FF"></p>
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        <?php if ($admin_info->Status == "A"): ?>
            <div class="title">
                <h4>SET USER TỈ LỆ THẮNG CAO <span style="color: #0000FF"></span></h4>
            </div>
            <div class="formRow">
                <div class="row">
                    <div class="col-sm-1">
                        <label class="nickname">Nickname:</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="nickName">
                    </div>

                    <div class="col-sm-1">
                        <label class="nickname">Loại User:</label>
                    </div>
                    <div class="col-sm-2">
                        <select id="user_type" name="ut">
                            <option value="0" selected>Người chơi</option>
                            <option value="1">bot</option>
                            <option value="2">TEST sport</option>
                            <option value="3">TEST xóc đĩa</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="formRow">
                <div class="row">
                    <div class="col-sm-1">
                        <input type="button" id="search_tran" value="Set tỉ lệ" class="button blueB">
                    </div>
                </div>
            </div>

                <div class="title">
                    <h6 class="title-jackpot">Danh sách user tỉ lệ thắng cao</h6>
                </div>
                <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                    <thead>
                    <tr>
                        <td>STT</td>
                        <td>Nickname</td>
                        <td>Status</td>
                        <td>Hành động</td>
                    </tr>
                    </thead>
                    <tbody id="logaction">

                    </tbody>
                </table>
        <?php else: ?>
            <div class="title">
                <h4>Bạn không được phân quyền</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

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
    }

    #search_tran {
        margin-left: -2px;
    }

    .widget .title .title-jackpot {
        margin-left: -10px;
    }

    .nickname {
        margin-left: -4px;
    }
</style>
<div id="spinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
</div>

<script>
    $("#search_tran").click(function () {
        if ($("#user_type").val() == "") {
            alert("Vui lòng chọn loại user");
        } else if($("#nickName").val() == ""){
            alert("Vui lòng nhập Nickname");
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('usergame/setuserwinajax')?>",
                data: {
                    nickname: $("#nickName").val(),
                    ut: $("#user_type").val()
                }, dataType: 'json',
                success: function (result) {
                    $("#spinner").hide();
                    $("#resultsearch").html("");
                    window.location='<?php echo admin_url('usergame/setuserwin') ?>';
                }, error: function (xhr) {
                    window.location='<?php echo admin_url('login') ?>';
                }
            });
        }
    });

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('usergame/listuserwinajax')?>",
            data: {
            },
            dataType: 'json',
            success: function (result) {
                stt = 1;
                if(result.data) {
                    $.each(result.data, function (index, value) {
                        result += resultSearchTransction(stt, index, value);
                        stt++;
                    });
                    $('#logaction').html(result);
                    remove();
                }
            }, error: function () {
                $('#logaction').html("");
                $("#spinner").hide();
                $("#error-popup").modal("show");
            }, timeout: 40000
        });
    });

    function resultSearchTransction(stt,key, value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td class='key'>" + key + "</td>";
        rs += "<td class='inactive'>" + (value ? '<span class="text-success" style="text-align: center;"><i class="fa fa-check" aria-hidden="true"></i></span>' : 'inactive') + "</td>";
        rs += "<td>" +
            '<a href="" class="tipS reject-action verify_action text-danger btn-circle"> <i class="fa fa-times" aria-hidden="true"></i></a>'
           + "</td>";
        rs += "</tr>";
        return rs;
    }

    function remove() {
        $(".tipS.reject-action").click(function () {
            if(confirm("Bạn có chắc chắn xóa không?")) {
                let value = $(this).closest('td').siblings('.key').text();
                $.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('usergame/deleteuserwinajax')?>",
                    data: {
                        nickname: value,
                    },
                    dataType: 'json',
                    success: function (result) {
                    }, error: function () {
                        $('#logaction').html("");
                        $("#spinner").hide();
                        $("#error-popup").modal("show");
                    }, timeout: 40000
                });
            }
        });
    }
</script>