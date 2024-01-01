<div class="payment-content">
    <div class="heading d-flex justify-content-between">
        <h2>Hóa đơn:
            <?php echo $list_order[0]['orderID'] ?> -
            <?php echo $table['name'] ?>
        </h2>
        <?php if (isset($info_unpaid[0])) { ?>
            <button class="btn btn-primary btn-pay-all m-1 fs-4">
                Thanh toán tất cả
            </button>
        <?php } ?>
    </div>
    <div class="content">
        <div class="bill">
            <?php
            if (isset($list_order)) {
                foreach ($list_order as $key => $value) {
                    if (isset($value['id']) && $value['status'] == 0) {
                        ?>
                        <div class="order-items unpaid" bill-id="<?php echo $value['id'] ?>">
                            <div>
                                <span>Mã đơn đặt:
                                    <?php echo $value['orderID'] ?>
                                </span>
                            </div>
                            <div>
                                <span>Món:
                                    <?php
                                    print_r($value['foodName']);
                                    ?>
                                </span>
                            </div>
                            <div>
                                <span>Loại:
                                    <?php echo $value['typeName'] ?>
                                </span>
                            </div>
                            <div>
                                <span>Giá:
                                    <?php echo number_format($value['price'], 0, ',', '.') . ' đ'; ?>
                                </span>
                            </div>
                            <div>
                                <span>Số lượng:
                                    <?php echo $value['quantity']; ?>
                                </span>
                            </div>
                            <div>
                                <span>Thành tiền:
                                    <?php echo number_format($value['total'], 0, ',', '.') . ' đ'; ?>
                                </span>
                            </div>
                            <div>
                                <span>Trạng thái: Chưa thanh toán</span>
                            </div>
                            <div>
                                <span>Ngày tạo:
                                    <?php echo $value['created_at']; ?>
                                </span>
                            </div>
                            <div class="setting">
                                <div class="btn-pay">
                                    <a
                                        href="<?php echo _WEB_ROOT ?>/chi-tiet-don-dat/<?php echo $value['orderID'] ?>.<?php echo $value['foodID'] ?>">Thanh
                                        toán
                                    </a>
                                </div>
                                <div class="btn-update">
                                    <a
                                        href="<?php echo _WEB_ROOT ?>/cap-nhat-don-dat/<?php echo $value['orderID'] ?>.<?php echo $value['foodID'] ?>">Cập
                                        nhật
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } else if (isset($value['id']) && $value['status'] == 1) { ?>
                            <div class="order-items paid">
                                <div>
                                    <span>Mã đơn đặt:
                                    <?php echo $value['orderID'] ?>
                                    </span>
                                </div>
                                <div>
                                    <span>Món:
                                        <?php
                                        echo $value['foodName']
                                            ?>
                                    </span>
                                </div>
                                <div>
                                    <span>Loại:
                                    <?php echo $value['typeName'] ?>
                                    </span>
                                </div>
                                <div>
                                    <span>Giá:
                                    <?php echo number_format($value['price'], 0, ',', '.') . ' đ'; ?>
                                    </span>
                                </div>
                                <div>
                                    <span>Số lượng:
                                    <?php echo $value['quantity']; ?>
                                    </span>
                                </div>
                                <div>
                                    <span>Thành tiền:
                                    <?php echo number_format($value['total'], 0, ',', '.') . ' đ'; ?>
                                    </span>
                                </div>
                                <div>
                                    <span>Trạng thái: Đã thanh toán</span>
                                </div>
                                <div>
                                    <span>Ngày tạo:
                                    <?php echo $value['created_at']; ?>
                                    </span>
                                </div>
                            </div>
                        <?php }
                }
            } ?>
        </div>
        <div class="info">
            <div class="heading">
                <h2 class="text-black">Thông tin hóa đơn</h2>
            </div>
            <div>
                <span>
                    <p>Bàn:</p>
                </span>
                <p>
                    <?php echo $table['name'] ?>
                </p>
            </div>
            <div>
                <span>
                    <p>Khu:</p>
                </span>
                <p>
                    <?php echo $area['name'] ?>
                </p>
            </div>
            <div>
                <span>
                    <p>Thời gian:</p>
                </span>
                <p>
                    <?php echo isset($info_paid[count($info_paid) - 1]['created_at']) ? $info_paid[count($info_paid) - 1]['created_at'] : $info_unpaid[count($info_unpaid) - 1]['created_at'] ?>
                </p>
            </div>
            <div>
                <span>
                    <p>Người xuất hóa đơn:</p>
                </span>
                <p>
                    <?php echo isset($info_paid[count($info_paid) - 1]['username']) ? $info_paid[count($info_paid) - 1]['username'] : '' ?>
                </p>
            </div>
            <div class="list-food">
                <span>
                    <p>Danh sách món:</p>
                    <?php
                    foreach ($info_paid as $key => $value) {
                        echo '<p  style=' . '"' . 'color:grey;' . '"' . '>' . $value['foodName'] . '</p>';
                    }
                    if (isset($info_unpaid)) {
                        foreach ($info_unpaid as $key => $value) {
                            echo '<p>' . $value['foodName'] . '</p>';
                        }
                    }
                    ?>
                </span>
                <span>
                    <p>Đơn giá:</p>
                    <?php
                    foreach ($info_paid as $key => $value) {
                        echo '<p  style=' . '"' . 'color:grey;' . '"' . '>' . number_format($value['price'], 0, ',', '.') . ' đ' . '</p>';
                    }
                    if (isset($info_unpaid)) {
                        foreach ($info_unpaid as $key => $value) {
                            echo '<p>' . number_format($value['price'], 0, ',', '.') . ' đ' . '</p>';
                        }
                    }
                    ?>
                </span>
                <span>
                    <p>Số lượng:</p>
                    <?php
                    foreach ($info_paid as $key => $value) {
                        echo '<p d-flex justify-content-center style=' . '"' . 'color:grey;' . '"' . '>' . $value['quantity'] . ' </p>';
                    }
                    if (isset($info_unpaid)) {
                        foreach ($info_unpaid as $key => $value) {
                            echo '<p class="d-flex justify-content-center">' . $value['quantity'] . ' </p>';
                        }
                    }
                    ?>
                </span>
                <span>
                    <p>Thành tiền:</p>
                    <?php
                    foreach ($info_paid as $key => $value) {
                        echo '<p class="d-flex justify-content-center" style=' . '"' . 'color:grey;' . '"' . '>' . number_format($value['total'], 0, ',', '.') . ' đ' . ' </p>';
                    }
                    if (isset($info_unpaid)) {
                        foreach ($info_unpaid as $key => $value) {
                            echo '<p class="d-flex justify-content-center">' . number_format($value['total'], 0, ',', '.') . ' đ' . ' </p>';
                        }
                    }
                    ?>
                </span>
            </div>
            <?php
            if (isset($info_unpaid[0])) { ?>
                <div class="unpaid">
                    <span>Chưa thanh toán:

                    </span>
                    <span>
                        <?php print_r(count($info_unpaid));
                        echo isset($total_unpaid) ? ' - ' . number_format($total_unpaid, 0, ',', '.') . ' đ' : ' - ' + 0 + ' đ';
                        ?>
                    </span>
                </div>
                <div>
                    <span>Đã thanh toán: </span>
                    <p>
                        <?php print_r(count($info_paid));
                        echo isset($total_paid) ? ' - ' . number_format($total_paid, 0, ',', '.') . ' đ' : ' - ' + 0 + ' đ'; ?>
                    </p>
                </div>
            <?php } else { ?>
                <div>
                    <span>
                        <p>Tổng:</p>
                    </span>
                    <p>
                        <?php echo isset($total_paid) ? number_format($total_paid, 0, ',', '.') . ' đ' : 0 . ' đ'; ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $('.btn-pay-all').click(() => {
        var formData = new FormData();
        formData.append('btn-pay-all-order', true);
        if ($('.unpaid')) {
            let bill_id = $('.order-items.unpaid').first().attr('bill-id');
            formData.append('bill_id', bill_id);
            $.ajax({
                url: '<?php echo _WEB_ROOT ?>/OrderController/processAllOrderPayment/',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    location.reload();
                }
            })
        }
    })
</script>