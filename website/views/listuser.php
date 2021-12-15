<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $user = $_POST['user'];
    $department = $_POST['department'];

    if (isset($_POST['checkaction'])) {
        $checkaction = $_POST['checkaction'];
    } else {
        $checkaction = 0;
    }

    $login_mngUser = $mngUser->setAccount($fullname, $user, $department, $checkaction);
}

if (isset($_GET["delete"])) {
    $id = $_GET['delete'];
    $login_mngUser = $mngUser->deleteAccount($id);
}

if (isset($login_mngUser)) {
    echo $login_mngUser;
}

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
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
                                                <h5>DANH SÁCH TÀI KHOẢN</h5>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".adduser">Thêm tài khoản</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="dt-responsive table-responsive">
                                            <div id="simpletable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table id="simpletable" class="table table-hover" role="grid" aria-describedby="simpletable_info">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 5%;">#</th>
                                                                    <th style="width: 20%;">Tên nhân viên</th>
                                                                    <th style="width: 18%;">Tên đăng nhập</th>
                                                                    <th style="width: 20%;">Phòng ban</th>
                                                                    <th style="width: 20%;">Chức vụ</th>
                                                                    <th style="width: 20%;">Thao tác</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                $getAccountOn = $mngUser->getAccountOn();
                                                                if ($getAccountOn) {
                                                                    while ($showAccountOn = $getAccountOn->fetch_assoc()) {
                                                                ?>
                                                                        <tr>
                                                                            <td class="align-baseline" scope="row"><?php echo $i++; ?></td>
                                                                            <td class="align-baseline"><?php echo $showAccountOn['fullname']; ?></td>
                                                                            <td class="align-baseline"><?php echo $showAccountOn['user']; ?></td>
                                                                            <td class="align-baseline"><?php echo $showAccountOn['roomname']; ?> - P<?php echo $showAccountOn['roomnumber']; ?></td>
                                                                            <td class="align-baseline"><?php if ($showAccountOn['level'] == "1") echo "Trưởng phòng"; ?></td>
                                                                            <td class="align-baseline">
                                                                                <a href="?q=useredit&edit=<?php echo $showAccountOn['id']; ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>">
                                                                                    <button type="button" class="btn btn-outline-success pt-1 pb-1">Xem</button>
                                                                                </a>
                                                                                <a href="?q=listuser&delete=<?php echo $showAccountOn['id']; ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>" onclick="return confirm('Hãy cân nhắc kỹ trước khi xóa?');">
                                                                                    <button type="button" class="btn btn-outline-danger pt-1 pb-1">Xóa</button>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                <?php   }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>DANH SÁCH TÀI KHOẢN CHƯA KÍCH HOẠT</h5>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table id="simpletable" class="table table-hover" role="grid" aria-describedby="simpletable_info">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;">#</th>
                                                        <th style="width: 20%;">Tên nhân viên</th>
                                                        <th style="width: 18%;">Tên đăng nhập</th>
                                                        <th style="width: 20%;">Phòng ban</th>
                                                        <th style="width: 20%;">Chức vụ</th>
                                                        <th style="width: 20%;">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $getAccountOff = $mngUser->getAccountOff();
                                                    if ($getAccountOff) {
                                                        while ($showAccountOff = $getAccountOff->fetch_assoc()) {
                                                    ?>
                                                            <tr>
                                                                <td class="align-baseline" scope="row"><?php echo $i++; ?></td>
                                                                <td class="align-baseline"><?php echo $showAccountOff['fullname']; ?></td>
                                                                <td class="align-baseline"><?php echo $showAccountOff['user']; ?></td>
                                                                <td class="align-baseline"><?php echo $showAccountOff['roomname']; ?> - P<?php echo $showAccountOff['roomnumber']; ?></td>
                                                                <td class="align-baseline"><?php if ($showAccountOff['level'] == "1") echo "Trưởng phòng"; ?></td>
                                                                <td class="align-baseline">
                                                                    <a href="?q=useredit&edit=<?php echo $showAccountOff['id']; ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>">
                                                                        <button type="button" class="btn btn-outline-success pt-1 pb-1">Xem</button>
                                                                    </a>
                                                                    <a href="?q=listuser&delete=<?php echo $showAccountOff['id']; ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>" onclick="return confirm('Hãy cân nhắc kỹ trước khi xóa?');">
                                                                        <button type="button" class="btn btn-outline-danger pt-1 pb-1">Xóa</button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                    <?php   }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->

                        <!-- [Thêm tài khoản] -->
                        <div class="modal fade adduser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title h4" id="myLargeModalLabel">THÊM TÀI KHOẢN</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <form action="?q=listuser" method="POST">
                                        <div class="modal-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Tên nhân viên</label>
                                                    <input type="text" name="fullname" class="form-control" placeholder="Nguyễn Văn A">
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Tên đăng nhập</label>
                                                    <input type="text" name="user" class="form-control" placeholder="nguyenvana">
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Phòng ban</label>
                                                    <select name="department" class="custom-select">
                                                        <option value="">---Chọn phòng ban---</option>
                                                        <?php
                                                        $getDepartment = $mngDepartment->getDepartment();
                                                        if ($getDepartment) {
                                                            while ($value = $getDepartment->fetch_assoc()) {
                                                        ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['roomname'] ?> - P<?php echo $value['roomnumber'] ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group text-left mt-2 mf-2">
                                                    <div class="checkbox checkbox-primary d-inline">
                                                        <input type="checkbox" name="checkaction" value="1" id="checkaction">
                                                        <label for="checkaction" class="cr ml-1">Xác nhận tạo tài khoản.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Thêm tài khoản</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- [End Thêm tài khoản] -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>