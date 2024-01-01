<?php
class GroupController extends Controller
{
    public $groups = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->groups = $this->model('GroupModel');
            $this->data['content'] = 'GroupView/';
        }
    }
    function add_group()
    {
        if (isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            $this->data['content'] = $this->data['content'] . 'add_group';
            $this->data['sub_content'][] = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-group-btn'])) {
                if ($this->isFieldValid($_POST['name'])) {
                    $replaceName = false;
                    foreach ($this->groups->groups() as $key => $value) {
                        if ($this->isFieldValid(mb_strtolower($value['name'])) == $this->isFieldValid(mb_strtolower($_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName == false) {
                        $this->data['sub_content']['isSucessed'] = 'Thêm mới thành công!';
                        $this->groups->add_group(ucfirst(mb_strtolower($_POST['name'])));
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = 'Quyền vừa thêm đã tồn tại!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = 'Vui lòng nhập đầy đủ thông tin!';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        }
    }
    function view_group()
    {
        $this->data['content'] = $this->data['content'] . 'view_group';
        $this->data['sub_content']['groups'] = $this->groups->groups();
        $this->render('layouts/admin_layout', $this->data);
    }
    function group_detail()
    {
    }
    function update_group($groupID)
    {
        if ((int)$groupID != 0 and $this->isFieldValid($this->groups->groups_id($groupID)['id'])) {
            $this->data['content'] = $this->data['content'] . 'update_group';
            $this->data['sub_content']['group'] = $this->groups->groups_id($groupID);
            $this->data['sub_content']['groups'] = $this->groups->groups();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-group-btn'])) {
                if ($this->isFieldValid($_POST['name'])) {
                    $replaceName = false;
                    foreach ($this->groups->groups() as $key => $value) {
                        if ($groupID != $value['id'] && mb_strtolower(str_replace(' ', '', $value['name'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->groups->update_group($groupID, $_POST['name']);
                        $this->data['sub_contet']['isSucessed'] = 'Cập nhật quyền thành công!';
                        header('Location: ' . _WEB_ROOT . '/GroupController/view_group');
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
            header('Location: ' . _WEB_ROOT . '/GroupController/view_group');
        }
    }
}
