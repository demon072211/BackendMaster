<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5>Cập nhật giao dịch rút tiền</h5>

		</div>
	
		
		<div class="clear"></div>
	</div>
</div>

<div class="line"></div>

    <div class="wrapper">
        <?php if(!isset($dataTrans['data'])):  ?>
        <h5>Hệ thống quá tải!!!</h5>
        <?php endif; ?>
        <?php $this->load->view('admin/message', $this->data); ?>
        
        

        
        
        
        <script
            src="<?php echo public_url() ?>/site/bootstrap/bootstrap-datetimepicker.min.js"></script>
        <div class="widget">
            <div class="title">
                <h6>Cập nhật giao dịch #<?php echo( $dataTrans['data']['Id']) ?></h6>
            </div>
            <form class="list_filter form" action="" method="post">
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4"><label id="errorname" style="color: #e72929;"></label></div>
                    </div>
                </div>
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2"><label>Nickname</label></div>
                        <div class="col-sm-2"><label><?php echo $dataTrans['data']['Nickname'] ?></label></div>

                    </div>

                </div>
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2"><label>Số tiền </label></div>
                        <div class="col-sm-2"><label><?php echo number_format($dataTrans['data']['Amount']) ?></label></div>

                    </div>

                </div>

                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2"><label>Ngân Hàng</label></div>
                        <div class="col-sm-2"><label><?php echo $dataTrans['data']['PhoneNumber'] ?></label></div>

                    </div>

                </div>

                

                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2"><label>Trạng Thái</label></div>
                        <div class="col-sm-2"><label>
                        
                        <select id="status" name="select_status"
                                style="margin-left: 0px;margin-bottom:-2px;width: 143px">
                                <option value="">Chọn</option>
                                <option value="success"
                                    <?php if($dataTrans['data']['Status'] == "success" ){echo "selected";} ?>>Thành
                                    công</option>
                                <option value="pending"
                                    <?php if($dataTrans['data']['Status'] == "pending" ){echo "selected";} ?>>Đang xử
                                    lý</option>
                                <option value="error"
                                    <?php if($dataTrans['data']['Status'] == "error" ){echo "selected";} ?>>Lỗi </option>
                                <option value="reject"
                                    <?php if($dataTrans['data']['Status'] == "reject" ){echo "selected";} ?>> Từ chối</option>
                            </select>
                        
                        </label></div>

                    </div>

                </div>               
                
                <div class="formRow">
                    <div class="row">
                        <div class="col-sm-4">
                        <input class="form-control" id="transId"  type="hidden"  value="<?php echo $dataTrans['data']['Id'] ?>">
                        </div>
                        <div class="col-sm-1">
                            <input type="button" id="congxu" value="Cập nhật" class="button blueB">
                        </div>
                        
                    </div>
                </div>
            </form>
            <div class="formRow"></div>
            <div class="modal fade" id="bsModal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            <p style="color: #7a6fbe">Cập nhật trạng thái thành công</p>
                        </div>
                        <div class="modal-footer">
                            <input class="blueB logMeIn" type="button" value="Đóng" data-dismiss="modal"
                                   aria-hidden="true">
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

<style>.spinner {
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
        <img id="img-spinner" src="<?php echo public_url('admin/images/loading.gif') ?>" alt="Loading"/>
    </div>
</div>
<script>
     
    $(document).ready(function () {
        $("#congxu").click(function(){
            var status = $("#status").val();
            if(status == ""){
                $("#errorname").html("Bạn chưa chọn trạng thái");
                return false;
            }
            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('report/updatetranmomoajax')?>",
                data: {
                    transId: $("#transId").val(),
                    status : $("#status").val()
                    
                },

                dataType: 'json',
                success: function (result) {
                    
                    $("#spinner").hide();
                    if(result != ""){
                        $("#errorname").html("");
                        $("#filter_iname").val("");
                        $("#txtmoney").val("");
                        $("#txtreason").val("");
                        $("#txtotp").val("");
                        $("#numchuyen").html("");
                        $("#bsModal3").modal("show");
                    }else {
                        $("#errorname").html("Cập nhật thất bại!");
                    }
                }, error: function () {
                    $("#spinner").hide();
                    $("#errorname").html("Hệ thống quá tải.  Vui long thử lại sau");
                },timeout : 20000
            });
        });
    });

    
</script>
