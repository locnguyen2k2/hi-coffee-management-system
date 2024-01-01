<div class="header">
    <div class="left-header">
        <div class="bars">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <span>website</span>
    </div>
    <div class="user-account">
        <i class="fa-solid fa-user"></i>
        <ul class="account-item">
            <?php if (!isset($_SESSION['user_logged'])) { ?>
                <li><a href="<?php echo _WEB_ROOT ?>/AccountController/Signin">Đăng nhập</a></li>
            <?php } else { ?>
                <li><a href="<?php echo _WEB_ROOT ?>/AccountController/profile">Thông tin</a></li>
                <li><a href="<?php echo _WEB_ROOT ?>/AccountController/Signout">Đăng xuất</a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="right-header">
        <div class="search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <span>all</span>
    </div>
</div>