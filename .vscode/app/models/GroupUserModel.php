<?php
class GroupUserModel
{
    function delete_user($id)
    {
        $sql = "DELETE FROM tbl_group_user WHERE user_id = $id; DELETE FROM tbl_users WHERE id = $id";
        pdo_execute($sql);
    }
    function group_user()
    {
        $sql = "SELECT * FROM tbl_group_user;";
        $row = pdo_query($sql);
        return $row;
    }
    function group_user_id($id)
    {
        $sql = "SELECT *  FROM tbl_group_user WHERE id ='$id'";
        $row = pdo_query_one($sql);
        return $row;
    }
    function group_user_user_id($id)
    {
        $sql = "SELECT *  FROM tbl_group_user WHERE user_id ='$id'";
        $row = pdo_query($sql);
        return $row;
    }
    function add_group_user_user_id($userID, $groupID)
    {
        $sql = "INSERT INTO tbl_group_user(user_id, group_id) values ($userID, $groupID);";
        pdo_execute($sql);
    }

    function update_group_user($id, $groupID, $status)
    {
        $sql = "UPDATE tbl_group_user SET group_id = $groupID, status = $status WHERE id = $id;";
        pdo_execute($sql);
    }
    function add_permission($userID, $groupID)
    {
        $sql = "INSERT INTO tbl_group_user (user_id, group_id) values ($userID, $groupID);";
        pdo_execute($sql);
    }
}
