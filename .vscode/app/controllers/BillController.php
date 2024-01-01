<?php
class BillController extends Controller
{
    public $data = [], $unpaidBills = [], $paidBills = [], $foods = [], $tables = [], $types = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['groups']['admin_permission']) && !isset($_SESSION['user_logged']['groups']['staff_permission'])) {
            header('Location: ' . _WEB_ROOT . '/HomeController/index');
        } else {
            $this->foods = $this->model('FoodModel');
            $this->tables = $this->model('TableModel');
            $this->types = $this->model('TypeModel');
            $this->unpaidBills = $this->model('UnPaidBillModel');
            $this->paidBills = $this->model('PaidBillModel');
            $this->data['content'] = 'BillView/';
        }
    }
    function bill_detail($orderID)
    {
        if (isset($this->unpaidBills->unpaid_bill_order_id($orderID)['ma_hoadon'])) {
            $unpaidBills = $this->unpaidBills->unpaid_bills_bill_id($this->unpaidBills->unpaid_bill_order_id($orderID)['ma_hoadon']);
            $this->data['sub_content']['tableNameUnpaid'] = $this->tables->table_id($unpaidBills[0]['ma_ban'])['ten_ban'];
            $this->data['sub_content']['unpaidBills'] = $unpaidBills;
            if (isset($this->paidBills->paid_bills_bill_id($unpaidBills[0]['ma_hoadon'])[0]['ma_hoadon'])) {
                $paidBills = $this->paidBills->paid_bills_bill_id($unpaidBills[0]['ma_hoadon']);
                $this->data['sub_content']['tableNamePaid'] = $this->tables->table_id($paidBills[0]['ma_ban'])['ten_ban'];
                $this->data['sub_content']['paidBills'] = $paidBills;
            }
        } else if (isset($this->paidBills->paid_bill_order_id($orderID)['ma_hoadon'])) {
            $paidBills = $this->paidBills->paid_bills_bill_id($this->paidBills->paid_bill_order_id($orderID)['ma_hoadon']);
            $this->data['sub_content']['tableNamePaid'] = $this->tables->table_id($paidBills[0]['ma_ban'])['ten_ban'];
            $this->data['sub_content']['paidBills'] = $paidBills;
            if (isset($this->unpaidBills->unpaid_bills_bill_id($paidBills[0]['ma_hoadon'])[0]['ma_hoadon'])) {
                $unpaidBills = $this->unpaidBills->unpaid_bills_bill_id($paidBills[0]['ma_hoadon']);
                $this->data['sub_content']['tableNameUnpaid'] = $this->tables->table_id($unpaidBills[0]['ma_ban'])['ten_ban'];
                $this->data['sub_content']['unpaidBills'] = $unpaidBills;
            }
        }
        if (isset($unpaidBills)) {
            foreach ($unpaidBills as $key => $value) {
                foreach ($this->foods->food() as $key1 => $value1) {
                    if ($value1['ma_mon'] == $value['ma_mon'] && !isset($this->data['sub_content']['foods'][$value['ma_mon']])) {
                        $this->data['sub_content']['foods'][$value['ma_mon']] = $value1['ten_mon'];
                    }
                }
                foreach ($this->types->types() as $key1 => $value1) {
                    if ($value1['ma_loai'] == $value['ma_loai'] && !isset($this->data['sub_content']['types'][$value['ma_loai']])) {
                        $this->data['sub_content']['types'][$value['ma_loai']] = $value1['ten_loai'];
                    }
                }
            }
        }
        if (isset($paidBills)) {
            foreach ($paidBills as $key => $value) {
                foreach ($this->foods->food() as $key1 => $value1) {
                    if ($value1['ma_mon'] == $value['ma_mon'] && !isset($this->data['sub_content']['foods'][$value['ma_mon']])) {
                        $this->data['sub_content']['foods'][$value['ma_mon']] = $value1['ten_mon'];
                    }
                }
                foreach ($this->types->types() as $key1 => $value1) {
                    if ($value1['ma_loai'] == $value['ma_loai'] && !isset($this->data['sub_content']['types'][$value['ma_loai']])) {
                        $this->data['sub_content']['types'][$value['ma_loai']] = $value1['ten_loai'];
                    }
                }
            }
        }
        if (!isset($unpaidBills) && !isset($paidBills)) {
            header('Location: ' . _WEB_ROOT . '/OrderController/add_order');
        } else {
            $this->data['content'] .= 'bill_detail';
            $this->data['sub_content']['foods'] = [];
            $this->data['sub_content']['types'] = [];
            $this->render('layouts/staff_layout', $this->data);
        }
    }
}
