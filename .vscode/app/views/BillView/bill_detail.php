<div class="payment-content">
    <div class="heading">
        <h3>Hóa đơn:
            <?php echo isset($unpaidBills) ? $unpaidBills[0]['ma_hoadon'] : $paidBills[0]['ma_hoadon']; ?>
            -
            <?php echo isset($tableNameUnpaid) ? $tableNameUnpaid : $tableNamePaid; ?>
        </h3>
    </div>
    <div class="bill">
        <?php
        if (isset($unpaidBills)) {
            foreach ($unpaidBills as $key => $value) { ?>
                <div class="order-items">
                    <div>
                        <span>Mã đơn đặt:
                            <?php echo $value['ma_dondat'] ?>
                        </span>
                    </div>
                    <div>
                        <span>Món:
                            <?php
                            if (isset($foods[$value['ma_mon']])) {
                                echo $foods[$value['ma_mon']];
                            }
                            ?>
                        </span>
                    </div>
                    <div>
                        <span>Loại:
                            <?php
                            if (isset($types[$value['ma_loai']])) {
                                echo $types[$value['ma_loai']];
                            }
                            ?>
                        </span>
                    </div>
                    <div><span>Giá: <?php echo $value['gia']; ?></span></div>
                    <div><span>Số lượng: <?php echo $value['so_luong']; ?></span></div>
                    <div><span>Thành tiền: <?php echo $value['thanh_tien']; ?></span></div>
                    <div><span>Trạng thái: Chưa thanh toán</span></div>
                    <div><span>Ngày tạo: <?php echo $value['created_at']; ?></span></div>
                    <div class="setting">
                        <div><a class="btn-pay" href="<?php echo _WEB_ROOT ?>/OrderController/view_order/<?php echo $value['ma_dondat'] ?>">Thanh toán</a></div>
                        <div><a class="btn-update" href="<?php echo _WEB_ROOT ?>/OrderController/update_order/<?php echo $value['ma_dondat'] ?>">Cập nhật</a></div>
                    </div>
                </div>
            <?php }
        }
        if (isset($paidBills)) {
            foreach ($paidBills as $key => $value) { ?>
                <div class="order-items paid">
                    <div><span>Mã đơn đặt: <?php echo $value['ma_dondat'] ?></span></div>
                    <div>
                        <span>Món:
                            <?php
                            if (isset($foods[$value['ma_mon']])) {
                                echo $foods[$value['ma_mon']];
                            }
                            ?>
                        </span>
                    </div>
                    <div>
                        <span>Loại:
                            <?php
                            if (isset($types[$value['ma_loai']])) {
                                echo $types[$value['ma_loai']];
                            }
                            ?>
                        </span>
                    </div>
                    <div><span>Giá: <?php echo $value['gia']; ?></span></div>
                    <div><span>Số lượng: <?php echo $value['so_luong']; ?></span></div>
                    <div><span>Thành tiền: <?php echo $value['thanh_tien']; ?></span></div>
                    <div><span>Trạng thái: Đã thanh toán</span></div>
                    <div><span>Ngày tạo: <?php echo $value['created_at']; ?></span></div>
                </div>
        <?php }
        }
        ?>
    </div>
</div>