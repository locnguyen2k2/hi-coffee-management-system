<?php
class TempInvoiceModel
{

    function getListTempInvoice()
    {
        $sql = "SELECT tbl_temp_invoice.id, tbl_temp_invoice.orderID, tbl_temp_invoice.foodID,
        tbl_temp_invoice.quantity, tbl_temp_invoice.total, tbl_temp_invoice.status,
        tbl_temp_invoice.created_at, tbl_temp_invoice.updated_at, tbl_temp_invoice.tableID,
        tbl_temp_invoice.typeID, tbl_temp_invoice.price, tbl_temp_invoice.username
        FROM tbl_temp_invoice ORDER BY id DESC ";
        $row = pdo_query($sql);
        return $row;
    }
    // Lấy ds thông tin của hóa đơn chưa thanh toán
    function getUnpaidAggregatedInvoiceList()
    {
        $sql = "SELECT id, tableID, count(orderID) as quantity,sum(total) as total, created_at, updated_at, username FROM tbl_temp_invoice GROUP BY id DESC";
        $row = pdo_query($sql);
        return $row;
    }
    function getTempInvoiceByID($billID)
    {
        $sql = "SELECT tbl_temp_invoice.id, tbl_temp_invoice.orderID, tbl_temp_invoice.foodID,
        tbl_temp_invoice.quantity, tbl_temp_invoice.total, tbl_temp_invoice.status,
        tbl_temp_invoice.created_at, tbl_temp_invoice.updated_at, tbl_temp_invoice.tableID,
        tbl_temp_invoice.typeID, tbl_temp_invoice.price, tbl_temp_invoice.username, 
        tbl_type.name as typeName, tbl_food.name as foodName, tbl_table.name as tableName FROM tbl_temp_invoice, tbl_food, tbl_type, tbl_table WHERE tbl_temp_invoice.id = $billID AND tbl_temp_invoice.foodID = tbl_food.id AND tbl_type.id = tbl_temp_invoice.typeID AND tbl_temp_invoice.tableID = tbl_table.id ORDER BY tbl_temp_invoice.id DESC";
        $row = pdo_query($sql);
        return $row;
    }
    // Thêm hóa đơn chưa thanh toán
    function addTempInvoice($billID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total, $username)
    {
        $sql = "INSERT INTO tbl_temp_invoice(id, tableID, orderID, foodID, typeID, price, quantity, total, username) values ($billID, $tableID, $orderID, $foodID, $typeID, $price, $quantity, $total, '$username');";
        pdo_execute($sql);
    }
    // Cập nhật hóa đơn chưa thanah toán
    function updateTempInvoice($unpaidBillID, $tableID, $orderID, $foodOldID, $foodID, $typeID, $price, $quantity, $total, $username)
    {
        $sql = "UPDATE tbl_temp_invoice SET id = $unpaidBillID, tableID = $tableID, foodID = $foodID, typeID = $typeID, price = $price, quantity = $quantity, total = $total, username = '$username' WHERE orderID = $orderID AND foodID = $foodOldID;";
        pdo_execute($sql);
    }
    // Cập nhật hóa đơn chưa thanha toán băng mã đơn đjăt
    function getTempInvoiceByOrder($orderID, $foodID)
    {
        $sql = "SELECT tbl_temp_invoice.id, tbl_temp_invoice.orderID, tbl_temp_invoice.foodID,
        tbl_temp_invoice.quantity, tbl_temp_invoice.total, tbl_temp_invoice.status,
        tbl_temp_invoice.created_at, tbl_temp_invoice.updated_at, tbl_temp_invoice.tableID,
        tbl_temp_invoice.typeID, tbl_temp_invoice.price, tbl_temp_invoice.username 
        FROM tbl_temp_invoice WHERE orderID = $orderID AND foodID = $foodID;";
        $row = pdo_query($sql);
        return $row;
    }
    function getTempInvoiceByTable($tableID)
    {
        $sql = "SELECT tbl_temp_invoice.id, tbl_temp_invoice.orderID, tbl_temp_invoice.foodID,
        tbl_temp_invoice.quantity, tbl_temp_invoice.total, tbl_temp_invoice.status,
        tbl_temp_invoice.created_at, tbl_temp_invoice.updated_at, tbl_temp_invoice.tableID,
        tbl_temp_invoice.typeID as typeID, tbl_temp_invoice.price, tbl_temp_invoice.username
        FROM tbl_temp_invoice WHERE tableID = $tableID;";
        $row = pdo_query($sql);
        return $row;
    }
}