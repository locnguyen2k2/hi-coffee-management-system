<div class="form-signup">
    <div class="content">
        <h1 class="d-flex flex-column text-center">
            <i class="fas fa-mug-hot"></i>
            HiCoffee
        </h1>
    </div>
    <div class="title">
        <h2>Đăng ký tài khoản</h2>
    </div>
    <div class="text-center">
        <?php if (isset($isReplaced)) {
            echo $isReplaced;
        } else if (isset($isNull)) {
            echo $isNull;
        } else if (isset($isSucessed)) {
            echo $isSucessed;
        } ?>
    </div>
    <form class="fSignup child-component" method="POST" action="<?php echo _WEB_ROOT ?>/dang-ky">
        <div class="inpUsername">
            <span>
                <a><i class="fas fa-user"></i>Họ</a>
            </span>
            <input type="text" class="inpUsername" id="inpUsername" name="fname">
        </div>
        <div class="inpPassword">
            <span>
                <a><i class="fas fa-user"></i>Tên</a>
            </span>
            <input type="text" class="inpPassword" id="inpPassword" name="lname">
        </div>
        <div class="inpUsername">
            <span>
                <a><i class="fas fa-user"></i> Tài khoản</a>
            </span>
            <input type="text" class="inpUsername" id="inpUsername" name="username">
        </div>
        <div class="inpPassword">
            <span>
                <a><i class="fas fa-lock"></i> Mật khẩu </a>
            </span>
            <input type="password" class="inpPassword" id="inpPassword" name="password">
        </div>
        <div class="inpUsername">
            <span>
                <a><i class="fas fa-lock"></i> Nhập lại mật khẩu</a>
            </span>
            <input type="password" class="inpUsername" id="inpUsername" name="password2">
        </div>
        <div class="inpPassword">
            <span>
                <a><i class="fas fa-phone"></i> Số điện thoại </a>
            </span>
            <input type="text" class="inpPassword" id="inpPassword" name="phonenumb">
        </div>
        <div class="inpPassword">
            <span>
                <a><i class="fa-solid fa-envelope"></i> Email </a>
            </span>
            <input type="email" class="inpPassword" id="inpPassword" name="email">
        </div>
        <div class="btnSignup">
            <input type="submit" class="btnSignup" id="btnSignin" name="signup-account-btn" value="Đăng ký">
        </div>
    </form>
    <span class="d-block w-100 text-center">Đã có tài khoản?
        <a href="<?php echo _WEB_ROOT ?>/dang-nhap">Đăng nhập tại đây.</a>
    </span>
</div>