<div>
  <h4 id="taixiumd5Resultsearch" style="color: red;margin-left: 20px"></h4>
  <?php if ($admin_info->Status == "A") : ?>
    <div class="title">
      <h4>SET RESULT TÀI XỈU MD5<span style="color: #0000FF"></span></h4>
    </div>
    <div class="formRow">
      <div class="row">
        <div class="col-sm-1">
          <label class="nickname">Result:</label>
        </div>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="taixiumd5Result">
        </div>
      </div>
    </div>
    <div class="formRow">
      <div class="row">
        <div class="col-sm-1">
          <input type="button" id="taixiumd5" value="Set Result" class="button blueB">
        </div>
      </div>
    </div>

    <div class="title">
      <h6 class="title-jackpot">Result tài xỉu md5</h6>
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck">
      <thead>
        <tr>
          <td style="min-width: 700px">Result</td>
          <td>Hành động</td>
        </tr>
      </thead>
      <tbody id="taixiumd5Logaction">
        <tr>
          <td id="taixiumd5ResultData"></td>
          <td><a href="" id="taixiumd5-icon" class="tipS reject-action verify_action text-danger btn-circle"> <i class="fa fa-times" aria-hidden="true"></i></a></td>
        </tr>
      </tbody>
    </table>

    <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable topTable" style="margin-top: 45px;">
      <thead>
        <tr>
          <td style="width: 50%">Tài [<em id="taimd5OrderCount">0</em> order(s) ~ <em id="taimd5OrderTotal">0</em> VNĐ]</td>
          <td>Xỉu [<em id="xiumd5OrderCount">0</em> order(s) ~ <em id="xiumd5OrderTotal">0</em> VNĐ]</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable">
              <thead>
                <tr>
                  <td style="width: 60%">Người chơi</td>
                  <td>Cược</td>
                </tr>
              </thead>
              <tbody id="taimd5Order">
              </tbody>
            </table>
          </td>
          <td>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable">
              <thead>
                <tr>
                  <td style="width: 60%">Người chơi</td>
                  <td>Cược</td>
                </tr>
              </thead>
              <tbody id="xiumd5Order">
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  <?php else : ?>
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
    margin-left: -50px;
    /* half width of the spinner gif */
    margin-top: -50px;
    /* half height of the spinner gif */
    text-align: center;
    z-index: 1234;
    overflow: auto;
    width: 100px;
    /* width of the spinner gif */
    height: 102px;
    /*hight of the spinner gif +2px to fix IE8 issue */
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

  .topTable td {
    vertical-align: top !important;
  }
</style>
<div id="taixiumd5Spinner" class="spinner" style="display:none;">
  <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading" />
</div>

