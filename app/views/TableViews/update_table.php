<div class='update-item'>
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
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="list-item">
            <div class="heading">
                <span>Cập nhật bàn</span>
            </div>
            <div class="items">
                <div>
                    <span>
                        <input class="name" type="text" value="<?php echo $table['name'] ?>" name="name"
                            data-table="<?php echo $table['id'] ?>">
                    </span>
                </div>
                <div>
                    <span>
                        <select name="area_name" class="area_name">
                            <option selected value="<?php echo $area['name'] ?>"><?php echo $area['name'] ?>
                            </option>
                            <?php foreach ($list_area as $key1 => $value1) {
                                if ($value1['id'] != $table['areaID']) { ?>
                                    <option value="<?php echo $value1['name'] ?>"><?php echo $value1['name'] ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </span>
                </div>
                <div>
                    <span>
                        <input class="status" type="number" min="0" max="1" value="<?php echo $table['status'] ?>"
                            name="status">
                    </span>
                </div>
                <div class="setting">
                    <input type="submit" class="update-table-btn" name="update-table-btn" value="Cập nhật">
                    <!-- <a class="update-table-btn">Cập nhật</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.update-table-btn').click(() => {
        let id = $('.name').attr('data-table');
        var formData = new FormData();
        formData.append('name', $('.update-table-btn').parent().parent().find('.name').val());
        formData.append('area_name', $('.update-table-btn').parent().parent().find('.area_name').val());
        formData.append('status', $('.update-table-btn').parent().parent().find('.status').val());
        if (formData.get('name') == '' || formData.get('area_table') == '' || formData.get('status') == '') {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('update_table_btn', true);
            var url = '<?php echo _WEB_ROOT ?>/cap-nhat-ban/' + id + '';
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('name');
                    formData.delete('area_name');
                    formData.delete('status');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            let freshTableName = $(data).find('.name').val();
                            let freshAreaName = $(data).find('.area_name').val();
                            let freshTableStatus = $(data).find('.status').val();

                            $('.alert').html(freshAlert);
                            $('.name').val(freshTableName);
                            $('.area_name').val(freshAreaName);
                            $('.status').val(freshTableStatus);
                        }
                    })
                },

            })
        }
    })
</script>