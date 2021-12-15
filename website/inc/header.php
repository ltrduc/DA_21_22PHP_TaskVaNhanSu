<!-- [ Header ] start -->
<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
        <a href="index.html" class="b-brand">
            <img src="../assets/images/logo.svg" alt="" class="logo images">
            <img src="../assets/images/logo-icon.svg" alt="" class="logo-thumb images">
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#!">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <a href="#!" class="mob-toggler"></a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <div class="main-search open">
                    <div class="input-group">
                        <input type="text" id="m-search" class="form-control" placeholder="Search . . .">
                        <a href="#!" class="input-group-append search-close">
                            <i class="feather icon-x input-group-text"></i>
                        </a>
                        <span class="input-group-append search-btn btn btn-primary">
                            <i class="feather icon-search input-group-text"></i>
                        </span>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li style="color: black;">
                <?php echo Session::get('fullname'); ?>
            </li>
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon feather icon-settings"></i>
                    </a>
                    <?php
                    if (isset($_GET['q']) && $_GET['q'] == 'logout') {
                        Session::destroy();
                    }
                    ?>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
                            <?php
                            $id_imageUser = Session::get('id');
                            $q_imagesUser = "SELECT * FROM tbl_user WHERE id = '$id_imageUser'";
                            $r_imagesUser = $db->select($q_imagesUser);
                            if ($r_imagesUser) {
                                $v_imagesUser = $r_imagesUser->fetch_assoc();
                            }
                            ?>
                            <img src="<?php echo $v_imagesUser['images']; ?>" class="img-radius" width="30" height="40">
                            <span>
                                <?php echo Session::get('fullname'); ?>
                            </span>
                            <a href="?q=logout" class="dud-logout" title="Logout">
                                <i class="feather icon-log-out"></i>
                            </a>
                        </div>
                        <ul class="pro-body">
                            <li><a href="#!" class="dropdown-item"><i class="feather icon-settings"></i> Đổi mật khẩu</a></li>
                            <?php $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz'; ?>
                            <li><a href="?q=useredit&edit=<?php echo Session::get('id'); ?>&<?php echo substr(str_shuffle($permitted_chars), 0, 30); ?>" class="dropdown-item"><i class="feather icon-user"></i> Thông tin</a></li>
                            <li><a href="?q=logout" class="dropdown-item"><i class="feather icon-lock"></i> Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<!-- [ Header ] end -->