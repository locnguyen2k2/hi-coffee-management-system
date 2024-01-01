<?php
class UserController extends Controller
{
    public $users = [], $groupuser = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->users = $this->model('UserModel');
            $this->groupuser = $this->model('GroupUserModel');
            $this->data['content'] = 'UserView/';
        }
    }
    function add_user()
    {
        if (isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            $this->data['content'] = $this->data['content'] . 'add_user';
            $this->data['sub_content'][] = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-account-btn'])) {
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
                    foreach ($this->users->accounts() as $key => $value) {
                        if (mb_strtolower($value['username']) == mb_strtolower($_POST['username'])) {
                            $replaceUsername = true;
                        }
                    }
                    if ($replaceUsername == true) {
                        $this->data['sub_content']['isReplaced'] = 'Tên tài khoản đã tồn tại!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                    if ($_POST['password'] != $_POST['password2']) {
                        $replacePassword2 = false;
                    }
                    if ($replacePassword2 == false) {
                        $this->data['sub_content']['isReplaced'] = 'Nhập lại mật khẩu không đúng!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                    if ($replaceUsername == false && $replacePassword2 == true) {
                        $this->users->add_account($_POST['fname'], $_POST['lname'], $_POST['username'], $_POST['password'], $_POST['phonenumb'], $_POST['email']);
                        $this->groupuser->add_permission($this->users->account_name($_POST['username'])['id'], 3);
                        $this->data['sub_content']['isSucessed'] = 'Thêm tài khoản mới thành công!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = 'Vui lòng nhập đầy đủ thông tin';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        }
    }
    function view_user()
    {
        $this->data['content'] = $this->data['content'] . 'view_user';
        $this->data['sub_content']['users'] = $this->users->users();
        $this->render('layouts/admin_layout', $this->data);
    }
    function delete_user($userID)
    {
        if ((int)$userID != 0 and $this->isFieldValid($this->users->account_id($userID)['id'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-delete-user'])) {
                $this->groupuser->delete_user($userID);
                header("Location: " . _WEB_ROOT . '/UserController/view_user');
            }
        }
    }
    function update_user($userID)
    {
        if ((int)$userID != 0 and $this->isFieldValid($this->users->account_id($userID)['id'])) {
            $this->data['content'] = $this->data['content'] . 'update_user';
            $this->data['sub_content']['user'] = $this->users->account_id($userID);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-user-btn'])) {
                if (
                    $this->isFieldValid($_POST['fname']) &&
                    $this->isFieldValid($_POST['lname']) &&
                    $this->isFieldValid($_POST['number']) &&
                    $this->isFieldValid($_POST['email']) &&
                    $_POST['status'] != null &&
                    $this->isFieldValid($_POST['username']) &&
                    $this->isFieldValid($_POST['password'])
                ) {
                    $replaceName = false;
                    foreach ($this->users->accounts() as $key => $value) {
                        if ($userID != $value['id'] && mb_strtolower(str_replace(' ', '', $value['username'])) == mb_strtolower(str_replace(' ', '', $_POST['username']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->users->update_user($userID, $_POST['fname'], $_POST['lname'], $_POST['number'], $_POST['email'], $_POST['status'], $_POST['username'], $_POST['password']);
                        $this->data['sub_content']['isSucessed'] = 'Cập nhật thông tin tài khoản thành công';
                        header('Location: ' . _WEB_ROOT . '/UserController/view_user');
                    } else {
                        $this->data['sub_content']['isReplaced'] = 'Tên vừa nhập đã tồn tại!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = 'Vui lòng không để trống thông tin!';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        } else {
            header('Location: ' . _WEB_ROOT . '/UserController/view_user');
        }
    }
}
