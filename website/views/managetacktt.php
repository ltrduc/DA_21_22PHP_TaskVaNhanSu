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
                                            <li class="breadcrumb-item"><a>Quản lý công việc</a></li>
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
                                                <h5>DANH SÁCH CÔNG VIỆC ĐÃ GIAO</h5>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-primary pb-1 pt-1" data-toggle="modal" data-target=".task">Tạo công việc</button>
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
                                                                    <th style="width: 5%;">Stt</th>
                                                                    <th style="width: 20%;">Tiêu đề</th>
                                                                    <th style="width: 30%;">Mô tả công việc</th>
                                                                    <th style="width: 10%;">Thời hạn</th>
                                                                    <th style="width: 10%;">Nhân viên</th>
                                                                    <th style="width: 10%;">Trạng thái</th>
                                                                    <th style="width: 5%;">Xem</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

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

                        <!-- [Tạo task] -->
                        <div class="modal fade task" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header pt-2 pb-2">
                                        <h5 class="modal-title h4" id="myLargeModalLabel">TẠO CÔNG VIỆC</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>

                                    <div class="card-body">
                                        <form action="?q=managetacktt" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="form-label">Tiêu đề</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Thời hạn</label>
                                                    <input type="date" name="begin" class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Nhân viên tiếp nhận</label>
                                                    <select name="position" class="custom-select">
                                                        <option value="">---Chọn Nhân sự---</option>
                                                        <?php
                                                        $idUser = Session::get('id');
                                                        $getAccountDepartment = $mngUser->getAccountDepartment($idUser);
                                                        if ($getAccountDepartment) {
                                                            while ($valueDepartment = $getAccountDepartment->fetch_assoc()) {
                                                        ?>
                                                                <option value="<?php echo $valueDepartment['user'] ?>"><?php echo $valueDepartment['fullname'] ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label w-100">File đính kèm (Nếu có)</label>
                                                    <input name="proof" id="file-upload" type="file">
                                                    <small class="form-text text-muted"><b style="color: red;">LƯU Ý:</b> Chỉ chấp nhận file zip</small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.16.2/ckeditor.js"></script>
                                                <label class="form-label">Mô tả công việc</label>
                                                <textarea name="contentpost" id="contentpost"></textarea>
                                                <script>
                                                    CKEDITOR.replace('contentpost');
                                                </script>
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
                        <!-- [End Tạo task] -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>