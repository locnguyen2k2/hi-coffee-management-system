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
    <div class="form add-group">
        <div class="name">
            <div><span>1) Tên quyền: </span></div>
            <input type="text" name="name" placeholder="Nhập tên quyền">
        </div>
        <div class="add-btn"><input type="submit" name="add-group-btn" value="thêm"></div>
    </div>
</div>
<script>
    $(document).on('click', '.add-btn', function () {
        var formData = new FormData();
        formData.append('name', $(this).parent().parent().find('.name input').val());
        if (formData.get('name') == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('add-group-btn', true);
            var url = '<?php echo _WEB_ROOT ?>/them-quyen/';
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('name');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            let freshGroupName = $(data).find('.name input').val();
                            $('.name input').val(freshGroupName);
                            $('.alert').html(freshAlert);
                        }
                    })
                },

            })
        }
    })
</script>