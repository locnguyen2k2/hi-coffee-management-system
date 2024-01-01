<div>
    <?php if (isset($isWrong)) {
        echo $isWrong;
    } else if (isset($isNull)) {
        echo $isNull;
    }
    ; ?>
</div>
<div class="form-login">
    <div class="content">
        <h1>
            <i class="fas fa-mug-hot"></i>
        </h1>
        <h1>Welcome!</h1>
        <p>Chào mừng đến với hệ thống quản lý đặt món tại HiCoffee</p>
    </div>
    <form class="fSignin child-component" method="POST" action="<?php echo _WEB_ROOT ?>/dang-nhap">
        <div class="title">
            <h2>Đăng nhập</h2>
        </div>
        <div class="inpUsername"><span><a><i class="fas fa-user"></i> Tài khoản </a></span><input type="textarea"
                class="inpUsername" id="inpUsername" name="inpUsername" placeholder="Tên tài khoản">
        </div>
        <div class="inpPassword">
            <span>
                <a><i class="fas fa-lock"></i> Mật khẩu </a>
            </span>
            <input type="password" class="inpPassword" id="inpPassword" name="inpPassword" placeholder="Mật khẩu">
        </div>
        <div class="btnSignin"><input type="submit" class="btnSignin" id="btnSignin" name="btnSignin" value="Đăng nhập">
        </div>
    </form>
</div>
<span class="d-block w-100 text-center">Chưa có tài khoản?
    <a href="<?php echo _WEB_ROOT ?>/dang-ky">Đăng ký tại đây.</a>
</span>
<span class="d-block w-100 text-center">Quên mật khẩu?
    <a href="<?php echo _WEB_ROOT ?>/lay-lai-mat-khau">Lấy lại mật khẩu tại đây.</a>
</span>