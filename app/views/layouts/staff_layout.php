<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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
    <div class="container staff-container" id="container">
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
<!-- Link to js -->
<script src="<?php echo _WEB_ROOT ?>/public/static/js/scripts.js"></script>
<script>

</script>

</html>