<?php $this->load->view('admin/usergame/head', $this->data) ?>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>
    
    <div class="widget">
        <div class="title">
            <h6>Top nạp tiền</h6>
        </div>
        <form class="list_filter form" action="<?php echo admin_url('report/topnaptien') ?>" method="post">
            <div class="formRow">
                <table>
                    <tr>
                        <td><label style="margin-left: 30px;margin-bottom:-2px;width: 120px">Nickname:</label></td>
                        <td>
                            <input name="nickname"
                                   value="<?php echo $this->input->post('nickname') ?>" id="nickname"
                                   type="text">
                        </td>
                        <td><label style="margin-left: 30px;margin-bottom:-2px;width: 120px">Hiển thị:</label></td>
                        <td><select id="displaytop" name="displaytop">
                                <option value="50" <?php if($this->input->post("displaytop")== "50"){ echo "selected";}?>>50</option>
                                <option value="100"  <?php if($this->input->post("displaytop")== "100"){ echo "selected";}?>>100</option>
                                <option value="200"  <?php if($this->input->post("displaytop")== "200"){ echo "selected";}?>>200</option>
                                <option value="500"  <?php if($this->input->post("displaytop")== "500"){ echo "selected";}?>>500</option>
                                <option value="1000"  <?php if($this->input->post("displaytop")== "1000"){ echo "selected";}?>>1000</option>
                            </select>
                        </td>
                        <td style="">
                            <input type="button" id="search_tran" value="Tìm kiếm" class="button blueB"
                                   style="margin-left: 123px">
                        </td>
                        <td>
                            <input type="reset"
                                   onclick="window.location.href = '<?php echo admin_url('usergame/topnaptien') ?>'; "
                                   value="Reset" class="basic" style="margin-left: 20px">
                        </td>
                    </tr>
                </table>
            </div>
        </form>
        <div class="formRow">
            <div class="row">
                <div class="col-xs-12">
                    <table id="checkAll" class="table table-bordered" style="table-layout: fixed">
                        <thead>
                        <tr style="height: 20px;">
                            <td>STT</td>
                            <td>Nickname</td>
                            <td>Tiền thắng</td>
                        </tr>
                        </thead>
                        <tbody id="logaction">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    td{
        word-break: break-all;
    }
    thead{
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
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
    <h1 id="resultsearch" style="position: absolute;top: 50%;left: 50%"></h1>
</div>
<script>
    function resultSearchTransction(stt, nickname,moneywin) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + nickname + "</td>";
        rs += "<td>" + commaSeparateNumber(moneywin) + "</td>";
        rs += "</tr>";
        return rs;
    }
    $(document).ready(function () {
        $("#spinner").show();
        var result1 = "";
        var oldpage = 0 ;
        $.ajax({
            type: "POST",
            url: "<?php echo $linkapi?>",
            data: {
                c: 123,
                t: $("#displaytop").val(),
                nn: $("#nickname").val(),
                p :1
            },
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                var totalPage = result.total;
                if (result.transactions == null || result.transactions == "") {
                    $("#resultsearch").html("Không tìm thấy kết quả");
                    $('#logaction').html("");
                } else {
                    $("#resultsearch").html("");
                    stt = 1;
                    $.each(result.transactions, function (index, value) {
                        result1 += resultSearchTransction(stt, value.userName, value.money);
                        stt++
                    });
                    $('#logaction').html(result1);
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if (oldpage > 0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo $linkapi?>",
                                    // url: "http://192.168.0.251:8082/api_backend",
                                    data: {
                                        c: 123,
                                        t: $("#displaytop").val(),
                                        nn: $("#nickname").val(),
                                        p : page
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#spinner").hide();
                                        stt = 1;
                                        $.each(result.transactions, function (index, value) {
                                            result1 += resultSearchTransction(stt, value.userName, value.money);
                                            stt++;

                                        });
                                        $('#logaction').html(result);
                                    }
                                });
                            }
                            oldpage = page;
                        }
                    });
                }

            }
        })

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