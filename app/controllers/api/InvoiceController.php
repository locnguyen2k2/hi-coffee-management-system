<?php
class InvoiceController extends Controller
{
    public $data = [], $invoice = [], $tempinvoice = [], $food = [], $table = [], $type = [], $area = [];
    public $order = [], $orderdetail = [];
    function __construct()
    {
        $this->food = $this->model('FoodModel');
        $this->table = $this->model('TableModel');
        $this->type = $this->model('TypeModel');
        $this->tempinvoice = $this->model('TempInvoiceModel');
        $this->invoice = $this->model('InvoiceModel');
        $this->area = $this->model('AreaModel');
        $this->order = $this->model('OrderModel');
        $this->orderdetail = $this->model('OrderDetailModel');
    }
    function getInvoiceDetail()
    {
        if (isset($_POST['invoiceID']) && $this->isFieldValid($_POST['invoiceID'])) {
            $billID = $_POST['invoiceID'];
            $this->data['list_order'] = [];
            if (isset($this->invoice->getInvoiceByID($billID)[0])) { //Nếu hóa đơn tồn tại và có đơn đặt đã thanh toán
                foreach ($this->invoice->getInvoiceByID($billID) as $key1 => $value) { //Vòng lập để lấy ra tất đơn đặt đã thanh toán của hóa đơn đó
                    array_push($this->data['list_order'], $value); //Gán vào biết $data['sub_content]['orders']
                }
            }
            // Tương tự với đơn đặt chưa thanh toán có trong cùng hóa đơn đó
            if (isset($this->tempinvoice->getTempInvoiceByID($billID)[0])) {
                foreach ($this->tempinvoice->getTempInvoiceByID($billID) as $key2 => $value) {
                    array_push($this->data['list_order'], $value);
                }
            }
            if (count($this->data['list_order']) > 0) {
                $this->data['table'] = $this->table->getTableByID($this->data['list_order'][0]['tableID']);
                $this->data['area'] = $this->area->getAreaByID($this->data['table']['areaID']);
                $this->data['total_paid'] = 0;
                $this->data['total_unpaid'] = 0;
                $this->data['info_paid'] = $this->invoice->getInvoiceByID($billID) ? $this->invoice->getInvoiceByID($billID) : [];
                $this->data['info_unpaid'] = $this->tempinvoice->getTempInvoiceByID($billID) ? $this->tempinvoice->getTempInvoiceByID($billID) : [];
                foreach ($this->data['list_order'] as $key => $value) {
                    if (isset($value['status'])) {
                        if ($value['status'] == 1) {
                            $this->data['total_paid'] += $value['total']; // Tính tổng tiền đã thanh toán
                        } else {
                            $this->data['total_unpaid'] += $value['total']; // Tính tổng tiền chưa thanh toán
                        }
                    } else if (isset($value['unpaidbill_status'])) {
                        if ($value['unpaidbill_status'] == 1) {
                            $this->data['total_paid'] += $value['total'];
                        } else {
                            $this->data['total_unpaid'] += $value['total'];
                        }
                    }
                }
                $this->data['error'] = 0;
            } else {
                $this->data['error'] = 1;
                $this->data['message'] = 'Hoa don khong ton tai';

            }
        } else {
            $this->data['error'] = 1;
            $this->data['message'] = 'Vui long nhap thong tin hoa don';
        }
        echo json_encode($this->data);
    }
    function getListInvoiceByTable()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tableName']) && $this->table->getTableByName($_POST['tableName'])) {
            $this->data['bills'] = [];
            if (isset($this->invoice->getInvoiceByTable($this->table->getTableByName($_POST['tableName'])['id'])[0])) {
                foreach ($this->invoice->getInvoiceByTable($this->table->getTableByName($_POST['tableName'])['id']) as $key => $value) {
                    if ($value['username'] == $_SESSION['user_logged']['username']) {
                        if (count($this->data['bills']) == 0) {
                            array_push($this->data['bills'], $value);
                        } else {
                            $result = false;
                            foreach ($this->data['bills'] as $key1 => $value1) {
                                if ($value1['id'] == $value['id']) {
                                    $this->data['bills'][$key1]['total'] += $value['total'];
                                    $this->data['bills'][$key1]['quantity'] += $value['quantity'];
                                    $result = true;
                                    break;
                                }
                            }
                            if ($result == false) {
                                array_push($this->data['bills'], $value);
                            }
                        }
                    }
                }
            }
            $this->data['error'] = 0;
        } else {
            $this->data['error'] = 1;
            $this->data['message'] = 'Bàn không tồn tại hoặc chưa có hóa đơn bàn này!';
        }
        echo json_encode($this->data);
    }
}