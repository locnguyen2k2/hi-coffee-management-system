<?php
class OrderModel
{
    function orders()
    {
        $sql = "SELECT * FROM tbl_dondat ORDER BY created_at DESC;";
        $row = pdo_query($sql);
        return $row;
    }
    function update_order($orderID, $foodID, $quantity)
    {
        $sql = "UPDATE tbl_dondat SET ma_mon = $foodID, so_luong = $quantity WHERE ma_dondat = $orderID;";
        pdo_execute($sql);
    }
    function add_order($orderID, $foodID, $quantity)
    {
        $sql = "INSERT INTO tbl_dondat (ma_dondat, ma_mon, so_luong) values ($orderID, $foodID, $quantity);";
        pdo_execute($sql);
    }
    function delete_order($id)
    {
        $sql = "DELETE FROM tbl_hoadon_tam WHERE ma_dondat = $id;  DELETE FROM tbl_chitietdondat WHERE ma_dondat = $id; DELETE FROM tbl_dondat WHERE ma_dondat = $id";
        pdo_execute($sql);
    }
}
