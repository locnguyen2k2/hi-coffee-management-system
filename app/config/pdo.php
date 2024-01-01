<?php

function database() // Kết nối database
{

    $host_name = "localhost";
    $db_name = $_ENV["db_name"];
    $username = $_ENV["username"];
    $password = $_ENV["password"];
    $conn = new PDO("mysql:host=$host_name;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Lỗi sẽ được báo lỗi
    return $conn;
}
function pdo_execute($sql) // Thực thi câu lệnh SQL
{
    $sql_args = array_slice(func_get_args(), 1); // Lấy các tham số truyền vào
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
function pdo_query($sql) // Trả về nhiều dữ liệu
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = database();
        $a = $conn->prepare($sql);
        $a->execute($sql_args);
        $rows = $a->fetchAll();
        return $rows;
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
function pdo_query_one($sql) // Trả về 1 dữ liệu
{
    $sql_args = array_slice(func_get_args(), 1);
    try {
        $conn = database();
        $a = $conn->prepare($sql);
        $a->execute($sql_args);
        $row = $a->fetch(PDO::FETCH_ASSOC); // Trả về 1 dòng dữ liệu
        return $row;
    } catch (PDOException $e) {
        throw $e;
    } finally {
        unset($conn);
    }
}
?>