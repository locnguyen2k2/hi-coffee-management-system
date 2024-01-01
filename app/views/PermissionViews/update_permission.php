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
                <span>Cập nhật phân quyền</span>
            </div>
            <div class="items">
                <div>
                    <span class="username" user-data="<?php echo $permission['id'] ?>">
                        <?php echo $user['username'] ?>
                    </span>
                </div>
                <div>
                    <span>
                        <!-- Tạo thẻ select chọn quyền -->
                        <select class="group_id" name="group_id">
                            <!-- Option chứa quyền hiện đang được cập nhật của người dùng -->
                            <option selected value="<?php echo $permission['roleID'] ?>">
                                <?php echo $role['name'] ?>
                            </option>
                            <!-- Tạo các option có quyền khác với quyền của người dùng hiện đang cập nhật -->
                            <?php
                            foreach ($list_role as $key1 => $value1) {
                                if ($value1['id'] != $permission['roleID']) { ?>
                                    <option value="<?php echo $value1['id'] ?>">
                                        <?php echo $value1['name'] ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <div>
                    <span>
                        <input class="status" type="number"
                            value="<?php echo $permission['status'] ?>" min="0" max="1"
                            name="status">
                    </span>
                </div>
                <div class="setting">
                    <input class="update-group-user-btn" type="submit" name="update-group-user-btn" value="Cập nhật">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.update-group-user-btn').click(() => {
        let id = $('.username').attr('user-data');
        var formData = new FormData();
        formData.append('group_id', $('.update-group-user-btn').parent().parent().find('.group_id').val());
        formData.append('status', $('.update-group-user-btn').parent().parent().find('.status').val());
        if ($('.update-group-user-btn').parent().parent().find('.group_id').val() == '' ||
            $('.update-group-user-btn').parent().parent().find('.status').val() == ''
        ) {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('update_group_user_btn', true);
            var url = '<?php echo _WEB_ROOT ?>/cap-nhat-phan-quyen/' + id + '';
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('group_id');
                    formData.delete('status');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            let freshUserGroup = $(data).find('.group_id').val();
                            let freshUserGroupStatus = $(data).find('.status').val();
                            $('.alert').html(freshAlert);
                            $('.fname').val(freshUserGroup);
                            $('.status').val(freshUserGroupStatus);
                        }
                    })
                },

            })
        }
    })
</script>