<?php
class TypeController extends Controller
{
    public $types = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->types = $this->model('TypeModel');
            $this->data['content'] = 'TypeView/';
        }
    }
    function add_type()
    {
        if (isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            $this->data['content'] = $this->data['content'] . 'add_type';
            $this->data['sub_content']['types'] = $this->model('TypeModel')->types();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-type-btn'])) {
                $isReplaced = false;
                if ($this->isFieldValid($_POST['name'])) {
                    $types = $this->types->types();
                    foreach ($types as $key => $value) {
                        if (mb_strtolower($value['ten_loai']) == mb_strtolower($_POST['name'])) {
                            $isReplaced = true;
                            break;
                        }
                    }
                    if ($isReplaced == false) {
                        $this->data['sub_content']['isSucessed'] = 'Thêm loại thành công!';
                        $this->types->add_type($_POST['name']);
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = 'Tên loại đã tồn tại!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = 'Vui lòng điền đủ thông tin!';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        }
    }
    function view_type()
    {
        $this->data['content'] = $this->data['content'] . 'view_type';
        $this->data['sub_content']['types'] = $this->types->types();
        $this->render('layouts/admin_layout', $this->data);
    }
    function type_detail()
    {
    }
    function update_type($typeID)
    {
        if ((int)$typeID != 0 and $this->isFieldValid($this->types->type_id($typeID)['ma_loai'])) {
            $this->data['content'] = $this->data['content'] . 'update_type';
            $this->data['sub_content']['type'] = $this->types->type_id($typeID);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-type-btn'])) {
                if (
                    $this->isFieldValid($_POST['name']) &&
                    $_POST['status'] != null
                ) {
                    $replaceName = false;
                    foreach ($this->types->types() as $key => $value) {
                        if ($typeID != $value['ma_loai'] && mb_strtolower(str_replace(' ', '', $value['ten_loai'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->types->update_type($typeID, ucfirst(mb_strtolower($_POST['name'])), $_POST['status']);
                        $this->data['sub_content']['isSucessed'] = 'Cập nhật loại thành công';
                        header('Location: ' . _WEB_ROOT . '/TypeController/view_type');
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
            header('Location: ' . _WEB_ROOT . '/TypeController/view_type');
        }
    }
}
