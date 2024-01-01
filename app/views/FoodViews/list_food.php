<div class="view-item">
    <?php require_once('app/views/blocks/list_form_nav.php'); ?>
    <div>
        <div class="heading"><span>Danh sách món</span></div>
        <table class="content" id="food_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên món</th>
                    <th>Loại</th>
                    <th>Giá</th>
                    <th>Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($list_food)) {
                    foreach ($list_food as $key => $value) {
                        echo '<tr>';
                        echo '<td>' . $key + 1 . '</td>';
                        echo '<td>' . $value[1] . '</td>';
                        echo '<td>' . $value[2] . '</td>';
                        echo '<td>' . $value[3] . '</td>';
                        echo '<td><a class="update-food-item" food-id="' . $value[0] . '">Cập nhật</a></td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('.update-food-item').click((item) => {
        let foodID = item.target.getAttribute('food-id');
        let url = '<?php echo _WEB_ROOT ?>/cap-nhat-mon/' + foodID;
        $.ajax({
            url: url,
            success: function (data) {
                var myElement = $(data).find('#container');
                $('#container').replaceWith(myElement);
            }
        })
    })
</script>