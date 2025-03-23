<?php
session_start();

if (isset($_SESSION["rb_user"]) && ($_SESSION["rb_user"]["type"] == "finance"||$_SESSION["rb_user"]["type"] == "finance_head")) {
  require "../config/MySQLConnector.php";

  $db = new MySQLConnector();
  $sql = "SELECT * FROM `order` WHERE `status`=? ORDER BY `datetime` DESC";
  $result = $db->search($sql, "s", ["NEW"]);

?>


  <!DOCTYPE html>
  <html dir="ltr" lang="en">

  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="keywords"
      content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template" />
    <meta
      name="description"
      content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Finance Dashboard</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../assetss/images/logotitle.jpg" />
    <!-- Custom CSS -->
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full">
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header" data-logobg="skin5">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="">
              <!-- Logo icon -->
              <b class="logo-icon ps-2">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img
                  src="../assetss/images/logo.webp"
                  alt="homepage"
                  class="light-logo"
                  width="25" />
              </b>
              <!--End Logo icon -->
              <!-- Logo text -->
              <span class="logo-text ms-2">
                <!-- dark Logo text -->
                <img
                  src="../assetss/images/logo.webp"
                  alt="homepage"
                  class="light-logo" width="180" />
              </span>
              <!-- Logo icon -->
              <!-- <b class="logo-icon"> -->
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <!-- <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

              <!-- </b> -->
              <!--End Logo icon -->
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a
              class="nav-toggler waves-effect waves-light d-block d-md-none"
              href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
          </div>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <div
            class="navbar-collapse collapse"
            id="navbarSupportedContent"
            data-navbarbg="skin5">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-start me-auto">
              <li class="nav-item d-none d-lg-block">
                <a
                  class="nav-link sidebartoggler waves-effect waves-light"
                  href="javascript:void(0)"
                  data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
              </li>
              <!-- ============================================================== -->
              <!-- create new -->
              <!-- ============================================================== -->

              <!-- ============================================================== -->
              <!-- Search -->
              <!-- ============================================================== -->

            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">

              
              <!-- ============================================================== -->
              <!-- End Messages -->
              <!-- ============================================================== -->

              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
              <li class="nav-item dropdown">
                <a
                  class="
                    nav-link
                    dropdown-toggle
                    text-muted
                    waves-effect waves-dark
                    pro-pic
                  "
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <?php

                  $imagePath = "../assets/images/users/1.jpg";
                  if (!empty($_SESSION["rb_user"]["img"])) {
                    $imagePath = "../resources/userImg/" . $_SESSION["rb_user"]["img"];
                  }
                  ?>
                  <img
                    src="<?= $imagePath ?>"
                    alt="user"
                    class="rounded-circle"
                    width="31" height="31" />
                </a>
                <ul
                  class="dropdown-menu dropdown-menu-end user-dd animated"
                  aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="profile/"><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php"><i class="fa fa-power-off me-1 ms-1"></i> Logout</a>


                </ul>
              </li>
              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href=""
                  aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
              </li>


              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="manageOrder/"
                  aria-expanded="false"><i class="me-2 mdi mdi-truck"></i><span class="hide-menu">Order Details</span></a>
              </li>

              <?php
              if ($_SESSION["rb_user"]["type"] == "finance_head") {
              ?>
                <li class="sidebar-item ">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="manageFinance/"
                    aria-expanded="false"><i class="me-2 mdi mdi-account"></i><span class="hide-menu">Manage Finance</span></a>
                </li>
      
              <?php
              }
              ?>


              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="profile/"
                  aria-expanded="false"><i class="me-2 mdi mdi-account-circle"></i><span class="hide-menu">My Profile</span></a>
              </li>


            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Dashboard</h4>
              
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Sales Cards  -->
          <!-- ============================================================== -->

          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-0">New Orders (<?= count($result) ?>)</h5>
                </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Order</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    for ($or = 0; $or < count($result); $or++) {
                      $process = $result[$or];



                    ?>
                      <tr role="button" onclick="window.location='manageOrder/orderView/?id=<?= $process['id'] ?>'">
                        <td><?= $process["name"] ?></td>
                        <td><?= $process["datetime"] ?></td>
                      </tr>
                    <?php
                    }

                    ?>


                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Latest Quotation</h4>
                </div>
                <div class="comment-widgets scrollable">
                  <!-- Comment Row -->


                  <?php



                  $manuOrderQuery = "SELECT `order`.`id`,`quotation`.`datetime`,`manifacturer`.`name`,`manifacturer`.`img`,`order`.`name` AS `oname` FROM `quotation` INNER JOIN `order_has_manifacturer` ON `quotation`.`order_has_manifacturer_id`=`order_has_manifacturer`.`id` INNER JOIN `manifacturer` ON `manifacturer`.`id`=`order_has_manifacturer`.`manifacturer_id` INNER JOIN `order` ON `order`.`id`=`order_has_manifacturer`.`order_id` ORDER BY `quotation`.`datetime` DESC LIMIT 5";
                  $manuOrderResult = $db->search($manuOrderQuery);


                  for ($i = 0; $i < count($manuOrderResult); $i++) {
                    $manufacturer = $manuOrderResult[$i];

                    $imgpath = "../assets/images/users/1.jpg";
                    if (!empty($manufacturer["img"])) {
                      $imgpath = "../resources/companyImg/" . $manufacturer["img"];
                    }

                  ?>
                    <div class="d-flex flex-row comment-row mt-0" onclick="window.location='manageOrder/orderView/?id=<?= $manufacturer['id'] ?>'" role="button">
                      <div class="p-2">
                        <img
                          src="<?= $imgpath ?>"
                          alt="user"
                          width="50"
                          class="rounded-circle" />
                      </div>
                      <div class="comment-text w-100">
                        <h6 class="font-medium"><?= $manufacturer["name"] ?></h6>
                        <span class="mb-3 d-block"><?= $manufacturer["oname"] ?>
                        </span>
                        <div class="comment-footer">
                          <span class="text-muted float-end"><?= $manufacturer["datetime"] ?></span>

                        </div>
                      </div>
                    </div>

                  <?php
                  }


                  ?>

                  <!-- Comment Row -->

                </div>
              </div>
            </div>

          </div>
          <!-- ============================================================== -->
          <!-- Sales chart -->
          <!-- ============================================================== -->

          <!-- ============================================================== -->
          <!-- Sales chart -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Recent comment and chats -->
          <!-- ============================================================== -->

          <!-- ============================================================== -->
          <!-- Recent comment and chats -->
          <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="../assets/libs/flot/excanvas.js"></script>
    <script src="../assets/libs/flot/jquery.flot.js"></script>
    <script src="../assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="../assets/libs/flot/jquery.flot.time.js"></script>
    <script src="../assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="../assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="../assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="../dist/js/pages/chart/chart-page-init.js"></script>
  </body>

  </html>

<?php
} else {
?>
  <script>
    window.location = "../";
  </script>
<?php
}
?>