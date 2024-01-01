<div class="view-item">
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="heading"><span>Danh sách khu</span></div>
        <table class="content" id="area_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên khu</th>
                    <th>Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list_area as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $key + 1 . '</td>';
                    echo '<td>' . $value['name'] . '</td>';
                    echo '<td><a class="update-area-item" area-id="' . $value['id'] . '">Cập nhật</a></td>';
                    echo '</tr>';
                } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).on('click', '.update-area-item', function () {
        $.ajax({
            url: '<?php echo _WEB_ROOT ?>/cap-nhat-khu/' + $(this).attr('area-id'),
            type: 'POST',
            success: function (data) {
                var myElement = ($(data).find('#container'));
                $('#main-container').html(myElement);
            }
        })
    })
</script>