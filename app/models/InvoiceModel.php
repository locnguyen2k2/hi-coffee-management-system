<?php
class InvoiceModel
{
    // Lấy ds hóa đơn đã thanh toán
    function getListInvoice()
    {
        $sql = "SELECT tbl_invoice.id, tbl_invoice.orderID, tbl_invoice.foodID,
        tbl_invoice.quantity, tbl_invoice.total, tbl_invoice.status,
        tbl_invoice.created_at, tbl_invoice.updated_at, tbl_invoice.tableID,
        tbl_invoice.typeID, tbl_invoice.price, tbl_invoice.username
        FROM tbl_invoice ORDER BY id DESC";
        $row = pdo_query($sql);
        return $row;
    }
    // Lấy thông tin về: mã hóa đơn, mã bàn, số đơn, số lượng, tổng tiền, ngày thuộc hóa đơn đã thanh toán
    function getAggregatedInvoiceList()
    {
        $sql = "SELECT id, tableID, count(orderID) as quantity,sum(total), created_at, updated_at, username FROM tbl_invoice GROUP BY id DESC";
        $row = pdo_query($sql);
        return $row;
    }
    function getInvoiceByID($billID)
    {
        $sql = "SELECT tbl_invoice.id, tbl_invoice.orderID, tbl_invoice.foodID,
        tbl_invoice.quantity, tbl_invoice.total, tbl_invoice.status,
        tbl_invoice.created_at, tbl_invoice.updated_at, tbl_invoice.tableID,
        tbl_invoice.typeID, tbl_invoice.price, tbl_invoice.username, 
        tbl_food.name as foodName, tbl_type.name as typeName, tbl_table.name FROM tbl_invoice, tbl_food, tbl_table, tbl_type WHERE tbl_invoice.id = $billID AND tbl_food.id = tbl_invoice.foodID AND tbl_table.id = tbl_invoice.tableID AND tbl_type.id = tbl_invoice.typeID;";
        $row = pdo_query($sql);
        return $row;
    }
    // Lấy danh sách hóa đơn đã thanh toán theo mã bàn
    function getInvoiceByTable($tableID)
    {
        $sql = "SELECT tbl_invoice.id, tbl_invoice.orderID, tbl_invoice.foodID,
        tbl_invoice.quantity, tbl_invoice.total, tbl_invoice.status,
        tbl_invoice.created_at, tbl_invoice.updated_at, tbl_invoice.tableID,
        tbl_invoice.typeID, tbl_invoice.price, tbl_invoice.username,
        tbl_food.name
        FROM tbl_invoice, tbl_food WHERE tbl_invoice.tableID = $tableID AND tbl_invoice.foodID = tbl_food.id
        ORDER BY tbl_invoice.id DESC;";
        $row = pdo_query($sql);
        return $row;
    }
    // Lấy ds hóa đơn đã thanh toán theo mã đơn đặt
    function getInvoiceByOrder($orderID)
    {
        $sql = "SELECT tbl_invoice.id, tbl_invoice.orderID, tbl_invoice.foodID,
        tbl_invoice.quantity, tbl_invoice.total, tbl_invoice.status,
        tbl_invoice.created_at, tbl_invoice.updated_at, tbl_invoice.tableID,
        tbl_invoice.typeID, tbl_invoice.price, tbl_invoice.username 
        FROM tbl_invoice WHERE tbl_invoice.orderID = $orderID;";
        $row = pdo_query($sql);
        return $row;
    }
    // Thêm hóa đơn đã thanh toán (mã hóa đơn, mã bàn, mã đơn đjăt, mã món, mã loại, giá, số lượng, tổng)
    function addInvoice($billID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total, $username)
    {
        $sql = "INSERT INTO tbl_invoice(id, tableID, orderID, foodID, typeID, price, quantity, total, username) values ($billID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total, '$username');";
        pdo_execute($sql);
    }
    // Cập nhật trạng thóa hóa đơn đã thanh toán dựa theo mã đơn đạt
    function updateInvoiceStatusByOrder($orderID, $foodID, $status)
    {
        $sql = "UPDATE tbl_invoice SET tbl_invoice.status = $status WHERE tbl_invoice.orderID = $orderID AND tbl_invoice.foodID = $foodID;";
        pdo_execute($sql);
    }
    // Xóa hóa đơn tạm đã thanh toán bằng mã đơn đặt
    function deleteTempInvoice($orderID, $foodID)
    {
        $sql = "DELETE FROM tbl_temp_invoice WHERE tbl_temp_invoice.orderID = $orderID AND tbl_temp_invoice.foodID = $foodID;";
        pdo_execute($sql);
    }
}