<?php

class FoodController extends Controller
{
    public $food = [];
    public $image = [];
    public $type = [];
    public $foodimage = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->food = $this->model('FoodModel');
            $this->image = $this->model('ImageModel');
            $this->type = $this->model('TypeModel');
            $this->foodimage = $this->model('FoodImageModel');
            $this->data['content'] = 'FoodViews/';
        }
    }
    function addFood()
    {
        $this->data['sub_content']['list_type'] = $this->type->getListType();
        $this->data['content'] = $this->data['content'] . 'add_food';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-food-btn'])) {
            if ($this->isFieldValid($_POST['name']) && $this->isFieldValid($_POST['type']) && $this->isFieldValid($_POST['price'])) {
                $name = $_POST['name'];
                $type = $_POST['type'];
                $price = $_POST['price'];
                $isReplaced = false;
                foreach ($this->food->getListFood() as $key => $value) {
                    if (mb_strtolower(trim($value['name'])) == mb_strtolower(trim($name))) {
                        $isReplaced = true;
                        break;
                    }
                }
                if ($isReplaced == true) {
                    $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Tên món đã tồn tại!</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
                if ($isReplaced != true) {
                    $this->food->addFood($name, $type, $price);
                    $food_id = $this->food->getFoodByName($name)['id'];
                    if (isset($_FILES['image_upload'])) {
                        $nameImage = explode('.', $_FILES['image_upload']['name']);
                        $expandImage = $nameImage[count($nameImage) - 1];
                        $image = $nameImage[0] . '_' . time() . '.' . $expandImage;
                        move_uploaded_file($_FILES['image_upload']['tmp_name'], _DIR_ROOT . '/public/static/imgs/uploadfiles/' . $image);
                        $this->image->addImage($image);
                        $this->foodimage->addFoodImage($food_id, $this->image->getImageByName($image)['id']);
                    }
                    $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Thêm món thành công!</div>';
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
    function getListFood()
    {
        $this->data['content'] = $this->data['content'] . 'list_food';
        $this->data['sub_content'][] = [];
        $list_food = $this->food->getListFood();
        $list_type = $this->type->getListType();
        $result = array();
        foreach ($list_food as $key => $value) {
            $item = array();
            $item[] = $value['id'];
            $item[] = $value['name'];
            foreach ($list_type as $key1 => $value1) {
                if ($value['typeID'] == $value1['id']) {
                    $item[] = $value1['name'];
                    break;
                }
            }
            $item[] = number_format($value['price'], 0, ',', '.');
            array_push($result, $item);
        }
        $this->data['sub_content']['list_food'] = $result;
        $this->render('layouts/admin_layout', $this->data);
    }
    function updateFood($foodID = 0)
    {
        if ((int) $foodID != 0 and $this->isFieldValid($this->food->getFoodByID($foodID)['id'])) {
            $this->data['content'] = $this->data['content'] . 'update_food';
            $this->data['sub_content']['food'] = $this->food->getFoodByID($foodID);
            $this->data['sub_content']['type'] = $this->type->getTypeByID($this->food->getFoodByID($foodID)['typeID']);
            $this->data['sub_content']['list_type'] = $this->type->getListType();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_food_btn'])) {
                if (
                    $this->isFieldValid($_POST['name']) &&
                    $this->isFieldValid($_POST['type']) &&
                    $this->isFieldValid($_POST['price']) &&
                    $_POST['status'] != null
                ) {
                    $replaceName = false;
                    // Kiểm tra tên món
                    foreach ($this->food->getListFood() as $key => $value) {
                        if ($foodID != $value['id'] && mb_strtolower(str_replace(' ', '', $value['name'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    // Tiến hành cập nhật nếu không có trùng tên món 
                    if ($replaceName != true) {
                        if (isset($_FILES['image_upload'])) {
                            $nameImage = explode('.', $_FILES['image_upload']['name']);
                            $expandImage = $nameImage[count($nameImage) - 1];
                            $image = $nameImage[0] . '_' . time() . '.' . $expandImage;
                            move_uploaded_file($_FILES['image_upload']['tmp_name'], _DIR_ROOT . '/public/static/imgs/uploadfiles/' . $image);
                            $this->image->addImage($image);
                            $this->foodimage->addFoodImage($foodID, $this->image->getImageByName($image)['id']);
                        }
                        $this->food->updateFood($foodID, ucfirst(mb_strtolower($_POST['name'])), $_POST['type'], $_POST['price'], $_POST['status']);
                        $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Cập nhật món thành công!</div>';
                    } else {
                        $this->data['sub_content']['isReplaced'] = '<div class="alert alert-danger" role="alert">Tên món đã tồn tại!</div>';
                    }
                    $this->render('layouts/admin_layout', $this->data);
                } else {
                    $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Vui lòng điền đủ thông tin!</div>';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        } else {
            header('Location: ' . _WEB_ROOT . '/danh-sach-mon');
        }
    }
}