<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
/**
 * actionAccount
 */
class actionAccount
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
                    $query = "UPDATE `tbl_user` SET `password`='$newpassword', `action` = '1' WHERE user = '$user' AND password = '$password' AND '$newpassword' = '$repassword'";
                    $result = $this->db->update($query);

                    if ($result != false) {
                        echo "<script>window.location='./?q=homepage';</script>";
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
}
?>