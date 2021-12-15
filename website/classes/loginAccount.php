<?php
$filepath = realpath(dirname(__FILE__));
include($filepath . '/../lib/session.php');
Session::checkLogin();
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
/**
 * loginAccount
 */
class loginAccount
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function loginAccount($user, $password, $checkaction)
	{
		if ($checkaction != 1) {
			$alert = '<script> toastr.warning("Chọn tiếp tục để đăng nhập!");</script>';
			return $alert;
		} else {
			$user = $this->fm->validation($user);
			$password = $this->fm->validation($password);

			$user = mysqli_real_escape_string($this->db->link, $user);
			$password = mysqli_real_escape_string($this->db->link, $password);

			if (empty($user) || empty($password)) {
				$alert = '<script> toastr.warning("Không được để trống thông tin!");</script>';
				return $alert;
			} else {
				$query = "SELECT * FROM tbl_user WHERE user = '$user' AND password = '$password'";
				$result = $this->db->select($query);

				if ($result != false) {
					$value = $result->fetch_assoc();
					Session::set('login', true);
					Session::set('id', $value['id']);
					Session::set('user', $value['user']);
					Session::set('password', $value['password']);
					Session::set('fullname', $value['fullname']);
					Session::set('level', $value['level']);
					Session::set('action', $value['action']);

					if ($value['action'] == "1") {
						echo "<script>window.location='?q=homepage';</script>";
					} else {
						echo "<script>window.location='activated.php';</script>";
					}
				} else {
					$alert = '<script> toastr.warning("Tài khoản hoặc mật khẩu không tồn tại!");</script>';
					return $alert;
				}
			}
		}
	}
}
?>