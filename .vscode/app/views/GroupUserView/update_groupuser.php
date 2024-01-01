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
                <span>Cập nhật phân quyền</span>
            </div>
            <form class="items" method="post" action="<?php echo _WEB_ROOT ?>/GroupUserController/update_groupuser/<?php echo $user_permission['id'] ?>">
                <div>
                    <span>
                        <?php echo $account['username'] ?>
                    </span>
                </div>
                <div>
                    <span>
                        <!-- Tạo thẻ select chọn quyền -->
                        <select name="group_id">
                            <!-- Option chứa quyền hiện đang được cập nhật của người dùng -->
                            <option selected value="<?php echo $user_permission['group_id'] ?>">
                                <?php echo $group_user['name'] ?>
                            </option>
                            <!-- Tạo các option có quyền khác với quyền của người dùng hiện đang cập nhật -->
                            <?php
                            foreach ($groups as $key1 => $value1) {
                                if ($value1['id'] != $user_permission['group_id']) { ?>
                                    <option value="<?php echo $value1['id'] ?>">
                                        <?php echo $value1['name'] ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <div>
                    <span>
                        <input type="number" value="<?php echo $user_permission['status'] ?>" min="0" max="1" name="status">
                    </span>
                </div>
                <div class="setting">
                    <input type="submit" name="update-group-user-btn" value="Cập nhật">
                </div>
            </form>
        </div>
    </div>
</div>