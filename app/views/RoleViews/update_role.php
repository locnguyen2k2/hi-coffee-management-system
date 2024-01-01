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
<div class='update-item'>
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="list-item">
            <div class="heading">
                <span>Cập nhật quyền</span>
            </div>
            <div class="items">
                <div>
                    <span>
                        <input class="name" group-data="<?php echo $role['id'] ?>" type="text"
                            value="<?php echo $role['name'] ?>" name="name">
                    </span>
                </div>
                <div class="setting">
                    <input type="submit" name="update-group-btn" class="update-group-btn" value="Cập nhật">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.update-group-btn').click(() => {
        let id = $('.name').attr('group-data');
        var formData = new FormData();
        formData.append('name', $('.update-group-btn').parent().parent().find('.name').val());
        if (formData.get('name') == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('update_group_btn', true);
            var url = '<?php echo _WEB_ROOT ?>/cap-nhat-quyen/' + id + '';
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
                            let freshGroupName = $(data).find('.name').val();
                            $('.name').val(freshGroupName);
                            $('.alert').html(freshAlert);
                        }
                    })
                },

            })
        }
    })
</script>