<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
/**
 * managerUser
 */
class managerUser
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function actionAccount($user, $password, $newpassword, $repassword)
    {
        $user = $this->fm->validation($user);
        $password = $this->fm->validation($password);
        $newpassword = $this->fm->validation($newpassword);
        $repassword = $this->fm->validation($repassword);

        $user = mysqli_real_escape_string($this->db->link, $user);
        $password = mysqli_real_escape_string($this->db->link, $password);
        $newpassword = mysqli_real_escape_string($this->db->link, $newpassword);
        $repassword = mysqli_real_escape_string($this->db->link, $repassword);

        if (empty($newpassword) || empty($repassword)) {
            $alert = '<script> toastr.warning("Không được để trống thông tin!");</script>';
            return $alert;
        } else {
            $query = "SELECT * FROM tbl_user WHERE user = '$user' AND password = '$password'";
            $result = $this->db->select($query);

            if ($result != false) {
                if ($newpassword != $repassword) {
                    $alert = '<script> toastr.warning("Mật khẩu không trùng khớp!");</script>';
                    return $alert;
                } else {
                    $query = "UPDATE `tbl_user` SET `password`='$newpassword', `action` = '1' WHERE user = '$user' AND password = '$password'";
                    $result = $this->db->update($query);

                    if ($result != false) {
                        echo "<script>window.location='?q=homepage';</script>";
                    } else {
                        $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
                        return $alert;
                    }
                }
            } else {
                $alert = '<script> toastr.warning("Mật khẩu cũ không trùng khớp!");</script>';
                return $alert;
            }
        }
    }

    public function setAccount($fullname, $user, $department, $checkaction)
    {
        if ($checkaction != 1) {
            $alert = '<script> toastr.warning("Vui lòng xác nhận tạo tài khoản!");</script>';
            return $alert;
        } else {
            $user = $this->fm->validation($user);

            $user = mysqli_real_escape_string($this->db->link, $user);
            $fullname = mysqli_real_escape_string($this->db->link, $fullname);
            $department = mysqli_real_escape_string($this->db->link, $department);

            if (empty($user) || empty($fullname) || empty($department)) {
                $alert = '<script> toastr.warning("Không được để trống thông tin!");</script>';
                return $alert;
            } else {
                $query = "SELECT * FROM tbl_user WHERE user = '$user'";
                $result = $this->db->select($query);

                if ($result != false) {
                    $alert = '<script> toastr.warning("Tên đăng nhập đã tồn tại!");</script>';
                    return $alert;
                } else {
                    $password = md5($user);
                    $query = "INSERT INTO `tbl_user`(`user`, `department`, `password`, `fullname`, `action`, `level`) 
                VALUES ('$user', '$department', '$password', '$fullname', '0', '2')";
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
    }

    public function upadateAccount($id, $address, $phone, $email, $checkaction)
    {
        $id = mysqli_real_escape_string($this->db->link, $id);
        $address = mysqli_real_escape_string($this->db->link, $address);
        $phone = mysqli_real_escape_string($this->db->link, $phone);
        $email = mysqli_real_escape_string($this->db->link, $email);

        if ($checkaction != 1) {
            $alert = '<script> toastr.warning("Chọn tiếp tục để thực hiện!");</script>';
            return $alert;
        } else {
            if ($_FILES['images']['name'] != NULL) {
                if (
                    $_FILES["images"]["type"] == "image/jpeg"
                    || $_FILES["images"]["type"] == "image/png"
                    || $_FILES["images"]["type"] == "image/gif"
                    || $_FILES["images"]["type"] == "image/jpg"
                ) {
                    // Xóa ảnh cũ trong file
                    $query = "SELECT * FROM tbl_user WHERE id = '$id'";
                    $result = $this->db->select($query);

                    if ($result) {
                        $value = $result->fetch_assoc();
                        if ($value['images'] != NULL) {
                            $img = substr($value['images'], 0, strlen($value['images']));
                            unlink("$img");
                        }
                    }
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $radom = 'user' . substr(str_shuffle($permitted_chars), 0, 10);

                    // Kiểm tra file up lên có phải là ảnh không            
                    // Nếu là ảnh tiến hành code upload
                    $path = "../assets/images/user/$radom"; // Ảnh sẽ lưu vào thư mục images
                    $tmp_name = $_FILES['images']['tmp_name'];
                    $name = $_FILES['images']['name'];
                    // Upload ảnh vào thư mục images
                    move_uploaded_file($tmp_name, $path . $name);
                    $image_url = $path . $name; // Đường dẫn ảnh lưu vào cơ sở dữ liệu
                    // Insert ảnh vào cơ sở dữ liệu

                    $query = "UPDATE `tbl_user` SET 
                    `address`='$address',
                    `phone`='$phone',
                    `email`='$email',
                    `images`='$image_url' WHERE id = '$id'";
                    $result = $this->db->update($query);
                } else {
                    $alert = '<script> toastr.warning("File đăng tải không phải là file ảnh!");</script>';
                    return $alert;
                }
            } else {
                $query = "UPDATE `tbl_user` SET 
                `address`='$address',
                `phone`='$phone',
                `email`='$email'
                 WHERE id = '$id'";
                $result = $this->db->update($query);
            }

            if ($result != false) {
                $alert = '<script> toastr.success("Cập nhật thành công!");</script>';
                return $alert;
            } else {
                $alert = '<script> toastr.warning("Cập nhật thất bại!");</script>';
                return $alert;
            }
        }
    }

    public function deleteAccount($id)
    {
        $query = "SELECT * FROM `tbl_user` WHERE `id` = '$id'";
        $result = $this->db->select($query);

        if ($result && $result->num_rows > 0) {
            $query = "DELETE FROM `tbl_user` WHERE id = '$id'";
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

    public function resetPassword($id)
    {
        $query = "SELECT * FROM tbl_user WHERE id = '$id'";
        $result = $this->db->select($query);

        if ($result != false) {
            $value = $result->fetch_assoc();
            $password = md5($value['user']);
            $action = 0;

            $query = "UPDATE `tbl_user` SET `password`='$password', `action`='$action' WHERE id = '$id'";
            $result = $this->db->update($query);

            if ($result != false) {
                $alert = '<script> toastr.success("Cập nhật thành công!");</script>';
                return $alert;
            } else {
                $alert = '<script> toastr.warning("Cập nhật thất bại!");</script>';
                return $alert;
            }
        } else {
            $alert = '<script> toastr.warning("Lỗi trong quá trình cập nhật!");</script>';
            return $alert;
        }
    }

    public function getAccountId($id)
    {
        $query = "SELECT * FROM tbl_user WHERE id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getAccountDepartment($idUser)
    {
        $query = "SELECT * FROM `tbl_user` WHERE id = '$idUser'";
        $result = $this->db->select($query);

        if ($result != false) {
            $value = $result->fetch_assoc();
            $idDepartment = $value['department'];

            $query = "SELECT tbl_user.* 
            FROM tbl_user, tbl_department 
            WHERE tbl_department.id = tbl_user.department AND tbl_department.id = '$idDepartment'";
            $result = $this->db->select($query);

            if ($result != false) {
                return $result;
            }
            return;
        }
        return;
    }

    public function getAccountOn()
    {
        $query = "SELECT tbl_user.*, roomname, roomnumber
        FROM tbl_user, tbl_department
        WHERE tbl_user.department = tbl_department.id AND `action` = '1' AND (`level` = '1' OR `level` = '2')";
        $result = $this->db->select($query);
        return $result;
    }

    public function getAccountOff()
    {
        $query = "SELECT tbl_user.*, roomname, roomnumber
        FROM tbl_user, tbl_department
        WHERE tbl_user.department = tbl_department.id AND `action` = '0' AND (`level` = '1' OR `level` = '2')";
        $result = $this->db->select($query);
        return $result;
    }
}
?>