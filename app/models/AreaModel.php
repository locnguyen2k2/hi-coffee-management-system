<?php
class AreaModel
{
    // Lấy danh sách tất cả các khu.
    function getListArea()
    {
        $sql = "SELECT tbl_area.id, tbl_area.name FROM tbl_area";
        $row = pdo_query($sql);
        return $row;
    }
    // Thêm mới một khu.
    function addArea($name)
    {
        $sql = "INSERT INTO tbl_area(name) values('$name');";
        pdo_execute($sql);
    }
    // Lấy thông tin của khu dựa theo tên khu.
    function getAreaByName($name)
    {
        $sql = "SELECT tbl_area.id, tbl_area.name FROM tbl_area WHERE name = '$name';";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Lây thông tin của khu dựa trên id của khu.
    function getAreaByID($id)
    {
        $sql = "SELECT tbl_area.id, tbl_area.name FROM tbl_area WHERE id = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Cập nhật tên khu: truyền vào id và tên mới.
    function updateArea($id, $name)
    {
        $sql = "UPDATE tbl_area SET name = '$name' WHERE id = $id;";
        pdo_execute($sql);
    }
}