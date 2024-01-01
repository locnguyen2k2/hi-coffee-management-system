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
<div class="success">
    <h3>
        <?php if (isset($isSucessed)) {
            echo $isSucessed;
        } ?>
    </h3>
</div>
<div class='update-item'>
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="list-item">
            <div class="heading">
                <span>Cập nhật khu</span>
            </div>
            <div class="items">
                <div><span><input class="name" data-area="<?php echo $area['id'] ?>" type="text"
                            value="<?php echo $area['name'] ?>" name="name"></span>
                </div>
                <div class="setting">
                    <input type="submit" class="update-area-btn" name="update-area-btn" value="Cập nhật">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.update-area-btn').click(() => {
        let id = $('.name').attr('data-area');
        var formData = new FormData();
        formData.append('name', $('.update-area-btn').parent().parent().find('.name').val());
        if (formData.get('name') == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('update_area_btn', true);
            var url = '<?php echo _WEB_ROOT ?>/cap-nhat-khu/' + id + '';
            $.ajax({
                url: url,
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('name');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        success: function (data) {
                            let freshAreaName = $(data).find('.name').val();
                            $('.name').val(freshAreaName);
                            $('.alert').html(freshAlert);
                        }
                    })
                },

            })
        }
    })
</script>