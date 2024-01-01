<?php
class FoodController extends Controller
{
    public $data = [], $foods = [], $types = [], $clients = [];
    public function __construct()
    {
        $this->foods = $this->model('FoodModel');
        $this->types = $this->model('TypeModel');
    }
    function getListFood()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type_id']) && $this->types->getTypeByID($_POST['type_id'])) {
            $this->data['data'] = $this->foods->getListFoodByType($_POST['type_id']);
        } else {
            $this->data['data'] = $this->foods->getListFood();
        }
        $this->data['error'] = 0;
        echo json_encode($this->data);
    }

}
?>