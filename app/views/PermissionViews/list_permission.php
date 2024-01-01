<div class="view-item">
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>

        <div class="heading"><span>Danh sách phân quyền</span></div>
        <table class="content" id="permission_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên tài khoản</th>
                    <th>Quyền</th>
                    <th>Trạng thái</th>
                    <th>Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list_permission as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $key + 1 . '</td>';
                    // Tìm và in ra username của phân quyền hiện tại
                    foreach ($list_user as $key1 => $value1) {
                        if ($value['userID'] == $value1['id']) {
                            echo '<td>' . $value1['username'] . '</td>';
                            break;
                        }
                    }
                    // Tìm và in ra quyền của phân quyền hiện tại
                    foreach ($list_role as $key2 => $value2) {
                        if ($value['roleID'] == $value2['id']) {
                            echo '<td>' . $value2['name'] . '</td>';
                            break;
                        }
                    }
                    echo '<td>' . $value['status'] . '</td>';
                    echo '<td><a class="update-permission-item" permission-id="' . $value['id'] . '">Cập nhật</a></td>';
                    echo '</tr>';
                } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).on('click', '.update-permission-item', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/cap-nhat-phan-quyen/' + $(this).attr('permission-id'),
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
            }
        })
    })
</script>