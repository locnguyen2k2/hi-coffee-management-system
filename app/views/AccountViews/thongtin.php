<div class="user_info">
    <div class="user_info__avatar">
        <img src="public/images/avatar.png" alt="avatar">
    </div>
    <div class="user_info__name">
        <p>
            <?php echo $_SESSION['user_logged']['name']; ?>
        </p>
    </div>
    <div class="user_info__username">
        <p>
            <?php echo $_SESSION['user_logged']['username']; ?>
        </p>
    </div>
    <div class="user_info__group">
        <p>Quyền hạn:</p>
        <ul>
            <?php
            if (isset($_SESSION['user_logged']['groups'])) {
                foreach ($_SESSION['user_logged']['groups'] as $key => $value) {
                    if ($value == 1) {
                        echo '<li>Quản trị viên</li>';
                    }
                    if ($value == 2) {
                        echo '<li>Quản lý</li>';
                    }
                    if ($value == 3) {
                        echo '<li>Nhân viên</li>';
                    }
                }
            }
            ?>
        </ul>
    </div>
    <div class="user_info__logout">
        <a href="<?php echo _WEB_ROOT?>/dang-xuat">Đăng xuất</a>
    </div>
</div>