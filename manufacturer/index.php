<?php
session_start();

if (isset($_SESSION["rb_manu"])) {
  require "../config/MySQLConnector.php";

  $manufacturerSession = $_SESSION["rb_manu"];
  $db = new MySQLConnector();
  $sql = "SELECT `order_has_manifacturer`.`status`,`order`.`name`,`order`.`datetime`,`order_has_manifacturer`.`id`,`order_has_manifacturer`.`uid` FROM `order` INNER JOIN `order_has_manifacturer` ON `order_has_manifacturer`.`order_id`=`order`.`id` WHERE `order_has_manifacturer`.`manifacturer_id`=? AND `order`.`status`!=?";
  $result = $db->search($sql, "is", [$manufacturerSession["id"], 'CANCELED']);


  $new = 0;
  $process = 0;
  $complete = 0;
  $cancel = 0;

  $HOLD = 0;
  $PENDING = 0;
  $INITIALGERBER = 0;
  $ENGINEERQUESTION = 0;
  $PROCESSEDGERBER = 0;
  $MANUFACTURING = 0;
  $DISPATCHBOARDS = 0;
  $BOARDSRECEIVE = 0;
  $BOARDSTEST = 0;

  $all = count($result);
  $processingOrdersArray = array();
  $newOrderArray = array();
  if ($all != 0) {
    for ($i = 0; $i < $all; $i++) {
      $order = $result[$i];
      if ($order["status"] == "NEW") {
        $newOrderArray[] = $order;
        $new++;
      } else if ($order["status"] == "PROCESSING") {
        $process++;
        
      } else if ($order["status"] == "COMPLETED") {
        $complete++;
      } else if ($order["status"] == "CANCELED") {
        $cancel++;
      } else if ($order["status"] == "HOLD") {
        $HOLD++;
      } else if ($order["status"] == "INITIAL GERBER") {
        $INITIALGERBER++;
      } else if ($order["status"] == "ENGINEER QUESTION") {
        $ENGINEERQUESTION++;
      } else if ($order["status"] == "PROCESSED GERBER") {
        $PROCESSEDGERBER++;
      } else if ($order["status"] == "MANUFACTURING") {
        $MANUFACTURING++;
      } else if ($order["status"] == "DISPATCH BOARDS") {
        $DISPATCHBOARDS++;
      } else if ($order["status"] == "BOARDS RECEIVE") {
        $BOARDSRECEIVE++;
      } else if ($order["status"] == "BOARDS TEST") {
        $BOARDSTEST++;
      } else if ($order["status"] == "PENDING") {
        $processingOrdersArray[] = $order;
        $PENDING++;
      }
    }
  }

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
    <title>Manufacturer Dashboard</title>
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
            <a class="navbar-brand" href="#">
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

              <li class="nav-item dropdown">




                <a class="nav-link dropdown-toggle waves-effect waves-dark position-relative"
                  href="#"
                  id="2"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                  style="overflow: visible;">

                  <?php

                  $chatResult = $db->search("SELECT chat.type,chat.datetime,chat.message,order_has_manifacturer.uid FROM `chat` INNER JOIN `chat_room` ON `chat_room`.`id`=`chat`.`chat_room_id` INNER JOIN `order_has_manifacturer` ON `order_has_manifacturer`.`id`=`chat_room`.`order_has_manifacturer_id` WHERE `order_has_manifacturer`.`manifacturer_id`='" . $_SESSION["rb_manu"]["id"] . "' AND `chat`.`person`='designer' AND `chat`.`is_view`='0'");

                  if (count($chatResult) > 0) {
                  ?>
                    <span class="position-absolute top-0 start-100 translate-middle-x badge rounded-pill bg-danger"
                      style="font-size: 0.75rem; padding: 4px 6px; transform: translate(-50%, -30%);">
                      <?= count($chatResult) ?>
                      <span class="visually-hidden">unread messages</span>
                    </span>
                  <?php
                  }
                  ?>

                  <!-- Notification Count Badge -->


                  <i class="font-24 mdi mdi-comment-processing"></i>
                </a>


                <ul
                  class="
  dropdown-menu dropdown-menu-end
  mailbox
  animated
  bounceInDown
"
                  aria-labelledby="2">
                  <ul class="list-style-none">
                    <li>
                      <div class="">
                        <!-- Message -->


                        <?php

                        for ($c = 0; $c < count($chatResult); $c++) {
                          $chat = $chatResult[$c];
                        ?>
                          <a href="myOrders/orderView/?orderNum=<?= $chat["uid"] ?>" class="link border-top">
                            <div class="d-flex no-block align-items-center p-10">
                              <span
                                class="
              btn btn-success btn-circle
              d-flex
              align-items-center
              justify-content-center
            "><i class="me-2 mdi mdi-message-reply text-white"></i></span>
                              <div class="ms-2">
                                <h5 class="mb-0"><?= $chat["datetime"] ?></h5>
                                <?php
                                if ($chat["type"] == "file") {
                                ?>
                                  <span class="mail-desc">Designer Uploaded A File</span>
                                <?php
                                } else {
                                ?>
                                  <span class="mail-desc"><?= (strlen($chat["message"]) > 20) ? substr($chat["message"], 0, 20) . "..." : $chat["message"] ?></span>
                                <?php
                                }
                                ?>

                              </div>
                            </div>
                          </a>
                        <?php
                        }

                        ?>


                      </div>
                    </li>
                  </ul>
                </ul>
              </li>
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
                  if (!empty($manufacturerSession["img"])) {
                    $imagePath = "../resources/companyImg/" . $manufacturerSession["img"];
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
                  href="myOrders/"
                  aria-expanded="false"><i class="me-2 mdi mdi-truck"></i><span class="hide-menu">Order Details</span></a>
              </li>


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


            <div class="col-lg-4 col-12">
              <div class="row">
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box  bg-warning text-center">
                      <h1 class="font-light text-white">
                        <i class="mdi mdi-truck-delivery"></i>
                      </h1>
                      <h6 class="text-white">All</h6>
                      <h3 class="text-white"><?php echo $all ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-info text-center">
                      <h1 class="font-light text-white">
                        <i class="me-2 mdi mdi-cart"></i>
                      </h1>
                      <h6 class="text-white">NEW</h6>
                      <h3 class="text-white"><?php echo $new ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                      <h1 class="font-light text-white">
                        <i class=" mdi mdi-timer-sand"></i>
                      </h1>
                      <h6 class="text-white">PROCESSING</h6>
                      <h3 class="text-white"><?php echo $process ?></h3>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-danger text-center">
                      <h1 class="font-light text-white">
                        <i class=" mdi mdi-timer"></i>
                      </h1>
                      <h6 class="text-white">PENDING</h6>
                      <h3 class="text-white"><?php echo $PENDING ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-success text-center">
                      <h1 class="font-light text-white">
                        <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                      </h1>
                      <h6 class="text-white">COMPLETED</h6>
                      <h3 class="text-white"><?php echo $complete ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-danger text-center">
                      <h1 class="font-light text-white">
                        <i class="mdi mdi-delete-forever"></i>
                      </h1>
                      <h6 class="text-white">CANCELED</h6>
                      <h3 class="text-white"><?php echo $cancel ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->

                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-dark text-center">
                      <h1 class="font-light text-white">
                        <i class="me-2 mdi mdi-pause"></i>
                      </h1>
                      <h6 class="text-white">HOLD</h6>
                      <h3 class="text-white"><?php echo $HOLD ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->

                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-info text-center">
                      <h1 class="font-light text-white">
                        <i class="me-2 mdi mdi-source-commit-start"></i>
                      </h1>
                      <h6 class="text-white">INITIAL GERBER</h6>
                      <h3 class="text-white"><?php echo $INITIALGERBER ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->

                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-white text-center">
                      <h1 class="font-light text-black">
                        <i class="me-2 mdi mdi-network-question"></i>
                      </h1>
                      <h6 class="text-black">ENGINEER QUESTION</h6>
                      <h3 class="text-black"><?php echo $ENGINEERQUESTION ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->


                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-warning text-center">
                      <h1 class="font-light text-white">
                        <i class="me-2 mdi mdi-message-settings-variant"></i>
                      </h1>
                      <h6 class="text-white">PROCESSED GERBER</h6>
                      <h3 class="text-white"><?php echo $PROCESSEDGERBER ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->

                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-primary text-center">
                      <h1 class="font-light text-white">
                        <i class="me-2 mdi mdi-autorenew"></i>
                      </h1>
                      <h6 class="text-white">MANUFACTURING</h6>
                      <h3 class="text-white"><?php echo $MANUFACTURING ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->

                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                      <h1 class="font-light text-white">
                        <i class="me-2 mdi mdi-truck-delivery"></i>
                      </h1>
                      <h6 class="text-white">DISPATCH BOARDS</h6>
                      <h3 class="text-white"><?php echo $DISPATCHBOARDS ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->

                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-success text-center">
                      <h1 class="font-light text-white">
                        <i class="me-2 mdi mdi-home-modern"></i>
                      </h1>
                      <h6 class="text-white">BOARDS RECEIVE</h6>
                      <h3 class="text-white"><?php echo $BOARDSRECEIVE ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->

                <!-- Column -->
                <div class="col-md-6 col-lg-4 col-xlg-4">
                  <div class="card card-hover">
                    <div class="box bg-white text-center">
                      <h1 class="font-light text-black">
                        <i class="me-2 mdi mdi-test-tube"></i>
                      </h1>
                      <h6 class="text-black">BOARDS TEST</h6>
                      <h3 class="text-black"><?php echo $BOARDSTEST ?></h3>
                    </div>
                  </div>
                </div>
                <!-- Column -->
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Recent Chat</h4>
                </div>
                <div class="comment-widgets scrollable">


                  <?php

                  $chatResult = $db->search("SELECT chat.message,chat.datetime,chat.type,order_has_manifacturer.uid FROM `chat` INNER JOIN `chat_room` ON `chat_room`.`id`=`chat`.`chat_room_id` INNER JOIN `order_has_manifacturer` ON `order_has_manifacturer`.`id`=`chat_room`.`order_has_manifacturer_id` WHERE `order_has_manifacturer`.`manifacturer_id`=? AND `chat`.`person`=? ORDER BY `chat`.`datetime` DESC LIMIT 5", 'is', [$manufacturerSession["id"], "designer"]);


                  for ($c = 0; $c < count($chatResult); $c++) {
                  ?>
                    <div role="button" class="d-flex flex-row comment-row mt-0" onclick="window.location='myOrders/orderView/?orderNum=<?= $chatResult[$c]['uid'] ?>'">
                      <div class="">
                        <img
                          src="../assets/images/users/1.jpg"
                          alt="user"
                          width="50"
                          class="rounded-circle" />
                      </div>
                      <div class="comment-text w-100">
                        <h6 class="font-medium">Designer</h6>
                        <span class="mb-3 d-block"><?php
                                                    if ($chatResult[$c]["type"] == "file") {
                                                      echo "Uploaded A File";
                                                    } else {
                                                      echo $chatResult[$c]["message"];
                                                    }
                                                    ?>
                        </span>
                        <div class="comment-footer">
                          <span class="text-muted float-end"><?= $chatResult[$c]["datetime"] ?></span>

                        </div>
                      </div>
                    </div>
                  <?php

                  }
                  ?>

                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-0">New Orders (<?= count($newOrderArray) ?>)</h5>
                    </div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Order</th>
                          <th scope="col">Order Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        for ($or = 0; $or < count($newOrderArray); $or++) {
                          $process = $newOrderArray[$or];



                        ?>
                          <tr role="button" onclick="window.location='myOrders/orderView/?orderNum=<?= $process['uid'] ?>'">
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
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-0">Pending Orders (<?= count($processingOrdersArray) ?>)</h5>
                    </div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Order</th>
                          <th scope="col">Order Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        for ($or = 0; $or < count($processingOrdersArray); $or++) {
                          $process = $processingOrdersArray[$or];

                        ?>
                          <tr role="button" onclick="window.location='myOrders/orderView/?orderNum=<?= $process['uid'] ?>'">
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
              </div>
            </div>
          </div>
          <!-- Column -->
          <!-- Column -->


          
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
    window.location = "login";
  </script>
<?php
}
?>