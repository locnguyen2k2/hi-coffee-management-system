<?php
class PaidBillModel
{
    function paid_bills()
    {
        $sql = "SELECT * FROM tbl_hoadon ORDER BY ma_hoadon DESC";
        $row = pdo_query($sql);
        return $row;
    }
    function paid_bills_table_id($tableID)
    {
        $sql = "SELECT * FROM tbl_hoadon WHERE ma_ban = $tableID;";
        $row = pdo_query($sql);
        return $row;
    }
    function paid_bill_order_id($orderID)
    {
        $sql = "SELECT * FROM tbl_hoadon WHERE ma_dondat = $orderID;";
        $row = pdo_query_one($sql);
        return $row;
    }
    function paid_bills_bill_id($billID)
    {
        $sql = "SELECT * FROM tbl_hoadon WHERE ma_hoadon = $billID";
        $row = pdo_query($sql);
        return $row;
    }
    function add_bill_paid($billID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total)
    {
        $sql = "INSERT INTO tbl_hoadon (ma_hoadon, ma_ban, ma_dondat, ma_mon, ma_loai, gia, so_luong, thanh_tien) values ($billID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total);";
        pdo_execute($sql);
    }
    function update_bill_paid_order_id_status($orderID, $status)
    {
        $sql = "UPDATE tbl_hoadon SET trang_thai = $status WHERE ma_dondat = $orderID;";
        pdo_execute($sql);
    }
    function delete_bill_paid($orderID)
    {
        $sql = "DELETE FROM tbl_hoadon_tam WHERE ma_dondat = $orderID;";
        pdo_execute($sql);
    }
}
