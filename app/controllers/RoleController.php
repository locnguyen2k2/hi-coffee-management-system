<?php 
class RoleController extends Controller
{
    public $role = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->role = $this->model('RoleModel');
            $this->data['content'] = 'RoleViews/';
        }
    }
    function addRole()
    {
        $this->data['content'] = $this->data['content'] . 'add_role';
        $this->data['sub_content'][] = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-group-btn'])) {
            if ($this->isFieldValid($_POST['name'])) {
                $replaceName = false;
                foreach ($this->role->getListRole() as $key => $value) {
                    if (str_replace(' ', '', (mb_strtolower($value['name']))) == str_replace(' ', '', (mb_strtolower($_POST['name'])))) {
                        $replaceName = true;
                        break;
                    }
                }
                if ($replaceName == false) {
                    $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success">Thêm quyền thành công</div>';
                    $this->role->addRole(ucfirst(mb_strtolower($_POST['name'])));
                    $this->render('layouts/admin_layout', $this->data);
                } else {
                    $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger">Tên quyền đã tồn tại</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->data['sub_content']['isNull'] = '<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin</div>';
                $this->render('layouts/admin_layout', $this->data);
            }
        } else {
            $this->render('layouts/admin_layout', $this->data);
        }
    }
    function getListRole()
    {
        $this->data['content'] = $this->data['content'] . 'list_role';
        $this->data['sub_content']['list_role'] = $this->role->getListRole();
        $this->render('layouts/admin_layout', $this->data);
    }
    function updateRole($groupID)
    {
        if ((int) $groupID != 0 and $this->isFieldValid($this->role->getRoleByID($groupID)['id'])) {
            $this->data['content'] = $this->data['content'] . 'update_role';
            $this->data['sub_content']['role'] = $this->role->getRoleByID($groupID);
            $this->data['sub_content']['list_role'] = $this->role->getListRole();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_group_btn'])) {
                if ($this->isFieldValid($_POST['name'])) {
                    $replaceName = false;
                    foreach ($this->role->getListRole() as $key => $value) {
                        if ($groupID != $value['id'] && mb_strtolower(str_replace(' ', '', $value['name'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->role->updateRole($groupID, $_POST['name']);
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Cập nhật thành công!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Quyền vừa thêm đã tồn tại!</div>';
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
            header('Location: ' . _WEB_ROOT . '/danh-sach-quyen');
        }
    }
}