
<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Danh Sách Đại lý</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div><link rel="stylesheet"
      href="<?php echo public_url() ?>/site/css/loggamethirdparty.css"><?php if($role == false): ?>
    <div class="wrapper">
        <div class="widget">
            <div class="title">
                <h6>Bạn không được phân quyền</h6>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php $this->load->view('admin/error')?>
    <div class="wrapper">
        <?php $this->load->view('admin/message', $this->data); ?>
        <div class="widget">
            <h4 id="resultsearch"></h4>
            <div class="title">
                <h6>Danh Sách Đại lý</h6>
                <h6 class="total">Tổng bản ghi:<span class="total-number" id="totalData"></span></h6>
            </div>
            <form class="list_filter form" action="<?php echo admin_url('agency/listAgencyWithCount') ?>" method="post">
                <div class="formRow">
                    <table>
                        <tr class="nick_name">
                            <td><label class="session-1">Tên Đại lý:</label></td>
                            <td><input type="text" class="session-2"
                                       id="nick_name" value="<?php echo $this->input->post('nick_name') ?>" name="nick_name"></td>
                        </tr>
                    </table>
                </div>
            </form>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable mTable myTable withCheck" id="checkAll">
                <thead>
                <tr class="list-loggameslot">
                    <td>STT</td>
                    <td>Tên đại lý</td>
                    <td>Mã giới thiệu</td>
                    <td>Số user</td>
                    <td>Ngày Tạo</td>
                    <td>Hành Động</td>
                </tr>
                </thead>
                <tbody id="logaction">
                </tbody>
            </table>
        </div>
    </div>
<?php endif;?>
<div class="container">
    <div id="spinner" class="spinner image-loggameslot">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>
<script>
    var list_agent = []
    var page_size = 10
    $(document).ready(function () {
        $("#nick_name").on('input',function (){
            setData(start=1)
        })

        var oldpage = 0;
        $('#pagination-demo').css("display", "block");
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('agency/listAgencyWithCountajax')?>",
            data: {},
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if (!result.data) {
                    $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                } else {
                    list_agent = result.data
                    let totalData = result.data.length
                    $("#totalData").html(totalData);
                    let totalPage = Math.floor(totalData/page_size) + (totalData%page_size?1:0);
                    stt = 1;
                    setData(stt)
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if(oldpage>0) {
                                stt = (page - 1) * page_size + 1;
                                setData(stt)
                            }
                            oldpage = page;
                        }
                    });
                }
            }, error: function () {
                $('#logaction').html("");
                $("#spinner").hide();
                $("#error-popup").modal("show");
            }, timeout: 40000
        })
    });

    function setData(start=1){
        $("#logaction").html("");
        let nickName = $("#nick_name").val()
        let stt = start
        let result = ''
        let list_search_data = []
        list_agent.forEach((x, index) => {
            if(nickName) {
                if(x.nick_name && x.nick_name.includes(nickName)) {
                    list_search_data.push(x)
                }
            } else {
                list_search_data.push(x)
            }
        })
        let totalData = list_search_data.length
        $("#totalData").html(totalData);
        $.each(list_search_data.slice(start-1, page_size + start-1), function (index, value) {
            result += resultSearchTransction(stt,value);
            stt ++;
        });

        $('#logaction').html(result);
    }

    function resultSearchTransction(stt,value) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td>" + value.nick_name + "</td>";
        rs += "<td>" + (value.referral_code || '-' ) + "</td>";
        rs += "<td>" + (value.countUser || '0' ) + "</td>";
        rs += "<td>" + value.create_time + "</td>";
        if(value.referral_code != "") {
            rs += "<td class='option'>" +
                `<a href="<?php echo admin_url('agency/listUserOfAgency')?>?referral_code=${value.referral_code}&parent=listAgencyWithCount" style="color: blue"> Chi tiết</a>` +
                "</td>";
        } else {
            rs += "<td>" +''+ "</td>";
        }
        rs += "</tr>";
        return rs;
    }
</script>