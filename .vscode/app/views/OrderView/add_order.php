<div class="order-container child-component">
    <div class="left-content">
        <div class="food">
            <div class="title">
                <h3>Chọn món: </h3>
            </div>
            <div class="content">
                <?php
                foreach ($foods as $key => $value) { ?>
                    <a class="item" data-food="<?php echo $value['ten_mon'] ?>">
                        <?php echo $value['ten_mon'] ?>
                    </a>
                <?php
                } ?>
            </div>
        </div>
        <div class="table">
            <div class="title">
                <h3>Chọn bàn: </h3>
            </div>
            <div class="content">
                <?php
                foreach ($tables as $key => $value) { ?>
                    <a class="item" data-table="<?php echo $value['ten_ban'] ?>">
                        <?php
                        echo $value['ten_ban'];
                        if ($value['trang_thai'] == 1) {
                            echo '(Đang dùng)';
                        } ?>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="right-content">
        <div class="form-order">
            <div class="title-form">
                <h3>Thông tin đơn đặt</h3>
            </div>
            <div class="alert">
                <span>
                    <?php
                    if (isset($isNull)) {
                        echo $isNull;
                    } else if (isset($isSucessed)) {
                        echo $isSucessed;
                    } ?>
                </span>
            </div>
            <form method="POST" action="<?php echo _WEB_ROOT ?>/OrderController/add_order">
                <div class="food">
                    <div><span>Món: </span></div>
                    <input type="text" name="food_name">
                </div>
                <div class="table">
                    <div><span>Bàn: </span></div>
                    <input type="text" name="table_name">
                </div>
                <div>
                    <div><span>Chọn số lượng: </span></div>
                    <input type="number" min="1" name="quantity">
                </div>
                <div class="btn-add-order">
                    <input class="btn-add-order" type="submit" name="btn-add-order" value="Đặt món">
                </div>
            </form>
        </div>
        <div class="bill-item">
            <div class="heading">
                <h3>Danh sách đơn đặt chưa thanh toán</h3>
            </div>
            <div class="content">
                <div class="title">
                    <div><span>STT</span></div>
                    <div><span>Mã đơn đặt</span></div>
                    <div><span>Bàn</span></div>
                    <div><span>Tên món</span></div>
                    <div><span>Số lượng</span></div>
                    <div><span>Thành tiền</span></div>
                    <div><span>Trạng thái</span></div>
                    <div><span>Ngày tạo</span></div>
                </div>
                <div class="list-item">
                    <?php
                    if (isset($unpaidBills)) {
                        foreach ($unpaidBills as $key => $value) { ?>
                            <a class="items" href="<?php echo _WEB_ROOT ?>/OrderController/view_order/<?php echo $value['ma_dondat'] ?>">
                                <div class="order">
                                    <span>
                                        <?php echo $key + 1 ?>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <?php echo $value['ma_dondat'] ?>
                                        <input type="number" value="<?php echo $value['ma_dondat'] ?>" name="ma_dondat">
                                    </span>
                                </div>
                                <div>
                                    <span class="tableName">
                                        <?php foreach ($tables as $key1 => $value1) {
                                            if ($value['ma_ban'] == $value1['ma_ban']) {
                                                echo $value1['ten_ban'];
                                                break;
                                            }
                                        } ?>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <?php foreach ($foods as $key2 => $value2) {
                                            if ($value['ma_mon'] == $value2['ma_mon']) {
                                                echo $value2['ten_mon'];
                                                break;
                                            }
                                        } ?>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <?php echo $value['so_luong']; ?>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <?php echo $value['thanh_tien']; ?>
                                    </span>
                                </div>
                                <div>
                                    <span>Chờ thanh toán</span>
                                </div>
                                <div>
                                    <span>
                                        <?php echo $value['created_at']; ?>
                                    </span>
                                </div>
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="order-item">
            <div class="heading">
                <h3>Danh sách hóa đơn</h3>
            </div>
            <div class="content">
                <div class="title">
                    <div><span>STT</span></div>
                    <div><span>Mã hóa đơn</span></div>
                    <div><span>Mã bàn</span></div>
                    <div><span>Tên món</span></div>
                    <div><span>Loại</span></div>
                    <div><span>Giá</span></div>
                    <div><span>Số lượng</span></div>
                    <div><span>Thành tiền</span></div>
                    <div><span>Trạng thái</span></div>
                    <div><span>Ngày tạo</span></div>
                </div>
                <div class="list-item">
                    <?php
                    foreach ($paidBills as $key => $value) { ?>
                        <a class="items" href="<?php echo _WEB_ROOT ?>/BillController/bill_detail/<?php echo $value['ma_dondat'] ?>">
                            <div class="order"><span><?php echo $key + 1 ?></span></div>
                            <div>
                                <span>
                                    <?php echo $value['ma_hoadon'] ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <?php foreach ($tables as $key1 => $value1) {
                                        if ($value['ma_ban'] === $value1['ma_ban']) {
                                            echo $value1['ten_ban'];
                                        }
                                    } ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <?php foreach ($foods as $key2 => $value2) {
                                        if ($value['ma_mon'] == $value2['ma_mon']) {
                                            echo $value2['ten_mon'];
                                            break;
                                        }
                                    } ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <?php foreach ($types as $key3 => $value3) {
                                        if ($value['ma_loai'] == $value3['ma_loai']) {
                                            echo $value3['ten_loai'];
                                            break;
                                        }
                                    } ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <?php echo $value['gia'] ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <?php echo $value['so_luong'] ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <?php echo $value['thanh_tien'] ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <?php echo $value['trang_thai'] ?>
                                </span>
                            </div>
                            <div>
                                <span>
                                    <?php echo $value['created_at'] ?>
                                </span>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>