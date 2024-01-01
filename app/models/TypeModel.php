<?php
class TypeModel
{

    // Lấy ds loại
    function getListType()
    {
        $sql = "SELECT tbl_type.id, tbl_type.name,
        tbl_type.status, tbl_type.created_at, tbl_type.updated_at
        FROM tbl_type";
        $row = pdo_query($sql);
        return $row;
    }
    // Tìm thông tin loại theo tên
    function getTypeByName($name)
    {
        $sql = "SELECT tbl_type.id, tbl_type.name,
        tbl_type.status, tbl_type.created_at, tbl_type.updated_at 
        FROM tbl_type WHERE name = '$name'";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Tìm thông tin loại theo mã 
    function getTypeByID($id)
    {
        $sql = "SELECT tbl_type.id, tbl_type.name,
        tbl_type.status, tbl_type.created_at, tbl_type.updated_at
        FROM tbl_type WHERE id = $id";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Thêm loại mới
    function addType($name)
    {
        $sql = "INSERT INTO tbl_type(name) VALUES ('$name');";
        pdo_execute($sql);
    }
    // Cập nhật tên loại
    function updateType($id, $name, $status)
    {
        $sql = "UPDATE tbl_type SET name = '$name', status = $status WHERE id = $id;";
        pdo_execute($sql);
    }
}