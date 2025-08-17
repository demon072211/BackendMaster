<div class="titleArea">
    <div class="wrapper">
        <div class="pageTitle">
            <h5>Xuất dữ liệu user đại Lý</h5>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="line"></div>
<div class="wrapper">
    <?php $this->load->view('admin/message', $this->data); ?>

    <div class="widget backaccount">
        <form class="list_filter form" action="<?php echo admin_url('userAgency/export') ?>" method="post">
            <div class="formRow row">
                <div class="col-sm-1">
                    <label for="giftCode">Mã đại lý (*) </label>
                </div>
                <div class="col-sm-2">
                    <input type="text" id="ref" value="<?= $this->input->post('ref') ?>" required name="ref">
                </div>
                <div class="col-sm-2">
                    <input type="submit" id="search_tran" value="Xuất dữ liệu" class="button blueB">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
    </div>
    <div class="text-center">
        <ul id="pagination-demo" class="pagination-lg"></ul>
    </div>
</div>
<script>

</script>
<script>

</script>
<style>
    .img-banner {
        max-height: 200px;
    }

    .text-decoration {
        color: blue;
        text-decoration: underline;
    }
</style>