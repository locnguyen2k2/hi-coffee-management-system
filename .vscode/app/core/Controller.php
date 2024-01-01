<?php
class Controller
{
    function render($view, $data = [])
    {
        extract($data);
        if (file_exists('app/views/' . $view . '.php')) {
            require_once 'app/views/' . $view . '.php';
        } else {
            require_once 'app/errors/404.php';
        }
    }
    public function model($model)
    {
        if (file_exists(_DIR_ROOT . '/app/models/' . $model . '.php')) {
            require_once(_DIR_ROOT . '/app/models/' . $model . '.php');
            if (class_exists($model)) {
                $model = new $model();
                return $model;
            }
        }
        return false;
    }
    function isFieldValid($field)
    {
        return !empty(trim($field));
    }
    function checkSignin($username, $password)
    {
        $users = $this->model('UserModel');
        $groupuser = $this->model('GroupUserModel');
        foreach ($users->users() as $key => $value) {
            if ($value['username'] == $username) {
                if ($value['password'] == $password && $value['status'] == 0) {
                    $_SESSION['user_logged']['name'] = $value['fname'] . ' ' . $value['lname'];
                    foreach ($groupuser->group_user_user_id($value['id']) as $key1 => $value1) {
                        if ($value1['group_id'] == 1 && $value1['status'] == 0) {
                            $_SESSION['user_logged']['groups']['admin_permission'] = $value1['group_id'];
                        }
                        if ($value1['group_id'] == 2 && $value1['status'] == 0) {
                            $_SESSION['user_logged']['groups']['manager_permission'] = $value1['group_id'];
                        }
                        if ($value1['group_id'] == 3 && $value1['status'] == 0) {
                            $_SESSION['user_logged']['groups']['staff_permission'] = $value1['group_id'];
                        }
                    }
                }
            }
        }
    }
}
