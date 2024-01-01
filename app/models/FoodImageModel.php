<?php
class FoodImageModel
{
    // Lấy danh sách hình ảnh của một món bằng ID món.
    function getFoodImageID($id)
    {
        $sql = "SELECT tbl_image_food.id, tbl_image_food.foodID,
        tbl_image_food.imageID, tbl_image_food.created_at
        FROM tbl_image_food WHERE foodID = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Lấy danh sách hình ảnh của một món bằng ID hình ảnh.
    function getFoodImageByImage($id)
    {
        $sql = "SELECT tbl_image_food.id, tbl_image_food.foodID,
        tbl_image_food.imageID, tbl_image_food.created_at
        FROM tbl_image_food WHERE imageID = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    function getFoodImageByFood($id)
    {
        $sql = "SELECT tbl_image_food.id, tbl_image_food.foodID,
        tbl_image_food.imageID, tbl_image_food.created_at
        FROM tbl_image_food WHERE foodID = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Thêm hình ảnh của món: truyền vào mã món và mã hình ảnh
    function addFoodImage($ma_mon, $ma_hinhanh)
    {
        $sql = "INSERT INTO tbl_image_food(foodID, imageID)  VALUES ($ma_mon, $ma_hinhanh);";
        pdo_execute($sql);
    }
    // Xóa hình ảnh của món: truyền vào mã món và mã hình ảnh
    function deleteFoodImage($ma_mon, $ma_hinhanh)
    {
        $sql = "DELETE FROM tbl_image_food WHERE foodID = $ma_mon AND imageID = $ma_hinhanh;";
        pdo_execute($sql);
    }

}