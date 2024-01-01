<?php 
class TypeController extends Controller
{
    public $type = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->type = $this->model('TypeModel');
            $this->data['content'] = 'TypeViews/';
        }
    }
    function addType()
    {
        if (isset($_SESSION['user_logged']['roles']['admin'])) {
            $this->data['content'] = $this->data['content'] . 'add_type';
            $this->data['sub_content']['list_type'] = $this->type->getListType();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-type-btn'])) {
                $isReplaced = false;
                if ($this->isFieldValid($_POST['name'])) {
                    $types = $this->type->getListType();
                    foreach ($types as $key => $value) {
                        if (mb_strtolower($value['name']) == mb_strtolower($_POST['name'])) {
                            $isReplaced = true;
                            break;
                        }
                    }
                    if ($isReplaced == false) {
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success">Thêm loại thành công!</div>';
                        $this->type->addType($_POST['name']);
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger">Loại đã tồn tại!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = '<div class="alert alert-danger">Vui lòng nhập đầy đủ thông tin!</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        }
    }
    function getListType()
    {
        $this->data['content'] = $this->data['content'] . 'list_type';
        $this->data['sub_content'][] = [];
        $list_type = $this->type->getListType();
        $result = array();
        foreach ($list_type as $key => $value) {
            $item = array();
            $item[] = $value['id'];
            $item[] = $value['name'];
            $item[] = $value['status'];
            array_push($result, $item);
        }
        $this->data['sub_content']['list_type'] = $result;
        $this->render('layouts/admin_layout', $this->data);
    }
    function updateType($typeID)
    {
        if ((int) $typeID != 0 and $this->isFieldValid($this->type->getTypeByID($typeID)['id'])) {
            $this->data['content'] = $this->data['content'] . 'update_type';
            $this->data['sub_content']['type'] = $this->type->getTypeByID($typeID);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_type_btn'])) {
                if (
                    $this->isFieldValid($_POST['name']) &&
                    $_POST['status'] != null
                ) {
                    $replaceName = false;
                    foreach ($this->type->getListType() as $key => $value) {
                        if ($typeID != $value['id'] && mb_strtolower(str_replace(' ', '', $value['name'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->type->updateType($typeID, ucfirst(mb_strtolower($_POST['name'])), $_POST['status']);
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Cập nhật thành công!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Tên loại đã tồn tại!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Vui lòng điền đủ thông tin!</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        } else {
            header('Location: ' . _WEB_ROOT . '/danh-sach-loai');
        }
    }
}