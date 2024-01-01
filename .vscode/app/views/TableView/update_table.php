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
                <span>Cập nhật bàn</span>
            </div>
            <form class="items" method="post">
                <div>
                    <span>
                        <input type="text" value="<?php echo $table['ten_ban'] ?>" name="name">
                    </span>
                </div>
                <div>
                    <span>
                        <select name="area_name">
                            <option selected value="<?php echo $area['ten_khu'] ?>"><?php echo $area['ten_khu'] ?></option>
                            <?php foreach ($areas as $key1 => $value1) {
                                if ($value1['ma_khu'] != $table['ma_khu']) { ?>
                                    <option value="<?php echo $value1['ten_khu'] ?>"><?php echo $value1['ten_khu'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </span>
                </div>
                <div>
                    <span>
                        <input type="number" min="0" max="1" value="<?php echo $table['trang_thai'] ?>" name="status">
                    </span>
                </div>
                <div class="setting">
                    <input type="submit" name="update-table-btn" value="Cập nhật">
                </div>
            </form>
        </div>
    </div>
</div>