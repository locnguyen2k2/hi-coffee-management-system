<?php
class FoodModel
{
    // Lấy danh sách món hiện có
    function getListFood()
    {
        $sql = "SELECT
        tbl_food.id , tbl_food.name, tbl_type.name as typeName,
        tbl_food.typeID , tbl_food.price , tbl_food.status , tbl_image.name as imageName 
        FROM tbl_food
        LEFT JOIN (
            SELECT id, foodID, MAX(created_at) AS max_created_at
            FROM tbl_image_food
            GROUP BY id
        ) latest_hinhanh ON tbl_food.id = latest_hinhanh.foodID
        LEFT JOIN tbl_image_food  ON tbl_image_food.id = latest_hinhanh.id AND tbl_image_food.created_at = latest_hinhanh.max_created_at
        LEFT JOIN tbl_image ON tbl_image.id = tbl_image_food.imageID
        JOIN tbl_type  ON tbl_type.id = tbl_food.typeID GROUP BY tbl_food.id";
        $row = pdo_query($sql);
        return $row;
    }
    // Lấy danh sách món hiện có theo loại
    function getListFoodByType($type)
    {
        $sql = "SELECT
        tbl_food.id , tbl_food.name, tbl_type.name as typeName,
        tbl_food.typeID , tbl_food.price , tbl_food.status , tbl_image.name as imageName 
        FROM tbl_food
        LEFT JOIN (
            SELECT id, foodID, MAX(created_at) AS max_created_at
            FROM tbl_image_food
            GROUP BY id
        ) latest_hinhanh ON tbl_food.id = latest_hinhanh.foodID
        LEFT JOIN tbl_image_food  ON tbl_image_food.id = latest_hinhanh.id AND tbl_image_food.created_at = latest_hinhanh.max_created_at
        LEFT JOIN tbl_image ON tbl_image.id = tbl_image_food.imageID
        JOIN tbl_type  ON tbl_type.id = tbl_food.typeID AND tbl_type.id = $type GROUP BY tbl_food.id";
        $row = pdo_query($sql);
        return $row;
    }
    // Thêm một món mới: truyền vào tên, mã loại, giá
    function addFood($name, $type, $price)
    {
        $sql = "INSERT INTO tbl_food(name, typeID, price) VALUES ('$name', $type, $price);";
        pdo_execute($sql);
    }
    // Tìm thông tin của một món bằng tên món.
    function getFoodByName($name)
    {
        $sql = "SELECT tbl_food.id, tbl_food.name,
        tbl_food.typeID, tbl_food.price, tbl_food.status
        FROM tbl_food WHERE name = '$name';";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Tìm thông tin một món bằng ID món
    function getFoodByID($id)
    {
        $sql = "SELECT
        tbl_food.id , tbl_food.name, tbl_type.name as typeName,
        tbl_food.typeID , tbl_food.price , tbl_food.status , tbl_image.name as imageName 
        FROM tbl_food
        LEFT JOIN (
            SELECT id, foodID, MAX(created_at) AS max_created_at
            FROM tbl_image_food
            GROUP BY id
        ) latest_hinhanh ON tbl_food.id = latest_hinhanh.foodID
        LEFT JOIN tbl_image_food  ON tbl_image_food.id = latest_hinhanh.id AND tbl_image_food.created_at = latest_hinhanh.max_created_at
        LEFT JOIN tbl_image ON tbl_image.id = tbl_image_food.imageID and tbl_food.id = $id
        JOIN tbl_type ON tbl_type.id = tbl_food.typeID LIMIT 1";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Cập nhật món: truyền vào id, tên, loại, giá, trạng thái
    function updateFood($id, $name, $type, $price, $status)
    {
        $sql = "UPDATE tbl_food SET name = '$name', typeID = $type, price = $price, status = $status WHERE id = $id;";
        pdo_execute($sql);
    }
    // Xóa món: truyền vào id món
    function deleteFood($id)
    {
        $sql = "DELETE FROM tbl_food WHERE id = $id;";
        pdo_execute($sql);
    }
}
