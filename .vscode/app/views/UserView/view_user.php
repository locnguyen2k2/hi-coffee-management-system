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
        <div class="heading"><span>Danh sách người dùng</span></div>
        <div class="content">
            <div class="title">
                <div><span>STT</span></div>
                <div><span>Tên người dùng</span></div>
                <div><span>Tài khoản</span></div>
                <div><span>Mật khẩu</span></div>
                <div><span>SĐT</span></div>
                <div><span>Email</span></div>
                <div><span>Trạng thái</span></div>
                <div><span><i class="fas fa-cogs"></i></span></div>
            </div>
            <div class="list-item">
                <?php
                foreach ($users as $key => $value) { ?>
                    <div class="items">
                        <div class="order"><span><?php echo $key + 1 ?></span></div>
                        <div class="name"><span><?php echo $value['fname'] . ' ' . $value['lname'] ?></span></div>
                        <div class="username"><span><?php echo $value['username'] ?></span></div>
                        <div class="password"><span><?php echo $value['password'] ?></span></div>
                        <div class="phonenumber"><span><?php echo $value['number'] ?></span></div>
                        <div class="email"><span><?php echo $value['email'] ?></span></div>
                        <div><span><?php echo $value['status'] ?></span></div>
                        <div class="setting">
                            <a class="btn-update" href="<?php echo _WEB_ROOT ?>/UserController/update_user/<?php echo $value['id']; ?>">Cập nhật</a>
                            <a class="btn-delete">
                                <form method="POST" action="<?php echo _WEB_ROOT . '/UserController/delete_user/' . $value['id']; ?>">
                                    <input type="submit" name="btn-delete-user" value="Xóa">
                                </form>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>