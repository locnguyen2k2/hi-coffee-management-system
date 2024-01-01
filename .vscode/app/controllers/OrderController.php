<?php
class OrderController extends Controller
{
    public $foods = [], $tables = [], $orders = [], $types = [], $paidbills = [], $unpaidbills = [], $orderdetails = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission']) && !isset($_SESSION['user_logged']['groups']['staff_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/idnex');
        } else {
            $this->foods = $this->model('FoodModel');
            $this->tables = $this->model('TableModel');
            $this->orders = $this->model('OrderModel');
            $this->types = $this->model('TypeModel');
            $this->paidbills = $this->model('PaidBillModel');
            $this->unpaidbills = $this->model('UnPaidBillModel');
            $this->orderdetails = $this->model('OrderDetailModel');
            $this->data['content'] = 'OrderView/';
        }
    }
    function add_order()
    {
        $this->data['content'] .= 'add_order';
        $this->data['sub_content']['foods'] = $this->foods->food();
        $this->data['sub_content']['tables'] = $this->tables->tables();
        $this->data['sub_content']['orders'] = $this->orders->orders();
        $this->data['sub_content']['types'] = $this->types->types();
        $this->data['sub_content']['paidBills'] = $this->paidbills->paid_bills();
        $this->data['sub_content']['unpaidBills'] = $this->unpaidbills->unpaid_bills();
        $this->data['sub_content']['ordersDetail'] = $this->orderdetails->orders_detail();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-add-order'])) {
            if ($this->isFieldValid($_POST['food_name']) && $_POST['quantity'] > 0 && $this->isFieldValid($_POST['table_name'])) {
                $food_id = $this->foods->food_name($_POST['food_name'])['ma_mon'];
                $table_id = $this->tables->table_name($_POST['table_name'])['ma_ban'];
                $quantity = $_POST['quantity'];
                $typeID = $this->foods->food_id($food_id)['ma_loai'];
                $price = $this->foods->food_id($food_id)['gia_mon'];
                if (!isset($food_id)) {
                    $this->data['sub_content']['isNull'] = 'Món không tồn tại!';
                    $this->render('layouts/staff_layout', $this->data);
                } else if (!isset($table_id)) {
                    $this->data['sub_content']['isNull'] = 'Bàn không tồn tại!';
                    $this->render('layouts/staff_layout', $this->data);
                } else {
                    $order_id = time();
                    $this->orders->add_order($order_id, $food_id, $quantity);
                    if ($this->tables->table_id($table_id)['trang_thai'] == 0) {
                        $this->tables->update_table_status($table_id, 1);
                    }
                    $this->orderdetails->add_order_detail($order_id, $table_id, $food_id, $this->foods->food_id($food_id)['ma_loai'], $this->foods->food_id($food_id)['gia_mon'], $quantity, $quantity * $this->foods->food_id($food_id)['gia_mon']);
                    $unpaidBills = $this->unpaidbills->unpaid_bills();
                    $result = false;
                    if (count($unpaidBills) == 0) {
                        $unpaidBillID = $this->paidbills->paid_bills()[0]['ma_hoadon'] + 1;
                        $this->unpaidbills->add_unpaid_bill($unpaidBillID, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->foods->food_id($food_id)['gia_mon']);
                    } else {
                        foreach ($unpaidBills as $key => $value) {
                            if ($value['ma_ban'] == $table_id) {
                                $this->unpaidbills->add_unpaid_bill($value['ma_hoadon'], $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->foods->food_id($food_id)['gia_mon']);
                                $result = true;
                                break;
                            }
                        }
                        if ($result == false) {
                            $this->unpaidbills->add_unpaid_bill($this->unpaidbills->unpaid_bills()[0]['ma_hoadon'] + 1, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->foods->food_id($food_id)['gia_mon']);
                        }
                    }
                    $this->data['sub_content']['isSucessed'] = 'Thêm thành công!';
                    header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
                }
                header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
            } else {
                $this->data['sub_content']['isNull'] = 'Vui lòng điền đầy đủ thông tin trước khi đặt món!';
                $this->render('layouts/staff_layout', $this->data);
            }
        } else {
            $this->render('layouts/staff_layout', $this->data);
        }
    }
    function view_order($orderID)
    {
        if ((int)$orderID != 0 and $this->isFieldValid($this->orderdetails->order_detail_id($orderID)['ma_dondat'])) {
            $orderdetail = $this->orderdetails->order_detail_id($orderID);
            $this->data['sub_content']['table'] = $this->tables->table_id($orderdetail['ma_ban']);
            $this->data['sub_content']['food'] = $this->foods->food_id($orderdetail['ma_mon']);
            $this->data['sub_content']['type'] = $this->types->type_id($orderdetail['ma_loai']);
            $this->data['sub_content']['orderdetail'] = $orderdetail;
            $this->data['content'] .= 'view_order';
        } else {
            $this->data['content'] = 'OrderView/add_order';
        }
        $this->render('layouts/staff_layout', $this->data);
    }
    function delete_order($orderID)
    {
        if ((int)$orderID != 0 and $this->isFieldValid($this->orderdetails->order_detail_id($orderID)['ma_dondat'])) {
            $this->data['sub_content']['tables'] = $this->tables->tables();
            $this->data['sub_content']['foods'] = $this->foods->food();
            $this->data['sub_content']['types'] = $this->types->types();
            $this->data['sub_content']['order_detail'] = $this->orderdetails->order_detail_id($orderID);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-delete'])) {
                if ($this->orderdetails->order_detail_id($orderID) == true) {
                    $table_id = $this->orderdetails->order_detail_id($orderID)['ma_ban'];
                    $this->orders->delete_order($orderID);
                    $unpaid_bills_table = $this->unpaidbills->unpaid_bills_table_id($table_id);
                    if ($unpaid_bills_table == false) {
                        $this->tables->update_table_status($table_id, 0);
                    }
                    header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
                }
                header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
            } else {
                $this->render('layouts/staff_layout', $this->data);
            }
        } else {
            header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
        }
        $this->render('layouts/staff_layout', $this->data);
    }
    function pay_order($orderID)
    {
        if ($this->isFieldValid($this->unpaidbills->unpaid_bill_order_id($orderID)['ma_dondat']) && isset($_POST['btn-pay-order'])) {
            $order_id = $orderID;
            $food_id = $this->orderdetails->order_detail_id($order_id)['ma_mon'];
            $type_id = $this->orderdetails->order_detail_id($order_id)['ma_loai'];
            $table_id = $this->orderdetails->order_detail_id($order_id)['ma_ban'];
            $price = $this->orderdetails->order_detail_id($order_id)['gia'];
            $quantity = $this->orderdetails->order_detail_id($order_id)['so_luong'];
            $total = $price * $quantity;
            $this->orderdetails->update_order_detail_status_order_id($orderID, 1);
            $this->paidbills->add_bill_paid($this->unpaidbills->unpaid_bill_order_id($order_id)['ma_hoadon'], $table_id, $order_id, $food_id, $type_id, $price, $quantity, $total);
            $tableID = $this->unpaidbills->unpaid_bill_order_id($orderID)['ma_ban'];
            $this->paidbills->delete_bill_paid($orderID);
            $tables = $this->model('TableModel');
            if ($this->unpaidbills->unpaid_bills_table_id($tableID) == false) {
                $tables->update_table_status($tableID, 0);
            }
            header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
        } else {
            header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
        }
    }
    function update_order($orderID)
    {
        $this->data['content'] .= 'update_order';
        if ((int)$orderID != 0 and $this->isFieldValid($this->orderdetails->order_detail_id($orderID)['ma_dondat'])) {
            $unpaidBill = $this->unpaidbills->unpaid_bill_order_id($orderID);
            $this->data['sub_content']['unpaidBill'] = $unpaidBill;
            $this->data['sub_content']['tables'] = $this->tables->tables();
            $this->data['sub_content']['foods'] = $this->foods->food();
            $this->data['sub_content']['types'] = $this->types->types();
            if (isset($_POST['btn-update'])) {
                if ($this->orderdetails->order_detail_id($orderID) == true) {
                    $food_id = $_POST['foodID'];
                    $table_id = $_POST['tableID'];
                    $quantity = $_POST['quantity'];
                    $type_id = $this->foods->food_id($food_id)['ma_loai'];
                    $price = $this->foods->food_id($food_id)['gia_mon'];
                    $table_id_before = $this->orderdetails->order_detail_id($orderID)['ma_ban'];
                    $this->orders->update_order($orderID, $food_id, $quantity);
                    $this->orderdetails->update_order_detail($orderID, $table_id, $food_id, $this->foods->food_id($food_id)['ma_loai'], $this->foods->food_id($food_id)['gia_mon'], $quantity, $quantity * $this->foods->food_id($food_id)['gia_mon']);
                    if ($table_id != $table_id_before) {
                        $unpaidBills = $this->unpaidbills->unpaid_bills();
                        $result = false;
                        foreach ($unpaidBills as $key => $value) {
                            if ($value['ma_ban'] == $table_id) {
                                $this->unpaidbills->update_unpaid_bill($value['ma_hoadon'], $table_id, $orderID, $food_id, $type_id, $price, $quantity, $quantity * $this->foods->food_id($food_id)['gia_mon']);
                                $result = true;
                                break;
                            }
                        }
                        if ($result == false) {
                            if (count($unpaidBills) > 1) {
                                $unpaidBillID = $this->unpaidbills->unpaid_bills()[0]['ma_hoadon'] + 1;
                            } else {
                                $unpaidBillID = $this->paidbills->paid_bills()[0]['ma_hoadon'] + 1;
                            }
                            $this->unpaidbills->update_unpaid_bill($unpaidBillID, $table_id, $orderID, $food_id, $type_id, $price, $quantity, $quantity * $this->foods->food_id($food_id)['gia_mon']);
                        }
                    } else {
                        $unpaidBillID = $this->unpaidbills->unpaid_bills_table_id($table_id)[0]['ma_hoadon'];
                        $this->unpaidbills->update_unpaid_bill($unpaidBillID, $table_id, $orderID, $food_id, $type_id, $price, $quantity, $quantity * $this->foods->food_id($food_id)['gia_mon']);
                    }
                    $unpaid_bills_table_before = $this->unpaidbills->unpaid_bills_table_id($table_id_before);
                    $unpaid_bills_table_after = $this->unpaidbills->unpaid_bills_table_id($table_id);
                    if ($unpaid_bills_table_before == false) {
                        $this->tables->update_table_status($table_id_before, 0);
                    }
                    if ($unpaid_bills_table_after == true) {
                        $this->tables->update_table_status($table_id, 1);
                    }
                    header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
                } else {
                    header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
                }
            }
            $this->render('layouts/staff_layout', $this->data);
        } else {
            header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
        }
    }
}
