<?php
class OrderController extends Controller
{
    public $food = [], $table = [], $type = [], $invoice = [], $tempinvoice = [], $order = [], $area, $orderdetail = [];
    public $data = [];
    function __construct()
    {
        $this->food = $this->model('FoodModel');
        $this->table = $this->model('TableModel');
        $this->order = $this->model('OrderModel');
        $this->type = $this->model('TypeModel');
        $this->invoice = $this->model('InvoiceModel');
        $this->area = $this->model('AreaModel');
        $this->tempinvoice = $this->model('TempInvoiceModel');
        $this->orderdetail = $this->model('OrderDetailModel');
    }
    function addOrder()
    {
        $this->data['sub_content']['list_food'] = [];
        foreach ($this->food->getListFood() as $key => $value) {
            if ($value['status'] == 0) {
                array_push($this->data['sub_content']['list_food'], $value);
            }
        }
        $this->data['sub_content']['list_table'] = $this->table->getListTable();
        $this->data['sub_content']['list_order'] = $this->order->getListOrder();
        $this->data['sub_content']['list_type'] = $this->type->getListType();
        $this->data['sub_content']['list_bill'] = $this->invoice->getListInvoice();
        $this->data['sub_content']['list_unpaidbill'] = $this->tempinvoice->getListTempInvoice();
        $this->data['sub_content']['bills'] = [];
        if (isset($this->invoice->getAggregatedInvoiceList()[0])) {
            foreach ($this->invoice->getAggregatedInvoiceList() as $key => $value) {
                array_push($this->data['sub_content']['bills'], $value);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['btn-add-order'])) {
                if (isset($_POST['list_food']) || ($this->isFieldValid($_POST['food_name']) && $_POST['quantity'] > 0 && $this->isFieldValid($_POST['table_name']))) {
                    if ($this->table->getTableByName($_POST['table_name'])) {
                        $table_id = $this->table->getTableByName($_POST['table_name'])['id'];
                        if (isset($_POST['list_food']) && count(json_decode($_POST['list_food'])) >= 1) {
                            $listFood = json_decode($_POST['list_food']);
                            $notexist = false;
                            foreach ($listFood as $key => $value) {
                                if (!$this->food->getFoodByName($value->food_name)) {
                                    $notexist = true;
                                    break;
                                }
                            }
                            if ($notexist == true) {
                                $this->data['message'] = 'Món không tồn tại!';
                                $this->data['error'] = 1;
                            } else {
                                $order_id = time();
                                if ($this->table->getTableByID($table_id)['status'] == 0) {
                                    $this->table->updateTableStatus($table_id, 1);
                                }
                                $listFood01[0] = $listFood[0];
                                foreach ($listFood as $key => $value) {
                                    if ($key > 0) {
                                        $check = false;
                                        foreach ($listFood01 as $key01 => $value01) {
                                            if ($value01->food_name == $value->food_name) {
                                                $listFood01[$key01]->quantity += $value->quantity;
                                                $check = true;
                                                break;
                                            }
                                        }
                                        if ($check == false) {
                                            array_push($listFood01, $value);
                                        }
                                    }
                                }
                                foreach ($listFood01 as $key => $value) {
                                    $food_id = $this->food->getFoodByName($value->food_name)['id'];
                                    $typeID = $this->food->getFoodByName($value->food_name)['typeID'];
                                    $price = $this->food->getFoodByName($value->food_name)['price'];
                                    $this->order->addOrder($order_id, $food_id, $value->quantity);
                                    $this->orderdetail->addOrderDetail($order_id, $table_id, $food_id, $typeID, $price, $value->quantity, $value->quantity * $price);
                                }
                                $unpaidBills = $this->tempinvoice->getListTempInvoice();
                                if (count($unpaidBills) == 0) {
                                    $unpaidBillID = $this->invoice->getListInvoice()[0]['id'] + 1;
                                    foreach ($listFood01 as $key => $value) {
                                        $food_id = $this->food->getFoodByName($value->food_name)['id'];
                                        $typeID = $this->food->getFoodByName($value->food_name)['typeID'];
                                        $price = $this->food->getFoodByName($value->food_name)['price'];
                                        $quantity = $value->quantity;
                                        $this->tempinvoice->addTempInvoice($unpaidBillID, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $price, $_SESSION['user_logged']['username']);
                                    }
                                    $this->data['message'] = 'Đặt món thành công!';
                                    $this->data['error'] = 0;
                                } else {
                                    $result = false;
                                    foreach ($unpaidBills as $key => $value) {
                                        if ($value['tableID'] == $table_id) {
                                            $unpaidBillID = $value['id'];
                                            foreach ($listFood01 as $key1 => $value1) {
                                                $food_id = $this->food->getFoodByName($value1->food_name)['id'];
                                                $typeID = $this->food->getFoodByName($value1->food_name)['typeID'];
                                                $price = $this->food->getFoodByName($value1->food_name)['price'];
                                                $quantity = $value1->quantity;
                                                $this->tempinvoice->addTempInvoice($unpaidBillID, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $price, $_SESSION['user_logged']['username']);
                                            }
                                            $result = true;
                                            break;
                                        }
                                    }
                                    if ($result == false) {
                                        $unpaidBillID = $this->tempinvoice->getListTempInvoice()[0]['id'] + 1;
                                        foreach ($listFood01 as $key => $value) {
                                            $food_id = $this->food->getFoodByName($value->food_name)['id'];
                                            $typeID = $this->food->getFoodByName($value->food_name)['typeID'];
                                            $price = $this->food->getFoodByName($value->food_name)['price'];
                                            $quantity = $value->quantity;
                                            $this->tempinvoice->addTempInvoice($unpaidBillID, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $price, $_SESSION['user_logged']['username']);
                                        }
                                    }
                                    $this->data['message'] = 'Đặt món thành công!';
                                    $this->data['error'] = 0;
                                }
                            }
                        } else {
                            if ($this->food->getFoodByName($_POST['food_name'])) {
                                $food_id = $this->food->getFoodByName($_POST['food_name'])['id'];
                                $order_id = time();
                                $quantity = $_POST['quantity'];
                                $price = $this->food->getFoodByID($food_id)['price'];
                                $typeID = $this->food->getFoodByID($food_id)['typeID'];
                                $this->order->addOrder($order_id, $food_id, $quantity);
                                if ($this->table->getTableByID($table_id)['status'] == 0) {
                                    $this->table->updateTableStatus($table_id, 1);
                                }
                                $this->orderdetail->addOrderDetail($order_id, $table_id, $food_id, $this->food->getFoodByID($food_id)['typeID'], $this->food->getFoodByID($food_id)['price'], $quantity, $quantity * $this->food->getFoodByID($food_id)['price']);
                                $unpaidBills = $this->tempinvoice->getListTempInvoice();
                                $result = false;
                                if (count($unpaidBills) == 0) { // Chưa có hóa đơn tạm
                                    $unpaidBillID = $this->invoice->getListInvoice()[0]['id'] + 1;
                                    $this->tempinvoice->addTempInvoice($unpaidBillID, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                                    $this->data['message'] = 'Đặt món thành công!';
                                    $this->data['error'] = 0;
                                } else {
                                    foreach ($unpaidBills as $key => $value) {
                                        if ($value['tableID'] == $table_id) {
                                            $this->tempinvoice->addTempInvoice($value['id'], $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                                            $result = true;
                                            break;
                                        }
                                    }
                                    if ($result == false) {
                                        $this->tempinvoice->addTempInvoice($this->tempinvoice->getListTempInvoice()[0]['id'] + 1, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                                    }
                                    $this->data['message'] = 'Đặt món thành công!';
                                    $this->data['error'] = 0;
                                }
                            } else {
                                $this->data['message'] = 'Món không tồn tại!';
                                $this->data['error'] = 1;
                            }
                        }
                    } else {
                        $this->data['message'] = 'Bàn không tồn tại!';
                        $this->data['error'] = 1;
                    }
                } else {
                    $this->data['error'] = 1;
                    $this->data['message'] = 'Vui lòng nhập đầy đủ thông tin!';
                }
                echo json_encode($this->data);
            } else if (isset($_POST['table_name'])) {
                if (isset($this->table->getTableByName($_POST['table_name'])['id'])) {
                    if (isset($this->tempinvoice->getTempInvoiceByTable($this->table->getTableByName($_POST['table_name'])['id'])[0])) {
                        $unpaidBills = $this->tempinvoice->getTempInvoiceByTable($this->table->getTableByName($_POST['table_name'])['id']);
                        $this->data['error'] = 0;
                        $this->data['message'] = 'Danh sách đơn đặt chưa thanh toán';
                        $this->data['list_order'] = [];
                        $this->data['order_info'] = [];
                        array_push($this->data['order_info'], ['username' => $unpaidBills[count($unpaidBills) - 1]['username']]);
                        array_push($this->data['order_info'], ['table' => $this->table->getTableByID($unpaidBills[count($unpaidBills) - 1]['tableID'])]);
                        array_push($this->data['order_info'], ['area' => $this->area->getAreaByID($this->table->getTableByID($unpaidBills[count($unpaidBills) - 1]['tableID'])['areaID'])]);
                        foreach ($unpaidBills as $key => $value) {
                            foreach ($this->food->getListFood() as $key2 => $value2) {
                                if ($value['foodID'] == $value2['id']) {
                                    $value['food_name'] = $value2['name'];
                                    break;
                                }
                            }
                            array_push($this->data['list_order'], $value);
                        }
                        ;
                    } else {
                        $this->data['error'] = 1;
                        $this->data['message'] = 'Chưa có đơn đặt';
                    }
                } else {
                    $this->data['error'] = 1;
                    $this->data['message'] = 'Bàn không tồn tại!';
                }
                array_splice($this->data['sub_content'], 0, count($this->data['sub_content']));
                echo json_encode($this->data);
            }
        } else {
            $this->data['message'] = 'Trang không tồn tại';
            $this->data['error'] = 1;
            echo json_encode($this->data);
        }
    }
    function getOrderDetail($id)
    {
        $orderID = explode('.', $id)[0];
        $foodID = explode('.', $id)[1];
        if ((int) $orderID != 0 and $this->isFieldValid($this->orderdetail->getOrderDetail($orderID, $foodID)['orderID'])) { // Kiểm tra xem có tồn tại đơn đặt và món đó không
            $orderdetail = $this->orderdetail->getOrderDetail($orderID, $foodID);
            $this->data['sub_content']['table'] = $this->table->getTableByID($orderdetail['tableID']);
            $this->data['sub_content']['food'] = $this->food->getFoodByID($orderdetail['foodID']);
            $this->data['sub_content']['type'] = $this->type->getTypeByID($orderdetail['typeID']);
            $this->data['sub_content']['order_detail'] = $orderdetail;
            $this->data['content'] .= 'order_detail';
        } else {
            header('Location: ' . _WEB_ROOT . '/them-don-dat');
        }
        $this->render('layouts/staff_layout', $this->data);
    }
    function deleteOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = json_decode($_POST['id']);
            $orderID = explode('.', $id)[0];
            $foodID = explode('.', $id)[1];
            if ((int) $orderID != 0 and $this->isFieldValid($this->orderdetail->getOrderDetail($orderID, $foodID)['orderID'])) { // Kiểm tra xem có tồn tại đơn đặt và món đó không
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ($this->orderdetail->getOrderDetail($orderID, $foodID) == true) {
                        $table_id = $this->orderdetail->getOrderDetail($orderID, $foodID)['tableID'];
                        $this->order->deleteOrder($orderID, $foodID);
                        $unpaid_bills_table = $this->tempinvoice->getTempInvoiceByTable($table_id);
                        if ($unpaid_bills_table == false) {
                            $this->table->updateTableStatus($table_id, 0);
                        }
                        $this->data['error'] = 0;
                        $this->data['message'] = 'Xóa đơn đặt thành công';
                    } else {
                        $this->data['error'] = 1;
                        $this->data['message'] = 'Đơn đặt không tồn tại!';
                    }
                } else {
                    $this->data['error'] = 1;
                    $this->data['message'] = 'Bad request!';
                }
            } else {
                $this->data['error'] = 1;
                $this->data['message'] = 'Đơn đặt không tồn tại!';
            }
        } else {
            $this->data['error'] = 1;
            $this->data['message'] = 'Bad request!';
        }
        echo json_encode($this->data);
    }

    // function thanhtoan_vnpay()
    // {
    //     $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    //     $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
    //     $vnp_TmnCode = ""; //Mã website tại VNPAY 
    //     $vnp_HashSecret = ""; //Chuỗi bí mật

    //     $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    //     $vnp_OrderInfo = $_POST['order_desc'];
    //     $vnp_OrderType = $_POST['order_type'];
    //     $vnp_Amount = $_POST['amount'] * 100;
    //     $vnp_Locale = $_POST['language'];
    //     $vnp_BankCode = $_POST['bank_code'];
    //     $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //     //Add Params of 2.0.1 Version
    //     $vnp_ExpireDate = $_POST['txtexpire'];
    //     //Billing
    //     $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
    //     $vnp_Bill_Email = $_POST['txt_billing_email'];
    //     $fullName = trim($_POST['txt_billing_fullname']);
    //     if (isset($fullName) && trim($fullName) != '') {
    //         $name = explode(' ', $fullName);
    //         $vnp_Bill_FirstName = array_shift($name);
    //         $vnp_Bill_LastName = array_pop($name);
    //     }
    //     $vnp_Bill_Address = $_POST['txt_inv_addr1'];
    //     $vnp_Bill_City = $_POST['txt_bill_city'];
    //     $vnp_Bill_Country = $_POST['txt_bill_country'];
    //     $vnp_Bill_State = $_POST['txt_bill_state'];
    //     // Invoice
    //     $vnp_Inv_Phone = $_POST['txt_inv_mobile'];
    //     $vnp_Inv_Email = $_POST['txt_inv_email'];
    //     $vnp_Inv_Customer = $_POST['txt_inv_customer'];
    //     $vnp_Inv_Address = $_POST['txt_inv_addr1'];
    //     $vnp_Inv_Company = $_POST['txt_inv_company'];
    //     $vnp_Inv_Taxcode = $_POST['txt_inv_taxcode'];
    //     $vnp_Inv_Type = $_POST['cbo_inv_type'];
    //     $inputData = array(
    //         "vnp_Version" => "2.1.0",
    //         "vnp_TmnCode" => $vnp_TmnCode,
    //         "vnp_Amount" => $vnp_Amount,
    //         "vnp_Command" => "pay",
    //         "vnp_CreateDate" => date('YmdHis'),
    //         "vnp_CurrCode" => "VND",
    //         "vnp_IpAddr" => $vnp_IpAddr,
    //         "vnp_Locale" => $vnp_Locale,
    //         "vnp_OrderInfo" => $vnp_OrderInfo,
    //         "vnp_OrderType" => $vnp_OrderType,
    //         "vnp_ReturnUrl" => $vnp_Returnurl,
    //         "vnp_TxnRef" => $vnp_TxnRef,
    //         "vnp_ExpireDate" => $vnp_ExpireDate,
    //         "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
    //         "vnp_Bill_Email" => $vnp_Bill_Email,
    //         "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
    //         "vnp_Bill_LastName" => $vnp_Bill_LastName,
    //         "vnp_Bill_Address" => $vnp_Bill_Address,
    //         "vnp_Bill_City" => $vnp_Bill_City,
    //         "vnp_Bill_Country" => $vnp_Bill_Country,
    //         "vnp_Inv_Phone" => $vnp_Inv_Phone,
    //         "vnp_Inv_Email" => $vnp_Inv_Email,
    //         "vnp_Inv_Customer" => $vnp_Inv_Customer,
    //         "vnp_Inv_Address" => $vnp_Inv_Address,
    //         "vnp_Inv_Company" => $vnp_Inv_Company,
    //         "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
    //         "vnp_Inv_Type" => $vnp_Inv_Type
    //     );

    //     if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    //         $inputData['vnp_BankCode'] = $vnp_BankCode;
    //     }
    //     if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
    //         $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    //     }

    //     //var_dump($inputData);
    //     ksort($inputData);
    //     $query = "";
    //     $i = 0;
    //     $hashdata = "";
    //     foreach ($inputData as $key => $value) {
    //         if ($i == 1) {
    //             $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    //         } else {
    //             $hashdata .= urlencode($key) . "=" . urlencode($value);
    //             $i = 1;
    //         }
    //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
    //     }

    //     $vnp_Url = $vnp_Url . "?" . $query;
    //     if (isset($vnp_HashSecret)) {
    //         $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
    //         $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    //     }
    //     $returnData = array(
    //         'code' => '00'
    //         ,
    //         'message' => 'success'
    //         ,
    //         'data' => $vnp_Url
    //     );
    //     if (isset($_POST['redirect'])) {
    //         header('Location: ' . $vnp_Url);
    //         die();
    //     } else {
    //         echo json_encode($returnData);
    //     }
    //     // vui lòng tham khảo thêm tại code demo
    // }
    function processOrderPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = json_decode($_POST['id']);
            $orderID = explode('.', $id)[0];
            $foodID = explode('.', $id)[1];
            if ($this->isFieldValid($this->tempinvoice->getTempInvoiceByOrder($orderID, $foodID)[0]['orderID'])) { // Kiểm tra xem có tồn tại đơn đặt và món đó không
                $order = $this->orderdetail->getOrderDetail($orderID, $foodID);
                $type_id = $order['typeID'];
                $table_id = $order['tableID'];
                $price = $order['price'];
                $quantity = $order['quantity'];
                $total = $price * $quantity;
                $this->orderdetail->updateOrderDetailStatus($orderID, $foodID, 1);
                $this->invoice->addInvoice($this->tempinvoice->getTempInvoiceByOrder($orderID, $foodID)[0]['id'], $table_id, $orderID, $foodID, $type_id, $price, $quantity, $total, $_SESSION['user_logged']['username']);
                $tableID = $this->tempinvoice->getTempInvoiceByOrder($orderID, $foodID)[0]['tableID'];
                $this->invoice->deleteTempInvoice($orderID, $foodID);
                $tables = $this->model('TableModel');
                if ($this->tempinvoice->getTempInvoiceByTable($tableID) == false) { // Kiểm tra xem bàn đó có đang có đơn đặt nào không
                    $tables->updateTableStatus($tableID, 0);
                }
                $this->data['error'] = 0;
                $this->data['message'] = 'Thanh toán đơn đặt thành công!';
            } else {
                $this->data['error'] = 1;
                $this->data['message'] = 'Đơn đặt không tồn tại!';
            }
        } else {
            $this->data['error'] = 1;
            $this->data['message'] = 'Bad request!';
        }
        echo json_encode($this->data);
    }
    function processAllOrderPayment()
    {
        if (isset($_POST['btn-pay-all-order']) && $_POST['bill_id']) {
            $billID = $_POST['bill_id'];
            $unpaidbills = $this->tempinvoice->getTempInvoiceByID($billID);
            $orders = [];
            foreach ($unpaidbills as $key => $value) {
                $orders[] = $this->orderdetail->getOrderDetail($value['orderID'], $value['foodID']);
            }
            foreach ($orders as $order) {
                $orderID = $order['orderID'];
                $foodID = $order['foodID'];
                $typeID = $order['typeID'];
                $tableID = $order['tableID'];
                $price = $order['price'];
                $quantity = $order['quantity'];
                $total = $price * $quantity;
                $this->orderdetail->updateOrderDetailStatus($orderID, $foodID, 1);
                $this->invoice->addInvoice($this->tempinvoice->getTempInvoiceByOrder($orderID, $foodID)[0]['id'], $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total, $_SESSION['user_logged']['username']);
                $this->invoice->deleteTempInvoice($orderID, $foodID);
                $tables = $this->model('TableModel');
                if ($this->tempinvoice->getTempInvoiceByTable($tableID) == false) {
                    $tables->updateTableStatus($tableID, 0);
                }
            }
            header('Location: ' . _WEB_ROOT . '/them-don-dat');
        } else {
            header('Location: ' . _WEB_ROOT . '/them-don-dat');
        }
    }
    function updateOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = json_decode($_POST['id']);
            $orderID = explode('.', $id)[0];
            $foodID = explode('.', $id)[1];
            if (isset($_POST['food_name']) && isset($_POST['table_name']) && isset($_POST['quantity']) && (int) $id != 0 and $this->isFieldValid($this->orderdetail->getOrderDetail($orderID, $foodID)['orderID'])) {
                if (isset($_POST['btn-update'])) {
                    if ($this->orderdetail->getOrderDetail($orderID, $foodID) == true) {
                        $food_id = $this->food->getFoodByName($_POST['food_name'])['id'];
                        $table_id = $this->table->getTableByName($_POST['table_name'])['id'];
                        $quantity = $_POST['quantity'];
                        $type_id = $this->food->getFoodByID($food_id)['typeID'];
                        $price = $this->food->getFoodByID($food_id)['price'];
                        $table_id_before = $this->orderdetail->getOrderDetail($orderID, $foodID)['tableID'];
                        $this->order->updateOrder($orderID, $foodID, $food_id, $quantity);
                        $this->orderdetail->updateOrderDetail($orderID, $foodID, $table_id, $food_id, $this->food->getFoodByID($food_id)['typeID'], $this->food->getFoodByID($food_id)['price'], $quantity, $quantity * $this->food->getFoodByID($food_id)['price']);
                        if ($table_id != $table_id_before) {
                            $unpaidBills = $this->tempinvoice->getListTempInvoice();
                            $result = false;
                            foreach ($unpaidBills as $key => $value) {
                                if ($value['tableID'] == $table_id) {
                                    $this->tempinvoice->updateTempInvoice($value['id'], $table_id, $orderID, $foodID, $food_id, $type_id, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                                    $result = true;
                                    break;
                                }
                            }
                            if ($result == false) {
                                if (count($unpaidBills) > 1) {
                                    $unpaidBillID = $this->tempinvoice->getListTempInvoice()[0]['id'] + 1;
                                } else {
                                    $unpaidBillID = $this->invoice->getListInvoice()[0]['id'] + 1;
                                }
                                $this->tempinvoice->updateTempInvoice($unpaidBillID, $table_id, $orderID, $foodID, $food_id, $type_id, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                            }
                        } else {
                            $unpaidBillID = $this->tempinvoice->getTempInvoiceByTable($table_id)[0]['id'];
                            $this->tempinvoice->updateTempInvoice($unpaidBillID, $table_id, $orderID, $foodID, $food_id, $type_id, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                        }
                        $unpaid_bills_table_before = $this->tempinvoice->getTempInvoiceByTable($table_id_before);
                        $unpaid_bills_table_after = $this->tempinvoice->getTempInvoiceByTable($table_id);
                        if ($unpaid_bills_table_before == false) {
                            $this->table->updateTableStatus($table_id_before, 0);
                        }
                        if ($unpaid_bills_table_after == true) {
                            $this->table->updateTableStatus($table_id, 1);
                        }
                        $this->data['error'] = 0;
                        $this->data['message'] = 'Cap nhat thanh cong!';
                    } else {
                        $this->data['error'] = 1;
                        $this->data['message'] = 'Đơn đặt không tồn tại!';
                    }
                } else {
                    $this->data['error'] = 1;
                    $this->data['message'] = 'Bad request!';
                }
            } else {
                $this->data['error'] = 1;
                $this->data['message'] = 'Đơn đặt không tồn tại!';
            }
        } else {
            $this->data['error'] = 1;
            $this->data['message'] = 'Bad request!';
        }
        echo json_encode($this->data);
    }
}