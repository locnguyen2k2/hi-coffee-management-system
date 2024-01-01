<div class="menu">
    <ul class="menu-left">
        <li><a href="#"><span>Về chúng tôi</span></a></li>
        <li><a href="#"><span>Địa chỉ</span></a></li>
        <li><a href="#"><span>Liên hệ</span></a></li>
    </ul>
    <ul class="menu-right">
        <?php
        if (!isset($_SESSION['user_logged'])) { ?>
            <li><a href="<?php echo _WEB_ROOT ?>/dang-nhap"><span>Đăng nhập</span></a></li>
            <li><a href="<?php echo _WEB_ROOT ?>/dang-ky"><span>Đăng ký</span></a></li>
        <?php }
        ?>
        <?php if (isset($_SESSION['user_logged']['roles']['admin'])) { ?>
            <li><a href="<?php echo _WEB_ROOT ?>/trang-chu/"><span>Quản trị viên</span></a></li>
        <?php } ?>
        <?php if (isset($_SESSION['user_logged']['roles']['staff'])) { ?>
            <li><a href="<?php echo _WEB_ROOT ?>/them-don-dat"><span>Nhân viên</span></a></li>
        <?php } ?>
        <?php if (isset($_SESSION['user_logged']['roles']['manager'])) { ?>
            <li><a href="<?php echo _WEB_ROOT ?>/trang-chu/quan-tri"><span>Quản lý</span></a></li>
        <?php } ?>
        <li><a href="<?php echo _WEB_ROOT ?>/InvoiceController/getListInvoice"><span>Hóa đơn</span></a></li>
    </ul>
</div>