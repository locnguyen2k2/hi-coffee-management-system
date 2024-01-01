<?php
class TableController extends Controller
{
    public $area = [];
    public $table = [];
    public $data = [];
    function __construct()
    {
        $this->area = $this->model('AreaModel');
        $this->table = $this->model('TableModel');
    }
    function getListTable()
    {
        $this->data['data']['list_table'] = $this->table->getListTable();
        $this->data['data']['list_area'] = $this->area->getListArea();
        $this->data['error'] = 0;
        echo json_encode($this->data);
    }
}