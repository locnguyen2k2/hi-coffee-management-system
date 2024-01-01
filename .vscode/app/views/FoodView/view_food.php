<div class="view-item">
    <div class="top-content">
        <a href="<?php echo _WEB_ROOT ?>/FoodController/view_food"><span>Món</span></a>
        <a href="<?php echo _WEB_ROOT ?>/TypeController/view_type"><span>Loại</span></a>
        <a href="<?php echo _WEB_ROOT ?>/TableController/view_table"><span>Bàn</span></a>
        <a href="<?php echo _WEB_ROOT ?>/AreaController/view_area"><span>Khu</span></a>
        <a href="<?php echo _WEB_ROOT ?>/UserController/view_user"><span>Người dùng</span></a>
        <a href="<?php echo _WEB_ROOT ?>/GroupController/view_group"><span>Quyền</span></a>
        <a href="<?php echo _WEB_ROOT ?>/GroupUserController/view_groupuser"><span>Phân quyền</span></a>
    </div>
    <div>
        <div class="heading"><span>Danh sách món</span></div>
        <div class="content">
            <div class="title">
                <div>
                    <span>STT</span>
                </div>
                <div>
                    <span>Tên món</span>
                </div>
                <div>
                    <span>Loại</span>
                </div>
                <div>
                    <span>Giá</span>
                </div>
                <div>
                    <span><i class="fas fa-cogs"></i></span>
                </div>
            </div>
            <div class="list-item">
                <!-- Lập qua danh sách món -->
                <?php
                foreach ($foods as $key => $value) { ?>
                    <div class="items">
                        <div class="order">
                            <span>
                                <?php echo $key + 1 ?>
                            </span>
                        </div>
                        <div class="name">
                            <span>
                                <!-- In tên món hiện tại -->
                                <?php echo $value['ten_mon'] ?>
                            </span>
                        </div>
                        <div class="type">
                            <span>
                                <!-- Lập qua danh sách loại và tìm loại của món hiện tại -->
                                <?php foreach ($types as $key1 => $value1) {
                                    if ($value['ma_loai'] == $value1['ma_loai']) {
                                        echo $value1['ten_loai'];
                                        break;
                                    }
                                } ?>
                            </span>
                        </div>
                        <div class="price">
                            <span>
                                <!-- In ra giá món hiện tại -->
                                <?php echo $value['gia_mon'] ?>
                            </span>
                        </div>
                        <div class="setting">
                            <a class="btn-update" href="<?php echo _WEB_ROOT ?>/FoodController/update_food/<?php echo $value['ma_mon'] ?>">
                                Cập nhật
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>