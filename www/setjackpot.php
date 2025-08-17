<div class="line"></div>
<div class="wrapper">
    <p id="message" style="color: #0000FF"></p>
    <div class="widget">
        <h4 id="resultsearch" style="color: red;margin-left: 20px"></h4>
        

        
        <?php if ($admin_info->Status == "A"): ?>
            <div class="title">
                <h4>SET NỔ HŨ <span style="color: #0000FF"></span></h4>
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
                        <label class="gameid">GameID:</label>
                    </div>
                    <div class="col-sm-2">
                        <select id="gameID">
                            <option value="160">160 - Chim điên</option>
                            <option value="110">110 - Đua xe</option>
                            <option value="150">150 - Thể thao</option>
                            <option value="120">120 - Thần tài</option>
                            <option value="170">170 - Bitcoin</option>
                            <option value="6">6 - Pokemon</option>
                            <option value="191">191 - Chiêm tinh</option>
                            <option value="1">1 - Minipoker</option>
                            <option value="180">180 - Thần bài</option>
                            <option value="197">197 - Bikini</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="formRow">
                <div class="row">
                    <div class="col-sm-1">
                        <label class="betvalue">Betvalue:</label>
                    </div>
                    <div class="col-sm-2">
                        <select id="betValue">
                            <option value="100">100</option>
                            <option value="1000">1000</option>
                            <option value="5000">5000</option>
                            <option value="10000">10000</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="formRow">
                <div class="row">
                    <div class="col-sm-1">
                        <input type="button" id="search_tran" value="Set Nổ Hũ" class="button blueB">
                    </div>
                </div>
            </div>

                <div class="title">
                    <h6 class="title-jackpot">Danh sách Nổ hũ</h6>
                </div>
                <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                    <thead>
                    <tr>
                        <td>STT</td>
                        <td>Nickname</td>
                        <td>GameID</td>
                        <td>Betvalue</td>
                        <td>Delete</td>
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

    .nickname,
    .gameid,
    .betvalue {
        margin-left: -4px;
    }

    #gameID,
    #betValue {
        width: 214px;
    }
</style>
<div id="spinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
</div>

<script>
    var list_data = [];
    $("#search_tran").click(function () {
        if($("#nickName").val() == ""){
            alert("vui lòng nhập Nickname");
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('usergame/setjackpotajax')?>",
                data: {
                    nickname: $("#nickName").val(),
                    gameid: $("#gameID").val(),
                    betvalue: $("#betValue").val()
                }, dataType: 'json',
                success: function (result) {
                    $("#spinner").hide();
                    $("#resultsearch").html("");
                    window.location='<?php echo admin_url('usergame/setjackpot') ?>';
                }, error: function (xhr) {
                    window.location='<?php echo admin_url('login') ?>';
                }
            });
        }
    });

    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('usergame/listjackpotajax')?>",
            data: {
            },
            dataType: 'json',
            success: function (result) {
                list_data = result.listUserJackpot;
                stt = 1;
                $.each(result.listUserJackpot, function (index, value) {
                    result += resultSearchTransction(stt, value);
                    stt++;
                });
                $('#logaction').html(result);
                remove();
            }, error: function () {
                $('#logaction').html("");
                $("#spinner").hide();
                $("#error-popup").modal("show");
            }, timeout: 40000
        });
    });

    function resultSearchTransction(stt,value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td class='stt'>" + stt + "</td>";
        rs += "<td>" + value.nickName + "</td>";
        rs += "<td>" + value.gameID + "</td>";
        rs += "<td>" + value.betValue + "</td>";
        rs += "<td>" +
            '<a href="" class="tipS reject-action verify_action text-danger btn-circle"> <i class="fa fa-times" aria-hidden="true"></i></a>'
           + "</td>";
        rs += "</tr>";
        return rs;
    }

    function remove() {
        $(".tipS.reject-action").click(function () {
            if(confirm("Bạn có chắc chắn xóa không?")) {
                let item_index = $(this).closest('td').siblings('.stt').text();
                let value = list_data[(item_index -1)];
                $.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('usergame/deletejackpotajax')?>",
                    data: {
                        nickname: value.nickName,
                        gameid: value.gameID,
                        betvalue: value.betValue
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