<?php 
class PermissionController extends Controller
{
    public $role = [];
    public $user = [];
    public $permission = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->role = $this->model('RoleModel');
            $this->user = $this->model('UserModel');
            $this->permission = $this->model('PermissionModel');
            $this->data['content'] = 'PermissionViews/';
        }
    }
    function addPermission()
    {
        if (isset($_SESSION['user_logged']['roles']['admin'])) {
            $this->data['sub_content']['list_role'] = $this->role->getListRole();
            $this->data['sub_content']['list_user'] = $this->user->getListUser();
            $this->data['content'] = $this->data['content'] . 'add_permission';
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-user-group-btn'])) {
                if ($_POST['userid'] != 0 && $_POST['groupid'] != 0) {
                    $replaceName = false;
                    foreach ($this->permission->getPermissionByUser($_POST['userid']) as $key => $value) {
                        if ($value['roleID'] == $_POST['groupid']) {
                            $replaceName = true;
                        }
                    }
                    if ($replaceName == false) {
                        $this->permission->addPermission($_POST['userid'], $_POST['groupid']);
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Thêm quyền thành công!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Quyền của người dùng đã tồn tại!</div>';
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
    function getListPermission()
    {
        $this->data['content'] = $this->data['content'] . 'list_permission';
        $this->data['sub_content']['list_permission'] = $this->permission->getListPermission();
        $this->data['sub_content']['list_role'] = $this->role->getListRole();
        $this->data['sub_content']['list_user'] = $this->user->getListUser();
        $this->render('layouts/admin_layout', $this->data);
    }
    function updatePermission($groupuserID)
    {
        if ((int) $groupuserID != 0 and $this->isFieldValid($this->permission->getPermissionByID($groupuserID)['roleID'])) {
            $this->data['content'] = $this->data['content'] . 'update_permission';
            $this->data['sub_content']['permission'] = $this->permission->getPermissionByID($groupuserID);
            $this->data['sub_content']['list_role'] = $this->role->getListRole();
            $this->data['sub_content']['user'] = $this->user->getUserByID($this->permission->getPermissionByID($groupuserID)['userID']);
            $this->data['sub_content']['role'] = $this->role->getRoleByID($this->permission->getPermissionByID($groupuserID)['roleID']);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_group_user_btn'])) {
                if ($this->isFieldValid($_POST['group_id']) && $_POST['status'] != null) {
                    $replaceName = false;
                    foreach ($this->permission->getListPermission() as $key => $value) {
                        if ($groupuserID != $value['id']) {
                            if ($value['userID'] == $this->permission->getPermissionByID($groupuserID)['userID'] && $value['roleID'] == $_POST['group_id']) {
                                $replaceName = true;
                                break;
                            }
                        }
                        if ($replaceName == true) {
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->permission->updatePermission($groupuserID, $_POST['group_id'], $_POST['status']);
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Cập nhật thành công!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        if ($_POST['status'] != $this->permission->getPermissionByID($groupuserID)['status']) {
                            $this->permission->updatePermissionStatus($groupuserID, $_POST['status']);
                            $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Cập nhật thành công!</div>';
                        } else {
                            $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Quyền của người dùng đã tồn tại!</div>';
                        }
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
            header('Location: ' . _WEB_ROOT . '/danh-sach-phan-quyen');
        }
    }
}