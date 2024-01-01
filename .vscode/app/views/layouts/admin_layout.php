<?php
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/icons/css/all.css">

<body>
    <?php $this->render('blocks/header'); ?>
    <?php $this->render('blocks/menu') ?>
    <div class="container admin-container">
        <div class="model"></div>
        <div class="content">
            <?php $this->render($content, $sub_content); ?>
        </div>
    </div>
    <?php $this->render('blocks/footer'); ?>
</body>
<script src="<?php echo _WEB_ROOT ?>/public/assets/js/scripts.js"></script>
<script>
    if (document.querySelector('.admin-container')) {
        if (document.querySelector('.add-food')) {
            const GetFormAddFood = document.querySelector('.add-food');
            const Image = GetFormAddFood.querySelector('.images')
            const GetAddImgBtn = Image.querySelector('.add-img-btn')
            let imageID = 0;
            GetAddImgBtn.addEventListener('click', () => {
                Image.querySelector('.imgs').outerHTML += '<div class="img"><input type="file" id="image-upload" name="image-upload' + imageID + '" accept="image/jpeg, image/png, image/jpg"><i class="fas fa-close"></i></div>'
                imageID += 1;
                Image.querySelectorAll('i').forEach(item => {
                    item.addEventListener('click', () => {
                        item.parentElement.remove();
                    })
                })
            })
        }
    }
</script>

</html>
<?php ob_end_flush(); ?>