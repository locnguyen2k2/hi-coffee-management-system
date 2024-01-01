<?php 
class UserController extends Controller
{
    public $user = [], $permission = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->user = $this->model('UserModel');
            $this->permission = $this->model('PermissionModel');
            $this->data['content'] = 'UserViews/';
        }
    }
    function addUser()
    {
        if (isset($_SESSION['user_logged']['roles']['admin'])) {
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
                    foreach ($this->user->getListUser() as $key => $value) {
                        if (mb_strtolower($value['username']) == mb_strtolower($_POST['username'])) {
                            $replaceUsername = true;
                        }
                    }
                    if ($replaceUsername == true) {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Tên tài khoản đã tồn tại!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    } else if ($_POST['password'] != $_POST['password2']) {
                        $replacePassword2 = false;
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Mật khẩu không khớp!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->user->addUser($_POST['fname'], $_POST['lname'], $_POST['username'], $_POST['password'], $_POST['phonenumb'], $_POST['email']);
                        $this->permission->addPermission($this->user->getUserByUsername($_POST['username'])['id'], 1);
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Thêm tài khoản thành công!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Vui lòng nhập đầy đủ thông tin!</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        }
    }
    function getListUser()
    {
        $this->data['content'] = $this->data['content'] . 'list_user';
        $this->data['sub_content']['list_user'] = $this->user->getListUser();
        $this->render('layouts/admin_layout', $this->data);
    }
    function deleteUser($userID)
    {
        if ((int) $userID != 0 and $this->isFieldValid($this->user->getUserByID($userID)['id'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-delete-user'])) {
                $this->permission->deletePermission($userID);
                if ($this->user->getUserByID($userID)['user_username'] == $_SESSION['user_logged']['username']) {
                    header('Location: ' . _WEB_ROOT . '/dang-xuat');
                }
            }
            header("Location: " . _WEB_ROOT . '/danh-sach-nguoi-dung');
        }
    }
    function updateUser($userID)
    {
        if ((int) $userID != 0 and $this->isFieldValid($this->user->getUserByID($userID)['id'])) {
            $this->data['content'] = $this->data['content'] . 'update_user';
            $this->data['sub_content']['user'] = $this->user->getUserByID($userID);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user_btn'])) {
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
                    foreach ($this->user->getListUser() as $key => $value) {
                        if ($userID != $value['id'] && mb_strtolower(str_replace(' ', '', $value['username'])) == mb_strtolower(str_replace(' ', '', $_POST['username']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->user->updateUser($userID, $_POST['fname'], $_POST['lname'], $_POST['number'], $_POST['email'], $_POST['status'], $_POST['username'], $_POST['password']);
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Cập nhật thành công!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Tên tài khoản đã tồn tại!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Vui lòng nhập đầy đủ thông tin!</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        } else {
            header('Location: ' . _WEB_ROOT . '/danh-sach-nguoi-dung');
        }
    }
}