<?php
if (!isset($_GET['edit']) || $_GET['edit'] == NULL) {
    echo "<script>window.location='./?q=department';</script>";
} else {
    $id = $_GET['edit'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomname = $_POST['roomname'];
    $description = $_POST['description'];
    $roomnumber = $_POST['roomnumber'];
    $position = $_POST['position'];

    $check_mngDepartment = $mngDepartment->updateDepartment($id, $roomname, $description, $roomnumber, $position);
}

if (isset($check_mngDepartment)) {
    echo $check_mngDepartment;
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
                                            <h5 class="m-b-10">Quản lý phòng ban</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="?q=homepage"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a>Danh sách phòng ban</a></li>
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
                                    <div class="card-header">
                                        <h5>CẬP NHẬT PHÒNG BAN</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <?php
                                            $getDepartmentId = $mngDepartment->getDepartmentId($id);
                                            if ($getDepartmentId) {
                                                $value = $getDepartmentId->fetch_assoc();
                                            } else {
                                                echo "<script>window.location='./?q=department';</script>";
                                            }
                                            ?>
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Tên phòng ban</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="roomname" value="<?php echo $value['roomname'] ?>">
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Mô tả</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="description" rows="5"><?php echo $value['description'] ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Số phòng</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="roomnumber" class="form-control" value="<?php echo $value['roomnumber'] ?>">
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Trưởng phòng</label>
                                                <div class="col-sm-5">
                                                    <?php
                                                    $getManagerFullname = $mngDepartment->getManagerFullname($id);
                                                    if ($getManagerFullname) {
                                                        $valueManager = $getManagerFullname->fetch_assoc();
                                                        $manager = $valueManager['fullname'];
                                                    } else {
                                                        $manager = "";
                                                    }
                                                    ?>
                                                    <input type="text" class="form-control" value="<?php echo $manager; ?>" disabled="disabled">
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <select name="position" class="custom-select">
                                                        <option value="">---Chọn Nhân sự---</option>
                                                        <option value="5301" style="color: red;">HỦY BỎ CHỨC VỤ</option>
                                                        <?php
                                                        $getManager = $mngDepartment->getManager($id);
                                                        if ($getManager) {
                                                            while ($valueManager = $getManager->fetch_assoc()) {
                                                        ?>
                                                                <option value="<?php echo $valueManager['user'] ?>"><?php echo $valueManager['user'] ?> [<?php echo $valueManager['fullname'] ?>]</option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-10 ml-sm-auto">
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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