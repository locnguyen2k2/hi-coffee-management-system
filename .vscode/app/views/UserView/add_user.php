<div class="add-form">
    <div class="title">
        <div class="add-food-title"><a href="<?php echo _WEB_ROOT ?>/FoodController/add_food"><span>Thêm món</span></a></div>
        <div class="add-type-title"><a href="<?php echo _WEB_ROOT ?>/TypeController/add_type"><span>Thêm loại</span></a></div>
        <div class="add-table-title"><a href="<?php echo _WEB_ROOT ?>/TableController/add_table"><span>Thêm bàn</span></a></div>
        <div class="add-area-title"><a href="<?php echo _WEB_ROOT ?>/AreaController/add_area"><span>Thêm khu</span></a></div>
        <div class="add-account-title"><a href="<?php echo _WEB_ROOT ?>/UserController/add_user"><span>Thêm người dùng</span></a></div>
        <div class="add-group-title"><a href="<?php echo _WEB_ROOT ?>/GroupController/add_group"><span>Thêm quyền</span></a></div>
        <div class="add-user-group-title"><a href="<?php echo _WEB_ROOT ?>/GroupUserController/add_groupuser"><span>Thêm phân quyền</span></a></div>
    </div>
    <div class="alert">
        <div class="error">
            <?php
            if (isset($isReplaced)) {
                echo $isReplaced;
            } else if (isset($isNull)) {
                echo $isNull;
            } else if (isset($isSucessed)) { ?>
        </div>
        <div class="success">
            <?php echo $isSucessed; ?>
        </div>
    <?php } ?>
    </div>
    <form method="post" action="<?php echo _WEB_ROOT ?>/UserController/add_user" class="add-account">
        <div class="fname">
            <div><span>1) Họ và tên đệm: </span></div>
            <input type="text" name="fname" placeholder="Nhập họ và tên đệm">
        </div>
        <div class="lname">
            <div><span>2) Tên: </span></div>
            <input type="text" name="lname" placeholder="Nhập tên">
        </div>
        <div class="username">
            <div><span>3) Tên tài khoản: </span></div>
            <input type="text" name="username" placeholder="Nhập tên tài khoản">
        </div>
        <div class="password">
            <div><span>4) Mật khẩu: </span></div>
            <input type="password" name="password" placeholder="Nhập mật khẩu">
        </div>
        <div class="password2">
            <div><span>5) Nhập lại mật khẩu: </span></div>
            <input type="password" name="password2" placeholder="Nhập lại mật khẩu">
        </div>
        <div class="phonenumb">
            <div><span>6) Nhập số điện thoại: </span></div>
            <input type="text" name="phonenumb" placeholder="Nhập số điện thoại">
        </div>
        <div class="email">
            <div><span>7) Nhập email: </span></div>
            <input type="email" name="email" placeholder="Nhập email">
        </div>
        <div class="add-btn"><input type="submit" name="add-account-btn" value="thêm"></div>
    </form>
</div>