<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <!-- Link to bootstrap 5 -->
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/bootstrap/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Link to data tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <!-- link to font awesome -->
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/static/icons/css/all.css">
    <!-- Link to css -->
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/static/css/styles.css">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/static/css/admin.css">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/static/css/staff.css">
    <!-- Link to jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/static/js/socket.js"></script>
</head>

<body>
<?php require_once(_DIR_ROOT . '/app/views/blocks/header.php'); ?>
<?php require_once(_DIR_ROOT . '/app/views/blocks/menu.php'); ?>
<div id="main-container">
    <div class="container admin-container" id="container">
        <div class="model"></div>
        <div class="content">
            <?php $this->render($content, $sub_content); ?>
        </div>
    </div>
</div>
</body>
<!-- Link to bootstrap 5 -->
<script src="<?php echo _WEB_ROOT ?>/bootstrap/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Link to data tables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<!-- Link to JS-->
<script src="<?php echo _WEB_ROOT ?>/public/static/js/scripts.js"></script>
<!-- Chuyển trang: giữa các loại danh sách -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $('.add-food').click(function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/them-mon',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
                $.getScript("<?php echo _WEB_ROOT ?>/public/static/js/admin/script.js",);
            }
        })
    })
    $(document).on('click', '.list-foods', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/danh-sach-mon',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
                $.getScript("<?php echo _WEB_ROOT ?>/public/static/js/admin/script.js",);
            }
        })
    })
    $(document).on('click', '.list-types', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/danh-sach-loai',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
                $.getScript("<?php echo _WEB_ROOT ?>/public/static/js/admin/script.js",);
            }
        })
    })
    $(document).on('click', '.list-tables', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/danh-sach-ban',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
                $.getScript("<?php echo _WEB_ROOT ?>/public/static/js/admin/script.js",);
            }
        })
    })
    $(document).on('click', '.list-areas', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/danh-sach-khu',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
                $.getScript("<?php echo _WEB_ROOT ?>/public/static/js/admin/script.js",);
            }
        })
    })
    $(document).on('click', '.list-users', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/danh-sach-nguoi-dung',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
                $.getScript("<?php echo _WEB_ROOT ?>/public/static/js/admin/script.js",);
            }
        })
    })
    $(document).on('click', '.list-role', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/danh-sach-quyen',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
                $.getScript("<?php echo _WEB_ROOT ?>/public/static/js/admin/script.js",);
            }
        })
    })
    $(document).on('click', '.list-permission', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/danh-sach-phan-quyen',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
                $.getScript("<?php echo _WEB_ROOT ?>/public/static/js/admin/script.js",);
            }
        })
    })
    $(document).on('click', '.statistics', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/StatisticController/statistic',
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
            }
        })
    })
</script>

</html>