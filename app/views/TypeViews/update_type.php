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
                <h3>Cập nhật loại</h3>
            </div>
            <div class="list-item">
                <div class="items" data-type="<?php echo $type['id'] ?>">
                    <div><span><input class="name" type="text" value="<?php echo $type['name'] ?>"
                                name="name"></span></div>
                    <div><span><input class="status" type="number" min="0" max="1"
                                value="<?php echo $type['status'] ?>" name="status"></span></div>
                    <div class="setting">
                        <input class="update-type-btn" type="submit" name="update-type-btn" value="Cập nhật">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.update-type-btn').click(() => {
        let id = $('.items').attr('data-type');
        var formData = new FormData();
        formData.append('name', $('.update-type-btn').parent().parent().find('.name').val());
        formData.append('status', $('.update-type-btn').parent().parent().find('.status').val());
        if (formData.get('name') == '' || formData.get('status') == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('update_type_btn', true);
            var url = '<?php echo _WEB_ROOT ?>/cap-nhat-loai/' + id + '';
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('name');
                    formData.delete('status');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            let freshAreaName = $(data).find('.name').val();
                            let freshAreaStatus = $(data).find('.status').val();
                            $('.name').val(freshAreaName);
                            $('.status').val(freshAreaStatus)
                            $('.alert').html(freshAlert);
                        }
                    })
                },

            })
        }
    })
</script>