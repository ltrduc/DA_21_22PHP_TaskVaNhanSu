<?php
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
                                            <li class="breadcrumb-item"><a>Quản lý nghỉ phép</a></li>
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
                                        <h5>DANH SÁCH NGHỈ PHÉP</h5>
                                    </div>
                                    <div class="card-body">
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
                                                                    <th style="width: 25%;">Phòng ban</th>
                                                                    <th style="width: 35%;">Lý do</th>
                                                                    <th style="width: 15%;">Từ ngày</th>
                                                                    <th style="width: 15%;">Đến ngày</th>
                                                                    <th style="width: 10%;">Trạng thái</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                $id_user = Session::get('id');
                                                                $level_user = Session::get('level');
                                                                $getLeaveLevel = $mngLeave->getLeave($id_user, $level_user);
                                                                if ($getLeaveLevel) {
                                                                    while ($value = $getLeaveLevel->fetch_assoc()) { ?>
                                                                        <tr>
                                                                            <td><?php echo $i++; ?></td>
                                                                            <td><a href="?q=manageleaveedit&edit=<?php echo $value['id'] ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>">NV<?php echo $value['id_user'] ?></a></td>
                                                                            <td><a href="?q=manageleaveedit&edit=<?php echo $value['id'] ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>"><?php echo $value['fullname'] ?></a></td>
                                                                            <td><?php echo $value['roomname']; ?> - P<?php echo $value['roomnumber']; ?></td>
                                                                            <td><?php echo $fm->textShorten($value['description'], 100) ?></td>
                                                                            <td><?php echo $fm->formatDate($value['begin']) ?></td>
                                                                            <td><?php echo $fm->formatDate($value['end']) ?></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>