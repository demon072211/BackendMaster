<!--<div class="titleArea">-->
<!--    <div class="wrapper">-->
<!--        <div class="pageTitle">-->
<!--            <h5>Log vòng quay vip</h5>-->
<!--        </div>-->
<!--        <div class="horControlB menu_action">-->
<!--            <ul>-->
<!---->
<!--            </ul>-->
<!--        </div>-->
<!--        <div class="clear"></div>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="line"></div>-->
<?php //if($role == false): ?>
<!--    <div class="wrapper">-->
<!--        <div class="widget">-->
<!--            <div class="title">-->
<!--                <h6>Bạn không được phân quyền</h6>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php //else: ?>
<!--    <div class="wrapper">-->
<!--        --><?php //$this->load->view('admin/message', $this->data); ?>
<!--        -->
<!--        <link rel="stylesheet"-->
<!--              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.15.35/css/bootstrap-datetimepicker.css">-->
<!--        <link rel="stylesheet"-->
<!--              href="--><?php //echo public_url() ?><!--/site/css/logminigame.css">-->

<!--        -->
<!--        -->
<!--        -->
<!--        <script-->
<!--            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.15.35/js/bootstrap-datetimepicker.min.js"></script>-->
<!--        <div class="widget">-->
<!--            <h4 id="resultsearch"></h4>-->
<!---->
<!--            <form class="list_filter form" action="--><?php //echo admin_url('logminigame/logvqvip') ?><!--" method="post">-->
<!--                <div class="formRow">-->
<!--                <table>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <label for="param_name" class="formLeft" id="nameuser">Từ ngày:</label></td>-->
<!--                        <td class="item">-->
<!--                            <div class="input-group date" id="datetimepicker1">-->
<!--                                <input type="text" id="toDate" name="toDate"-->
<!--                                       value="--><?php //echo $this->input->post('toDate') ?><!--"> <span class="input-group-addon">-->
<!--                        <span class="glyphicon glyphicon-calendar"></span>-->
<!--</span>-->
<!--                            </div>-->
<!--                        </td>-->
<!---->
<!--                        <td>-->
<!--                            <label for="param_name" class="formLeft formtoDate"> Đến ngày: </label>-->
<!--                        </td>-->
<!--                        <td class="item">-->
<!---->
<!--                            <div class="input-group date" id="datetimepicker2">-->
<!--                                <input type="text" id="fromDate" name="fromDate"-->
<!--                                       value="--><?php //echo $this->input->post('fromDate') ?><!--"> <span-->
<!--                                    class="input-group-addon">-->
<!--                        <span class="glyphicon glyphicon-calendar"></span>-->
<!--</span>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                </table>-->
<!--                </div>-->
<!--                <div class="formRow">-->
<!--                <table>-->
<!--                    <tr class="nickname">-->
<!--                        <td><label>Nick name:</label></td>-->
<!--                        <td><input type="text" id="filter_iname" value="--><?php //echo $this->input->post('name') ?><!--" name="name"></td>-->
<!--                    </tr>-->
<!--                </table>-->
<!--                </div>-->
<!--                <div class="formRow">-->
<!--                    <table>-->
<!--                        <tr>-->
<!--                            <td style="">-->
<!--                                <input type="submit" id="search_tran" value="Tìm kiếm" class="button blueB search">-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </form>-->
<!--            <div class="formRow"></div>-->
<!--            <table cellpadding="0" cellspacing="0" width="100%" class="tablesorter table table-bordered table-hover"-->
<!--                   id="checkAll">-->
<!--                <thead>-->
<!--                <tr class="list-logminigame">-->
<!--                    <th>STT</th>-->
<!--                    <th data-toggle="true">-->
<!--                        Mã giao dịch-->
<!--                    </th>-->
<!---->
<!--                    <th>-->
<!--                        Nick name-->
<!--                    </th>-->
<!--                    <th>-->
<!--                        Giải vòng quay vin-->
<!--                    </th>-->
<!--                    <th>-->
<!--                        Mức nhân-->
<!--                    </th>-->
<!--                    <th>-->
<!--                        Tháng nhận thưởng-->
<!--                    </th>-->
<!--                    <th>-->
<!--                        Ngày tạo-->
<!--                    </th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody id="logaction">-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--        <div id="spinner" class="spinne image-logminigamer">-->
<!--            <img id="img-spinner" src="--><?php //echo public_url('admin/images/gif-load.gif') ?><!--" alt="Loading"/>-->
<!--        </div>-->
<!--        <div class="text-center">-->
<!--            <ul id="pagination-demo" class="pagination-sm"></ul>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<?php //endif;?>
<!--<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>-->
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">-->
<!--<script>-->
<!---->
<!--    $("#search_tran").click(function () {-->
<!---->
<!---->
<!--    });-->
<!--    $(function () {-->
<!--        $('#datetimepicker1').datetimepicker({-->
<!--            format: 'YYYY-MM-DD HH:mm:ss'-->
<!--        });-->
<!--        $('#datetimepicker2').datetimepicker({-->
<!--            format: 'YYYY-MM-DD HH:mm:ss'-->
<!--        });-->
<!---->
<!--    });-->
<!---->
<!--    function resultSearchVQMM(stt,tranid, nickname, resultvin,resultmulti,month,trantime) {-->
<!--        var rs = "";-->
<!--        rs += "<tr>";-->
<!--        rs += "<td>" + stt + "</td>";-->
<!--        rs += "<td>" + tranid + "</td>";-->
<!--        rs += "<td>" + nickname + "</td>";-->
<!--        rs += "<td>" + commaSeparateNumber(resultvin) + "</td>";-->
<!--        rs += "<td>" + "X"+resultmulti + "</td>";-->
<!--        rs += "<td>" + month + "</td>";-->
<!--        rs += "<td>" + trantime + "</td>";-->
<!--        rs += "</tr>";-->
<!--        return rs;-->
<!--    }-->
<!---->
<!---->
<!--    function commaSeparateNumber(val) {-->
<!--        while (/(\d+)(\d{3})/.test(val.toString())) {-->
<!--            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');-->
<!--        }-->
<!--        return val;-->
<!--    }-->
<!---->
<!--    $(document).ready(function () {-->
<!--        var result = "";-->
<!--        var oldPage = 0;-->
<!--        $("#spinner").show();-->
<!--        $.ajax({-->
<!--            type: "POST",-->
<!--            url: "--><?php //echo admin_url('logminigame/logvqvipajax') ?>//",
//            data: {
//                nickname: $("#filter_iname").val(),
//                pages : 1,
//                todate : $("#toDate").val(),
//                fromdate : $("#fromDate").val()
//            },
//            dataType: 'json',
//            success: function (result) {
//                $("#spinner").hide();
//                var totalpage = result.total;
//                stt = 1;
//                $.each(result.transactions, function (index, value) {
//                    result += resultSearchVQMM(stt,value.trans_id, value.nick_name,value.result_vin,value.result_mutil,value.month,value.timelog);
//                    stt ++;
//                });
//                $('#logaction').html(result);
//                var table = $('#checkAll').DataTable({
//                    "ordering": true,
//                    "searching": true,
//                    "paging": false,
//                    "draw": false
//                });
//
//                $('#pagination-demo').twbsPagination({
//
//                    totalPages: totalpage,
//                    visiblePages: 5,
//                    onPageClick: function (event, page) {
//                        if (oldPage > 0) {
//                            $("#spinner").show();
//                            table.destroy();
//                            $.ajax({
//                                type: "POST",
//                                url: "<?php //echo admin_url('logminigame/logvqvipajax') ?>//",
//                                data: {
//                                    nickname: $("#filter_iname").val(),
//                                    pages : page,
//                                    todate : $("#toDate").val(),
//                                    fromdate : $("#fromDate").val()
//                                },
//                                dataType: 'json',
//                                cache: true,
//                                success: function (result) {
//                                    $("#resultsearch").html("");
//                                    $("#spinner").hide();
//                                    stt = 1;
//                                    $.each(result.transactions, function (index, value) {
//                                        result += resultSearchVQMM(stt,value.trans_id, value.nick_name,value.result_vin,value.result_mutil,value.month,value.timelog);
//                                        stt ++;
//                                    });
//                                    $('#logaction').html(result);
//                                    table = $('#checkAll').DataTable({
//                                        "ordering": true,
//                                        "searching": true,
//                                        "paging": false,
//                                        "draw": false
//                                    });
//                                }
//                            });
//                        }
//                        oldPage = page;
//                    }
//                });
//            }
//        })
//    });
//
//
//</script>