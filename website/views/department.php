<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomname = $_POST['roomname'];
    $description = $_POST['description'];
    $roomnumber = $_POST['roomnumber'];

    $check_mngDepartment = $mngDepartment->setDepartment($roomname, $description, $roomnumber);
}

if (isset($_GET["delete"])) {
    $id = $_GET['delete'];
    $check_mngDepartment = $mngDepartment->deleteDepartment($id);
}

if (isset($check_mngDepartment)) {
    echo $check_mngDepartment;
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
                                    <div class="card-header pt-2 pb-2">
                                        <div class="row">
                                            <div class="col-6 p-2">
                                                <h5>DANH SÁCH PHÒNG BAN</h5>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".department">Thêm phòng ban</button> </a>
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
                                                                    <th style="width: 25%;">Tên phòng ban</th>
                                                                    <th style="width: 35%;">Mô tả</th>
                                                                    <th style="width: 10%;">Số phòng</th>
                                                                    <th style="width: 20%;">Trưởng phòng</th>
                                                                    <th style="width: 10%;">Thao tác</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;

                                                                $getDepartment = $mngDepartment->getDepartment();
                                                                if ($getDepartment) {
                                                                    while ($value = $getDepartment->fetch_assoc()) {
                                                                ?>
                                                                        <tr>
                                                                            <td class="align-baseline" scope="row"><?php echo $i++; ?></td>
                                                                            <td class="align-baseline"><?php echo $value['roomname']; ?></td>
                                                                            <td class="align-baseline"><?php echo $fm->textShorten($value['description'], 50); ?></td>
                                                                            <td class="align-baseline"><?php echo $value['roomnumber']; ?></td>
                                                                            <?php
                                                                            $id = $value['id'];
                                                                            $getManagerFullname = $mngDepartment->getManagerFullname($id);
                                                                            if ($getManagerFullname) {
                                                                                $valueManager = $getManagerFullname->fetch_assoc();
                                                                                $manager = $valueManager['fullname'];
                                                                            } else {
                                                                                $manager = "";
                                                                            }
                                                                            ?>
                                                                            <td class="align-baseline"><?php echo $manager; ?></td>
                                                                            <td class="align-baseline">
                                                                                <a href="?q=departmentedit&edit=<?php echo $value['id']; ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>">
                                                                                    <button type="button" class="btn btn-outline-success pt-1 pb-1">Xem</button>
                                                                                </a>
                                                                                <a href="?q=department&delete=<?php echo $value['id']; ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>" onclick="return confirm('Hãy cân nhắc kỹ trước khi xóa?');">
                                                                                    <button type="button" class="btn btn-outline-danger pt-1 pb-1">Xóa</button>
                                                                                </a>
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

                        <!-- [Thêm tài khoản] -->
                        <div class="modal fade department" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title h4" id="myLargeModalLabel">THÊM PHÒNG BAN</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <form action="?q=department" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Tên phòng ban</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="roomname" placeholder="Kỹ thuật">
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Mô tả</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="description" placeholder="Hỗ trợ các vấn đề về phần mềm, hệ thống, an ninh mạng của công ty..." rows="5"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-sm-2 text-sm-right">Số phòng</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="roomnumber" class="form-control" placeholder="01">
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Thêm phòng ban</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>