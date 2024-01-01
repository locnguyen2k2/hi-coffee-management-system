<?php
class UserModel
{
    function users()
    {
        $sql = "SELECT *  FROM tbl_users";
        $row = pdo_query($sql);
        return $row;
    }
    function accounts()
    {
        $sql = "SELECT * FROM tbl_users;";
        $row = pdo_query($sql);
        return $row;
    }
    function account_name($username)
    {
        $sql = "SELECT * FROM tbl_users WHERE username = '$username';";
        $row = pdo_query_one($sql);
        return $row;
    }
    function account_id($id)
    {
        $sql = "SELECT * FROM tbl_users WHERE id = $id;";
        $row = pdo_query_one($sql);
        return $row;
    }
    function add_account($fname, $lname, $username, $password, $phonenumb, $email)
    {
        $sql = "INSERT INTO tbl_users (fname, lname, username, password, number, email) values ('$fname','$lname','$username','$password',$phonenumb,'$email');";
        pdo_execute($sql);
    }
    function update_user($id, $fname, $lname, $number, $email, $status, $username, $password)
    {
        $sql = "UPDATE tbl_users SET fname = '$fname', lname = '$lname', number = $number, email = '$email', status = $status, username = '$username', password = '$password' WHERE id = $id;";
        pdo_execute($sql);
    }
}
