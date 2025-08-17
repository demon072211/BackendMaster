<div>
    <h4 id="taixiuResultsearch" style="color: red;margin-left: 20px"></h4>
      <div class="title">
          <h4>SET RESULT TÀI XỈU<span style="color: #0000FF"></span></h4>
      </div>
      <div class="formRow">
          <div class="row">
              <div class="col-sm-1">
                  <label class="nickname">Result:</label>
              </div>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="taixiuResult">
              </div>
          </div>
      </div>
      <div class="formRow">
          <div class="row">
              <div class="col-sm-1">
                  <input type="button" id="taixiu" value="Set Result" class="button blueB">
              </div>
          </div>
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

    #taixiu {
        margin-left: -2px;
    }

    .title .title-jackpot {
        margin-left: -10px;
    }

    .nickname {
        margin-left: -4px;
    }
</style>
<div id="taixiuSpinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
</div>

<script>
    $("#taixiu").click(function () {
        if ($("#taixiuResult").val() == "") {
            alert("vui lòng nhập Result");
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('usergame/setresultonlytaixiuajax')?>",
                data: {
                    result: $("#taixiuResult").val(),
                }, dataType: 'json',
                success: function (result) {
                    $("#taixiuSpinner").hide();
                    $("#taixiuResultsearch").html("");
                    window.location = '<?php echo admin_url('usergame/setresulttaixiu') ?>';
                }, error: function (xhr) {
                    window.location = '<?php echo admin_url('login') ?>';
                }
            });
        }
    });

</script>