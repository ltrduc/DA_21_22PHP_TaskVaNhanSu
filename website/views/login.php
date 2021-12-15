<?php include '../classes/loginAccount.php'; ?>
<?php
$loginAccount = new loginAccount();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $password = md5($_POST['password']);

    if (isset($_POST['checkaction'])) {
        $checkaction = $_POST['checkaction'];
    } else {
        $checkaction = 0;
    }

    $login_check = $loginAccount->loginAccount($user, $password, $checkaction);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login</title>
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

<!-- [ auth-signup ] start -->
<div class="auth-wrapper">
    <div class="auth-content container" style="max-width: 500px;">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3 f-w-700">HỆ THỐNG <br> THÔNG TIN CÔNG TY</h3>
                <form action="login.php" method="post">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-user"></i></span>
                        </div>
                        <input type="text" name="user" class="form-control" placeholder="Tên đăng nhập">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-lock"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                    </div>
                    <div class="form-group text-left mt-2">
                        <div class="checkbox checkbox-primary d-inline">
                            <input type="checkbox" name="checkaction" value="1" id="checkaction">
                            <label for="checkaction" class="cr">Tiếp tục đăng nhập.</label>
                        </div>
                    </div>
                    <button class="btn btn-primary mb-4">Đăng nhập</button>
                </form>
                <p class="mb-2">Quên mật khẩu? <span class="f-w-700">Vui lòng liên hệ giám đốc để được cấp lại!</span></p>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signup ] end -->

<!-- Required Js -->
<script src="../assets/js/vendor-all.min.js"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<?php if (isset($login_check)) echo $login_check; ?>
</body>

</html>