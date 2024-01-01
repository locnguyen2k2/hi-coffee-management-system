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
    <form method="post" action="<?php echo _WEB_ROOT ?>/TableController/add_table" class="add-table">
        <div class="name">
            <div><span>1) Tên bàn: </span></div>
            <input type="text" name="name" placeholder="Nhập tên bàn">
        </div>
        <div class="area">
            <div><span>2) Tên khu: </span></div>
            <input type="text" name="area" placeholder="Nhập tên khu">
        </div>
        <div class="add-btn"><input type="submit" name="add-table-btn" value="thêm"></div>
    </form>
</div>