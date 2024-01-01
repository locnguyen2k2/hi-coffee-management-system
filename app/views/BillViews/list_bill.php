<div class="order-container child-component" id="list-bill">
    <div class="right-content">
        <div class="order-item">
            <div class="heading">
                <h3>Danh sách hóa đơn</h3>
            </div>
            <table class="content" id="order_table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã hóa đơn</th>
                        <th>Bàn</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bills as $key => $value) { ?>
                        <tr>
                            <td>
                                <?php echo $key + 1 ?>
                            </td>
                            <td>
                                <?php echo $value['id'] ?>
                            </td>
                            <td>
                                <?php foreach ($list_table as $key1 => $value1) {
                                    if ($value['tableID'] === $value1['id']) {
                                        echo $value1['name'];
                                    }
                                } ?>
                            </td>
                            <td>
                                <?php echo $value['created_at'] ?>
                            </td>
                            <td>
                                <a href="<?php echo _WEB_ROOT ?>/chi-tiet-hoa-don/<?php echo $value['id'] ?>">Chi
                                    tiết</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#order_table').DataTable();
    });
</script>