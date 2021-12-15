<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $description = $_POST['description'];
    $begin = $_POST['begin'];
    $end = $_POST['end'];

    if (isset($_POST['checkaction'])) {
        $checkaction = $_POST['checkaction'];
    } else {
        $checkaction = 0;
    }

    $check_Leave = $mngLeave->setLeave($id, $user, $description, $begin, $end, $checkaction);
}

if (isset($check_Leave)) {
    echo $check_Leave;
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
                                            <h5 class="m-b-10">Quản lý nghiệp vụ</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="?q=homepage"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a>Lịch sử nghỉ phép</a></li>
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
                                                <h5>LỊCH SỬ NỘP ĐƠN</h5>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-primary pb-1 pt-1" data-toggle="modal" data-target=".leave">Tạo đơn xin nghỉ phép</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-right">
                                                    SỐ NGÀY NGHỈ TRONG NĂM:
                                                    <?php if (Session::get('level') == "1") { ?>
                                                        <span class="badge badge-success p-1"><?php echo $sum = 15; ?></span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-success p-1"><?php echo $sum = 12; ?></span>
                                                    <?php } ?>
                                                </div>
                                                <div class="text-right">
                                                    SỐ NGÀY ĐÃ NGHỈ:
                                                    <?php
                                                    $id_user = Session::get('id');
                                                    $query = "SELECT * FROM tbl_user WHERE id = '$id_user'";
                                                    $result = $db->select($query);

                                                    if ($result) {
                                                        $value = $result->fetch_assoc();
                                                    ?>
                                                        <span class="badge badge-warning p-1">
                                                            <?php
                                                            if (($sum - $value['numleave']) < 10) {
                                                                echo '0' . ($sum - $value['numleave']);
                                                            } else {
                                                                echo ($sum - $value['numleave']);
                                                            }
                                                            ?>
                                                        </span>
                                                    <?php } ?>
                                                </div>
                                                <div class="text-right">
                                                    SỐ NGÀY CÒN LẠI:
                                                    <?php
                                                    $id_user = Session::get('id');
                                                    $query = "SELECT * FROM tbl_user WHERE id = '$id_user'";
                                                    $result = $db->select($query);

                                                    if ($result) {
                                                        $value = $result->fetch_assoc();
                                                    ?>
                                                        <span class="badge badge-danger p-1">
                                                            <?php
                                                            if ($value['numleave'] < 10) {
                                                                echo '0' . $value['numleave'];
                                                            } else {
                                                                echo $value['numleave'];
                                                            } ?>
                                                        </span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="dt-responsive table-responsive">
                                            <div id="simpletable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table id="simpletable" class="table table-hover" role="grid" aria-describedby="simpletable_info">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 5%;">Stt</th>
                                                                    <th style="width: 10%;">Mã NV</th>
                                                                    <th style="width: 25%;">Tên nhân viên</th>
                                                                    <th style="width: 35%;">Lý do</th>
                                                                    <th style="width: 15%;">Từ ngày</th>
                                                                    <th style="width: 15%;">Đến ngày</th>
                                                                    <th style="width: 25%;">Ngày duyệt</th>
                                                                    <th style="width: 10%;">Trạng thái</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                $id_user = Session::get('id');
                                                                $getLeaveIdUser = $mngLeave->getLeaveIdUser($id_user);
                                                                if ($getLeaveIdUser) {
                                                                    while ($value = $getLeaveIdUser->fetch_assoc()) { ?>
                                                                        <tr>
                                                                            <td><?php echo $i++; ?></td>
                                                                            <td>NV<?php echo $value['id_user'] ?></td>
                                                                            <td><?php echo $value['fullname'] ?></td>
                                                                            <td><?php echo $fm->textShorten($value['description'], 100) ?></td>
                                                                            <td><?php echo $fm->formatDate($value['begin']) ?></td>
                                                                            <td><?php echo $fm->formatDate($value['end']) ?></td>
                                                                            <td><?php echo $fm->formatDate($value['today']) ?></td>
                                                                            <td>
                                                                                <?php if ($value['status'] == "1") { ?>
                                                                                    <span class="badge badge-success">Được duyệt</span>
                                                                                <?php } elseif ($value['status'] == "2") { ?>
                                                                                    <span class="badge badge-danger">Từ chối</span>
                                                                                <?php } else { ?>
                                                                                    <span class="badge badge-warning">Đang xữ lý</span>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                <?php }
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
                        <!-- [ Main Content ] end -->

                        <!-- [Tạo đơn] -->
                        <div class="modal fade leave" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header pt-2 pb-2">
                                        <h5 class="modal-title h4" id="myLargeModalLabel">ĐƠN XIN NGHỈ PHÉP</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>

                                    <div class="card-body">
                                        <form action="?q=creationhistory" method="POST" enctype="multipart/form-data">
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label class="form-label">Mã nhân viên</label>
                                                    <input type="text" class="form-control" value="NV<?php echo Session::get('id'); ?>" disabled="disabled">
                                                    <input type="hidden" class="form-control" value="<?php echo Session::get('id'); ?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Tên nhân viên</label>
                                                    <input type="text" class="form-control" value="<?php echo Session::get('fullname'); ?>" disabled="disabled">
                                                    <input type="hidden" class="form-control" name="user" value="<?php echo Session::get('user'); ?>">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label">Từ ngày</label>
                                                    <input type="date" name="begin" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label">Đến ngày</label>
                                                    <input type="date" name="end" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Lý do xin nghỉ</label>
                                                <textarea class="form-control" name="description" rows="6"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label w-100">Minh chứng đính kèm (Nếu có)</label>
                                                <input name="proof" id="file-upload" type="file">
                                                <small class="form-text text-muted"><b style="color: red;">LƯU Ý:</b></small>
                                                <small class="form-text text-muted">Chỉ chấp nhận minh chứng bằng hình ảnh có đuôi file: <span style="color: red;">jpg, png</span></small>
                                            </div>
                                            <div class="form-group text-left mt-2 mf-2">
                                                <div class="checkbox checkbox-primary d-inline">
                                                    <input type="checkbox" name="checkaction" value="1" id="checkaction">
                                                    <label for="checkaction" class="cr ml-1">Xác nhận thông tin.</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary text-left">Gửi yêu cầu</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [End Tạo đơn] -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>