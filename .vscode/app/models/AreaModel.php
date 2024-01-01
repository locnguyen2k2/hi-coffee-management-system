<?php
class AreaModel
{
    function areas()
    {
        $sql = "SELECT * FROM tbl_khu";
        $row = pdo_query($sql);
        return $row;
    }
    function add_area($name)
    {
        $sql = "INSERT INTO tbl_khu (ten_khu) values ('$name');";
        pdo_execute($sql);
    }
    function area_name($name)
    {
        $sql = "SELECT * FROM tbl_khu WHERE ten_khu = '$name';";
        $row = pdo_query_one($sql);
        return $row;
    }
    function area_id($id)
    {
        $sql = "SELECT * FROM tbl_khu WHERE ma_khu = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    function update_area($id, $name)
    {
        $sql = "UPDATE tbl_khu SET ten_khu = '$name' WHERE ma_khu = $id;";
        pdo_execute($sql);
    }
}
