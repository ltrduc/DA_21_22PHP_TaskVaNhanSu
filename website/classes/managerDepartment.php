<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
?>

<?php
/**
 * managerDepartment
 */
class managerDepartment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function setDepartment($roomname, $description, $roomnumber)
    {
        $roomname = mysqli_real_escape_string($this->db->link, $roomname);
        $description = mysqli_real_escape_string($this->db->link, $description);
        $roomnumber = mysqli_real_escape_string($this->db->link, $roomnumber);

        if (empty($roomname) || empty($description) || empty($roomnumber)) {
            $alert = '<script> toastr.warning("Không được để trống thông tin!");</script>';
            return $alert;
        } else {
            $query = "SELECT * FROM tbl_department WHERE `roomname` = '$roomname' AND `roomnumber` = '$roomnumber'";
            $result = $this->db->select($query);

            if ($result != false) {
                $alert = '<script> toastr.warning("Phòng ban này đã tồn tại!");</script>';
                return $alert;
            } else {
                $query = "INSERT INTO `tbl_department`(`roomname`, `description`, `roomnumber`) VALUES ('$roomname','$description','$roomnumber')";
                $result = $this->db->insert($query);

                if ($result != false) {
                    $alert = '<script> toastr.success("Đã thêm thành công!");</script>';
                    return $alert;
                } else {
                    $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                    return $alert;
                }
            }
        }
    }

    public function getDepartment()
    {
        $query = "SELECT * FROM tbl_department ORDER BY roomname ASC, roomnumber ASC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getDepartmentId($id)
    {
        $query = "SELECT * FROM tbl_department WHERE `id` = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getManager($id)
    {
        $query = "SELECT tbl_user.user, tbl_user.fullname, tbl_department.* 
        FROM tbl_department, tbl_user
        WHERE tbl_user.department = tbl_department.id AND tbl_department.id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getManagerFullname($id)
    {
        $query = "SELECT tbl_user.user, tbl_user.fullname, tbl_user.level, tbl_department.* 
        FROM tbl_department, tbl_user
        WHERE tbl_user.department = tbl_department.id AND tbl_department.id = '$id' AND tbl_user.level = '1'";
        $result = $this->db->select($query);
        return $result;
    }

    public function deleteDepartment($id)
    {
        $query = "SELECT * FROM `tbl_department` WHERE `id` = '$id'";
        $result = $this->db->select($query);

        if ($result && $result->num_rows > 0) {
            $query = "DELETE FROM `tbl_department` WHERE id = '$id'";
            $this->db->delete($query);

            if ($result != false) {
                $alert = '<script> toastr.success("Đã xóa thành công!");</script>';
                return $alert;
            } else {
                $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                return $alert;
            }
        }
    }

    public function updateDepartment($id, $roomname, $description, $roomnumber, $position)
    {
        $id = mysqli_real_escape_string($this->db->link, $id);
        $roomname = mysqli_real_escape_string($this->db->link, $roomname);
        $description = mysqli_real_escape_string($this->db->link, $description);
        $roomnumber = mysqli_real_escape_string($this->db->link, $roomnumber);
        $position = mysqli_real_escape_string($this->db->link, $position);

        if (empty($id) || empty($roomname) || empty($description) || empty($roomnumber)) {
            $alert = '<script> toastr.warning("Vui lòng không được để trống thông tin!");</script>';
            return $alert;
        } else {
            if (!empty($position)) {
                if ($position != "5301") {
                    $q_department = "SELECT * FROM tbl_department WHERE `id` = '$id'";
                    $r_department = $this->db->select($q_department);

                    if ($r_department != false) {
                        $v_department = $r_department->fetch_assoc();
                        $manager = $v_department['manager'];

                        $q_user = "SELECT * FROM tbl_user WHERE department = '$id' AND `level` = '1' AND user = '$manager'";
                        $r_user = $this->db->select($q_user);

                        if ($r_user != false) {
                            $q_user = "UPDATE `tbl_user` SET `level`='2', numleave = numleave - 3 WHERE `user` = '$manager'";
                            $r_user = $this->db->update($q_user);

                            if ($r_user != false) {
                                $q_user = "UPDATE `tbl_user` SET `level`='1', numleave = numleave + 3 WHERE `user` = '$position'";
                                $r_user = $this->db->update($q_user);

                                if ($r_user != false) {
                                    $q_department = "UPDATE `tbl_department` SET `manager` = '$position' WHERE `id` = '$id'";
                                    $r_department = $this->db->update($q_department);

                                    if ($r_department != false) {
                                        $alert = '<script> toastr.success("Cập nhật thành công!");</script>';
                                        return $alert;
                                    } else {
                                        $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                                        return $alert;
                                    }
                                } else {
                                    $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                                    return $alert;
                                }
                            } else {
                                $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                                return $alert;
                            }
                        } else {
                            $q_user = "UPDATE `tbl_user` SET `level`='1', numleave = numleave + 3 WHERE `user` = '$position'";
                            $r_user = $this->db->update($q_user);

                            if ($r_user != false) {
                                $q_department = "UPDATE `tbl_department` SET `manager` = '$position' WHERE `id` = '$id'";
                                $r_department = $this->db->update($q_department);

                                if ($r_department != false) {
                                    $alert = '<script> toastr.success("Cập nhật thành công!");</script>';
                                    return $alert;
                                } else {
                                    $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                                    return $alert;
                                }
                            } else {
                                $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                                return $alert;
                            }
                        }
                    }
                } else {
                    $q_department = "SELECT * FROM tbl_department WHERE `id` = '$id'";
                    $r_department = $this->db->select($q_department);

                    if ($r_department != false) {
                        $v_department = $r_department->fetch_assoc();
                        $manager = $v_department['manager'];

                        $q_user = "UPDATE `tbl_user` SET `level`='2', numleave = numleave - 3 WHERE `user` = '$manager'";
                        $r_user = $this->db->update($q_user);

                        if ($r_user != false) {
                            $q_department = "UPDATE `tbl_department` SET `manager` = '' WHERE `id` = '$id'";
                            $r_department = $this->db->update($q_department);

                            if ($r_department != false) {
                                $alert = '<script> toastr.success("Cập nhật thành công!");</script>';
                                return $alert;
                            } else {
                                $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                                return $alert;
                            }
                        } else {
                            $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                            return $alert;
                        }
                    }
                }
            } else {
                $query = "SELECT * FROM tbl_department WHERE `roomname` = '$roomname' AND `roomnumber` = '$roomnumber'";
                $result = $this->db->select($query);

                if ($result != false) {
                    $alert = '<script> toastr.warning("Phòng ban này đã tồn tại!");</script>';
                    return $alert;
                } else {
                    $query = "UPDATE `tbl_department` SET 
                    `roomname`='$roomname',
                    `description`='$description',
                    `roomnumber`='$roomnumber' WHERE `id` = '$id'";
                    $result = $this->db->update($query);

                    if ($result != false) {
                        $alert = '<script> toastr.success("Cập nhật thành công!");</script>';
                        return $alert;
                    } else {
                        $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                        return $alert;
                    }
                }
            }
        }
    }
}
?>