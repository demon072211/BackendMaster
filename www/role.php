<!-- head -->
<?php $this->load->view('admin/groupuser/head', $this->data) ?>
<div class="line"></div>
<div class="wrapper">
    <div class="widget">
        <div class="title">
            <h6>Phân quyền nhóm người dùng</h6>
        </div>
        <form id="form" class="form" enctype="multipart/form-data" method="post" action="">
            <fieldset>
                <div class="formRow">
                    <?php echo $list; ?>
                </div>
                <div class="formSubmit">
                    <input type="submit" class="redB" value="Cập nhật">
                </div>
            </fieldset>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(function () {
            $("input[type='checkbox']").change(function () {
                $(this).siblings('ul')
                    .find("input[type='checkbox']")
                    .prop('checked', this.checked);
            });
        });

        $(document).on('change', 'input.child', function (e) {
            if (this.checked) {
                $(this).closest('.parent').children("input[type='checkbox']").prop('checked', true);
                return;
            }
            var parent = this.parentNode.parentNode.parentNode;
            var x = parent.querySelectorAll(".child");
            var i, isCheck = false;
            for (i = 0; i < x.length; i++) {
                if (x[i].checked) {
                    isCheck = true;
                    break;
                }
            }
            $(this).closest('.parent').children("input[type='checkbox']").prop('checked', isCheck);
            e.stopPropagation();
        });
    });
</script>