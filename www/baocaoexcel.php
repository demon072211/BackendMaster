<span>
    <input type="button" id="exportexel" value="Xuất EXCEL" class="button blueB">
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
</script>