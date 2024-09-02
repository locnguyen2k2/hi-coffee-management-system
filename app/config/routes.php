<?php
// Định nghĩa các đường dẫn
$routes['default_controller'] = 'HomeController';
$routes['trang-chu'] = 'HomeController';
// TaiKhoanController
$routes['dang-nhap'] = 'AccountController/Signin';
$routes['dang-ky'] = 'AccountController/Signup';
$routes['dang-xuat'] = 'AccountController/Signout';
$routes['thong-tin'] = 'AccountController/thongtin';
$routes['lay-lai-mat-khau'] = 'AccountController/forgotPassword';
// MonController
$routes['danh-sach-mon'] = 'FoodController/getListFood';
$routes['them-mon'] = 'FoodController/addFood';
$routes['cap-nhat-mon/'] = 'FoodController/updateFood/';
// LoaiController
$routes['danh-sach-loai'] = 'TypeController/getListType';
$routes['them-loai'] = 'TypeController/addType';
$routes['cap-nhat-loai/'] = 'TypeController/updateType/';
// BanController
$routes['danh-sach-ban'] = 'TableController/getListTable';
$routes['them-ban'] = 'TableController/addTable';
$routes['cap-nhat-ban/'] = 'TableController/updateTable/';
// KhuController
$routes['danh-sach-khu'] = 'AreaController/getListArea';
$routes['them-khu'] = 'AreaController/addArea';
$routes['cap-nhat-khu/'] = 'AreaController/updateArea/';
// NguoiDungController
$routes['danh-sach-nguoi-dung'] = 'UserController/getListUser';
$routes['them-nguoi-dung'] = 'UserController/addUser';
$routes['cap-nhat-nguoi-dung/'] = 'UserController/updateUser/';
$routes['xoa-nguoi-dung/'] = 'UserController/deleteUser/';
// RoleController
$routes['danh-sach-quyen'] = 'RoleController/getListRole';
$routes['them-quyen'] = 'RoleController/addRole';
$routes['cap-nhat-quyen/'] = 'RoleController/updateRole/';
// PermissionController
$routes['danh-sach-phan-quyen'] = 'PermissionController/getListPermission';
$routes['them-phan-quyen'] = 'PermissionController/addPermission';
$routes['cap-nhat-phan-quyen/'] = 'PermissionController/updatePermission/';
// BillController
$routes['chi-tiet-hoa-don/'] = 'InvoiceController/getInvoiceDetail/';
// OrderController
$routes['them-don-dat'] = 'OrderController/addOrder';
$routes['cap-nhat-don-dat/'] = 'OrderController/updateOrder/';
$routes['thanh-toan-don-dat/'] = 'OrderController/processOrderPayment/';
$routes['xoa-don-dat/'] = 'OrderController/deleteOrder/';
$routes['chi-tiet-don-dat/'] = 'OrderController/getOrderDetail/';
// ThongKeController
$routes['thong-ke-hoa-don-trong-ngay'] = 'StatisticController/getDailyInvoiceStatistic';
// APIs
$routes['api/dang-nhap'] = 'api/AccountController/signin/';
$routes['api/danh-sach-mon'] = 'api/FoodController/getListFood/';
$routes['api/danh-sach-mon'] = 'api/CategoryController/getListCategory/';
$routes['api/them-hoa-don'] = 'api/OrderController/addOrder';
$routes['api/chi-tiet-hoa-don'] = 'api/InvoiceController/getInvoiceDetail/';
$routes['api/danh-sach-hoa-don-theo-ban'] = 'api/InvoiceController/getListInvoiceByTable/';
$routes['api/thong-ke-trong-ngay'] = 'api/StatisticController/getDailyInvoiceStatistic';
$routes['api/thong-ke-theo-ngay'] = 'api/StatisticController/getInvoiceStatisticsInRange';