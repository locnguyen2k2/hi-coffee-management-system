<?php

class InvoiceController extends Controller
{
    public $data = [], $invoice = [], $tempinvoice = [], $food = [], $table = [], $type = [], $area = [];
    public $order = [], $orderdetail = [];
    function __construct()
    {
        if (
            !isset($_SESSION['user_logged']['roles']['admin']) &&
            !isset($_SESSION['user_logged']['roles']['staff'])
        ) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->food = $this->model('FoodModel');
            $this->table = $this->model('TableModel');
            $this->type = $this->model('TypeModel');
            $this->tempinvoice = $this->model('TempInvoiceModel');
            $this->invoice = $this->model('InvoiceModel');
            $this->area = $this->model('AreaModel');
            $this->order = $this->model('OrderModel');
            $this->orderdetail = $this->model('OrderDetailModel');
            $this->data['content'] = 'BillViews/';
        }
    }
    function getInvoiceDetail($billID)
    {
        $this->data['sub_content']['list_order'] = [];
        if (isset($this->invoice->getInvoiceByID($billID)[0])) { //Nếu hóa đơn tồn tại và có đơn đặt đã thanh toán
            foreach ($this->invoice->getInvoiceByID($billID) as $key1 => $value) { //Vòng lập để lấy ra tất đơn đặt đã thanh toán của hóa đơn đó
                array_push($this->data['sub_content']['list_order'], $value); //Gán vào biết $data['sub_content]['orders']
            }
        }
        // Tương tự với đơn đặt chưa thanh toán có trong cùng hóa đơn đó
        if (isset($this->tempinvoice->getTempInvoiceByID($billID)[0])) {
            foreach ($this->tempinvoice->getTempInvoiceByID($billID) as $key2 => $value) {
                array_push($this->data['sub_content']['list_order'], $value);
            }
        }
        if (count($this->data['sub_content']['list_order']) > 0) {
            $this->data['content'] .= 'bill_detail';
            $this->data['sub_content']['list_food'] = [];
            $this->data['sub_content']['list_type'] = [];
            $this->data['sub_content']['table'] = $this->table->getTableByID($this->data['sub_content']['list_order'][0]['tableID']);
            $this->data['sub_content']['area'] = $this->area->getAreaByID($this->data['sub_content']['table']['areaID']);
            $this->data['sub_content']['total_paid'] = 0;
            $this->data['sub_content']['total_unpaid'] = 0;
            $this->data['sub_content']['info_paid'] = $this->invoice->getInvoiceByID($billID);
            $this->data['sub_content']['info_unpaid'] = $this->tempinvoice->getTempInvoiceByID($billID);
            foreach ($this->data['sub_content']['list_order'] as $key => $value) {
                if (isset($value['status'])) {
                    if ($value['status'] == 1) {
                        $this->data['sub_content']['total_paid'] += $value['total']; // Tính tổng tiền đã thanh toán
                    } else {
                        $this->data['sub_content']['total_unpaid'] += $value['total']; // Tính tổng tiền chưa thanh toán
                    }
                } else if (isset($value['unpaidbill_status'])) {
                    if ($value['unpaidbill_status'] == 1) {
                        $this->data['sub_content']['total_paid'] += $value['total'];
                    } else {
                        $this->data['sub_content']['total_unpaid'] += $value['total'];
                    }
                }
            }
            $this->render('layouts/staff_layout', $this->data);
        } else {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        }
    }
    function getListInvoice()
    {
        $this->data['content'] .= 'list_bill';
        $this->data['sub_content']['list_food'] = [];
        foreach ($this->food->getListFood() as $key => $value) {
            if ($value['status'] == 0) {
                array_push($this->data['sub_content']['list_food'], $value);
            }
        }
        $this->data['sub_content']['list_table'] = $this->table->getListTable();
        $this->data['sub_content']['list_order'] = $this->order->getListOrder();
        $this->data['sub_content']['list_type'] = $this->type->getListType();
        $this->data['sub_content']['list_paid'] = $this->invoice->getListInvoice();
        $this->data['sub_content']['list_unpaid'] = $this->tempinvoice->getListTempInvoice();
        $this->data['sub_content']['bills'] = [];
        // $this->data['sub_content']['list_table'] = $this->table->getListTable();
        if (isset($this->invoice->getAggregatedInvoiceList()[0])) {
            foreach ($this->invoice->getAggregatedInvoiceList() as $key => $value) {
                array_push($this->data['sub_content']['bills'], $value);
            }
        }
        $this->render('layouts/user_layout', $this->data);
    }
}