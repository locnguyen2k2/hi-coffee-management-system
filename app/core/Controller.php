<?php
class Controller
{
    function render($view, $data = []) // Hàm render view
    {
        extract($data); // Chuyển mảng thành các biến
        if (file_exists('app/views/' . $view . '.php')) {
            require_once 'app/views/' . $view . '.php';
        } else {
            require_once 'app/errors/404.php';
        }
    }
    public function model($model) // Hàm load model
    {
        if (file_exists(_DIR_ROOT . '/app/models/' . $model . '.php')) {
            require_once(_DIR_ROOT . '/app/models/' . $model . '.php');
            if (class_exists($model)) {
                $model = new $model(); // Khởi tạo lớp của model
                return $model;
            }
        }
        return false;
    }
    function isFieldValid($field) // Hàm kiểm tra trường có hợp lệ
    {
        return !empty(trim($field));
    }
    function checkSignin($username, $password) // Hàm kiểm tra đăng nhập
    {
        $users = $this->model('UserModel');
        $permission = $this->model('PermissionModel');
        foreach ($users->getListUser() as $key => $value) {
            if ($value['username'] == $username) {
                if ($value['password'] == $password) {
                    if ($value['status'] == 0) {
                        $_SESSION['user_logged']['name'] = $value['fname'] . ' ' . $value['lname'];
                        $_SESSION['user_logged']['username'] = $value['username'];
                        foreach ($permission->getPermissionByUser($value['id']) as $key1 => $value1) {
                            if ($value1['roleID'] == 1 && $value1['status'] == 0) {
                                $_SESSION['user_logged']['roles']['admin'] = $value1['roleID'];
                            }
                            if ($value1['roleID'] == 2 && $value1['status'] == 0) {
                                $_SESSION['user_logged']['roles']['manager'] = $value1['roleID'];
                            }
                            if ($value1['roleID'] == 3 && $value1['status'] == 0) {
                                $_SESSION['user_logged']['roles']['staff'] = $value1['roleID'];
                            }
                        }
                    } else {
                        $_SESSION['not_allowed'] = 'Tài khoản của bạn đã bị khóa!';
                    }
                }
            }
        }
    }
}
