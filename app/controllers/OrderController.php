<?php 
class OrderController extends Controller
{
    public $food = [], $table = [], $type = [], $invoice = [], $tempinvoice = [], $order = [], $orderdetail = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin']) && !isset($_SESSION['user_logged']['roles']['staff'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->food = $this->model('FoodModel');
            $this->table = $this->model('TableModel');
            $this->order = $this->model('OrderModel');
            $this->type = $this->model('TypeModel');
            $this->invoice = $this->model('InvoiceModel');
            $this->tempinvoice = $this->model('TempInvoiceModel');
            $this->orderdetail = $this->model('OrderDetailModel');
            $this->data['content'] = 'OrderViews/';
        }
    }
    function addOrder()
    {
        $this->data['content'] .= 'add_order';
        $this->data['sub_content']['list_food'] = [];
        foreach ($this->food->getListFood() as $key => $value) {
            if ($value['status'] == 0) { // 0: Đang bán
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Nếu có dữ liệu POST lên thì xử lý
            if (isset($_POST['btn-add-order'])) { // Nếu là thêm đơn đặt
                if (isset($_POST['list_food']) || ($this->isFieldValid($_POST['food_name']) && $_POST['quantity'] > 0 && $this->isFieldValid($_POST['table_name']))) { // Nếu có dữ liệu POST lên thì xử lý
                    $table_id = $this->table->getTableByName($_POST['table_name'])['id'];
                    function checkFood($food_id, $food_list) // Kiểm tra món có tồn tại trong danh sách món không
                    {
                        foreach ($food_list as $key => $value) {
                            if ($value['id'] == $food_id) {
                                return true;
                            }
                        }
                        return false;
                    }
                    if (!isset($table_id)) { // Kiểm tra bàn có tồn tại không
                        $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Bàn không tồn tại!</div>';
                        $this->render('layouts/staff_layout', $this->data);
                    } else if (isset($_POST['list_food']) && count(json_decode($_POST['list_food'])) > 1) { // Nếu có dữ liệu POST lên thì xử lý
                        $listFood = json_decode($_POST['list_food']);
                        $notexist = false;
                        foreach ($listFood as $key => $value) {
                            if (checkFood($this->food->getFoodByName($value->food_name)['id'], $this->food->getListFood()) == false) {
                                $notexist = true;
                                break;
                            }
                        }
                        if ($notexist == true) {
                            $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Món không tồn tại!</div>';
                            $this->render('layouts/staff_layout', $this->data);
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
                                $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Đặt món thành công!</div>';
                                $this->render('layouts/staff_layout', $this->data);
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
                                $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Đặt món thành công!</div>';
                                $this->render('layouts/staff_layout', $this->data);
                            }
                        }
                    } else if (isset($_POST['food_name']) && isset($_POST['quantity']) && $_POST['quantity'] > 0 && isset($_POST['table_name'])) { // Đặt món từ trang danh sách món
                        $food_id = $this->food->getFoodByName($_POST['food_name'])['id'];
                        $quantity = $_POST['quantity'];
                        $typeID = $this->food->getFoodByID($food_id)['typeID'];
                        $price = $this->food->getFoodByID($food_id)['price'];
                        echo $food_id;
                        if (checkFood($food_id, $this->food->getListFood()) == false) {
                            $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Món không tồn tại!</div>';
                            $this->render('layouts/staff_layout', $this->data);
                        } else {
                            $order_id = time();
                            $this->order->addOrder($order_id, $food_id, $quantity);
                            if ($this->table->getTableByID($table_id)['status'] == 0) { // Bàn trống
                                $this->table->updateTableStatus($table_id, 1);
                            }
                            $this->orderdetail->addOrderDetail($order_id, $table_id, $food_id, $this->food->getFoodByID($food_id)['typeID'], $this->food->getFoodByID($food_id)['price'], $quantity, $quantity * $this->food->getFoodByID($food_id)['price']);
                            $unpaidBills = $this->tempinvoice->getListTempInvoice();
                            $result = false;
                            if (count($unpaidBills) == 0) { // Chưa có hóa đơn tạm
                                $unpaidBillID = $this->invoice->getListInvoice()[0]['id'] + 1;
                                $this->tempinvoice->addTempInvoice($unpaidBillID, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                                $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Đặt món thành công!</div>';
                                $this->render('layouts/staff_layout', $this->data);
                            } else {
                                foreach ($unpaidBills as $key => $value) {
                                    if ($value['tableID'] == $table_id) { // Đã có hóa đơn tạm
                                        $this->tempinvoice->addTempInvoice($value['id'], $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                                        $result = true;
                                        break;
                                    }
                                }
                                if ($result == false) { // Chưa có hóa đơn tạm
                                    $this->tempinvoice->addTempInvoice($this->tempinvoice->getListTempInvoice()[0]['id'] + 1, $table_id, $order_id, $food_id, $typeID, $price, $quantity, $quantity * $this->food->getFoodByID($food_id)['price'], $_SESSION['user_logged']['username']);
                                }
                                $this->data['sub_content']['isSucessed'] = '<div class="alert alert-success" role="alert">Đặt món thành công!</div>';
                                $this->render('layouts/staff_layout', $this->data);
                            }
                        }
                        $this->render('layouts/staff_layout', $this->data);
                    }
                } else {
                    $this->data['sub_content']['isNull'] = '<div class="alert alert-danger" role="alert">Vui lòng nhập đầy đủ thông tin!</div>';
                    $this->render('layouts/staff_layout', $this->data);
                }
            } else if (isset($_POST['table_name'])) {
                if (isset($this->table->getTableByName($_POST['table_name'])['id'])) {
                    if (isset($this->tempinvoice->getTempInvoiceByTable($this->table->getTableByName($_POST['table_name'])['id'])[0])) {
                        $unpaidBills = $this->tempinvoice->getTempInvoiceByTable($this->table->getTableByName($_POST['table_name'])['id']);
                        echo '<div class="heading"><h3>Danh sách đơn đặt chưa thanh toán</h3></div>
                        <div class="content"><div class="list-item"><div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner">';
                        foreach ($unpaidBills as $key => $value) {
                            echo $key == 0 ? '<div class="carousel-item active">' : '<div class="carousel-item">';
                            echo '<div class="card"><div class="card-body"><a class="items" href="' . _WEB_ROOT . '/' . 'chi-tiet-don-dat' . '/' . $value['orderID'] . '.' . $value['foodID'] . '"><div class="order"><span>STT: </span><span>' . $key + 1 . '</span></div><div><span>Mã hóa đơn: </span><span class="bill_id">' . $value['id'] . '</span></div><div><span>Mã đơn đặt:</span><span>' . $value['orderID'] . '</span></div><div><span>Bàn: </span><span class="tableName">';
                            foreach ($this->table->getListTable() as $key1 => $value1) {
                                if ($value['tableID'] == $value1['id']) {
                                    echo $value1['name'];
                                    break;
                                }
                            }
                            ;
                            echo '</span></div><div> <span>Món: </span> <span>';
                            foreach ($this->food->getListFood() as $key2 => $value2) {
                                if ($value['foodID'] == $value2['id']) {
                                    echo $value2['name'];
                                    break;
                                }
                            }
                            ;
                            echo '</span></div><div><span>Số lượng: </span><span>' . $value['quantity'] . '</span></div><div><span>Thành tiền: </span><span>' . number_format($value['total'], 0, ',', '.') . ' đ' . '</span></div><div><span>Trạng thái: </span><span>Chờ thanh toán</span></div><div><span>Ngày đặt: </span><span>' . $value['created_at'] . '</span></div></a></div></div></div>';
                        }
                        ;
                        echo '</div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button><button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button></div></div></div>';
                    }
                }
            }
        } else {
            $this->render('layouts/staff_layout', $this->data);
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
    function deleteOrder($id)
    {
        $orderID = explode('.', $id)[0];
        $foodID = explode('.', $id)[1];
        if ((int) $orderID != 0 and $this->isFieldValid($this->orderdetail->getOrderDetail($orderID, $foodID)['orderID'])) { // Kiểm tra xem có tồn tại đơn đặt và món đó không
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-delete-order'])) {
                if ($this->orderdetail->getOrderDetail($orderID, $foodID) == true) {
                    $table_id = $this->orderdetail->getOrderDetail($orderID, $foodID)['tableID'];
                    $this->order->deleteOrder($orderID, $foodID);
                    $unpaid_bills_table = $this->tempinvoice->getTempInvoiceByTable($table_id);
                    if ($unpaid_bills_table == false) {
                        $this->table->updateTableStatus($table_id, 0);
                    }
                    header('Location: ' . _WEB_ROOT . '/them-don-dat');
                }
                header('Location: ' . _WEB_ROOT . '/them-don-dat');
            } else {
                header('Location: ' . _WEB_ROOT . '/them-don-dat');
            }
        } else {
            header('Location: ' . _WEB_ROOT . '/them-don-dat');
        }
    }
    // function thanhtoan_vnpay()
    // {
        // $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        // $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
        // $vnp_TmnCode = ""; //Mã website tại VNPAY 
        // $vnp_HashSecret = ""; //Chuỗi bí mật

        // $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        // $vnp_OrderInfo = $_POST['order_desc'];
        // $vnp_OrderType = $_POST['order_type'];
        // $vnp_Amount = $_POST['amount'] * 100;
        // $vnp_Locale = $_POST['language'];
        // $vnp_BankCode = $_POST['bank_code'];
        // $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        // //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        // //Billing
        // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
        // $vnp_Bill_Email = $_POST['txt_billing_email'];
        // $fullName = trim($_POST['txt_billing_fullname']);
        // if (isset($fullName) && trim($fullName) != '') {
        //     $name = explode(' ', $fullName);
        //     $vnp_Bill_FirstName = array_shift($name);
        //     $vnp_Bill_LastName = array_pop($name);
        // }
        // $vnp_Bill_Address = $_POST['txt_inv_addr1'];
        // $vnp_Bill_City = $_POST['txt_bill_city'];
        // $vnp_Bill_Country = $_POST['txt_bill_country'];
        // $vnp_Bill_State = $_POST['txt_bill_state'];
        // // Invoice
        // $vnp_Inv_Phone = $_POST['txt_inv_mobile'];
        // $vnp_Inv_Email = $_POST['txt_inv_email'];
        // $vnp_Inv_Customer = $_POST['txt_inv_customer'];
        // $vnp_Inv_Address = $_POST['txt_inv_addr1'];
        // $vnp_Inv_Company = $_POST['txt_inv_company'];
        // $vnp_Inv_Taxcode = $_POST['txt_inv_taxcode'];
        // $vnp_Inv_Type = $_POST['cbo_inv_type'];
        // $inputData = array(
        //     "vnp_Version" => "2.1.0",
        //     "vnp_TmnCode" => $vnp_TmnCode,
        //     "vnp_Amount" => $vnp_Amount,
        //     "vnp_Command" => "pay",
        //     "vnp_CreateDate" => date('YmdHis'),
        //     "vnp_CurrCode" => "VND",
        //     "vnp_IpAddr" => $vnp_IpAddr,
        //     "vnp_Locale" => $vnp_Locale,
        //     "vnp_OrderInfo" => $vnp_OrderInfo,
        //     "vnp_OrderType" => $vnp_OrderType,
        //     "vnp_ReturnUrl" => $vnp_Returnurl,
        //     "vnp_TxnRef" => $vnp_TxnRef,
        //     "vnp_ExpireDate" => $vnp_ExpireDate,
        //     "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
        //     "vnp_Bill_Email" => $vnp_Bill_Email,
        //     "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
        //     "vnp_Bill_LastName" => $vnp_Bill_LastName,
        //     "vnp_Bill_Address" => $vnp_Bill_Address,
        //     "vnp_Bill_City" => $vnp_Bill_City,
        //     "vnp_Bill_Country" => $vnp_Bill_Country,
        //     "vnp_Inv_Phone" => $vnp_Inv_Phone,
        //     "vnp_Inv_Email" => $vnp_Inv_Email,
        //     "vnp_Inv_Customer" => $vnp_Inv_Customer,
        //     "vnp_Inv_Address" => $vnp_Inv_Address,
        //     "vnp_Inv_Company" => $vnp_Inv_Company,
        //     "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
        //     "vnp_Inv_Type" => $vnp_Inv_Type
        // );

        // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        //     $inputData['vnp_BankCode'] = $vnp_BankCode;
        // }
        // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        // }

        // //var_dump($inputData);
        // ksort($inputData);
        // $query = "";
        // $i = 0;
        // $hashdata = "";
        // foreach ($inputData as $key => $value) {
        //     if ($i == 1) {
        //         $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        //     } else {
        //         $hashdata .= urlencode($key) . "=" . urlencode($value);
        //         $i = 1;
        //     }
        //     $query .= urlencode($key) . "=" . urlencode($value) . '&';
        // }

        // $vnp_Url = $vnp_Url . "?" . $query;
        // if (isset($vnp_HashSecret)) {
        //     $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
        //     $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        // }
        // $returnData = array(
        //     'code' => '00'
        //     ,
        //     'message' => 'success'
        //     ,
        //     'data' => $vnp_Url
        // );
        // if (isset($_POST['redirect'])) {
        //     header('Location: ' . $vnp_Url);
        //     die();
        // } else {
        //     echo json_encode($returnData);
        // }
        // // vui lòng tham khảo thêm tại code demo
    // }
    function processOrderPayment($id)
    {
        $orderID = explode('.', $id)[0];
        $foodID = explode('.', $id)[1];
        if ($this->isFieldValid($this->tempinvoice->getTempInvoiceByOrder($orderID, $foodID)[0]['orderID']) && isset($_POST['btn-pay-order'])) { // Kiểm tra xem có tồn tại đơn đặt và món đó không
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
            header('Location: ' . _WEB_ROOT . '/them-don-dat');
        } else {
            header('Location: ' . _WEB_ROOT . '/them-don-dat');
        }
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
    function updateOrder($id)
    {
        $orderID = explode('.', $id)[0];
        $foodID = explode('.', $id)[1];
        if ((int) $id != 0 and $this->isFieldValid($this->orderdetail->getOrderDetail($orderID, $foodID)['orderID'])) {
            $this->data['content'] .= 'update_order';
            $unpaidBill = $this->tempinvoice->getTempInvoiceByOrder($orderID, $foodID);
            $this->data['sub_content']['unpaidbill'] = $unpaidBill;
            $this->data['sub_content']['list_table'] = $this->table->getListTable();
            $this->data['sub_content']['list_food'] = $this->food->getListFood();
            $this->data['sub_content']['list_type'] = $this->type->getListType();
            if (isset($_POST['btn-update'])) {
                if ($this->orderdetail->getOrderDetail($orderID, $foodID) == true) {
                    $food_id = $_POST['foodID'];
                    $table_id = $_POST['tableID'];
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
                    header('Location: ' . _WEB_ROOT . '/' . 'cap-nhat-don-dat' . '/' . $orderID . '.' . $food_id);
                } else {
                    header('Location: ' . _WEB_ROOT . '/them-don-dat');
                }
            }
            $this->render('layouts/staff_layout', $this->data);
        } else {
            header('Location: ' . _WEB_ROOT . '/them-don-dat');
        }
    }
}