<div>
    <?php if (isset($isWrong)) {
        echo $isWrong;
    } else if (isset($isNull)) {
        echo $isNull;
    };
    ?>
</div>
<div class="form-login">
    <div class="content">
        <h1>
            <i class="fas fa-mug-hot"></i>
        </h1>
        <h1>Welcome!</h1>
        <p>Chào mừng đến với hệ thống quản lý đặt món</p>
    </div>
    <form class="fSignin child-component" method="POST" action="<?php echo _WEB_ROOT ?>/AccountController/Signin">
        <div class="title">
            <h2>Đăng nhập</h2>
        </div>
        <div class="inpUsername"><span><a><i class="fas fa-user"></i> Tài khoản </a></span><input type="text" class="inpUsername" id="inpUsername" name="inpUsername" placeholder="abcxyz0123"></div>
        <div class="inpPassword"><span><a><i class="fas fa-lock"></i> Mật khẩu </a></span><input type="password" class="inpPassword" id="inpPassword" name="inpPassword" placeholder="abcxyz0123"></div>
        <div class="btnSignin"><input type="submit" class="btnSignin" id="btnSignin" name="btnSignin" value="Đăng nhập"></div>
    </form>
</div>