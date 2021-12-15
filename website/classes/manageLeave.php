<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
?>

<?php
/**
 * manageLeave
 */
class manageLeave
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function setLeave($id, $user, $description, $begin, $end, $checkaction)
    {
        if ($checkaction != 1) {
            $alert = '<script> toastr.warning("Chưa xác nhận thông tin!");</script>';
            return $alert;
        } else {
            $id = mysqli_real_escape_string($this->db->link, $id);
            $user = mysqli_real_escape_string($this->db->link, $user);
            $description = mysqli_real_escape_string($this->db->link, $description);
            $begin = mysqli_real_escape_string($this->db->link, $begin);
            $end = mysqli_real_escape_string($this->db->link, $end);

            if (empty($id) || empty($user) || empty($description) || empty($begin) || empty($begin)) {
                $alert = '<script> toastr.warning("Không được để trống thông tin!");</script>';
                return $alert;
            } else {
                $query = "SELECT true FROM tbl_user
                WHERE id = '$id' AND DATEDIFF('$end', '$begin') + 1 <= numleave";
                $result = $this->db->select($query);

                if ($result != false) {
                    $query = "SELECT tbl_leave.* 
                    FROM tbl_leave, tbl_user
                    WHERE tbl_leave.user = tbl_user.user AND tbl_user.id = '$id' ORDER BY tbl_leave.id DESC LIMIT 1";
                    $result = $this->db->select($query);

                    if ($result != false) {
                        $value = $result->fetch_assoc();
                        if ($value['status'] != 0) {
                            $beforeday =  date('Y-m-d', strtotime(date($value['today']) . ' + 7 days'));
                            $today =  date('Y-m-d');

                            if ($beforeday <= $today) {
                                if ($_FILES['proof']['name'] != NULL) {
                                    if ($_FILES['proof']['size'] > 10 * 1048576) {
                                        $alert = '<script> toastr.warning("Dung lượng file không vượt quá 10MB!");</script>';
                                        return $alert;
                                    } else {
                                        if (
                                            $_FILES["proof"]["type"] == "image/jpeg"
                                            || $_FILES["proof"]["type"] == "image/png"
                                            || $_FILES["proof"]["type"] == "image/gif"
                                            || $_FILES["proof"]["type"] == "image/jpg"
                                        ) {
                                            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                                            $radom = 'leave' . substr(str_shuffle($permitted_chars), 0, 10);
                                            // Kiểm tra file up lên có phải là ảnh không            
                                            // Nếu là ảnh tiến hành code upload

                                            $path = "../assets/images/leave/$radom"; // Ảnh sẽ lưu vào thư mục images
                                            $tmp_name = $_FILES['proof']['tmp_name'];
                                            $name = $_FILES['proof']['name'];
                                            // Upload ảnh vào thư mục images
                                            move_uploaded_file($tmp_name, $path . $name);
                                            $proof = $path . $name; // Đường dẫn ảnh lưu vào cơ sở dữ liệu
                                            // Insert ảnh vào cơ sở dữ liệu

                                            $query = "INSERT INTO `tbl_leave`(`user`, `description`, `begin`, `end`, `proof`, `status`) 
                                            VALUES ('$user','$description','$begin', '$end', '$proof','0')";
                                            $result = $this->db->insert($query);
                                        } else {
                                            $alert = '<script> toastr.warning("File đăng tải không phải là file ảnh!");</script>';
                                            return $alert;
                                        }
                                    }
                                } else {
                                    $query = "INSERT INTO `tbl_leave`(`user`, `description`, `begin`, `end`, `status`) VALUES ('$user','$description','$begin','$end','0')";
                                    $result = $this->db->insert($query);

                                    if ($result != false) {
                                        $alert = '<script> toastr.success("Gửi yêu cầu thành công!");</script>';
                                        return $alert;
                                    } else {
                                        $alert = '<script> toastr.warning("Gửi yêu cầu thất bại!");</script>';
                                        return $alert;
                                    }
                                }
                            } else {
                                $alert = '<script> toastr.warning("Sau 7 ngày từ khi duyệt đơn cũ bạn mới có thể tạo đơn mới!");</script>';
                                return $alert;
                            }
                        } else {
                            $alert = '<script> toastr.warning("Đơn của bạn vẫn chưa được duyệt nên không thể tạo đơn mới!");</script>';
                            return $alert;
                        }
                    } else {
                        if ($_FILES['proof']['name'] != NULL) {
                            if ($_FILES['proof']['size'] > 10 * 1048576) {
                                $alert = '<script> toastr.warning("Dung lượng file không vượt quá 10MB!");</script>';
                                return $alert;
                            } else {
                                if (
                                    $_FILES["proof"]["type"] == "image/jpeg"
                                    || $_FILES["proof"]["type"] == "image/png"
                                    || $_FILES["proof"]["type"] == "image/gif"
                                    || $_FILES["proof"]["type"] == "image/jpg"
                                ) {
                                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                                    $radom = 'leave' . substr(str_shuffle($permitted_chars), 0, 10);
                                    // Kiểm tra file up lên có phải là ảnh không            
                                    // Nếu là ảnh tiến hành code upload

                                    $path = "../assets/images/leave/$radom"; // Ảnh sẽ lưu vào thư mục images
                                    $tmp_name = $_FILES['proof']['tmp_name'];
                                    $name = $_FILES['proof']['name'];
                                    // Upload ảnh vào thư mục images
                                    move_uploaded_file($tmp_name, $path . $name);
                                    $proof = $path . $name; // Đường dẫn ảnh lưu vào cơ sở dữ liệu
                                    // Insert ảnh vào cơ sở dữ liệu

                                    $query = "INSERT INTO `tbl_leave`(`user`, `description`, `begin`, `end`, `proof`, `status`) 
                                    VALUES ('$user','$description','$begin', '$end', '$proof','0')";
                                    $result = $this->db->insert($query);
                                } else {
                                    $alert = '<script> toastr.warning("File đăng tải không phải là file ảnh!");</script>';
                                    return $alert;
                                }
                            }
                        } else {
                            $query = "INSERT INTO `tbl_leave`(`user`, `description`, `begin`, `end`, `status`) VALUES ('$user','$description','$begin','$end','0')";
                            $result = $this->db->insert($query);

                            if ($result != false) {
                                $alert = '<script> toastr.success("Gửi yêu cầu thành công!");</script>';
                                return $alert;
                            } else {
                                $alert = '<script> toastr.warning("Gửi yêu cầu thất bại!");</script>';
                                return $alert;
                            }
                        }
                    }
                } else {
                    $alert = '<script> toastr.warning("Số ngày nghỉ vượt quá số ngày còn lại!");</script>';
                    return $alert;
                }
            }
        }
    }

    public function getLeave($id, $level)
    {
        if ($level == "0") {
            $query = "SELECT tbl_leave.*, tbl_user.id AS id_user, tbl_user.fullname, tbl_department.roomname, tbl_department.roomnumber
            FROM tbl_leave, tbl_user, tbl_department
            WHERE tbl_leave.user = tbl_user.user AND tbl_user.department = tbl_department.id AND `level` = '1' ORDER BY `status` ASC, `begin` ASC ";
            $result = $this->db->select($query);
            return $result;
        }
        if ($level == "1") {
            $query = "SELECT * FROM tbl_user WHERE id = '$id'";
            $result = $this->db->select($query);

            if ($result != false) {
                $value = $result->fetch_assoc();
                $department_user = $value['department'];
                $query = "SELECT tbl_leave.*, tbl_user.id AS id_user, tbl_user.fullname, tbl_department.roomname, tbl_department.roomnumber
                FROM tbl_leave, tbl_user, tbl_department
                WHERE tbl_leave.user = tbl_user.user AND tbl_user.department = tbl_department.id AND `level` = '2' AND  tbl_department.id = '$department_user'
                ORDER BY `status` ASC, `begin` ASC";
                $result = $this->db->select($query);
                return $result;
            } else {
                return false;
            }
        }
    }

    public function getLeaveId($id)
    {
        $query = "SELECT tbl_leave.*, tbl_user.id AS id_user, tbl_user.fullname, tbl_department.roomname, tbl_department.roomnumber
        FROM tbl_leave, tbl_user, tbl_department
        WHERE tbl_leave.id = '$id' AND tbl_leave.user = tbl_user.user AND tbl_user.department = tbl_department.id";
        $result = $this->db->select($query);
        return $result;
    }

    public function getLeaveIdUser($id)
    {
        $query = "SELECT tbl_leave.*, tbl_user.id AS id_user, tbl_user.fullname, tbl_department.roomname, tbl_department.roomnumber
        FROM tbl_leave, tbl_user, tbl_department
        WHERE tbl_leave.user = tbl_user.user AND tbl_user.department = tbl_department.id AND tbl_user.id = '$id' ORDER BY status ASC, begin ASC";
        $result = $this->db->select($query);
        return $result;
    }

    public function upadateStatus($id, $status)
    {
        $query = "SELECT numleave FROM tbl_user, tbl_leave 
        WHERE tbl_user.user = tbl_leave.user AND tbl_leave.id = '$id'";
        $result = $this->db->select($query);

        if ($result != false) {
            $v_numleave =  $result->fetch_assoc();

            $query = "SELECT DATEDIFF(`end`, `begin`) + 1 AS sumDate FROM tbl_leave WHERE tbl_leave.id = '$id'";
            $result = $this->db->select($query);

            if ($result != false) {
                $v_sumDate =  $result->fetch_assoc();
                $sumDate = $v_sumDate['sumDate'];

                if ($v_numleave['numleave'] > 0 && $sumDate <= $v_numleave['numleave']) {
                    $today =  date('Y-m-d');
                    $query = "UPDATE tbl_leave SET `today`= '$today' WHERE id = '$id'";
                    $result = $this->db->update($query);

                    if ($result != false) {
                        if ($status == "1") {
                            $query = "UPDATE tbl_leave SET `status`='$status' WHERE id = '$id'";
                            $result = $this->db->update($query);

                            if ($result != false) {
                                $query = "UPDATE tbl_user, tbl_leave
                                SET `numleave` =  numleave - (DATEDIFF(end, begin) + 1)
                                WHERE tbl_leave.user = tbl_user.user AND tbl_leave.id = '$id'";
                                $result = $this->db->update($query);

                                if ($result != false) {
                                    $alert = '<script> toastr.success("Đã phê duyệt thành công!");</script>';
                                    return $alert;
                                } else {
                                    $alert = '<script> toastr.warning("Lỗi trong quá trình phê duyệt!");</script>';
                                    return $alert;
                                }
                            } else {
                                $alert = '<script> toastr.warning("Lỗi trong quá trình phê duyệt!");</script>';
                                return $alert;
                            }
                        } else {
                            $query = "UPDATE `tbl_leave` SET `status`='$status' WHERE `id`='$id'";
                            $result = $this->db->update($query);

                            if ($result != false) {
                                $alert = '<script> toastr.success("Đã phê duyệt thành công!");</script>';
                                return $alert;
                            } else {
                                $alert = '<script> toastr.warning("Lỗi trong quá trình phê duyệt!");</script>';
                                return $alert;
                            }
                        }
                    } else {
                        $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                        return $alert;
                    }
                } else {
                    $query = "UPDATE `tbl_leave` SET `status`='2' WHERE `id`='$id'";
                    $result = $this->db->update($query);

                    if ($result != false) {
                        if ($sumDate > $v_numleave['numleave']) {
                            $alert = '<script> toastr.warning("Số ngày nghỉ vượt đã vượt thời gian quy định!");</script>';
                            return $alert;
                        } else {
                            $alert = '<script> toastr.warning("Số ngày nghỉ trong 1 năm đã hết!");</script>';
                            return $alert;
                        }
                    } else {
                        $alert = '<script> toastr.warning("Lỗi trong quá trình phê duyệt!");</script>';
                        return $alert;
                    }
                }
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
?>