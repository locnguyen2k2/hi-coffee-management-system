<div class="title text-center">
    <h1 class="d-flex flex-column">
        <i class="fas fa-mug-hot"></i>
        Quên mật khẩu
    </h1>
</div>
<div>
    <?php if (isset($isWrong)) {
        echo $isWrong;
    } else if (isset($isNull)) {
        echo $isNull;
    }
    ;
    ?>
</div>
<div class="form-login justify-content-center">
    <form class="fSignin child-component" method="POST"
        action="<?php echo _WEB_ROOT ?>/lay-lai-mat-khau">
        <div class="inpUsername"><span><a><i class="fas fa-user"></i> Tài khoản </a></span><input type="text"
                class="inpUsername" id="inpUsername" name="inpUsername" placeholder="Tên tài khoản"></div>
        <div class="inpPassword">
            <span>
                <a><i class="fa-solid fa-envelope"></i> Email </a>
            </span>
            <input type="email" class="inpPassword" id="inpPassword" placeholder="Email được liên kết với tài khoản"
                name="inpEmail">
        </div>
        <div class="btnSignin"><input type="submit" class="btnSignin" id="btnSignin" name="btnResetPassword"
                value="Lấy lại mật khẩu">
        </div>
    </form>
</div>
<span class="d-block w-100 text-center">Chưa có tài khoản?
    <a href="<?php echo _WEB_ROOT ?>/dang-ky">Đăng ký tại đây.</a>
</span>
<span class="d-block w-100 text-center">Đã có tài khoản?
    <a href="<?php echo _WEB_ROOT ?>/dang-nhap">Đăng nhập tại đây.</a>
</span>