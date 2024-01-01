<?php
class TableController extends Controller
{
    public $areas = [];
    public $tables = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->areas = $this->model('AreaModel');
            $this->tables = $this->model('TableModel');
            $this->data['content'] = 'TableView/';
        }
    }
    function add_table()
    {
        if (isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            $this->data['content'] = $this->data['content'] . 'add_table';
            $this->data['sub_content']['areas'] = $this->areas->areas();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-table-btn'])) {
                $isReplaced = false;
                if ($this->isFieldValid($_POST['name']) && $this->isFieldValid($_POST['area'])) {
                    foreach ($this->tables->tables() as $key => $value) {
                        if (mb_strtolower($_POST['name']) == mb_strtolower($value['ten_ban'])) {
                            $isReplaced = true;
                            break;
                        }
                    }
                    if ($isReplaced == true) {
                        $this->data['sub_content']['isReplaced'] = 'Tên bàn đã tồn tại!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                    foreach ($this->areas->areas() as $key => $value) {
                        if (mb_strtolower($value['ten_khu']) == mb_strtolower($_POST['area'])) {
                            $isReplaced = true;
                        }
                    }
                    if ($isReplaced != true) {
                        $this->data['sub_content']['isReplaced'] = 'Khu vừa nhập không tồn tại!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                    if ($isReplaced == false) {
                        $this->tables->add_table(ucfirst($_POST['name']), $this->areas->area_name(ucwords(mb_strtolower($_POST['area'])))['ma_khu']);
                        $this->data['sub_content']['isSucessed'] = 'Thêm thành công!';
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
    function view_table()
    {
        $this->data['content'] = $this->data['content'] . 'view_table';
        $this->data['sub_content']['tables'] = $this->tables->tables();
        $this->data['sub_content']['areas'] = $this->areas->areas();
        $this->render('layouts/admin_layout', $this->data);
    }
    function table_detail()
    {
    }
    function update_table($tableID)
    {
        if ((int)$tableID != 0 and $this->isFieldValid($this->tables->table_id($tableID)['ma_ban'])) {
            $this->data['content'] = $this->data['content'] . 'update_table';
            $this->data['sub_content']['table'] = $this->tables->table_id($tableID);
            $this->data['sub_content']['area'] = $this->areas->area_id($this->tables->table_id($tableID)['ma_khu']);
            $this->data['sub_content']['areas'] = $this->areas->areas();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-table-btn'])) {
                if (
                    $this->isFieldValid($_POST['name']) &&
                    $this->isFieldValid($_POST['area_name']) &&
                    $_POST['status'] != null
                ) {
                    $replaceName = false;
                    foreach ($this->tables->tables() as $key => $value) {
                        if ($tableID != $value['ma_ban'] && mb_strtolower(str_replace(' ', '', $value['ten_ban'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        if ($this->areas->area_name(ucwords(mb_strtolower($_POST['area_name']))) == null) {
                            $this->data['sub_content']['isNull'] = 'Tên khu vừa nhập không tồn tại!';
                        } else {
                            $this->tables->update_table($tableID, ucfirst(mb_strtolower($_POST['name'])), $this->areas->area_name($_POST['area_name'])['ma_khu'], $_POST['status']);
                            $this->data['sub_content']['isScuessed'] = 'Cập nhật bàn thành công';
                            header('Location: ' . _WEB_ROOT . '/TableController/view_table');
                        }
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
            header('Location: ' . _WEB_ROOT . '/TableController/view_table');
        }
    }
}
