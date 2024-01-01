<div class="view-item">
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="heading"><span>Danh sách người dùng</span></div>
        <table class="content" id="user_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên người dùng</th>
                    <th>Tài khoản</th>
                    <th>Mật khẩu</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th>Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list_user as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $key + 1 . '</td>';
                    echo '<td>' . $value['fname'] . ' ' . $value['lname'] . '</td>';
                    echo '<td>' . $value['username'] . '</td>';
                    echo '<td>' . $value['password'] . '</td>';
                    echo '<td>' . $value['number'] . '</td>';
                    echo '<td>' . $value['email'] . '</td>';
                    echo '<td>' . $value['status'] . '</td>';
                    echo '<td><a class="update-user-item" user-id="' . $value['id'] . '">Cập nhật</a></td>';
                    echo '</tr>';
                } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).on('click', '.update-user-item', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/cap-nhat-nguoi-dung/' + $(this).attr('user-id'),
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
            }
        })
    })
</script>