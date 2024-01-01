<?php
class OrderDetailModel
{
    function order_detail_id($id)
    {
        $sql = "SELECT * FROM tbl_chitietdondat WHERE ma_dondat = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    function orders_detail()
    {
        $sql = "SELECT * FROM tbl_chitietdondat ORDER BY created_at DESC;";
        $row = pdo_query($sql);
        return $row;
    }
    function update_order_detail_status_order_id($id, $status)
    {
        $sql = "UPDATE tbl_chitietdondat SET trang_thai = $status WHERE ma_dondat = $id;";
        pdo_execute($sql);
    }
    function add_order_detail($orderID, $tableID, $foodID, $typeID, $price, $quantity, $total)
    {
        $sql = "INSERT INTO tbl_chitietdondat (ma_dondat, ma_ban, ma_mon, ma_loai, gia, so_luong, thanh_tien) values ($orderID, $tableID, $foodID, $typeID, $price, $quantity, $total);";
        pdo_execute($sql);
    }
    function update_order_detail($orderID, $tableID, $foodID, $typeID, $price, $quantity, $total)
    {
        $sql = "UPDATE tbl_chitietdondat SET ma_ban = $tableID, ma_mon = $foodID, ma_loai = $typeID, gia = $price, so_luong = $quantity, thanh_tien = $total WHERE ma_dondat = $orderID;";
        pdo_execute($sql);
    }
    function order_detail_table_id($tableID)
    {
        $sql = "SELECT * FROM tbl_chitietdondat WHERE ma_ban = $tableID;";
        $row = pdo_query($sql);
        return $row;
    }
}
