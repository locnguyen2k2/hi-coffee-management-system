<?php

class AreaController extends Controller
{
    public $area = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->area = $this->model('AreaModel');
            $this->data['content'] = 'AreaViews/';
        }
    }
    function addArea()
    {
        $this->data['content'] = $this->data['content'] . 'add_area';
        $this->data['sub_content']['list_area'] = $this->area->getListArea();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-area-btn'])) {
            $isReplaced = false;
            if ($this->isFieldValid($_POST['name'])) {
                foreach ($this->area->getListArea() as $key => $value) {
                    if (mb_strtolower($value['name']) == mb_strtolower($_POST['name'])) {
                        $isReplaced = true;
                    }
                }
                if ($isReplaced == false) {
                    $this->area->addArea(ucwords(mb_strtolower($_POST['name'])));
                    $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Thêm thành công</div>';
                    $this->render('layouts/admin_layout', $this->data);
                } else {
                    $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Tên khu vừa nhập đã tồn tại!</div>';
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
    function getListArea()
    {
        $this->data['content'] = $this->data['content'] . 'list_area';
        $this->data['sub_content']['list_area'] = $this->area->getListArea();
        $this->render('layouts/admin_layout', $this->data);
    }
    function updateArea($areaID)
    {
        if ((int) $areaID != 0 and $this->isFieldValid($this->area->getAreaByID($areaID)['id'])) {
            $this->data['content'] = $this->data['content'] . 'update_area';
            $this->data['sub_content']['area'] = $this->area->getAreaByID($areaID);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_area_btn'])) {
                if ($this->isFieldValid($_POST['name'])) {
                    $replaceName = false;
                    foreach ($this->area->getListArea() as $key => $value) {
                        if ($areaID != $value['id'] && mb_strtolower(str_replace(' ', '', $value['name'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->area->updateArea($areaID, ucwords(mb_strtolower($_POST['name'])));
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Cập nhật thành công!</div>';
                        $this->render('layouts/admin_layout', $this->data);
                    } else {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Tên khu vừa nhập đã tồn tại!</div>';
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
            header('Location: ' . _WEB_ROOT . '/danh-sach-khu');
        }
    }
}