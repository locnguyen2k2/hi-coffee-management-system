<div class='title'>
    <h3>Chào mừng <?php echo $_SESSION['user_logged']['name'] ?> đã trở lại!</h3>
    <p>Vui lòng chọn các chức năng bên dưới để tiếp tục.</p>
</div>
<div class='list-content child-component'>
    <a href="<?php echo _WEB_ROOT ?>/FoodController/add_food">Thêm</a>
    <a href="<?php echo _WEB_ROOT ?>/FoodController/view_food">DS Món</a>
    <a href="<?php echo _WEB_ROOT ?>/TypeController/view_type">DS Loại</a>
    <a href="<?php echo _WEB_ROOT ?>/TableController/view_table">DS Bàn</a>
    <a href="<?php echo _WEB_ROOT ?>/AreaController/view_area">DS Khu</a>
    <a href="<?php echo _WEB_ROOT ?>/UserController/view_user">DS Người dùng</a>
    <a href="<?php echo _WEB_ROOT ?>/GroupController/view_group">DS Quyền</a>
    <a href="<?php echo _WEB_ROOT ?>/GroupUserController/view_groupuser">DS Phân quyền</a>
</div>