<?php
class CategoryController extends Controller
{
    public $data = [], $category = [];
    function __construct()
    {
        $this->category = $this->model('TypeModel');

    }
    function getListCategory()
    {
        $this->data['data'] = $this->category->getListType();
        $this->data['error'] = 0;
        $this->data['message'] = 'Get successfull';
        echo json_encode($this->data);
    }

    function addCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['user_logged'])) {
                if (isset($_SESSION['user_logged']['roles']['admin'])) {
                    if ($_POST['name']) {
                        $isReplaced = false;
                        if ($this->isFieldValid($_POST['name'])) {
                            $types = $this->category->getListType();
                            foreach ($types as $key => $value) {
                                if (mb_strtolower(str_replace(' ', '', $value['name'])) == mb_strtolower(str_replace(' ', '', $_POST['name']))) {
                                    $isReplaced = true;
                                    break;
                                }
                            }
                            if ($isReplaced == false) {
                                $this->category->addType($_POST['name']);
                                $this->data['error'] = 0;
                                $this->data['message'] = 'Them thanh cong';
                            } else {
                                $this->data['error'] = 1;
                                $this->data['message'] = 'Loai nay da ton tai';
                            }
                        } else {
                            $this->data['error'] = 1;
                            $this->data['message'] = 'Loai khong hop le';
                        }
                    } else {
                        $this->data['error'] = 1;
                        $this->data['message'] = 'Vui lòng nhập đầy đủ thông tin!';
                    }
                } else {
                    $this->data['error'] = 1;
                    $this->data['message'] = 'Không có quyền thực hiện thao tác này!';
                }
            } else {
                $this->data['error'] = 1;
                $this->data['message'] = 'Vui lòng đăng nhập để thực hiện thao tác này!';
            }
        } else {
            $this->data['error'] = 1;
            $this->data['message'] = 'Trang không tồn tài hoặc chưa được khởi tạo vui lòng thử lại sau!';
        }
        echo json_encode($this->data);
    }
}
?>