<?php
class RoleModel
{
    // Lấy danh sách các nhóm người dùng
    function getListRole()
    {
        $sql = "SELECT tbl_role.id, tbl_role.name FROM tbl_role";
        $row = pdo_query($sql);
        return $row;
    }
    // Thêm nhóm người dùng mới: truyền vào tên
    function addRole($name)
    {
        $sql = "INSERT INTO tbl_role(name) values('$name');";
        pdo_execute($sql);
    }
    // Lấy tên của nhóm người dùng bằng ID
    function getRoleByID($id)
    {
        $sql = "SELECT tbl_role.id, tbl_role.name FROM tbl_role WHERE id = $id";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Cập nhật tên nhóm người dùng: truyền vào ID và tên mới
    function updateRole($id, $name)
    {
        $sql = "UPDATE tbl_role SET name = '$name' WHERE id = $id;";
        pdo_execute($sql);
    }
}