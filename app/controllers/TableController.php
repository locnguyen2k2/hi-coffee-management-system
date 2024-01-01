<?php 
class TableController extends Controller
{
    public $area = [];
    public $table = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->area = $this->model('AreaModel');
            $this->table = $this->model('TableModel');
            $this->data['content'] = 'TableViews/';
        }
    }
    function addTable()
    {
        $this->data['content'] = $this->data['content'] . 'add_table';
        $this->data['sub_content']['list_area'] = $this->area->getListArea();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-table-btn'])) { // kiểm tra xem người dùng có bấm nút thêm bàn không
            $isReplaced = false;
            $areaExsist = false;
            if ($this->isFieldValid($_POST['name']) && $this->isFieldValid($_POST['area'])) { // kiểm tra xem có nhập đầy đủ thông tin không
                foreach ($this->table->getListTable() as $key => $value) {
                    if (mb_strtolower($_POST['name']) == mb_strtolower($value['name'])) { // kiểm tra xem tên bàn vừa nhập có trùng với tên bàn nào trong database không
                        $isReplaced = true;
                        break;
                    }
                }
                if ($isReplaced == true) {
                    $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Bàn vừa nhập đã tồn tại!</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
                foreach ($this->area->getListArea() as $key => $value) {
                    if (mb_strtolower($value['name']) == mb_strtolower($_POST['area'])) { // kiểm tra xem khu vừa nhập có tồn tại không
                        $areaExsist = true;
                        break;
                    }
                }
                if ($areaExsist != true) {
                    $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Khu vừa nhập không tồn tại!</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
                if ($isReplaced == false && $areaExsist == true && $this->isFieldValid($_POST['name']) && $this->isFieldValid($_POST['area'])) { // nếu tên bàn vừa nhập không trùng với tên bàn nào trong database thì thêm bàn vào database
                    // print_r($this->area->getAreaByName(ucwords(mb_strtolower($_POST['area'])))['area_id']);
                    $this->table->addTable(ucfirst($_POST['name']), $this->area->getAreaByName(ucwords(mb_strtolower($_POST['area'])))['id']);
                    $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Thêm bàn thành công!</div>';
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
    function getListTable()
    {
        $this->data['content'] = $this->data['content'] . 'list_table';
        $this->data['sub_content']['list_table'] = $this->table->getListTable();
        $this->data['sub_content']['list_area'] = $this->area->getListArea();
        $this->render('layouts/admin_layout', $this->data);
    }
    function updateTable($tableID)
    {
        if ((int) $tableID != 0 and $this->isFieldValid($this->table->getTableByID($tableID)['id'])) { // kiểm tra xem id bàn có tồn tại không
            $this->data['content'] = $this->data['content'] . 'update_table';
            $this->data['sub_content']['table'] = $this->table->getTableByID($tableID);
            $this->data['sub_content']['area'] = $this->area->getAreaByID($this->table->getTableByID($tableID)['areaID']);
            $this->data['sub_content']['list_area'] = $this->area->getListArea();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_table_btn'])) { // kiểm tra xem người dùng có bấm nút cập nhật bàn không
                if (
                    $this->isFieldValid($_POST['name']) &&
                    $this->isFieldValid($_POST['area_name']) &&
                    $_POST['status'] != null
                ) { // kiểm tra xem người dùng có nhập đầy đủ thông tin không
                    $replaceName = false;
                    foreach ($this->table->getListTable() as $key => $value) {
                        if ($tableID != $value['id'] && mb_strtolower(str_replace(' ', '', $value['name'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) { // kiểm tra xem tên bàn vừa nhập có trùng với tên bàn nào trong database không
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        if ($this->area->getAreaByName(ucwords(mb_strtolower($_POST['area_name']))) == null) { // kiểm tra xem khu vừa nhập có tồn tại không
                            $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Khu vừa nhập không tồn tại!</div>';
                            $this->render('layouts/admin_layout', $this->data);
                        } else {
                            $this->table->updateTable($tableID, ucfirst(mb_strtolower($_POST['name'])), $this->area->getAreaByName($_POST['area_name'])['id'], $_POST['status']);
                            $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Cập nhật bàn thành công!</div>';
                            $this->render('layouts/admin_layout', $this->data);
                        }
                    } else {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Tên bàn đã tồn tại!</div>';
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
            header('Location: ' . _WEB_ROOT . '/danh-sach-ban');
        }
    }
}