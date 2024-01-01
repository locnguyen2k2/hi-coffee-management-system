<div class="payment-content">
    <div class="heading">
        <h3>Cập nhật đơn đặt:
            <?php echo $order_detail['order_id'] ?>
        </h3>
    </div>
    <div class="order-items">
        <div class="order-detail">
            <div>
                <span>Bàn:
                </span>
                <span>
                    <?php echo $table['table_name'] ?>
                </span>
            </div>
            <div>
                <span>Tên món:
                </span>
                <span>
                    <?php echo $food['food_name'] ?>
                </span>
            </div>
            <div>
                <span>Loại:
                </span>
                <span>
                    <?php echo $type['type_name'] ?>
                </span>
            </div>
            <div>
                <span>Giá món:
                </span>
                <span>
                    <?php echo $food['price'] ?>
                </span>
            </div>
            <div>
                <span>Số lượng:
                </span>
                <span>
                    <?php echo $order_detail['quantity'] ?>
                </span>
            </div>
            <div>
                <span>Thành tiền:
                </span>
                <span>
                    <?php echo $order_detail['total'] ?>
                </span>
            </div>
            <div>
                <span>Trạng thái: Chưa thanh toán
                </span>
            </div>
            <div class="setting">
                <div class="btn-update">
                    <a href="<?php echo _WEB_ROOT ?>/cap-nhat-don-dat/<?php echo $order_detail['order_id'] ?>">Cập
                        nhật</a>
                </div>
                <div class="btn-pay">
                    <form method="post"
                        action="<?php echo _WEB_ROOT ?>/thanh-toan-don-dat/<?php echo $order_detail['order_id'] ?>">
                        <input type="submit" name="btn-pay-order" value="Thanh toán">
                    </form>
                </div>
                <div class="btn-delete">
                    <form method="post"
                        action="<?php echo _WEB_ROOT ?>/xoa-don-dat/<?php echo $order_detail['order_id'] ?>">
                        <input type="submit" name="btn-delete-order" value="Xóa">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>