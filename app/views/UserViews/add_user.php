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
    <div class="form add-account">
        <div class="fname">
            <div><span>1) Họ và tên đệm: </span></div>
            <input type="text" name="fname" placeholder="Nhập họ và tên đệm">
        </div>
        <div class="lname">
            <div><span>2) Tên: </span></div>
            <input type="text" name="lname" placeholder="Nhập tên">
        </div>
        <div class="username">
            <div><span>3) Tên tài khoản: </span></div>
            <input type="text" name="username" placeholder="Nhập tên tài khoản">
        </div>
        <div class="password">
            <div><span>4) Mật khẩu: </span></div>
            <input type="password" name="password" placeholder="Nhập mật khẩu">
        </div>
        <div class="password2">
            <div><span>5) Nhập lại mật khẩu: </span></div>
            <input type="password" name="password2" placeholder="Nhập lại mật khẩu">
        </div>
        <div class="phonenumb">
            <div><span>6) Nhập số điện thoại: </span></div>
            <input type="text" name="phonenumb" placeholder="Nhập số điện thoại">
        </div>
        <div class="email">
            <div><span>7) Nhập email: </span></div>
            <input type="email" name="email" placeholder="Nhập email">
        </div>
        <div class="add-btn"><input type="submit" name="add-account-btn" value="thêm"></div>
    </div>
</div>
<script>
    $(document).on('click', '.add-btn', function () {
        if ($(this).parent().parent().find('.fname input').val() == '' ||
            $(this).parent().parent().find('.lname input').val() == '' ||
            $(this).parent().parent().find('.username input').val() == '' ||
            $(this).parent().parent().find('.password input').val() == '' ||
            $(this).parent().parent().find('.password2 input').val() == '' ||
            $(this).parent().parent().find('.phonenumb input').val() == '' ||
            $(this).parent().parent().find('.email input').val() == ''
        ) {
            $('.alert').html('<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>');
        } else {
            var formData = new FormData();
            formData.append('fname', $(this).parent().parent().find('.fname input').val());
            formData.append('lname', $(this).parent().parent().find('.lname input').val());
            formData.append('username', $(this).parent().parent().find('.username input').val());
            formData.append('password', $(this).parent().parent().find('.password input').val());
            formData.append('password2', $(this).parent().parent().find('.password2 input').val());
            formData.append('phonenumb', $(this).parent().parent().find('.phonenumb input').val());
            formData.append('email', $(this).parent().parent().find('.email input').val());
            formData.append('add-account-btn', true);
            var url = '<?php echo _WEB_ROOT ?>/them-nguoi-dung/';
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
                    formData.delete('password2');
                    formData.delete('phonenumb');
                    formData.delete('email');
                    formData.delete('add-account-btn');

                    let freshAlert = $(data).find('.alert').html();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        success: function (data) {
                            let freshUserFName = $(data).find('.fname input').val();
                            let freshUserLName = $(data).find('.lname input').val();
                            let freshUserName = $(data).find('.username input').val();
                            let freshUserPassword = $(data).find('.password input').val();
                            let freshUserPassword2 = $(data).find('.password2 input').val();
                            let freshUserNumber = $(data).find('.phonenumb input').val();
                            let freshUserEmail = $(data).find('.email input').val();
                            let freshUserStatus = $(data).find('.status input').val();
                            $('.alert').html(freshAlert);
                            $('.fname input').val(freshUserFName);
                            $('.lname input').val(freshUserLName);
                            $('.username input').val(freshUserName);
                            $('.password input').val(freshUserPassword);
                            $('.password2 input').val(freshUserPassword2);
                            $('.phonenumb input').val(freshUserNumber);
                            $('.email input').val(freshUserEmail);
                        }
                    })
                },

            })
        }
    })
</script>