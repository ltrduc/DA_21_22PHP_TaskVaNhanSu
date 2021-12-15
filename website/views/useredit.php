<?php
if (!isset($_GET['edit']) || $_GET['edit'] == NULL) {
    echo "<script>window.location='./?q=homepage';</script>";
} else {
    if (Session::get('level') == "0") {
        $id = $_GET['edit'];
    } else {
        $id = Session::get('id');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['useredit'])) {
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        if (isset($_POST['checkaction'])) {
            $checkaction = $_POST['checkaction'];
        } else {
            $checkaction = 0;
        }

        $check_mngUser = $mngUser->upadateAccount($id, $address, $phone, $email, $checkaction);
    }

    if (isset($_POST['resetpassword'])) {
        $check_mngUser = $mngUser->resetPassword($id);
    }
}

if (isset($check_mngUser)) {
    echo $check_mngUser;
}
?>

<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ breadcrumb ] start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Quản lý tài khoản</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="?q=homepage"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a>Danh sách tài khoản</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ breadcrumb ] end -->
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header pt-2 pb-2">
                                        <div class="row">
                                            <div class="col-6 p-2">
                                                <h5>THÔNG TIN TÀI KHOẢN</h5>
                                            </div>
                                            <?php if (Session::get('level') == "0") { ?>
                                                <div class="col-6">
                                                    <div class="text-right">
                                                        <form action="" method="post">
                                                            <button type="submit" name="resetpassword" class="btn btn-warning">Reset tài khoản</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="" enctype="multipart/form-data" method="post">
                                            <?php
                                            $getAccountId = $mngUser->getAccountId($id);
                                            if ($getAccountId) {
                                                $value = $getAccountId->fetch_assoc();
                                            } else {
                                                echo "<script>window.location='./?q=listuser';</script>";
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="text-center mt-3 mb-3">
                                                        <img alt="Avata" src="<?php echo $value['images']; ?>" id="avatars" class="rounded-circle img-responsive mt-2" width="128" height="128">
                                                        <div class="mt-4 mb-4">
                                                            <input name="images" id="file-upload" type="file" style="width: 200px;">
                                                        </div>
                                                        <div class="mt-4 mb-4">Để có kết quả tốt nhất, hãy sử dụng hình ảnh có kích thước tối thiểu 128px x 128px ở định dạng .jpg</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-2">
                                                            <label class="form-label">Mã nhân viên</label>
                                                            <input type="text" class="form-control" value="NV<?php echo $value['id']; ?>" disabled="disabled">
                                                        </div>
                                                        <div class="form-group col-md-5">
                                                            <label class="form-label">Tên nhân viên</label>
                                                            <input type="text" class="form-control" value="<?php echo $value['fullname']; ?>" disabled="disabled">
                                                        </div>
                                                        <div class="form-group col-md-5">
                                                            <label class="form-label">Tên đăng nhập</label>
                                                            <input type="text" class="form-control" value="<?php echo $value['user']; ?>" disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-7">
                                                            <label class="form-label">Địa chỉ</label>
                                                            <input type="text" name="address" class="form-control" value="<?php echo $value['address']; ?>">
                                                        </div>
                                                        <div class="form-group col-md-5">
                                                            <label class="form-label">Số điện thoại</label>
                                                            <input type="text" name="phone" class="form-control" value="<?php echo $value['phone']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label class="form-label">Địa chỉ email</label>
                                                            <input type="email" name="email" class="form-control" value="<?php echo $value['email']; ?>">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="form-label">Phòng ban</label>
                                                            <select class="custom-select" disabled="disabled">
                                                                <?php
                                                                $department = $value['department'];
                                                                $q_department = "SELECT tbl_department.* FROM tbl_department, tbl_user WHERE tbl_department.id = '$department'";
                                                                $r_department = $db->select($q_department);
                                                                if ($r_department) {
                                                                    $v_department = $r_department->fetch_assoc();
                                                                    $department_user = $v_department['roomname'] . ' - P' . $v_department['roomnumber'];
                                                                } else {
                                                                    $department_user = "";
                                                                }
                                                                ?>
                                                                <option><?php echo $department_user ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label class="form-label">Chức vụ</label>
                                                            <input type="text" name="position" class="form-control" value="<?php if ($value['level'] == "1") echo "Trưởng phòng"; ?>" disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="custom-control custom-checkbox m-0">
                                                            <input type="checkbox" name="checkaction" value="1" class="custom-control-input">
                                                            <span class="custom-control-label">Đồng ý thay đổi</span>
                                                        </label>
                                                    </div>
                                                    <button type="submit" name="useredit" class="btn btn-success">Lưu thông tin</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>