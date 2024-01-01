<?php
class GroupUserController extends Controller
{
    public $groups = [];
    public $users = [];
    public $groupuser = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->groups = $this->model('GroupModel');
            $this->users = $this->model('UserModel');
            $this->groupuser = $this->model('GroupUserModel');
            $this->data['content'] = 'GroupUserView/';
        }
    }
    function add_groupuser()
    {
        if (isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            $this->data['sub_content']['groups'] = $this->groups->groups();
            $this->data['sub_content']['accounts'] = $this->users->accounts();
            $this->data['content'] = $this->data['content'] . 'add_groupuser';
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-user-group-btn'])) {
                if ($_POST['userid'] != 0 && $_POST['groupid'] != 0) {
                    $replaceName = false;
                    foreach ($this->groupuser->group_user_user_id($_POST['userid']) as $key => $value) {
                        if ($value['group_id'] == $_POST['groupid']) {
                            $replaceName = true;
                        }
                    }
                    if ($replaceName == false) {
                        $this->groupuser->add_group_user_user_id($_POST['userid'], $_POST['groupid']);
                        $this->data['sub_content']['isSucessed'] = 'Thêm mới thành công!';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = 'Quyền của người dùng đã tồn tại!';
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
    function view_groupuser()
    {
        $this->data['content'] = $this->data['content'] . 'view_groupuser';
        $this->data['sub_content']['permissions'] = $this->groupuser->group_user();
        $this->data['sub_content']['groups'] = $this->groups->groups();
        $this->data['sub_content']['users'] = $this->users->users();
        $this->render('layouts/admin_layout', $this->data);
    }
    function groupuser_detail()
    {
    }
    function update_groupuser($groupuserID)
    {
        if ((int)$groupuserID != 0 and $this->isFieldValid($this->groupuser->group_user_id($groupuserID)['id'])) {
            $this->data['content'] = $this->data['content'] . 'update_groupuser';
            $this->data['sub_content']['user_permission'] = $this->groupuser->group_user_id($groupuserID);
            $this->data['sub_content']['groups'] = $this->groups->groups();
            $this->data['sub_content']['account'] = $this->users->account_id($this->groupuser->group_user_id($groupuserID)['user_id']);
            $this->data['sub_content']['group_user'] = $this->groups->groups_id($this->groupuser->group_user_id($groupuserID)['group_id']);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-group-user-btn'])) {
                if ($this->isFieldValid($_POST['group_id']) && $_POST['status'] != null) {
                    $replaceName = false;
                    foreach ($this->groupuser->group_user() as $key => $value) {
                        if ($groupuserID != $value['id']) {
                            if ($value['user_id'] == $this->groupuser->group_user_id($groupuserID)['user_id'] && $value['group_id'] == $_POST['group_id']) {
                                $replaceName = true;
                                break;
                            }
                        }
                        if ($replaceName == true) {
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->groupuser->update_group_user($groupuserID, $_POST['group_id'], $_POST['status']);
                        $this->data['sub_content']['isSucessed'] = 'Cập nhật phân quyền thành công';
                        header('Location: ' . _WEB_ROOT . '/GroupUserController/view_groupuser');
                    } else {
                        $this->data['sub_content']['isReplaced'] = 'Tài khoản đã có quyền này!';
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
            header('Location: ' . _WEB_ROOT . '/GroupUserController/view_groupuser');
        }
    }
}
