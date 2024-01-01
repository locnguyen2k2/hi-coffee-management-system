<div class="add-form">
    <?php require_once('app/views/blocks/add_form_nav.php'); ?>
    <div class="alert">
        <div class="error">
            <h3>
                <?php
                if (isset($isNull)) {
                    echo $isNull;
                } else if (isset($isReplaced)) {
                    echo $isReplaced;
                } ?>
            </h3>
        </div>
        <div class="success">
            <h3>
                <?php if (isset($isSucessed)) {
                    echo $isSucessed;
                } ?>
            </h3>
        </div>
    </div>
    <div class="form add-type">
        <div class="name">
            <div><span>1) Tên loại: </span></div>
            <input class="type-name" type="text" name="name" placeholder="Nhập tên loại">
        </div>
        <div class="add-btn"><input type="submit" name="add-type-btn" value="thêm"></div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.add-btn').click(function () {
            var formData = new FormData();
            var name = $('.type-name').val();
            if (name == '') {
                $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
            } else {
                formData.append('name', name);
                formData.append('add-type-btn', 'add-type-btn');
                var url = '<?php echo _WEB_ROOT ?>/them-loai';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        formData.delete('name');
                        formData.delete('add-type-btn');
                        let freshAlert = $(data).find('.alert').html();
                        $.ajax({
                            url: url,
                            type: 'POST',
                            success: function (data) {
                                $('.add-form').find('input[type="text"]').val('');
                                $('.alert').html(freshAlert);
                            }
                        })
                    }
                })
            }
        })
    })
</script>