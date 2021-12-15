<?php include '../classes/actionAccount.php'; ?>
<?php
include '../lib/session.php';
Session::checkSession();
?>
<?php
$actionAccount = new actionAccount();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$user = Session::get('user');
	$password = Session::get('password');
	$newpassword = $_POST['newpassword'];
	$repassword = $_POST['repassword'];

	if (!empty($newpassword) && !empty($repassword)) {
		$newpassword = md5($_POST['newpassword']);
		$repassword = md5($_POST['repassword']);
	}

	$action_check = $actionAccount->actionAccount($user, $password, $newpassword, $repassword);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Activated</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<!-- Favicon icon -->
	<link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
	<!-- fontawesome icon -->
	<link rel="stylesheet" href="../assets/fonts/fontawesome/css/fontawesome-all.min.css">
	<!-- animation css -->
	<link rel="stylesheet" href="../assets/plugins/animation/css/animate.min.css">

	<!-- vendor css -->
	<link rel="stylesheet" href="../assets/css/style.css">

	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content container" style="max-width: 500px;">
		<div class="card">
			<div class="card-body">
				<h3 class="mb-3 f-w-400">ĐỔI MẬT KHẨU MỚI</h3>
				<form action="activated.php" method="post">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="feather icon-lock"></i></span>
						</div>
						<input type="password" name="newpassword" class="form-control" placeholder="Mật khẩu mới">
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="feather icon-lock"></i></span>
						</div>
						<input type="password" name="repassword" class="form-control" placeholder="Nhập lại mật khẩu">
					</div>
					<button class="btn btn-primary mb-4">Đổi mật khẩu</button>
				</form>
				<?php
				if (isset($_GET['q']) && $_GET['q'] == 'logout') {
					Session::destroy();
				}
				?>
				<p class="mb-2 text-muted"> Nhân viên vui lòng đổi mật khẩu để tiếp tục đăng nhập vào hệ thống thông tin công ty! <a href="?q=logout">hoặc Đăng xuất</a></p>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="../assets/js/vendor-all.min.js"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script>
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>
<?php if (isset($action_check)) echo $action_check; ?>
</body>

</html>