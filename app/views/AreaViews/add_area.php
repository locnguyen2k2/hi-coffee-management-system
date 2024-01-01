<div class="add-form">
    <?php require_once('app/views/blocks/add_form_nav.php'); ?>
    <div class="alert">
        <div class="error">
            <?php if (isset($isReplaced)) {
                echo $isReplaced;
            } else if (isset($isNull)) {
                echo $isNull;
            } else if (isset($isSucessed)) {
                echo $isSucessed;
            } ?>
        </div>
    </div>
    <div class="form add-area">
        <div class="name">
            <div><span>1) Tên khu: </span></div>
            <input type="text" name="name" placeholder="Nhập tên khu">
        </div>
        <div class="add-btn"><input type="submit" name="add-area-btn" value="thêm"></div>
    </div>
</div>
<script>
    $(document).on('click', '.add-btn', function () {
        var formData = new FormData();
        if ($(this).parent().find('.name input').val() == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('name', $(this).parent().find('.name input').val());
            formData.append('add-area-btn', true);
            var url = '<?php echo _WEB_ROOT ?>/them-khu/';
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('name');
                    formData.delete('add-area-btn');
                    let freshAlert = $(data).find('.alert')[0];
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            // let freshAreaName = $(data).find('.form .name').html();
                            $('.form .name input').val('');
                            $('.alert').html(freshAlert.innerHTML);
                            // console.log(freshAlert.innerHTML);
                        }
                    })
                },

            })
        }
    })
</script>