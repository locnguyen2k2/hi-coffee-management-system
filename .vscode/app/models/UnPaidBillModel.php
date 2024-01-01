<?php
class UnPaidBillModel
{
    function unpaid_bills()
    {
        $sql = "SELECT * FROM tbl_hoadon_tam ORDER BY ma_hoadon DESC";
        $row = pdo_query($sql);
        return $row;
    }
    function add_unpaid_bill($billID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total)
    {
        $sql = "INSERT INTO tbl_hoadon_tam (ma_hoadon, ma_ban, ma_dondat, ma_mon, ma_loai, gia, so_luong, thanh_tien) values ($billID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total);";
        pdo_execute($sql);
    }
    function update_unpaid_bill($unpaidBillID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total)
    {
        $sql = "UPDATE tbl_hoadon_tam SET ma_hoadon = $unpaidBillID, ma_ban = $tableID, ma_mon = $foodID, ma_loai = $typeID, gia = $price, so_luong = $quantity, thanh_tien = $total WHERE ma_dondat = $orderID";
        pdo_execute($sql);
    }
    function unpaid_bill_order_id($orderID)
    {
        $sql = "SELECT * FROM tbl_hoadon_tam WHERE ma_dondat = $orderID;";
        $row = pdo_query_one($sql);
        return $row;
    }
    function unpaid_bills_table_id($tableID)
    {
        $sql = "SELECT * FROM tbl_hoadon_tam WHERE ma_ban = $tableID;";
        $row = pdo_query($sql);
        return $row;
    }
    function unpaid_bills_bill_id($billID)
    {
        $sql = "SELECT * FROM tbl_hoadon_tam WHERE ma_hoadon = $billID";
        $row = pdo_query($sql);
        return $row;
    }
}
