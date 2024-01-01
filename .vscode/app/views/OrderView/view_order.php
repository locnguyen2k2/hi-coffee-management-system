<div class="payment-content">
    <div class="heading">
        <h3>Cập nhật đơn đặt: <?php echo $orderdetail['ma_dondat'] ?></h3>
    </div>
    <div class="order-items">
        <div class="order-detail">
            <div>
                <span>Bàn:
                </span>
                <span>
                    <?php echo $table['ten_ban'] ?>
                </span>
            </div>
            <div>
                <span>Tên món:
                </span>
                <span>
                    <?php echo $food['ten_mon'] ?>
                </span>
            </div>
            <div>
                <span>Loại:
                </span>
                <span>
                    <?php echo $type['ten_loai'] ?>
                </span>
            </div>
            <div>
                <span>Giá món:
                </span>
                <span><?php echo $food['gia_mon'] ?></span>
            </div>
            <div>
                <span>Số lượng:
                </span>
                <span>
                    <?php echo $orderdetail['so_luong'] ?>
                </span>
            </div>
            <div>
                <span>Thành tiền:
                </span>
                <span><?php echo $orderdetail['thanh_tien'] ?></span>
            </div>
            <div>
                <span>Trạng thái: Chưa thanh toán
                </span>
            </div>
            <div class="setting">
                <div>
                    <a href="<?php echo _WEB_ROOT ?>/OrderController/update_order/<?php echo $orderdetail['ma_dondat'] ?>">Cập nhật</a>
                </div>
                <div class="btn-pay">
                    <form method="post" action="<?php echo _WEB_ROOT ?>/OrderController/pay_order/<?php echo $orderdetail['ma_dondat'] ?>">
                        <input type="submit" name="btn-pay-order" value="Thanh toán">
                    </form>
                </div>
                <div>
                    <a href="<?php echo _WEB_ROOT ?>/OrderController/add_order/<?php echo $orderdetail['ma_dondat'] ?>">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</div>