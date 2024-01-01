<?php
class TypeModel
{

    function types()
    {
        $sql = "SELECT *  FROM tbl_loai";
        $row = pdo_query($sql);
        return $row;
    }
    function type_name($name)
    {
        $sql = "SELECT *  FROM tbl_loai WHERE ten_loai = '$name'";
        $row = pdo_query_one($sql);
        return $row;
    }
    function type_id($id)
    {
        $sql = "SELECT *  FROM tbl_loai WHERE ma_loai = $id";
        $row = pdo_query_one($sql);
        return $row;
    }
    function add_type($name)
    {
        $sql = "INSERT INTO tbl_loai(ten_loai) VALUES ('$name');";
        pdo_execute($sql);
    }
    function update_type($id, $name, $status)
    {
        $sql = "UPDATE tbl_loai SET ten_loai = '$name', trang_thai = $status WHERE ma_loai = $id;";
        pdo_execute($sql);
    }
}
