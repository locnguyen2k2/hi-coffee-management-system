<?php
class FoodController extends Controller
{
    public $foods = [];
    public $images = [];
    public $types = [];
    public $foodimage = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->foods = $this->model('FoodModel');
            $this->images = $this->model('ImageModel');
            $this->types = $this->model('TypeModel');
            $this->foodimage = $this->model('FoodImageModel');
            $this->data['content'] = 'FoodView/';
        }
    }
    function add_food()
    {
        if (isset($_SESSION['user_logged']['groups']['admin_permission'])) {
            $this->data['sub_content']['types'] = $this->types->types();
            $this->data['content'] = $this->data['content'] . 'add_food';
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-food-btn'])) {
                if ($this->isFieldValid($_POST['name']) && $this->isFieldValid($_POST['type']) && $this->isFieldValid($_POST['price'])) {
                    $name = $_POST['name'];
                    $type = $_POST['type'];
                    $price = $_POST['price'];
                    $isReplaced = false;
                    if (count($_FILES) > 0) {
                        for ($i = 0; $i < count($_FILES); $i++) {
                            if (file_exists(_DIR_ROOT . '/public/static/imgs/' . $_FILES['image-upload' . $i]['name'])) {
                                $isReplaced = true;
                                break;
                            }
                        }
                    }
                    if ($isReplaced == true) {
                        $this->data['sub_content']['isReplaced'] = 'Ảnh vừa thêm bị trùng tên!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                    foreach ($this->foods->food() as $key => $value) {
                        if (mb_strtolower($value['ten_mon']) == mb_strtolower($name)) {
                            $isReplaced = true;
                            break;
                        }
                    }
                    if ($isReplaced == true) {
                        $this->data['sub_content']['isReplaced'] = 'Tên món đã tồn tại!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                    if ($isReplaced != true) {
                        $this->foods->add_food($name, $type, $price);
                        $food_id = $this->foods->food_name($name)['ma_mon'];
                        for ($i = 0; $i < count($_FILES); $i++) {
                            move_uploaded_file($_FILES['image-upload' . $i]['tmp_name'], _DIR_ROOT . '/public/static/imgs/' . $_FILES['image-upload' . $i]['name']);
                            $imageName = explode('.', $_FILES['image-upload' . $i]['name'])[0];
                            $this->images->add_image($imageName);
                            $this->foodimage->add_food_image($food_id, $this->images->image_name($imageName)['ma_hinhanh']);
                        }
                        // $this->data['sub_content']['isSucessed'] = 'Thêm món thành công!';
                        // $this->render('layouts/admin_layout', $this->data);
                        header('Location: ' . _WEB_ROOT . '/FoodController/view_food');
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
    function view_food()
    {
        $this->data['content'] = $this->data['content'] . 'view_food';
        $this->data['sub_content']['foods'] = $this->foods->food();
        $this->data['sub_content']['types'] = $this->types->types();
        $this->render('layouts/admin_layout', $this->data);
    }
    function food_detail()
    {
    }
    function update_food($foodID)
    {
        if ((int)$foodID != 0 and $this->isFieldValid($this->foods->food_id($foodID)['ma_mon'])) {
            $this->data['content'] = $this->data['content'] . 'update_food';
            $this->data['sub_content']['food'] = $this->foods->food_id($foodID);
            $this->data['sub_content']['type'] = $this->types->type_id($this->foods->food_id($foodID)['ma_loai']);
            $this->data['sub_content']['types'] = $this->types->types();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-food-btn'])) {
                if (
                    $this->isFieldValid($_POST['name']) &&
                    $this->isFieldValid($_POST['type']) &&
                    $this->isFieldValid($_POST['price']) &&
                    $_POST['status'] != null
                ) {
                    $replaceName = false;
                    foreach ($this->foods->food() as $key => $value) {
                        if ($foodID != $value['ma_mon'] && mb_strtolower(str_replace(' ', '', $value['ten_mon'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                            $replaceName = true;
                            break;
                        }
                    }
                    if ($replaceName != true) {
                        $this->foods->update_food($foodID, ucfirst(mb_strtolower($_POST['name'])), $_POST['type'], $_POST['price'], $_POST['status']);
                        header('Location: ' . _WEB_ROOT . '/FoodController/view_food');
                    } else {
                        $this->data['sub_content']['isReplaced'] = 'Tên vừa nhập đã tồn tại!';
                        $this->render('layouts/admin_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = 'Vui lòng không để trống!';
                    $this->render('layouts/admin_layout', $this->data);
                }
            } else {
                $this->render('layouts/admin_layout', $this->data);
            }
        } else {
            header('Location: ' . _WEB_ROOT . '/FoodController/view_food');
        }
    }
}
