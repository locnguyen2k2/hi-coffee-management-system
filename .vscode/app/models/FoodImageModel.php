<?php
class FoodImageModel
{
    function food_image_id($id)
    {
        $sql = "SELECT * FROM tbl_hinhanhmon WHERE mon_id = $id;";
        $row = pdo_query($sql);
        return $row;
    }
    function add_food_image($ma_mon, $ma_hinhanh)
    {
        $sql = "INSERT INTO tbl_hinhanh_mon(ma_mon, ma_hinhanh)  VALUES ($ma_mon, $ma_hinhanh);";
        pdo_execute($sql);
    }
}
