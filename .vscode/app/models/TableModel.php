<?php
class TableModel
{
    function tables()
    {
        $sql = "SELECT * FROM tbl_ban";
        $row = pdo_query($sql);
        return $row;
    }
    function table_id($id)
    {
        $sql = "SELECT * FROM tbl_ban WHERE ma_ban = $id";
        $row = pdo_query_one($sql);
        return $row;
    }
    function table_name($name)
    {
        $sql = "SELECT * FROM tbl_ban WHERE ten_ban = '$name';";
        $row = pdo_query_one($sql);
        return $row;
    }
    function add_table($name, $areaID)
    {
        $sql = "INSERT INTO tbl_ban (ten_ban, ma_khu) values ('$name', '$areaID');";
        pdo_execute($sql);
    }
    function update_table($id, $name, $areaID, $status)
    {
        $sql = "UPDATE tbl_ban SET ten_ban = '$name', ma_khu = $areaID, trang_thai = $status WHERE ma_ban = $id;";
        pdo_execute($sql);
    }
    function update_table_status($id, $status)
    {
        $sql = "UPDATE tbl_ban SET trang_thai = $status WHERE ma_ban = $id;";
        pdo_execute($sql);
    }
}
