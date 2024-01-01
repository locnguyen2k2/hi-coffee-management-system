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
    <div class="form add-user-group">
        <div class="name">
            <div><span>1) Tên tài khoản: </span></div>
            <select class="username" user-data="userid" name="userid">
                <option value="0"></option>
                <?php foreach ($list_user as $key => $value) { ?>
                    <option value="<?php echo $value['id'] ?>"><?php echo $value['username'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="group">
            <div><span>2) Chọn quyền: </span></div>
            <select class="group_id" name="groupid">
                <option value="0"></option>
                <?php foreach ($list_role as $key => $value) { ?>
                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="add-btn"><input type="submit" name="add-user-group-btn" value="thêm"></div>
    </div>
</div>
<script>
    $(document).on('click', '.add-btn', function () {
        var formData = new FormData();
        if ($(this).parent().parent().find('.group_id').val() == '' ||
            $(this).parent().parent().find('.username').val() == ''
        ) {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('groupid', $(this).parent().parent().find('.group_id').val());
            formData.append('userid', $(this).parent().parent().find('.username').val());
            formData.append('add-user-group-btn', true);
            var url = '<?php echo _WEB_ROOT ?>/them-phan-quyen/';
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('groupid');
                    formData.delete('userid');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            let freshUserGroup = $(data).find('.group_id').val();
                            let freshUserGroupUsername = $(data).find('.username').val();
                            $('.alert').html(freshAlert);
                            $('.group_id').val(freshUserGroup);
                            $('.username').val(freshUserGroupUsername);
                        }
                    })
                },

            })
        }
    })
</script>