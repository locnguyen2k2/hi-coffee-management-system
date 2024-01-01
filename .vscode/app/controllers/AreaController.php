<?php
class AreaController extends Controller
{
    public $areas = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->areas = $this->model('AreaModel');
            $this->data['content'] = 'AreaView/';
        }
    }
    function add_area()
    {
        if (isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            $this->data['content'] = $this->data['content'] . 'add_area';
            $this->data['sub_content']['areas'] = $this->model('AreaModel')->areas();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-area-btn'])) {
                $isReplaced = false;
                if ($this->isFieldValid($_POST['name'])) {
                    foreach ($this->areas->areas() as $key => $value) {
                        if (mb_strtolower($value['ten_khu']) == mb_strtolower($_POST['name'])) {
                            $isReplaced = true;
                        }
                    }
                    if ($isReplaced == false) {
                        $this->areas->add_area(ucwords(mb_strtolower($_POST['name'])));
                        $this->data['sub_content']['isSucessed'] = 'Thêm thành công!';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = 'Khu vừa thêm bị trùng!';
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
    function view_area()
    {
        $this->data['content'] = $this->data['content'] . 'view_area';
        $this->data['sub_content']['areas'] = $this->areas->areas();
        $this->render('layouts/admin_layout', $this->data);
    }
    function update_area($areaID)
    {
        if ((int)$areaID != 0 and $this->isFieldValid($this->areas->area_id($areaID)['ma_khu'])) {
            $this->data['content'] = $this->data['content'] . 'update_area';
            $this->data['sub_content']['area'] = $this->areas->area_id($areaID);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-area-btn'])) {
                if ($this->isFieldValid($_POST['name'])) {
                    $replaceName = false;
                    foreach ($this->areas->areas() as $key => $value) {
                        if ($areaID != $value['ma_khu'] && mb_strtolower(str_replace(' ', '', $value['ten_khu'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->areas->update_area($areaID, ucwords(mb_strtolower($_POST['name'])));
                        $this->data['sub_content']['isSucessed'] = 'Cập nhật khu thành công';
                        header('Location: ' . _WEB_ROOT . '/AreaController/view_area');
                    } else {
                        $this->data['sub_content']['isReplaced'] = 'Tên vùa nhập đã tồn tại';
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
            header('Location: ' . _WEB_ROOT . '/AreaController/view_area');
        }
    }
}
