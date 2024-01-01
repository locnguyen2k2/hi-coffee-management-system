<?php
class FoodModel
{
    function food()
    {
        $sql = "SELECT *  FROM tbl_mon";
        $row = pdo_query($sql);
        return $row;
    }
    function add_food($name, $type, $price)
    {
        $sql = "INSERT INTO tbl_mon(ten_mon, ma_loai, gia_mon) VALUES ('$name', $type, $price);";
        pdo_execute($sql);
    }
    function food_name($name)
    {
        $sql = "SELECT * FROM tbl_mon WHERE ten_mon = '$name';";
        $row = pdo_query_one($sql);
        return $row;
    }
    function food_id($id)
    {
        $sql = "SELECT * FROM tbl_mon WHERE ma_mon = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    function update_food($id, $name, $type, $price, $status)
    {
        $sql = "UPDATE tbl_mon SET ten_mon = '$name', ma_loai = $type, gia_mon = $price, trang_thai = $status WHERE ma_mon = $id;";
        pdo_execute($sql);
    }
}
