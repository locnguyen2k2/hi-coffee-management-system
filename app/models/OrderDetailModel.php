<?php
class OrderDetailModel
{
    // Lấy chi tiết đơn đặt dựa vào ID đơn dặt
    function getOrderDetail($id, $foodID)
    {
        $sql = "SELECT tbl_order_detail.id, tbl_order_detail.orderID, 
        tbl_order_detail.tableID, tbl_order_detail.foodID, tbl_order_detail.typeID, tbl_order_detail.price, 
        tbl_order_detail.quantity, tbl_order_detail.total 
        FROM tbl_order_detail WHERE orderID = $id AND foodID = $foodID;";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Lấy danh sách chi tiết đơn đặt, mới nhất.
    function getListOrderDetail()
    {
        $sql = "SELECT tbl_order_detail.id , tbl_order_detail.orderID, tbl_order_detail.tableID, tbl_order_detail.foodID, tbl_order_detail.typeID, tbl_order_detail.price, tbl_order_detail.quantity, tbl_order_detail.total FROM tbl_order_detail ORDER BY created_at DESC;";
        $row = pdo_query($sql);
        return $row;
    }
    // Cập nhật trạng thái của chi tiết đơn đặt bằng mã đơn đặt
    function updateOrderDetailStatus($id, $foodID, $status)
    {
        $sql = "UPDATE tbl_order_detail SET status = $status WHERE orderID = $id AND foodID = $foodID;";
        pdo_execute($sql);
    }
    // Thêm chi tiết đơn đặt mới: mã đơn đặt, mã bàn, mã món, mã loại, giá, số lượng, tổng
    function addOrderDetail($orderID, $tableID, $foodID, $typeID, $price, $quantity, $total)
    {
        $sql = "INSERT INTO tbl_order_detail(orderID, tableID, foodID, typeID, price, quantity, total) values ($orderID, $tableID, $foodID, $typeID, $price, $quantity, $total);";
        pdo_execute($sql);
    }
    // cập nhật chi tiết đơn đặt: mã đơn đặt, mã bàn, mã món, mã loại, giá, số lượng, tổng
    function updateOrderDetail($orderID, $foodOldID, $tableID, $foodID, $typeID, $price, $quantity, $total)
    {
        $sql = "UPDATE tbl_order_detail SET tableID = $tableID, foodID = $foodID, typeID = $typeID, price = $price, quantity = $quantity, total = $total WHERE orderID = $orderID AND foodID = $foodOldID;";
        pdo_execute($sql);
    }
    // lấy danh sách chi tiết đơn đặt dựa thoe mã bàn
    function getOrderDetailTable($tableID)
    {
        $sql = "SELECT * FROM tbl_order_detail WHERE tableID = $tableID;";
        $row = pdo_query($sql);
        return $row;
    }
}