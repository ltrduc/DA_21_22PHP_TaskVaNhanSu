<?php
if (!isset($_GET['edit']) || $_GET['edit'] == NULL) {
    echo "<script>window.location='./?q=manageleave';</script>";
} else {
    $id = $_GET['edit'];
}

if (!empty($_GET['file'])) {
    $fileName = basename($_GET['file']);
    $filePath = "../assets/images/leave/" . $fileName;
    if (!empty($fileName) && file_exists($filePath)) {
        //define header
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        //read file 
        readfile($filePath);
        exit;
    } else {
        $alert = '<script> toastr.warning("File đã bị xóa khỏi hệ thống!");</script>';
        return $alert;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approved'])) {
        $status = 1;
        $check_mngLeave = $mngLeave->upadateStatus($id, $status);
    }

    if (isset($_POST['refused'])) {
        $status = 2;
        $check_mngLeave = $mngLeave->upadateStatus($id, $status);
    }
}

if (isset($check_mngLeave)) {
    echo $check_mngLeave;
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
                                            <h5 class="m-b-10">Quản lý nghỉ phép</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="?q=homepage"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a>Đơn xin nghỉ phép</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ breadcrumb ] end -->
                        <!-- [ Main Content ] start -->
                        <form action="" method="POST">
                            <?php
                            $getLeaveId = $mngLeave->getLeaveId($id);
                            if ($getLeaveId) {
                                $value = $getLeaveId->fetch_assoc();
                            } else {
                                echo "<script>window.location='./?q=listuser';</script>";
                            }
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <?php
                                            $getLeaveId = $mngLeave->getLeaveId($id);
                                            if ($getLeaveId) {
                                                $value_fullname = $getLeaveId->fetch_assoc();
                                            } else {
                                                echo "<script>window.location='./?q=listuser';</script>";
                                            }
                                            ?>
                                            <h5>ĐƠN XIN NGHỈ PHÉP - NHÂN VIÊN <span style="text-transform: uppercase;">
                                                    <?php echo $value_fullname['fullname'] ?></span>
                                                <?php if ($value['status'] == "1") { ?>
                                                    <span class="badge badge-success">Được duyệt</span>
                                                <?php } elseif ($value['status'] == "2") { ?>
                                                    <span class="badge badge-danger">Từ chối</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-warning">Đang xữ lý</span>
                                                <?php } ?>
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Mã nhân viên</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" value="NV<?php echo $value['id_user']; ?>" disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Tên nhân viên</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" value="<?php echo $value['fullname']; ?>" disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Phòng ban</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" value="<?php echo $value['roomname']; ?> - P<?php echo $value['roomnumber']; ?>" disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Ngày nghỉ</label>
                                                <div class="col-sm-5 mb-2">
                                                    <input type="text" class="form-control" value="<?php echo $fm->formatDate($value['begin']); ?>" disabled="disabled">
                                                </div>
                                                <div class="col-sm-5 mb-2">
                                                    <input type="text" class="form-control" value="<?php echo $fm->formatDate($value['end']); ?>" disabled="disabled">
                                                </div>
                                            </div>
                                            <?php if ($value['proof'] != "") { ?>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-sm-2 text-sm-right">Minh chứng</label>
                                                    <div class="col-sm-10 mb-2">
                                                        <a href="<?php echo $value['proof']; ?>">
                                                            <input type="text" value="click chuột để xem minh chứng" class="form-control" disabled="disabled">
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Lý do nghỉ</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" disabled="disabled" rows="6" placeholder="Textarea"><?php echo $value['description']; ?></textarea>
                                                </div>
                                            </div>
                                            <?php if ($value['status'] == "0") { ?>
                                                <div class="form-group row">
                                                    <div class="col-sm-10 ml-sm-auto">
                                                        <button type="submit" class="btn btn-success" name="approved">Phê duyệt</button>
                                                        <button type="submit" class="btn btn-danger" name="refused">Từ chối</button>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>