<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Danh sách jackpot cache</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="widget backaccount">
        <form class="list_filter form">
            <div class="formRow row">
                <div class="col-sm-2">
                    <label for="giftCode">Name cached (*) : </label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="nameCache" value="" name="nameCache">
                </div>
                <div class="col-sm-1">
                    <label for="giftCode">Key : </label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="key" value="" name="key">
                </div>
                <div class="col-sm-1">
                    <label for="giftCode">Action : </label>
                </div>
                <div class="col-sm-2">
                    <select id="action" name="action">
                        <option value="0" >View</option>
                        <option value="1" >Delete</option>
                        <option value="2" >Update</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <div class="col-sm-1">
                        <button type="button" id="search_tran" class="button blueB">Xác nhận</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <div id="resultsearch" class="float-left text-danger"></div>
            </div>
        </div>
        <div class="formRow mt-5">
            <div class="row">
                <div class="col-sm-4">
                    <textarea id="myTextArea" cols=100 rows=15 style="color: #0000ff;font-size: 20px"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
</div>
<script>
    $("#search_tran").click(function () {
        var nameCache = $('#nameCache').val();
        if(!nameCache) {
            return alert("Name cache là bắt buộc");
        }
        var key = $('#key').val();
        var action = $('#action').val();
        if(!action) {
            return alert("Action là bắt buộc");
        }
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('usergame/ajaxJackpotCache')?>",
            data: {
                cn: nameCache,
                k: key,
                action : $('#action').val(),
                value: $('#myTextArea').val()
            },
            dataType: 'json',
            success: function (response) {
                $("#spinner").hide();
                var data = getValue(response);
                document.getElementById('myTextArea').innerHTML = data;
                console.log(data);
            }, error: function () {
                list_data = []
                $("#spinner").hide();
                $('#logaction').html("");
                $("#resultsearch").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
            },timeout : 20000
        })
    });

    function getValue(response) {
        console.log(response);
        if (typeof response == 'string' || typeof response == 'number') {
            return response;
        }
        if (typeof response === 'object' && Object.keys(response).length) {
            return JSON.stringify(response);
        }
        return ' ';
    }
</script>
<style>
    .text-decoration {
        color: blue;
        text-decoration: underline;
    }
</style>