<script>
  $("#taixiumd5").click(function() {
    if ($("#taixiumd5Result").val() == "") {
      alert("vui lòng nhập Result");
    } else {
      $.ajax({
        type: "POST",
        url: "<?php echo admin_url('usergame/setresulttaixiumd5ajax') ?>",
        data: {
          result: $("#taixiumd5Result").val(),
        },
        dataType: 'json',
        success: function(result) {
          $("#taixiuSpinner").hide();
          $("#taixiumd5Resultsearch").html("");
          window.location = '<?php echo admin_url('usergame/setresulttaixiumd5') ?>';
        },
        error: function(xhr) {
          window.location = '<?php echo admin_url('login') ?>';
        }
      });
    }
  });

  $(document).ready(function() {
    listresulttaixiu();
    setInterval(listOrderTaiXiu, 1000);
  });

  // {"success":true,"message":null,"errorCode":"0","data":null,"total":1,"totalRecord":1,"transactions":[{"referenceId":237460,"user_name":"123xyz","bet_value":60000,"bet_side":0,"bet_time":33}]}
  // {"success":true,"message":null,"errorCode":"0","data":null,"total":1,"totalRecord":1,"transactions":[{"referenceId":237461,"user_name":"123xyz","bet_value":100000,"bet_side":1,"bet_time":33}]}
  function listOrderTaiXiu() {
    $.ajax({
      type: "GET",
      url: "<?php echo admin_url('usergame/listordertaixiumd5') ?>",
      data: {},
      dataType: 'json',
      success: function(result) {
        $('#taimd5Order').html('');
        $("#taimd5OrderCount").html(0);
        $("#taimd5OrderTotal").html(0);
        $('#xiumd5Order').html('');
        $("#xiumd5OrderCount").html(0);
        $("#xiumd5OrderTotal").html(0);
        if (result.totalRecord == 0) {
          $("#taimd5Order").hide();
          $('#xiumd5Order').hide();
        } else {
          // Tai Orders
          var taiOrderList = result.transactions.filter(function(txn) {
            if (txn.bet_side) {
              return txn
            }
          });
          //// Group orders by username
          taiOrderList = taiOrderList.reduce(function(res, txn) {
            if (txn.user_name in res) {
              res[txn.user_name]['bet_value'] += parseInt(txn.bet_value);
            } else {
              res[txn.user_name] = txn;
            }

            return res;
          }, {});
          taiOrderList = Object.values(taiOrderList);
          /// Display orders
          taiOrderList = taiOrderList.sort((a, b) => b.bet_value - a.bet_value);
          var taiRes = '';
          var taiOrderTotal = taiOrderList.reduce(function(sum, item) {
            return sum + parseInt(item['bet_value']);
          }, 0);
          $("#taimd5OrderCount").html(taiOrderList.length);
          $("#taimd5OrderTotal").html(taiOrderTotal.toLocaleString());
          for (var taiTxn of taiOrderList) {
            taiRes += '<tr><td><strong>';
            taiRes += taiTxn['user_name'];
            taiRes += '</strong></td><td style="text-align: right;">';
            taiRes += parseInt(taiTxn['bet_value']).toLocaleString();
            taiRes += '</td></tr>';
          }
          $('#taimd5Order').show();
          $("#taimd5Order").html(taiRes);
          // Xiu Orders
          var xiuOrderList = result.transactions.filter(function(txn) {
            if (!txn.bet_side) {
              return txn
            }
          });
          //// Group orders by username
          xiuOrderList = xiuOrderList.reduce(function(res, txn) {
            if (txn.user_name in res) {
              res[txn.user_name]['bet_value'] += parseInt(txn.bet_value);
            } else {
              res[txn.user_name] = txn;
            }

            return res;
          }, {});
          xiuOrderList = Object.values(xiuOrderList);
          /// Display orders
          xiuOrderList = xiuOrderList.sort((a, b) => b.bet_value - a.bet_value);
          var xiuRes = '';
          var xiuOrderTotal = xiuOrderList.reduce(function(sum, item) {
            return sum + parseInt(item['bet_value']);
          }, 0);
          $("#xiumd5OrderCount").html(xiuOrderList.length);
          $("#xiumd5OrderTotal").html(xiuOrderTotal.toLocaleString());
          for (var xiuTxn of xiuOrderList) {
            xiuRes += '<tr><td><strong>';
            xiuRes += xiuTxn['user_name'];
            xiuRes += '</strong></td><td style="text-align: right;">';
            xiuRes += parseInt(xiuTxn['bet_value']).toLocaleString();
            xiuRes += '</td></tr>';
          }
          $('#xiumd5Order').show();
          $("#xiumd5Order").html(xiuRes);
        }
      },
      error: function() {
        $('#taixiumd5Logaction').html("");
        $("#taixiumd5Spinner").hide();
      },
      timeout: 40000
    });
  }

  function listresulttaixiu() {
    $.ajax({
      type: "POST",
      url: "<?php echo admin_url('usergame/listresulttaixiumd5ajax') ?>",
      data: {},
      dataType: 'json',
      success: function(result) {
        if (result.data == null) {
          $("#taixiumd5Resultsearch").html("Không tìm thấy kết quả");
          $('#taixiumd5Logaction').hide();
        } else {
          var rs = result.data[0] + ',' + result.data[1] + ',' + result.data[2];
          $('#taixiumd5Logaction').show();
          $("#taixiumd5ResultData").html(rs);
          removetaixiu();
        }
      },
      error: function() {
        $('#taixiumd5Logaction').html("");
        $("#taixiumd5Spinner").hide();
      },
      timeout: 40000
    });
  }

  function removetaixiu() {
    $("#taixiumd5-icon").click(function() {
      if (confirm("Bạn có chắc chắn xóa không?")) {
        $.ajax({
          type: "POST",
          url: "<?php echo admin_url('usergame/deleteresulttaixiumd5ajax') ?>",
          data: {},
          dataType: 'json',
          success: function(result) {},
          error: function() {
            $('#taixiumd5Logaction').html("");
            $("#taixiumd5Spinner").hide();
          },
          timeout: 40000
        });
      }
    });
  }
</script>