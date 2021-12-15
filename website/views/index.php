<?php
include '../lib/database.php';
include '../helpers/format.php';
include '../lib/session.php';
Session::checkSession();

spl_autoload_register(function ($class) {
    include_once "../classes/" . $class . ".php";
});

$db = new Database();
$fm = new Format();

$mngDepartment = new managerDepartment();
$mngUser = new managerUser();
$mngLeave = new manageLeave();

$id = Session::get('id');
$query = "SELECT * FROM tbl_user WHERE `id` = '$id'";
$result = $db->select($query);
if ($result) {
    $value = $result->fetch_assoc();
    if ($value['action'] == "1") { ?>
        <?php include '../inc/menu.php'; ?>
        <?php include '../inc/header.php'; ?>

        <?php if (isset($_GET["q"])) {
            switch ($_GET["q"]) {
                case 'homepage':
                    include_once 'homepage.php';
                    break;
                case 'listuser':
                    if (Session::get('level') == "0") {
                        include_once 'listuser.php';
                    } else {
                        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location='?q=homepage';</script>";
                    }
                    break;
                case 'useredit':
                    include_once 'useredit.php';
                    break;
                case 'department':
                    if (Session::get('level') == "0") {
                        include_once 'department.php';
                    } else {
                        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location='?q=homepage';</script>";
                    }
                    break;
                case 'departmentedit':
                    if (Session::get('level') == "0") {
                        include_once 'departmentedit.php';
                    } else {
                        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location='?q=homepage';</script>";
                    }
                    break;
                case 'manageleave':
                    if (Session::get('level') == "0" || Session::get('level') == "1") {
                        include_once 'manageleave.php';
                    } else {
                        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location='?q=homepage';</script>";
                    }
                    break;
                case 'manageleaveedit':
                    if (Session::get('level') == "0" || Session::get('level') == "1") {
                        include_once 'manageleaveedit.php';
                    } else {
                        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location='?q=homepage';</script>";
                    }
                    break;
                case 'creationhistory':
                    if (Session::get('level') == "1" || Session::get('level') == "2") {
                        include_once 'creationhistory.php';
                    } else {
                        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location='?q=homepage';</script>";
                    }
                    break;
                case 'managetacktt':
                    if (Session::get('level') == "1") {
                        include_once 'managetacktt.php';
                    } else {
                        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location='?q=homepage';</script>";
                    }
                    break;
                case 'managetacknv':
                    if (Session::get('level') == "2") {
                        include_once 'managetacknv.php';
                    } else {
                        echo "<script>alert('Bạn không có quyền truy cập vào trang này!'); window.location='?q=homepage';</script>";
                    }
                    break;
                default:
                    include_once '404.php';
                    break;
            }
        } else {
            include_once 'homepage.php';
        } ?>
        <?php include '../inc/footer.php'; ?>
<?php } else {
        echo "<script>alert('Bạn không có quyền truy cập vào trang này khi chưa kích hoạt tài khoản!');</script>";
        Session::destroy();
    }
} ?>