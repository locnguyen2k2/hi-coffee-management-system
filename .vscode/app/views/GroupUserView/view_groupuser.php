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
        <div class="heading"><span>Danh sách phân quyền</span></div>
        <div class="content">
            <div class="title">
                <div><span>STT</span></div>
                <div><span>Tên tài khoản</span></div>
                <div><span>Quyền</span></div>
                <div><span>Trạng thái</span></div>
                <div><span><i class="fas fa-cogs"></i></span></div>
            </div>
            <div class="list-item">
                <!-- Lập qua mục phân quyền -->
                <?php
                foreach ($permissions as $key => $value) { ?>
                    <div class="items">
                        <div class="order">
                            <span>
                                <?php echo $key + 1 ?>
                            </span>
                        </div>
                        <div class="name">
                            <span>
                                <!-- Tìm và in ra username của phân quyền hiện tại -->
                                <?php foreach ($users as $key1 => $value1) {
                                    if ($value['user_id'] == $value1['id']) {
                                        echo $value1['username'];
                                        break;
                                    }
                                } ?>
                            </span>
                        </div>
                        <div class="group">
                            <span>
                                <!-- Tìm và in ra quyền của phân quyền hiện tại -->
                                <?php foreach ($groups as $key2 => $value2) {
                                    if ($value['group_id'] == $value2['id']) {
                                        echo $value2['name'];
                                        break;
                                    }
                                } ?>
                            </span>
                        </div>
                        <div class="status">
                            <span>
                                <!-- In trạng thái của phân quyền -->
                                <?php echo $value['status'] ?>
                            </span>
                        </div>
                        <div class="setting">
                            <a class="btn-update" href="<?php echo _WEB_ROOT ?>/GroupUserController/update_groupuser/<?php echo $value['id'] ?>">Cập nhật</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>