<?php
class App
{
    private $__controller, $__action, $__params, $__route;
    function __construct() // Khởi tạo giá trị mặc định cho controller, action, params
    {
        $this->__controller = 'HomeController';
        $this->__action = 'index';
        $this->__params = [];
        $this->__route = new Route();
        $this->handleURL();
    }
    function getURL() // Lấy đường dẫn URL
    {
        return !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/'; // Nếu đường dẫn tồn tại thì trả về đường dẫn, nếu không thì trả về '/'
    }
    function handleURL() // Xử lý đường dẫn URL
    {
        $url = $this->getURL(); // Lấy đường dẫn URL
        $url = $this->__route->handleRoute($url); // Xử lý đường dẫn URL
        $path = ''; // Khởi tạo biến path
        $urlArr = array_values(array_filter(explode('/', $url))); // Tách chuỗi URL thành mảng và loại bỏ các phần tử rỗng
        if (count($urlArr) >= 2) { // Nếu độ dài mảng lớn hơn 2 thì xác định controller
            foreach ($urlArr as $key => $value) {
                $path .= '/' . $value; // Thêm giá trị vào path
                unset($urlArr[$key]); // Xóa phần tử đã lấy
                if (file_exists(_DIR_ROOT . '/app/controllers' . $path . '.php')) { // Nếu file controller tồn tại
                    $path = trim($path, $value); // Xóa giá trị cuối cùng của mảng khỏi path
                    $this->__controller = $value; // Gán controller bằng giá trị cuối cùng của mảng
                    $urlArr = array_values($urlArr); // Sắp lại trật tự mảng
                    break;
                }
                if (empty($urlArr)) { // Nếu mảng rỗng thì trả về lỗi 404
                    return $this->loadError();
                }
            }
        } else {
            // Xác định controller
            if (!empty($urlArr[0])) {
                $this->__controller = $urlArr[0]; // Gán controller bằng giá trị đầu tiên của mảng
                unset($urlArr[0]); // Xóa phần tử đã lấy
                $urlArr = array_values($urlArr); // Sắp lại trật tự mảng
            }
        }
        // Xác định action
        if (!empty($urlArr[0])) {
            $this->__action = $urlArr[0];
            unset($urlArr[0]); // Xóa phần tử đã lấy
            $this->__params = $urlArr; // Gán params bằng mảng còn lại
        }
        // Nếu đường dẫn rỗng thì path = '/'
        if (empty($path)) {
            $path = '/';
        }
        // Require file controller
        if (file_exists(_DIR_ROOT . '/app/controllers/' . $path . $this->__controller . '.php')) { // Nếu file controller tồn tại
            require_once 'app/controllers/' . $path . $this->__controller . '.php'; // Require file controller
            $this->__controller = new $this->__controller(); // Khởi tạo lớp của controller
            if (method_exists($this->__controller, $this->__action)) { // Nếu hàm tồn tại trong lớp 
                call_user_func_array([$this->__controller, $this->__action], $this->__params); // Gọi hàm
            } else {
                return $this->loadError(); // Trả về lỗi 404
            }
        } else {
            return $this->loadError();
        }
    }
    function loadError($name = '404')
    {
        if (file_exists(_DIR_ROOT . '/app/errors/' . $name . '.php')) {
            require_once _DIR_ROOT . '/app/errors/' . $name . '.php';
        }
    }
}