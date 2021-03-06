<!DOCTYPE html>
<html lang="en">

<head>

    <title>Flash</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon icon -->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="../assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="../assets/plugins/animation/css/animate.min.css">
    <!-- Data table -->
    <link rel="stylesheet" href="../assets/plugins/datatable/datatables.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar menupos-fixed menu-light brand-blue ">
        <div class="navbar-wrapper ">
            <div class="navbar-brand header-logo">
                <a href="index.html" class="b-brand">
                    <img src="../assets/images/logo.svg" alt="" class="logo images">
                    <img src="../assets/images/logo-icon.svg" alt="" class="logo-thumb images">
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item">
                        <a href="?q=homepage" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Trang t???ng quan</span></a>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Qu???n l?? chuy??n m??n</label>
                    </li>
                    <?php if (Session::get('level') == "0") { ?>
                        <li class="nav-item">
                            <a href="?q=listuser" class="nav-link"><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Qu???n l?? t??i kho???n</span></a>
                        </li>
                    <?php } ?>
                    <?php if (Session::get('level') == "0") { ?>
                        <li class="nav-item">
                            <a href="?q=department" class="nav-link"><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Qu???n l?? ph??ng ban</span></a>
                        </li>
                    <?php } ?>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link"><span class="pcoded-micon"><i class="feather icon-book"></i></span><span class="pcoded-mtext">Qu???n l?? nghi???p v???</span></a>
                        <ul class="pcoded-submenu">
                            <?php if (Session::get('level') == "1") { ?>
                                <li class=""><a href="?q=managetacktt" class="">Qu???n l?? c??ng vi???c</a></li>
                            <?php } ?>
                            <?php if (Session::get('level') == "2") { ?>
                                <li class=""><a href="?q=managetacknv" class="">Qu???n l?? c??ng vi???c</a></li>
                            <?php } ?>
                            <?php if (Session::get('level') == "0" || Session::get('level') == "1") { ?>
                                <li class=""><a href="?q=manageleave" class="">Y??u c???u ngh??? ph??p</a></li>
                            <?php } ?>
                            <?php if (Session::get('level') == "1" || Session::get('level') == "2") { ?>
                                <li class=""><a href="?q=creationhistory" class="">????n xin ngh??? ph??p</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Thao t??c kh??c</label>
                    </li>
                    <?php
                    if (isset($_GET['q']) && $_GET['q'] == 'logout') {
                        Session::destroy();
                    }
                    ?>
                    <li class="nav-item"><a href="?q=logout" class="nav-link"><span class="pcoded-micon"><i class="feather icon-lock"></i></span><span class="pcoded-mtext">????ng xu???t</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->