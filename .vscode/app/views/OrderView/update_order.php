<div class="payment-content">
    <div class="heading">
        <h3>Cập nhật đơn đặt: <?php echo $unpaidBill['ma_dondat'] ?></h3>
    </div>
    <div class="order-items">
        <form method="post" action="<?php echo _WEB_ROOT ?>/OrderController/update_order/<?php echo $unpaidBill['ma_dondat'] ?>">
            <div class="order-detail">
                <div>
                    <span>Bàn:
                    </span>
                    <span>
                        <select name="tableID">
                            <option value="<?php echo $unpaidBill['ma_ban'] ?>">
                                <?php
                                foreach ($tables as $key => $value) {
                                    if ($unpaidBill['ma_ban'] == $value['ma_ban']) {
                                        echo $value['ten_ban'];
                                        break;
                                    }
                                }
                                ?>
                            </option>
                            <?php
                            foreach ($tables as $key1 => $value1) {
                                if ($value1['ma_ban'] != $unpaidBill['ma_ban']) {
                            ?>
                                    <option value="<?php echo $value1['ma_ban'] ?>">
                                        <?php echo $value1['ten_ban'] ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <div>
                    <span>Tên món:
                    </span>
                    <span>
                        <select name="foodID">
                            <option value="<?php echo $unpaidBill['ma_mon'] ?>">
                                <?php
                                foreach ($foods as $key => $value) {
                                    if ($unpaidBill['ma_mon'] == $value['ma_mon']) {
                                        echo $value['ten_mon'];
                                        break;
                                    }
                                }
                                ?>
                            </option>
                            <?php
                            foreach ($foods as $key1 => $value1) {
                                if ($unpaidBill['ma_mon'] != $value1['ma_mon']) {
                            ?>
                                    <option value="<?php echo $value1['ma_mon'] ?>">
                                        <?php echo $value1['ten_mon'] ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <div>
                    <span>Loại:
                    </span>
                    <span>
                        <?php
                        foreach ($types as $key => $value) {
                            if ($unpaidBill['ma_loai'] == $value['ma_loai']) {
                                echo $value['ten_loai'];
                                break;
                            }
                        }
                        ?>
                    </span>
                </div>
                <div>
                    <span>Giá món:
                    </span>
                    <span><?php echo $unpaidBill['gia'] ?></span>
                </div>
                <div>
                    <span>Số lượng:
                    </span>
                    <span>
                        <input name="quantity" type="number" min="1" value="<?php echo $unpaidBill['so_luong'] ?>">
                    </span>
                </div>
                <div>
                    <span>Thành tiền:
                    </span>
                    <span><?php echo $unpaidBill['thanh_tien'] ?></span>
                </div>
                <div>
                    <span>Trạng thái: Chưa thanh toán
                    </span>
                </div>
                <div class="setting">
                    <div>
                        <input type="submit" name="btn-update" value="Cập nhật">
                    </div>
                    <div>
                        <input type="submit" name="btn-delete" value="Xóa">
                    </div>
                    <div>
                        <a href="<?php echo _WEB_ROOT ?>/dat-mon">Quay lại</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>