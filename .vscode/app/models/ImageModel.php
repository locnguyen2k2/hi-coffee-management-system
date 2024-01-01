<?php
class ImageModel
{
    function images()
    {
        $sql = "SELECT * FROM tbl_hinhanh";
        $row = pdo_query($sql);
        return $row;
    }
    function images_id($id)
    {
        $sql = "SELECT * FROM tbl_hinhanh WHERE ma_hinhanh = $id;";
        $row = pdo_query($sql);
        return $row;
    }
    function image_name($name)
    {
        $sql = "SELECT * FROM tbl_hinhanh WHERE ten_hinhanh = '$name';";
        $row = pdo_query_one($sql);
        return $row;
    }
    function add_image($name)
    {
        $sql = "INSERT INTO tbl_hinhanh(ten_hinhanh)  VALUES ('$name');";
        pdo_execute($sql);
    }
}
