<div class="error">
    <h3>
        <?php
        if (isset($isNull)) {
            echo $isNull;
        } else if (isset($isReplaced)) {
            echo $isReplaced;
        } ?>
    </h3>
</div>
<div class="success">
    <h3>
        <?php if (isset($isSucessed)) {
            echo $isSucessed;
        } ?>
    </h3>
</div>
<div class='update-item'>
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
        <div class="list-item">
            <div class="heading">
                <h3>Cập nhật loại</h3>
            </div>
            <div class="list-item">
                <form class="items" method="post" action="<?php echo _WEB_ROOT ?>/TypeController/update_type/<?php echo $type['ma_loai'] ?>">
                    <div><span><input type="text" value="<?php echo $type['ten_loai'] ?>" name="name"></span></div>
                    <div><span><input type="number" min="0" max="1" value="<?php echo $type['trang_thai'] ?>" name="status"></span></div>
                    <div class="setting">
                        <input type="submit" name="update-type-btn" value="Cập nhật">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>