<html>
<head>
    <?php $this->load->view('admin/head') ?>
</head>

<body class="main-body">
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fas fa-bars"></i>
    </a>
    <?php $this->load->view('admin/left') ?>
    <main class="page-content">

        <div id="page-content-wrapper">
            <div style="min-height: 634px;">
                <?php $this->load->view($temp, $this->data); ?>
            </div>
        </div>
    </main>
</div>

</body>
</html>
