<?php 
class StatisticController extends Controller
{
    public $statistic = [];
    public $data = [];
    function __construct()
    {
        if (!isset($_SESSION['user_logged']['roles']['admin'])) {
            header('Location: ' . _WEB_ROOT . '/trang-chu');
        } else {
            $this->statistic = $this->model('StatisticModel');
            $this->data['content'] = 'StatisticViews/statistic';
        }
    }
    function Statistic()
    {
        $this->data['sub_content'] = [];
        $this->render('layouts/admin_layout', $this->data);
    }
    function getDailyInvoiceStatistic()
    {
        if (isset($_POST['statistical_type']) && $_POST['statistical_type'] == 'day') {
            $date = $_POST['from'];
            $draw = $this->statistic->getDailyInvoiceStatistic($date, $_POST['statistical_object']);
            $data = [];
            $total = 0;
            foreach ($draw as $key => $value) {
                $item = array(
                    'ten_mon' => $value['foodName'],
                    'so_luong' => $value['quantity'],
                    'thanh_tien' => $value['total'],
                    'ban' => $value['tableName'],
                    'loai' => $value['typeName']
                );
                $data[] = $item;
                $total += $value['total'];
            }
            echo json_encode($data);
        } else {
            $this->data['sub_content'] = [];
            $this->render('layouts/admin_layout', $this->data);
        }
    }
    function getInvoiceStatisticsInRange()
    {
        if (isset($_POST['statistical_type']) && $_POST['statistical_type'] == 'range') {
            $from = $_POST['from'];
            $to = $_POST['to'];
            $draw = $this->statistic->getInvoiceStatisticsInRange($from, $to, $_POST['statistical_object']);
            $data = [];
            $total = 0;
            foreach ($draw as $key => $value) {
                $item = array(
                    'ten_mon' => $value['foodName'],
                    'so_luong' => $value['quantity'],
                    'thanh_tien' => $value['total'],
                    'ban' => $value['tableName'],
                    'loai' => $value['typeName']
                );
                $total += $value['total'];
                $data[] = $item;
            }
            echo json_encode($data);
        } else {
            $this->data['sub_content'] = [];
            $this->render('layouts/admin_layout', $this->data);
        }
    }
}