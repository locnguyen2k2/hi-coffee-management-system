<?php
class PermissionModel
{
    // Xóa thông tin về quyền, phân quyền, người dùng: truyền vào ID cần xóa
    function deletePermission($id)
    {
        $sql = "DELETE FROM tbl_permission WHERE userID = $id; DELETE FROM tbl_user WHERE id = $id";
        pdo_execute($sql);
    }
    // Lấy danh sách phân quyền người dùng
    function getListPermission()
    {
        $sql = "SELECT tbl_permission.id, tbl_permission.userID, 
        tbl_permission.roleID, tbl_permission.status
        FROM tbl_permission;";
        $row = pdo_query($sql);
        return $row;
    }
    // Lấy danh sách phân quyền của một quyền: truyền id quyền
    function getPermissionByID($id)
    {
        $sql = "SELECT tbl_permission.id, tbl_permission.userID,
        tbl_permission.roleID, tbl_permission.status  
        FROM tbl_permission WHERE id ='$id'";
        $row = pdo_query_one($sql);
        return $row;
    }
    // Lấy danh sách phân quyền của một người dùng: truyền vào id người dùng
    function getPermissionByUser($id)
    {
        $sql = "SELECT tbl_permission.id, tbl_permission.userID,
        tbl_permission.roleID, tbl_permission.status 
        FROM tbl_permission WHERE userID ='$id'";
        $row = pdo_query($sql);
        return $row;
    }
    // Cập nhật phân quyền: id phân quyền, id quyền, trạng thái
    function updatePermission($id, $groupID, $status)
    {
        $sql = "UPDATE tbl_permission SET roleID = $groupID, status = $status WHERE id = $id;";
        pdo_execute($sql);
    }
    function updatePermissionStatus($id, $status)
    {
        $sql = "UPDATE tbl_permission SET status = $status WHERE id = $id;";
        pdo_execute($sql);
    }
    // Thêm phân quyền: truyền vào id người dùng và id quyền
    function addPermission($userID, $groupID)
    {
        $sql = "INSERT INTO tbl_permission (userID, roleID) values ($userID, $groupID);";
        pdo_execute($sql);
    }
}