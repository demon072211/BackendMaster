<div class="modal fade" id="my-bootstrap-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Tài khoản ngân hàng</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 id="resultSubmit" style="color: red;margin-left: 20px"></h4>
                <form class="tagForm needs-validation" action="<?php echo admin_url('bankaccount/save_ajax')?>" novalidate>
                    <input id="inputId" type="text" hidden>
                    <input id="inputType" type="text" hidden>
                    <div class="form-group">
                        <label for="inputNickName" class="col-form-label">Nick Name:</label>
                        <input id="inputNickName" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputCustomerName" class="col-form-label">Tên khách hàng:</label>
                        <input id="inputCustomerName" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputBankNumber" class="col-form-label">Số tài khoản:</label>
                        <input id="inputBankNumber" type="text" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="inputBankName" class="col-form-label">Ngân hàng:</label>
                        <select id="inputBankName" class="form-control" name="bankName">
                            <option value="">Chọn</option>
													<?php
													foreach ($banklist as $bank) {
														echo '<option value="'.$bank.'" ';
														if ($this->input->post("bankName") == $bank) {echo " selected ";}
														echo '>'.$bank.' </option>';
													}
													?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputBranchName" class="col-form-label">Chi nhánh:</label>
                        <input id="inputBranchName" type="text" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="inputStatus" class="col-form-label">Active:</label>
                        <input id="inputStatus" type="checkbox" checked data-toggle="toggle" data-style="ios" class="ml-3">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="tag-form-submit">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        $("#inputStatus").bootstrapToggle()
    })
    $(function() {
        $('#my-bootstrap-modal').on('hidden.bs.modal', function (e) {
            $("#resultSubmit").html("")
            $(this).find("input").val('')
            $("#inputStatus").bootstrapToggle('on')
            $(this).find("#inputBankName").prop('selectedIndex',0)
        })

        $('#tag-form-submit').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('bankaccount/save_ajax')?>",
                dataType: 'json',
                data: {
                    inputId: $("#inputId").val(),
                    inputType: $("#inputType").val() || 0,
                    inputNickName: $("#inputNickName").val(),
                    inputCustomerName: $("#inputCustomerName").val(),
                    inputBankNumber: $("#inputBankNumber").val(),
                    inputBankName: $("#inputBankName").val(),
                    inputBranchName: $("#inputBranchName").val(),
                    inputStatus: $("#inputStatus").parent().hasClass('off') ? 0 : 1
                },
                success: function (response) {
                    $("#spinner").hide();
                    if (response.success) {
                        $("#resultSubmit").html("");
                        $('#my-bootstrap-modal').modal('hide')
                        bankInitData()
                    } else {
                        $("#resultSubmit").html(response.errorCode + ": " + response.message);
                    }

                }, error: function () {
                    $("#spinner").hide();
                    $("#resultSubmit").html("Hệ thống quá tải. Vui lòng gọi 19008698 hoặc F5 lại pages");
                },timeout : 20000
            });
            return false;
        });

    });

</script>
<style>
    .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; margin-top: 0px; }
    .toggle.ios .toggle-handle { border-radius: 20px; }

    /* for input dropdown */
    #inputBankName {
        width: -webkit-fill-available;
        width: -moz-available;
    }
</style>

