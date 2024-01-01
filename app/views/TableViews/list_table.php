<div class="view-item">
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="heading"><span>Danh sách bàn</span></div>
        <table class="content" id="table_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên bàn</th>
                    <th>Tên khu</th>
                    <th>Cập nhật</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list_table as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $key + 1 . '</td>';
                    echo '<td>' . $value['name'] . '</td>';
                    foreach ($list_area as $key1 => $value1) {
                        if ($value['areaID'] == $value1['id']) {
                            echo '<td>' . $value1['name'] . '</td>';
                            break;
                        }
                    }
                    if ($value['status'] == 0) {
                        echo '<td>Trống</td>';
                    } else {
                        echo '<td>Đã đặt</td>';
                    }
                    echo '<td><a class="update-table-item" table-id="' . $value['id'] . '">Cập nhật</a></td>';
                    echo '</tr>';
                } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).on('click', '.update-table-item', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/cap-nhat-ban/' + $(this).attr('table-id'),
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
            }
        })
    })
</script>