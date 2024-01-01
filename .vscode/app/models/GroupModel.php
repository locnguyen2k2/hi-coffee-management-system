<?php
class GroupModel
{
    function groups()
    {
        $sql = "SELECT *  FROM tbl_groups";
        $row = pdo_query($sql);
        return $row;
    }
    function add_group($name)
    {
        $sql = "INSERT INTO tbl_groups(name) values('$name');";
        pdo_execute($sql);
    }
    function groups_id($id)
    {
        $sql = "SELECT *  FROM tbl_groups WHERE id = $id";
        $row = pdo_query_one($sql);
        return $row;
    }
    function update_group($id, $name)
    {
        $sql = "UPDATE tbl_groups SET name = '$name' WHERE id = $id;";
        pdo_execute($sql);
    }
}
