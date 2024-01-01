<?php
class StatisticModel
{
    function getDailyInvoiceStatistic($date, $choice)
    {
        $date = date('Y-m-d', strtotime($date));
        $username = $_SESSION['user_logged']['username'];
        $sql = "SELECT orderID, tbl_food.name as foodName, SUM(quantity) AS quantity, SUM(total) AS total, tbl_table.name as tableName, tbl_type.name as typeName
        FROM (
            SELECT orderID, foodID, quantity, total, tableID, typeID 
            FROM tbl_invoice 
            WHERE created_at LIKE '$date%' AND tbl_invoice.username = '$username'
        ) AS invoice
        INNER JOIN tbl_food ON invoice.foodID = tbl_food.id
        INNER JOIN tbl_table ON invoice.tableID = tbl_table.id
        INNER JOIN tbl_type ON invoice.typeID = tbl_type.id
        GROUP BY
            CASE
                WHEN '$choice' = 'mon' THEN tbl_food.id
                WHEN '$choice' = 'ban' THEN tbl_table.id
                WHEN '$choice' = 'loai' THEN tbl_type.id
            END
        ;";
        $row = pdo_query($sql);
        return $row;
    }
    function getInvoiceStatisticsInRange($from, $to, $choice)
    {
        $from = date('Y-m-d', strtotime($from));
        $to = date('Y-m-d', strtotime($to . ' +1 day'));
        $username = $_SESSION['user_logged']['username'];
        $sql = "SELECT orderID, tbl_food.name as foodName, SUM(quantity) AS quantity, SUM(total) AS total, tbl_table.name as tableName, tbl_type.name as typeName
        FROM (
            SELECT orderID, foodID, quantity, total, tableID, typeID 
            FROM tbl_invoice 
            WHERE created_at BETWEEN '$from' AND '$to' AND tbl_invoice.username = '$username'
        ) AS invoice
        INNER JOIN tbl_food ON invoice.foodID = tbl_food.id
        INNER JOIN tbl_table ON invoice.tableID = tbl_table.id
        INNER JOIN tbl_type ON invoice.typeID = tbl_type.id
        GROUP BY
            CASE
                WHEN '$choice' = 'mon' THEN tbl_food.id
                WHEN '$choice' = 'ban' THEN tbl_table.id
                WHEN '$choice' = 'loai' THEN tbl_type.id
            END
        ;";
        $row = pdo_query($sql);
        return $row;
    }
}