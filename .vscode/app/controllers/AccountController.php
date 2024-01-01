<?php
class AccountController extends Controller
{
    public $data = [];
    function __construct()
    {
        if (isset($_SESSION['user_logged'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->data['content'] = 'AccountView/Signin';
        }
    }
    function Signin()
    {
        $this->data['sub_content'] = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnSignin'])) {
            if ($this->isFieldValid($_POST['inpUsername']) && $this->isFieldValid($_POST['inpPassword'])) {
                $username = $_POST['inpUsername'];
                $password = $_POST['inpPassword'];
                $this->checkSignin($username, $password);
                if (!isset($_SESSION['user_logged'])) {
                    $this->data['sub_content']['isWrong'] = 'Vui lòng nhập đúng tài khoản và mật khẩu!';
                    $this->render('layouts/user_layout', $this->data);
                } else {
                    header('Location: ' . _WEB_ROOT . '/HomeController/index');
                }
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
        header('Location: ' . _WEB_ROOT . '/HomeController/index');
    }
}
