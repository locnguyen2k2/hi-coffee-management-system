<?php
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/icons/css/all.css">
</head>

<body>
    <?php $this->render('blocks/header'); ?>
    <?php $this->render('blocks/menu') ?>
    <div class="container">
        <div class="model"></div>
        <div class="content"><?php $this->render($content, $sub_content); ?></div>
    </div>
    <?php $this->render('blocks/footer'); ?>
</body>
<script src="<?php echo _WEB_ROOT ?>/public/assets/js/scripts.js"></script>

</html>
<?php ob_end_flush(); ?>