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
                <span>Cập nhật người dùng</span>
            </div>
            <div class="items">
                <div>
                    <span>
                        <input class="fname" type="text" value="<?php echo $user['fname'] ?>" name="fname">
                    </span>
                </div>
                <div>
                    <span>
                        <input class="lname" type="text" value="<?php echo $user['lname'] ?>" name="lname">
                    </span>
                </div>
                <div>
                    <span>
                        <input class="username" data-user="<?php echo $user['id'] ?>" type="text"
                            value="<?php echo $user['username'] ?>" name="username">
                    </span>
                </div>
                <div>
                    <span>
                        <input class="password" type="text" value="<?php echo $user['password'] ?>"
                            name="password">
                    </span>
                </div>
                <div>
                    <span>
                        <input class="number" type="number" value="<?php echo $user['number'] ?>" name="number">
                    </span>
                </div>
                <div>
                    <span>
                        <input class="email" type="email" value="<?php echo $user['email'] ?>" name="email">
                    </span>
                </div>
                <div>
                    <span>
                        <input class="status" type="number" min="0" max="1" value="<?php echo $user['status'] ?>"
                            name="status">
                    </span>
                </div>
                <div class="setting">
                    <input type="submit" class="update-user-btn" name="update-user-btn" value="Cập nhật">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.update-user-btn').click(() => {
        let id = $('.username').attr('data-user');
        var formData = new FormData();
        formData.append('fname', $('.update-user-btn').parent().parent().find('.fname').val());
        formData.append('lname', $('.update-user-btn').parent().parent().find('.lname').val());
        formData.append('username', $('.update-user-btn').parent().parent().find('.username').val());
        formData.append('password', $('.update-user-btn').parent().parent().find('.password').val());
        formData.append('number', $('.update-user-btn').parent().parent().find('.number').val());
        formData.append('email', $('.update-user-btn').parent().parent().find('.email').val());
        formData.append('status', $('.update-user-btn').parent().parent().find('.status').val());
        if ($('.update-user-btn').parent().parent().find('.fname').val() == '' ||
            $('.update-user-btn').parent().parent().find('.lname').val() == '' ||
            $('.update-user-btn').parent().parent().find('.username').val() == '' ||
            $('.update-user-btn').parent().parent().find('.password').val() == '' ||
            $('.update-user-btn').parent().parent().find('.number').val() == '' ||
            $('.update-user-btn').parent().parent().find('.email').val() == '' ||
            $('.update-user-btn').parent().parent().find('.status').val() == ''
        ) {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            formData.append('update_user_btn', true);
            var url = '<?php echo _WEB_ROOT ?>/cap-nhat-nguoi-dung/' + id + '';
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (data) {
                    formData.delete('fname');
                    formData.delete('lname');
                    formData.delete('username');
                    formData.delete('password');
                    formData.delete('number');
                    formData.delete('email');
                    formData.delete('status');
                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            let freshUserFName = $(data).find('.fname').val();
                            let freshUserLName = $(data).find('.lname').val();
                            let freshUserName = $(data).find('.username').val();
                            let freshUserPassword = $(data).find('.password').val();
                            let freshUserNumber = $(data).find('.number').val();
                            let freshUserEmail = $(data).find('.email').val();
                            let freshUserStatus = $(data).find('.status').val();
                            $('.alert').html(freshAlert);
                            $('.fname').val(freshUserFName);
                            $('.lname').val(freshUserLName);
                            $('.username').val(freshUserName);
                            $('.password').val(freshUserPassword);
                            $('.number').val(freshUserNumber);
                            $('.email').val(freshUserEmail);
                            $('.status').val(freshUserStatus);
                        }
                    })
                },

            })
        }
    })
</script>