<?php
function database()
{
    $host_name = "localhost";
    $db_name = "orderapp";
    $username = "root";
    $password = "";
    $conn = new PDO("mysql:host=$host_name;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
function pdo_execute($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = database();
        $a = $conn->prepare($sql);
        $a->execute($sql_args);
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
function pdo_query($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = database();
        $a = $conn->prepare($sql);
        $a->execute($sql_args);
        $rows = $a->fetchAll(); // fetchAll là trả về tất cả dữ liệu
        return $rows;
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
function pdo_query_one($sql)
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = database();
        $a = $conn->prepare($sql);
        $a->execute($sql_args);
        $row = $a->fetch(PDO::FETCH_ASSOC); // fetch là trả về 1 dữ liệu
        return $row;
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
?>