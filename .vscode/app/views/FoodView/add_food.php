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
    <form method="post" class="add-food" enctype="multipart/form-data" action="<?php echo _WEB_ROOT ?>/FoodController/add_food">
        <div class="name">
            <div><span>1) Tên món: </span></div>
            <div><input type="text" name="name" placeholder="Nhập tên món"></div>
        </div>
        <div class="type">
            <div>
                <span>2) Loại loại món: </span>
            </div>
            <div>
                <?php
                foreach ($types as $key => $value) { ?>
                    <div class="type-item">
                        <input type="radio" value="<?php echo $value['ma_loai'] ?>" name="type">
                        <label for="type">
                            <?php echo $value['ten_loai'] ?>
                        </label>
                    </div>
                <?php
                } ?>
            </div>
        </div>
        <div class="images">
            <div><span>3) Hình ảnh: </span></div>
            <div>
                <div class="imgs"></div>
            </div>
            <div class="add-img-btn content"><input type="button" value="Thêm hình"></div>
        </div>
        <div class="price">
            <div><span>4) Giá sản món: </span></div>
            <div><input type="number" name="price" placeholder="Nhập giá sản món"></div>
        </div>
        <div class="featured">
            <div><span>5) Nổi bật: </span></div>
            <div>
                <div>
                    <input type="radio" value="0" name="featured">
                    <label for="type">Không</label>
                </div>
                <div>
                    <input type="radio" value="1" name="featured">
                    <label for="type">Có</label>
                </div>
            </div>
        </div>
        <div class="add-btn"><input type="submit" name="add-food-btn" value="Thêm"></div>
    </form>
</div>