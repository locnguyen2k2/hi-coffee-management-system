<?php
class TableModel
{
    // Lấy ds bàn
    function getListTable()
    {
        $sql = "SELECT tbl_table.id, tbl_table.name, tbl_table.areaID, tbl_table.status FROM tbl_table";
        $row = pdo_query($sql);
        return $row;
    }
    // Tìm thông tin bàn theo mã bàn
    function getTableByID($id)
    {
        $sql = "SELECT tbl_table.id, tbl_table.name, tbl_table.areaID, tbl_table.status FROM tbl_table WHERE id = $id";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Tìm thông tin bàn theo tên
    function getTableByName($name)
    {
        $sql = "SELECT tbl_table.id, tbl_table.name, tbl_table.areaID, tbl_table.status FROM tbl_table WHERE name = '$name';";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Thêm bàn mới (tên, mã khu)
    function addTable($name, $areaID)
    {
        $sql = "INSERT INTO tbl_table(name, areaID) values ('$name', $areaID);";
        pdo_execute($sql);
    }
    // Cập nhật thông tin bàn (mã bàn, tên, mã khu, trạng thái)
    function updateTable($id, $name, $areaID, $status)
    {
        $sql = "UPDATE tbl_table SET name = '$name', areaID = $areaID, status = $status WHERE id = $id;";
        pdo_execute($sql);
    }
    // Cập nhật trạng thái của bàn(mã bàn)
    function updateTableStatus($id, $status)
    {
        $sql = "UPDATE tbl_table SET status = $status WHERE id = $id;";
        pdo_execute($sql);
    }
}