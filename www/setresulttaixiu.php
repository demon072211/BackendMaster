
    <div class="wrapper">
        <div class="widget">
                <div class="formRow">
                    <div class="container">
                        <div id="tabs-container">
                            <div id="tab-1" class="tab-content col-sm-12">
                                <!--  Tài xỉu  -->
                              <?php $this->load->view('admin/usergame/resultonlytaixiu', $this->data) ?>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
<div class="clear mt30"></div>
<style>
    #checkAll {
        border: 1px solid #ddd;
    }

    .tabs-menu {
        height: 30px;
        /*float: left;*/
        clear: both;
    }

    .tabs-menu li {
        height: 30px;
        line-height: 30px;
        float: left;
        margin-right: 10px;
        background-color: #ccc;
        border-top: 1px solid #d4d4d1;
        border-right: 1px solid #d4d4d1;
        border-left: 1px solid #d4d4d1;
    }

    .tabs-menu li.current {
        position: relative;
        background-color: #fff;
        border-bottom: 1px solid #fff;
        z-index: 5;
    }

    .tabs-menu li a {
        padding: 10px;
        text-transform: uppercase;
        color: #fff;
        text-decoration: none;
    }

    .tabs-menu .current a {
        color: #2e7da3;
    }

    .tab-content {
        width: 100%;
        padding: 20px;
    }

    #tab-1 {
        display: block;
    }

    td {
        word-break: break-all;
    }

    thead {
        font-size: 12px;
    }

</style>

<script>
    $(document).ready(function () {
        $(".tabs-menu a").click(function (event) {
            event.preventDefault();
            $(this).parent().addClass("current");
            $(this).parent().siblings().removeClass("current");
            var tab = $(this).attr("href");
            $(".tab-content").not(tab).css("display", "none");
            $(tab).fadeIn();
        });
    });
</script>
