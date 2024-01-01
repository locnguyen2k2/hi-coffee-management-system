<?php
class AccountController extends Controller
{
    public $data = [], $nguoidung, $phanquyen;
    function signin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_logged'])) {
                if ($this->isFieldValid($_POST['inpUsername']) && $this->isFieldValid($_POST['inpPassword'])) {
                    $username = $_POST['inpUsername'];
                    $password = $_POST['inpPassword'];
                    $this->checkSignin($username, $password);
                    if (!isset($_SESSION['user_logged']) && !isset($_SESSION['not_allowed'])) {
                        $this->data['error'] = 1;
                        $this->data['message'] = 'Vui lòng nhập đúng tài khoản và mật khẩu!';
                        echo json_encode($this->data);
                    } else if (isset($_SESSION['not_allowed'])) {
                        $not_allow = $_SESSION['not_allowed'];
                        unset($_SESSION['not_allowed']);
                        $this->data['error'] = 1;
                        $this->data['message'] = 'Đã đăng nhập!';
                        echo json_encode($this->data);
                    } else {
                        $this->data['error'] = 0;
                        $this->data['data'] = $_SESSION['user_logged'];
                        $this->data['message'] = 'Đăng nhập thành công!';
                        echo json_encode($this->data);
                    }
                } else {
                    // echo 'Vui lòng điền đầy đủ thông tin!';
                    $this->data['error'] = 1;
                    $this->data['message'] = 'Vui lòng nhập đủ thông tin!';
                    echo json_encode($this->data);
                }
            } else {
                $this->data['error'] = 1;
                $this->data['message'] = 'Đã đăng nhập';
                echo json_encode($this->data);
            }
        } else {
            echo 'oke';
        }
    }
    function signout()
    {
        if (isset($_SESSION['user_logged'])) {
            unset($_SESSION['user_logged']);
            $this->data['error'] = 0;
            $this->data['message'] = 'Đăng xuất thành công!';
        } else {
            $this->data['error'] = 0;
            $this->data['message'] = 'Chưa đăng nhập!';
        }
        echo json_encode($this->data);
    }
    function checkSigned()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_SESSION['user_logged'])) {
                $this->data['error'] = 0;
                $this->data['data'] = $_SESSION['user_logged'];
                echo json_encode($this->data);
            } else {
                $this->data['error'] = 1;
                $this->data['message'] = 'Nguời dùng chưa đăng nhập';
                echo json_encode($this->data);
            }
        }
    }
}