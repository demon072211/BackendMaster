<div>
    <h4 id="baucuaResultsearch" style="color: red;margin-left: 20px"></h4>
	<?php if ($admin_info->Status == "A"): ?>
      <div class="title">
          <h4>SET RESULT BẦU CUA<span style="color: #0000FF"></span></h4>
      </div>
      <div class="formRow">
          <div class="row">
              <div class="col-sm-1">
                  <label class="nickname">Result:</label>
              </div>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="baucuaResult">
              </div>
          </div>
      </div>
      <div class="formRow">
          <div class="row">
              <div class="col-sm-1">
                  <input type="button" id="baucua" value="Set Result" class="button blueB">
              </div>
          </div>
      </div>

      <div class="title">
          <h6 class="title-jackpot">Result bầu cua</h6>
      </div>
      <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck">
          <thead>
          <tr>
              <td style="min-width: 700px">Result</td>
              <td>Hành động</td>
          </tr>
          </thead>
          <tbody id="baucuaLogaction">
          <tr>
              <td id="baucuaResultData"></td>
              <td><a href="" id="baucua-icon" class="tipS reject-action verify_action text-danger btn-circle"> <i
                              class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>
          </tbody>
      </table>
	<?php else: ?>
      <div class="title">
          <h4>Bạn không được phân quyền</h4>
      </div>
	<?php endif; ?>
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

    #baucua {
        margin-left: -2px;
    }

    .title .title-jackpot {
        margin-left: -10px;
    }
    
    .nickname {
        margin-left: -4px;
    }
</style>
<div id="baucuaSpinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
</div>

<script>
    $("#baucua").click(function () {
        if ($("#baucuaResult").val() == "") {
            alert("vui lòng nhập Result");
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('usergame/setresultbaucuaajax')?>",
                data: {
                    result: $("#baucuaResult").val(),
                }, dataType: 'json',
                success: function (result) {
                    $("#baucuaSpinner").hide();
                    $("#baucuaResultsearch").html("");
                    window.location = '<?php echo admin_url('usergame/setresult') ?>';
                }, error: function (xhr) {
                    window.location = '<?php echo admin_url('login') ?>';
                }
            });
        }
    });

    $(document).ready(function () {
        listresultbaucua()
    });

    function listresultbaucua() {
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('usergame/listresultbaucuaajax')?>",
            data: {},
            dataType: 'json',
            success: function (result) {
                if (result.data == null) {
                    $("#baucuaResultsearch").html("Không tìm thấy kết quả");
                    $('#baucuaLogaction').hide();
                } else {
                    var rs = result.data[0] + ',' + result.data[1] + ',' + result.data[2];
                    $('#baucuaLogaction').show();
                    $("#baucuaResultData").html(rs);
                    removebaucua()
                }
            }, error: function () {
                $('#baucuaLogaction').html("");
                $("#baucuaSpinner").hide();
            }, timeout: 40000
        });
    }

    function removebaucua() {
        $("#baucua-icon").click(function () {
            if (confirm("Bạn có chắc chắn xóa không?")) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('usergame/deleteresultbaucuaajax')?>",
                    data: {},
                    dataType: 'json',
                    success: function (result) {
                    }, error: function () {
                        $('#baucuaLogaction').html("");
                        $("#baucuaSpinner").hide();
                    }, timeout: 40000
                });
            }
        });
    }
</script>