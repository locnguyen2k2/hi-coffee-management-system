<?php
class OrderModel
{
    // Lấy danh sách đơn đặt
    function getListOrder()
    {
        $sql = "SELECT tbl_order.id, tbl_order.foodID, tbl_order.quantity, tbl_order.created_at, tbl_order.updated_at FROM tbl_order ORDER BY created_at DESC;";
        $row = pdo_query($sql);
        return $row;
    }
    // Cập nhật đơn đặt: Mã đơn đặt, mã món, số lượng
    function updateOrder($orderID, $foodOldID, $foodID, $quantity)
    {
        $sql = "UPDATE tbl_order SET foodID = $foodID, quantity = $quantity WHERE id = $orderID AND foodID = $foodOldID;";
        pdo_execute($sql);
    }
    // Thêm đơn đặt mới: mã đơn đặt, mã món, số lượng
    function addOrder($orderID, $foodID, $quantity)
    {
        $sql = "INSERT INTO tbl_order(id, foodID, quantity) values ($orderID, $foodID, $quantity);";
        pdo_execute($sql);
    }
    // Xóa đơn đặt (đơn đặt chưa thanh toán)
    function deleteOrder($id, $foodID)
    {
        $sql = "DELETE FROM tbl_temp_invoice WHERE orderID = $id AND foodID = $foodID;
        DELETE FROM tbl_order_detail WHERE orderID = $id AND foodID = $foodID; 
        DELETE FROM tbl_order WHERE id = $id AND foodID = $foodID;";
        pdo_execute($sql);
    }
}