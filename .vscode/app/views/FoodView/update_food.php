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
                <span>Cập nhật món</span>
            </div>
            <form class="items" method="post" action="<?php echo _WEB_ROOT ?>/FoodController/update_food/<?php echo $food['ma_mon'] ?>">
                <div>
                    <span>
                        <input type="text" value="<?php echo $food['ten_mon'] ?>" name="name">
                    </span>
                </div>
                <div>
                    <span>
                        <!-- Tạo thẻ select chọn loại -->
                        <select name="type">
                            <!-- Option chứa loại của món hiệ tại -->
                            <option selected value="<?php echo $food['ma_loai']; ?>">
                                <?php echo $type['ten_loai'] ?>
                            </option>
                            <!-- Tạo các option chứa loại khác với loại của món đang được cập nhật -->
                            <?php foreach ($types as $key1 => $value1) {
                                if ($value1['ma_loai'] != $food['ma_loai']) { ?>
                                    <option value="<?php echo $value1['ma_loai'] ?>"><?php echo $value1['ten_loai'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </span>
                </div>
                <div><span><input type="number" value="<?php echo $food['gia_mon'] ?>" name="price"></span></div>
                <div><span><input type="number" min="0" max="1" value="<?php echo $food['trang_thai'] ?>" name="status"></span></div>
                <div class="setting">
                    <input type="submit" name="update-food-btn" value="Cập nhật">
                </div>
            </form>
        </div>
    </div>
</div>