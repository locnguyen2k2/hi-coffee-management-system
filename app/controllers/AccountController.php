<?php

use PHPMailer\PHPMailer\PHPMailer;

class AccountController extends Controller
{
    public $data = [], $user, $permission;
    function __construct()
    {
        if (isset($_SESSION['user_logged'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->data['content'] = 'AccountViews/';
            $this->user = $this->model('UserModel');
            $this->permission = $this->model('PermissionModel');
        }
    }
    function Signin()
    {
        $this->data['content'] = $this->data['content'] . 'signin';
        $this->data['sub_content'] = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnSignin'])) {
            if ($this->isFieldValid($_POST['inpUsername']) && $this->isFieldValid($_POST['inpPassword'])) {
                $username = $_POST['inpUsername'];
                $password = $_POST['inpPassword'];
                $this->checkSignin($username, $password);
                if (!isset($_SESSION['user_logged']) && !isset($_SESSION['not_allowed'])) {
                    $this->data['sub_content']['isWrong'] = 'Vui lòng nhập đúng tài khoản và mật khẩu!';
                    $this->render('layouts/user_layout', $this->data);
                } else if (isset($_SESSION['not_allowed'])) {
                    $this->data['sub_content']['isWrong'] = $_SESSION['not_allowed'];
                    unset($_SESSION['not_allowed']);
                    $this->render('layouts/user_layout', $this->data);
                } else {
                    header('Location: ' . _WEB_ROOT . '/trang-chu');
                }
            } else {
                $this->data['sub_content']['isNull'] = 'Vui lòng điền đầy đủ thông tin!';
                $this->render('layouts/user_layout', $this->data);
            }
        } else {
            $this->render('layouts/user_layout', $this->data);
        }
    }
    function Signup()
    {
        $this->data['content'] = $this->data['content'] . 'signup';
        $this->data['sub_content'][] = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup-account-btn'])) {
            $replaceUsername = false;
            $replacePassword2 = true;
            if (
                $this->isFieldValid($_POST['fname']) &&
                $this->isFieldValid($_POST['lname']) &&
                $this->isFieldValid($_POST['username']) &&
                $this->isFieldValid($_POST['password']) &&
                $this->isFieldValid($_POST['password2']) &&
                $this->isFieldValid($_POST['phonenumb']) &&
                $this->isFieldValid($_POST['email'])
            ) {
                foreach ($this->user->getListUser() as $key => $value) {
                    if (mb_strtolower($value['username']) == mb_strtolower($_POST['username'])) {
                        $replaceUsername = true;
                    }
                }
                if ($replaceUsername == true) {
                    $this->data['sub_content']['isReplaced'] = 'Tên tài khoản đã tồn tại!';
                    $this->render('layouts/user_layout', $this->data);
                }
                if ($_POST['password'] != $_POST['password2']) {
                    $replacePassword2 = false;
                }
                if ($replacePassword2 == false) {
                    $this->data['sub_content']['isReplaced'] = 'Nhập lại mật khẩu không đúng!';
                    $this->render('layouts/user_layout', $this->data);
                }
                if ($replaceUsername == false && $replacePassword2 == true) {
                    $this->user->addUser($_POST['fname'], $_POST['lname'], $_POST['username'], $_POST['password'], $_POST['phonenumb'], $_POST['email']);
                    $this->permission->addPermission($this->user->getUserByUsername($_POST['username'])['id'], 2);
                    $this->user->updateUserStatus($this->user->getUserByUsername($_POST['username'])['id'], 1);
                    $this->data['sub_content']['isSucessed'] = 'Đăng ký thành công, vui lòng liên hệ admin để được kích hoạt tài khoản!';
                    $this->render('layouts/user_layout', $this->data);
                }
            } else {
                $this->data['sub_content']['isNull'] = 'Vui lòng nhập đầy đủ thông tin';
                $this->render('layouts/user_layout', $this->data);
            }
        } else {
            $this->render('layouts/user_layout', $this->data);
        }
    }
    function forgotPassword()
    {
        $this->data['content'] .= 'forgot_password';
        $this->data['sub_content'][] = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnResetPassword'])) {
            if ($this->isFieldValid($_POST['inpUsername']) && $this->isFieldValid($_POST['inpEmail'])) {
                $username = $_POST['inpUsername'];
                $email = $_POST['inpEmail'];
                $result = false;
                function randomPassword($length = 8)
                {
                    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $count = mb_strlen($chars);
                    for ($i = 0, $result = ''; $i < $length; $i++) {
                        $index = rand(0, $count - 1);
                        $result .= mb_substr($chars, $index, 1);
                    }
                    return $result;
                }
                ;
                if (isset($this->user->getUserByUsername($username)['id'])) {
                    if ($this->user->getUserByUsername($username)['email'] == $email) {
                        $this->user->updateUserPassword($this->user->getUserByUsername($username)['id'], randomPassword());
                        require _DIR_ROOT . '/vendor/autoload.php';
                        $mail = new PHPMailer(true);
                        // Thiết lập SMTP
                        // $mail->SMTPDebug = 2;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'ntloc0711@gmail.com';
                        $mail->Password = $_ENV['emailPassword'];
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        // Thiết lập người gửi và người nhận
                        $mail->setFrom('ntloc0711@gmail.com', 'HiCoffee');
                        $mail->addAddress($email, 'Recipient Name');

                        // Thiết lập tiêu đề và nội dung email
                        $subject = 'Lấy lại mật khẩu - Lưu ý: đổi lại mật khẩu sau khi đăng nhập để bảo mật tài khoản!';
                        $sub = '=?UTF-8?B?' . base64_encode($subject) . '?=';
                        $mail->Subject = $sub;
                        $mail->Body = 'Mật khẩu của bạn là: ' . $this->user->getUserByUsername($username)['password'];

                        // Gửi email
                        $mail->send();
                        $this->data['sub_content']['isWrong'] = 'Vui lòng kiểm tra email để lấy lại mật khẩu!';
                        $this->data['content'] = 'AccountViews/signin';
                        $this->render('layouts/user_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isWrong'] = 'Vui lòng nhập đúng tài khoản và email!';
                        $this->render('layouts/user_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isWrong'] = 'Vui lòng nhập đúng tài khoản và email!';
                    $this->render('layouts/user_layout', $this->data);
                }
            } else {
                $this->data['sub_content']['isNull'] = 'Vui lòng điền đầy đủ thông tin!';
                $this->render('layouts/user_layout', $this->data);
            }
        } else {
            $this->render('layouts/user_layout', $this->data);
        }
        $this->render('layouts/user_layout', $this->data);
    }
    function updateAccount($userID)
    {
        $this->data['content'] .= 'update_account';
        $this->data['sub_content'][] = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnUpdateAccount'])) {
            if ($this->isFieldValid($_POST['inpFname']) && $this->isFieldValid($_POST['inpLname']) && $this->isFieldValid($_POST['inpUsername']) && $this->isFieldValid($_POST['inpEmail']) && $this->isFieldValid($_POST['inpPhoneNumb'])) {
                $fname = $_POST['inpFname'];
                $lname = $_POST['inpLname'];
                $username = $_POST['inpUsername'];
                $email = $_POST['inpEmail'];
                $phonenumb = $_POST['inpPhoneNumb'];
                $this->user->updateUser($userID, $fname, $lname, $username, $email, $phonenumb);
                $this->data['sub_content']['isSucessed'] = 'Cập nhật tài khoản thành công!';
                $this->render('layouts/user_layout', $this->data);
            } else {
                $this->data['sub_content']['isNull'] = 'Vui lòng điền đầy đủ thông tin!';
                $this->render('layouts/user_layout', $this->data);
            }
        } else {
            $this->render('layouts/user_layout', $this->data);
        }
    }
    function Signout()
    {
        if (isset($_SESSION['user_logged'])) {
            unset($_SESSION['user_logged']);
        }
        header('Location: ' . _WEB_ROOT . '/trang-chu');
    }
}