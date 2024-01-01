<?php
class UserModel
{
    // Lấy ds thông tin người dùng
    function getListUser()
    {
        $sql = "SELECT tbl_user.id, tbl_user.fname, 
        tbl_user.lname, tbl_user.number,
        tbl_user.email, tbl_user.status,
        tbl_user.username, tbl_user.password
        FROM tbl_user";
        $row = pdo_query($sql);
        return $row;
    }
    // Tìm thông tin người dùng bằng tài khoản
    function getUserByUsername($username)
    {
        $sql = "SELECT tbl_user.id, tbl_user.fname, 
        tbl_user.lname, tbl_user.number,
        tbl_user.email, tbl_user.status,
        tbl_user.username, tbl_user.password
        FROM tbl_user WHERE username = '$username';";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Tìm thông tin người dùng bằng mã người dùng
    function getUserByID($id)
    {
        $sql = "SELECT tbl_user.id, tbl_user.fname, 
        tbl_user.lname, tbl_user.number,
        tbl_user.email, tbl_user.status,
        tbl_user.username, tbl_user.password
        FROM tbl_user WHERE id = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Thêm người dùng
    function addUser($fname, $lname, $username, $password, $phonenumb, $email)
    {
        $sql = "INSERT INTO tbl_user (fname, lname, username, password, number, email) values ('$fname','$lname','$username','$password',$phonenumb,'$email');";
        pdo_execute($sql);
    }
    // Cập nhật thông tin người dùng
    function updateUser($id, $fname, $lname, $number, $email, $status, $username, $password)
    {
        $sql = "UPDATE tbl_user SET fname = '$fname', lname = '$lname', number = $number, email = '$email', status = $status, username = '$username', password = '$password' WHERE id = $id;";
        pdo_execute($sql);
    }
    function updateUserStatus($id, $status)
    {
        $sql = "UPDATE tbl_user SET status = $status WHERE id = $id;";
        pdo_execute($sql);
    }
    function updateUserPassword($id, $password)
    {
        $sql = "UPDATE tbl_user SET password = '$password' WHERE id = $id;";
        pdo_execute($sql);
    }
}