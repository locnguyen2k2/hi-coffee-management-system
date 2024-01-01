<?php
class StatisticController extends Controller
{
    public $statistic = [];
    public $data = [];
    function __construct()
    {
        $this->statistic = $this->model('StatisticModel');
    }
    function getDailyInvoiceStatistic()
    {
        if (isset($_POST['statistical_type']) && $_POST['statistical_type'] == 'day') {
            $date = $_POST['from'];
            $draw = $this->statistic->getDailyInvoiceStatistic($date, $_POST['statistical_object']);
            $data = [];
            $total = 0;
            $label = '';
            if ($_POST['statistical_object'] == 'ban') {
                $label = 'tableName';
            } else if ($_POST['statistical_object'] == 'mon') {
                $label = 'foodName';
            } else {
                $label = 'typeName';
            }
            foreach ($draw as $key => $value) {
                $item = array(
                    'ten_mon' => $value['foodName'],
                    'loai' => $value['typeName'],
                    'ban' => $value['tableName'],
                    'thanh_tien' => $value['total'],
                    'value' => $value['total'] / 1000,
                    'so_luong' => $value['quantity'],
                    'label' => $value[$label],
                );
                $data[] = $item;
                $total += $value['total'];
            }
            $this->data['error'] = 0;
            $this->data['result'] = $data;
        } else {
            $this->data['error'] = 1;
        }
        echo json_encode($this->data);
    }
    function getInvoiceStatisticsInRange()
    {
        if (isset($_POST['statistical_type']) && $_POST['statistical_type'] == 'range') {
            $from = $_POST['from'];
            $to = $_POST['to'];
            $draw = $this->statistic->getInvoiceStatisticsInRange($from, $to, $_POST['statistical_object']);
            $data = [];
            $total = 0;
            $label = '';
            if ($_POST['statistical_object'] == 'ban') {
                $label = 'tableName';
            } else if ($_POST['statistical_object'] == 'mon') {
                $label = 'foodName';
            } else {
                $label = 'typeName';
            }
            foreach ($draw as $key => $value) {
                $item = array(
                    'ten_mon' => $value['foodName'],
                    'so_luong' => $value['quantity'],
                    'thanh_tien' => $value['total'],
                    'ban' => $value['tableName'],
                    'loai' => $value['typeName'],
                    'label' => $value[$label],
                    'value' => $value['total'] / 1000,
                );
                $total += $value['total'];
                $data[] = $item;
            }
            $this->data['error'] = 0;
            $this->data['result'] = $data;
        } else {
            $this->data['error'] = 1;
        }
        echo json_encode($this->data);
    }
}