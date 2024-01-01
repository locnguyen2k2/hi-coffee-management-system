<?php
class ImageModel
{
    // Lấy danh sách hình ảnh
    function getListImage()
    {
        $sql = "SELECT tbl_image.id, tbl_image.name, 
        tbl_image.created_at 
        FROM tbl_image";
        $row = pdo_query($sql);
        return $row;
    }
    // Lấy hình ảnh dựa trên id ảnh.
    function getImageByID($id)
    {
        $sql = "SELECT tbl_image.id, tbl_image.name, 
        tbl_image.created_at
        FROM tbl_image WHERE id = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Lấy hình ảnh dựa trên tên ảnh
    function getImageByName($name)
    {
        $sql = "SELECT tbl_image.id, tbl_image.name, 
        tbl_image.created_at 
        FROM tbl_image WHERE name = '$name';";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Thêm hình ảnh mới
    function addImage($name)
    {
        $sql = "INSERT INTO tbl_image(name)  VALUES ('$name');";
        pdo_execute($sql);
    }
    // Cập nhật hình ảnh dựa trên id ảnh
    function updateImage($id, $name)
    {
        $sql = "UPDATE tbl_image SET name = '$name' WHERE id = $id;";
        pdo_execute($sql);
    }
    // Xóa hình ảnh dựa trên id ảnh
    function deleteImage($id)
    {
        $sql = "DELETE FROM tbl_image WHERE id = $id;";
        pdo_execute($sql);
    }
}