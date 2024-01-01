<div class="view-item">
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="heading"><span>Danh sách loại</span></div>
        <table class="content" id="type_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên loại</th>
                    <th>Trạng thái</th>
                    <th>Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list_type as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $key + 1 . '</td>';
                    echo '<td>' . $value[1] . '</td>';
                    echo '<td>' . $value[2] . '</td>';
                    echo '<td><a class="update-type-item" type-id="' . $value[0] . '">Cập nhật</a></td>';
                    echo '</tr>';
                } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).on('click', '.update-type-item', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/cap-nhat-loai/' + $(this).attr('type-id'),
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
            }
        })
    })
</script>