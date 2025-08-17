<span>
    <input type="button" id="exportexel" value="Xuất EXCEL" class="button blueB">
    <select id="page_size" name="page_size"
            style=" width: 40px !important;">
                                    <option value="10" <?php if ($this->input->post('page_size') == "10") {
                                        echo "selected";
                                    } ?>
                                    >10
                                    </option>
                                    <option value="20" <?php if ($this->input->post('page_size') == "20") {
										echo "selected";
									} ?>
                                    >20
                                    </option>
                                    <option value="50" <?php if ($this->input->post('page_size') == "50") {
                                        echo "selected";
                                    } ?>
                                    >50
                                    </option>
                                    <option value="100" <?php if ($this->input->post('page_size') == "100") {
                                        echo "selected";
                                    } ?>
                                    >100
                                    </option>    </select>

</span>

<script>
    $("#exportexel").click(function () {
        $("#checkAll").table2excel({
            name: "<?php echo $pre_file_name ?>_export",
            filename: "<?php echo $pre_file_name ?>_export",
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true,
            columns:  [<?php echo !empty($columns_excel) ? $columns_excel : '' ?>]
        });
    });
    $("#page_size").change(function () {
        page_size = $(this).children("option:selected").val()
        initData()
    })
</script>