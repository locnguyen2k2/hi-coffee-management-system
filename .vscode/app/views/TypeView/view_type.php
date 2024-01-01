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
        <div class="heading"><span>Danh sách loại</span></div>
        <div class="content">
            <div class="title">
                <div><span>STT</span></div>
                <div><span>Tên loại</span></div>
                <div><span><i class="fas fa-cogs"></i></span></div>
            </div>
            <div class="list-item">
                <?php
                foreach ($types as $key => $value) { ?>
                    <div class="items">
                        <div class="order">
                            <span>
                                <?php echo $key + 1 ?>
                            </span>
                        </div>
                        <div class="name">
                            <span>
                                <?php echo $value['ten_loai'] ?>
                            </span>
                        </div>
                        <div class="setting">
                            <a class="btn-update" href="<?php echo _WEB_ROOT ?>/TypeController/update_type/<?php echo $value['ma_loai'] ?>">Cập nhật</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>