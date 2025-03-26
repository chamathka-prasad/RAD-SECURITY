<?php

session_start();
if (isset($_SESSION["rb_manu"])) {
  $manuSession = $_SESSION["rb_manu"];
  require "../../../config/MySQLConnector.php";

  $db = new MySQLConnector();
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
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../../../assetss/images/logotitle.jpg" />
    <!-- Favicon icon -->
    <title>Manufacturer - Order View In Detail</title>
    <!-- Custom CSS -->
    <link
      rel="stylesheet"
      type="text/css"
      href="../../../assets/extra-libs/multicheck/multicheck.css" />
    <link
      href="../../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
      rel="stylesheet" />
    <link href="../../../dist/css/style.min.css" rel="stylesheet" />
    <link href="../../../assets/libs/toastr/build/toastr.min.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onload="">
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
            <a class="navbar-brand" href="../../">
              <!-- Logo icon -->
              <b class="logo-icon ps-2">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img
                  src="../../../assetss/images/logo.webp"
                  alt="homepage"
                  class="light-logo"
                  width="25" />
              </b>
              <!--End Logo icon -->
              <!-- Logo text -->
              <span class="logo-text ms-2">
                <!-- dark Logo text -->
                <img
                  src="../../../assetss/images/logo.webp"
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


                  if (isset($_GET["orderNum"])) {
                    $chatResultThisOrder = $db->search("SELECT chat.id,chat.type,chat.datetime,chat.message,order_has_manifacturer.uid FROM `chat` INNER JOIN `chat_room` ON `chat_room`.`id`=`chat`.`chat_room_id` INNER JOIN `order_has_manifacturer` ON `order_has_manifacturer`.`id`=`chat_room`.`order_has_manifacturer_id` WHERE `order_has_manifacturer`.`manifacturer_id`='" . $_SESSION["rb_manu"]["id"] . "' AND `chat`.`person`='designer' AND `chat`.`is_view`='0' AND order_has_manifacturer.uid='" . $_GET["orderNum"] . "'");
                    for ($notwach = 0; $notwach < count($chatResultThisOrder); $notwach++) {
                      $db->iud("UPDATE `chat` SET `is_view`='1' WHERE `id`='" . $chatResultThisOrder[$notwach]["id"] . "'");
                    }
                  }

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
                          <a href="../orderView/?orderNum=<?= $chat["uid"] ?>" class="link border-top">
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

                  $imagePath = "../../../assets/images/users/1.jpg";
                  if (!empty($manuSession["img"])) {
                    $imagePath = "../../../resources/companyImg/" . $manuSession["img"];
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
                  <a class="dropdown-item" href="../../profile/"><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../../logout.php"><i class="fa fa-power-off me-1 ms-1"></i> Logout</a>


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
                  href="../../"
                  aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
              </li>

              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="../"
                  aria-expanded="false"><i class="me-2 mdi mdi-truck"></i><span class="hide-menu">Order Details</span></a>
              </li>


              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="../../profile/"
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
              <a href="../">
                <h4 class="page-title">My Orders </h4>
              </a>
              <h4 class="page-title">/ Order Details</h4>


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
          <!-- Start Page Content -->
          <!-- ============================================================== -->

          <!-- before Upload -->

          <?php



          if (!isset($_GET["orderNum"])) {
          ?>
            <script>
              window.location = "../"
            </script>
            <?php
          } else {
            $uid = $_GET["orderNum"];
            $sql = "SELECT `order_has_manifacturer`.`id`,`order_has_manifacturer`.`status`,`order`.`name`,`order`.`dead_line`,`order`.`datetime`,`order`.`path`,`order`.`id` AS `order_id_history`  FROM order_has_manifacturer INNER JOIN `order` ON `order`.`id`=`order_has_manifacturer`.`order_id` WHERE `uid`=?";
            $result = $db->search($sql, "s", [$uid]);


            if (count($result) > 0) {

              $manuOrderDetails = $result[0];

              if ($manuOrderDetails["status"] == "NEW") {
            ?>
                <div class="row">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">

                        <div class="col-12 col-md-8">
                          <span><?php echo $manuOrderDetails["name"] ?></span> <br>
                          <span>Order Date: <?php echo $manuOrderDetails["datetime"] ?></span> <br>
                          <span>Quotation Deadline: <?php echo $manuOrderDetails["dead_line"] ?></span> <br>
                          <span class="text-success fw-bolder"><?php echo $manuOrderDetails["status"] ?> ORDER</span> <br>

                        </div>
                        <div class="col-12 col-md-4 text-center">
                          <button class="btn btn-info" onclick="downloadFile('<?php echo '../../../resources/orders/' . $manuOrderDetails['path'] ?>', '<?php echo $manuOrderDetails['name'] . $manuOrderDetails['path'] ?>')">Download Order Zip</button>
                        </div>

                      </div>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <h4 class="card-title">Upload Your Quotation</h4>
                        <div class="col-12">
                          <div class="form-group row">
                            <label
                              for="lname"
                              class="col-sm-3 text-start text-lg-end control-label col-form-label">Zip file<span class="text-danger">&#8727;</span></label>
                            <div class="col-sm-9">
                              <input
                                type="file"
                                class="form-control"
                                id="qzip"
                                placeholder="zip" />
                            </div>
                          </div>
                          <div class="row justify-content-center">
                            <button class="btn btn-primary w-50" onclick="uploadQuotation()">Upload Quotation Zip</button>
                          </div>

                        </div>

                      </div>
                    </div>

                  </div>
                </div>
                <!-- before Upload -->
                <?php

              } else if ($manuOrderDetails["status"] == "PENDING") {
                $sqlquosearch = "SELECT * FROM quotation WHERE order_has_manifacturer_id = ?";
                $resultquotsearch = $db->search($sqlquosearch, 'i', [$manuOrderDetails["id"]]);

                if (count($resultquotsearch) > 0) {
                  $quotation = $resultquotsearch[0];

                ?>

                  <div class="row">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">

                          <div class="col-12 col-md-4">
                            <span><?php echo $manuOrderDetails["name"] ?></span> <br>
                            <span>Order Date: <?php echo $manuOrderDetails["datetime"] ?></span> <br>
                            <button class="btn btn-info" onclick="downloadFile('<?php echo '../../../resources/orders/' . $manuOrderDetails['path'] ?>', '<?php echo $manuOrderDetails['name'] . $manuOrderDetails['path'] ?>')">Download Order</button>

                          </div>

                          <div class="col-12 col-md-4">
                            <span>Quotation</span> <br>
                            <span><?php echo $quotation["datetime"] ?></span> <br>
                            <button class="btn btn-info" onclick="downloadFile('<?php echo '../../../resources/quotations/' . $quotation['path'] ?>', '<?php echo 'quotation' . $manuOrderDetails['name'] . $quotation['path'] ?>')">Download Your Quotation</button>
                          </div>

                          <div class="col-12 col-md-4">

                            <h4 class="card-title">Order Status</h4>
                            <span><?php echo $manuOrderDetails["status"] ?></span><br>
                            <span>Company Is checking your Quotation</span>
                          </div>

                        </div>
                      </div>

                    </div>
                  </div>
                <?php
                }


                ?>

                <?php
              } else if ($manuOrderDetails["status"] == "LOSS") {

                $sqlquosearch = "SELECT * FROM quotation WHERE order_has_manifacturer_id = ?";
                $resultquotsearch = $db->search($sqlquosearch, 'i', [$manuOrderDetails["id"]]);

                if (count($resultquotsearch) > 0) {
                  $quotation = $resultquotsearch[0];


                ?>
                  <div class="row">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">

                          <div class="col-12 col-md-4">
                            <span><?php echo $manuOrderDetails["name"] ?></span> <br>
                            <button class="btn btn-info" onclick="downloadFile('<?php echo '../../../resources/orders/' . $manuOrderDetails['path'] ?>', '<?php echo $manuOrderDetails['name'] . $manuOrderDetails['path'] ?>')">Download Order</button>

                          </div>

                          <div class="col-12 col-md-4">
                            <span>Quotation Submit Date : <?php echo $quotation["datetime"] ?>< </span> <br>
                                <button class="btn btn-info" onclick="downloadFile('<?php echo '../../../resources/quotations/' . $quotation['path'] ?>', '<?php echo 'quotation' . $manuOrderDetails['name'] . $quotation['path'] ?>')">Download Your Quotation</button>
                          </div>

                          <div class="col-12 col-md-4">

                            <h4 class="card-title">Order Status</h4>
                            <span><?php echo $manuOrderDetails["status"] ?></span>
                          </div>

                        </div>
                      </div>

                    </div>
                  </div>

                <?php
                }
              } else if ($manuOrderDetails["status"] == "NOT SUBMITTED") {
                ?>
                <div class="row">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">

                        <div class="col-12 col-md-8">
                          <span><?php echo $manuOrderDetails["name"] ?></span> <br>
                          <span>Order Date: <?php echo $manuOrderDetails["datetime"] ?></span> <br>
                          <span>Quotation Deadline: <?php echo $manuOrderDetails["dead_line"] ?></span> <br>
                          <span class="text-danger fw-bolder"><?php echo $manuOrderDetails["status"] ?> ORDER</span> <br>

                        </div>
                        <div class="col-12 col-md-4 text-center">
                          <button class="btn btn-info" onclick="downloadFile('<?php echo '../../../resources/orders/' . $manuOrderDetails['path'] ?>', '<?php echo $manuOrderDetails['name'] . $manuOrderDetails['path'] ?>')">Download Order Zip</button>
                        </div>

                      </div>
                    </div>

                  </div>
                </div>


                <!-- before Upload -->
                <?php

              } else {

                $sqlquosearch = "SELECT * FROM quotation WHERE order_has_manifacturer_id = ?";
                $resultquotsearch = $db->search($sqlquosearch, 'i', [$manuOrderDetails["id"]]);

                if (count($resultquotsearch) > 0) {
                  $quotation = $resultquotsearch[0];


                  $resultCharRooms = $db->search("SELECT * FROM `chat_room` WHERE `order_has_manifacturer_id`=?", "i", [$manuOrderDetails["id"]]);


                  if (count($resultCharRooms) == 1) {

                    $chatRoom = $resultCharRooms[0];
                ?>
                    <div class="row">
                      <div class="card">
                        <div class="card-body">
                          <div class="row">

                            <div class="col-12 col-md-3">
                              <span><?php echo $manuOrderDetails["name"] ?></span> <br>
                              <button class="btn btn-info" onclick="downloadFile('<?php echo '../../../resources/orders/' . $manuOrderDetails['path'] ?>', '<?php echo $manuOrderDetails['name'] . $manuOrderDetails['path'] ?>')">Download Order</button>

                            </div>

                            <div class="col-12 col-md-3">
                              <span>Quotation Submit Date :<?php echo $quotation["datetime"] ?></span> <br>
                              <button class="btn btn-info" onclick="downloadFile('<?php echo '../../../resources/quotations/' . $quotation['path'] ?>', '<?php echo 'quotation' . $manuOrderDetails['name'] . $quotation['path'] ?>')">Download Your Quotation</button>
                            </div>

                            <div class="col-12 col-md-3">

                              <h4 class="card-title">Order Status</h4>
                              <span><?php echo $manuOrderDetails["status"] ?></span>
                            </div>

                            <div class="col-12 col-md-3">

                              <h4 class="card-title">Change Status</h4>
                              <select name="" id="statusChange" class="form-select ">
                                <option value="0">Select</option>
                                <option value="INITIAL GERBER">INITIAL GERBER</option>
                                <option value="ENGINEER QUESTION">ENGINEER QUESTION</option>
                                <option value="PROCESSED GERBER">PROCESSED GERBER</option>
                                <option value="MANUFACTURING">MANUFACTURING</option>
                                <option value="DISPATCH BOARDS">DISPATCH BOARDS</option>
                                <option value="BOARDS RECEIVE">BOARDS RECEIVE</option>
                                <option value="BOARDS TEST">BOARDS TEST</option>

                              </select>
                              <div class="col-12 mt-2 mb-2 
                            <?php
                            // if ($orderDetails["status"] == "COMPLETED") {
                            //   echo "d-none";
                            // }
                            ?>
                                                          ">
                                <span><button class="btn btn-info w-100" onclick="changeTheOrderStatus()">Submit</button></span>
                              </div>


                            </div>


                            <div class="modal fade" id="stateChangeModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Order State Change Confirmation</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <h5 class="card-title mb-0">Order Details</h5>
                                    <div class="row mt-2">
                                      <div class="col-12">
                                        <span><?php echo $manuOrderDetails["name"] ?></span>
                                      </div>
                                      <div class="col-12">
                                        <span>Order Date : <?php echo $manuOrderDetails["datetime"] ?></span>
                                      </div>


                                      <hr>



                                    </div>

                                    <div class="row">
                                      <div class="col-12 mt-2">
                                        <span>Order Status <b><?php echo $manuOrderDetails["status"] ?></b></span>
                                      </div>
                                      <hr>
                                      <div class="col-12 mt-1">

                                        <input type="text" class="form-control" placeholder="select" id="statusChangeText" disabled />
                                      </div>
                                      <div class="col-12">
                                        <label for="" class="form-label">Type <b class="text-danger" id="statInformText">"select"</b> to Change The Status</label>
                                        <input type="text" class="form-control" placeholder="type" id="orderNewStatus" />
                                      </div>

                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="changeTheOrderStatusByModel(<?php echo $manuOrderDetails['id'] ?>)">Confirm</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>

                      </div>
                    </div>
                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        loadAllChats(<?php echo $chatRoom['id'] ?>)
                      }, false);
                    </script>


                    <div class="row">

                      <div class="col-12">
                        <div class="row">
                          <div class="card">
                            <div class="card-body">
                              <div class="row">

                                <div class="col-12 d-flex no-block align-items-center">
                                  <h4 class="card-title">Chat with Designer / <?php echo $manuOrderDetails["name"] ?> </h4>


                                </div>

                              </div>



                              <div class="chat-box scrollable" style="height: 440px">
                                <!--chat Row -->
                                <ul class="chat-list" id="chatContainer">
                                  <!--chat Row -->
                                </ul>
                              </div>
                            </div>
                            <div class="card-body border-top">
                              <div class="row">
                                <div class="col-lg-1 col-2 text-end">
                                  <!-- model trigger -->
                                  <a
                                    class="btn-circle btn-lg btn-warning float-end text-white"
                                    href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#uploadFile"><i class="me-2 mdi mdi-attachment"></i></a>

                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="uploadFile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Upload File</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-center">
                                        <h2>Upload File</h2>
                                        <label for="msgFile">
                                          <i class="mdi mdi-cloud-upload " style="font-size: xx-large;"></i>
                                        </label> <br>
                                        <input type="file" id="msgFile">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="saveFileChat(<?php echo $chatRoom['id'] ?>)">Upload</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-9 col-8">
                                  <div class="input-field mt-0 mb-0">
                                    <textarea

                                      placeholder="Type and enter"
                                      class="form-control border-0" id="chatText"></textarea>
                                  </div>
                                </div>
                                <div class="col-lg-2 col-2">
                                  <a
                                    class="btn-circle btn-lg btn-cyan float-end text-white"
                                    href="javascript:void(0)" onclick="saveChat(<?php echo $chatRoom['id'] ?>)"><i class="mdi mdi-send fs-3"></i></a>


                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-12 col-lg-6 offset-lg-3">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title mb-0">Order History</h5>
                            <div class="row mt-2">
                              <div class="col-12 justify-content-between">


                                <?php

                                $oh = $db->search("SELECT * FROM `order_history` WHERE `order_id`=? ORDER BY `date_time` ASC", 'i', [$manuOrderDetails["order_id_history"]]);
                                for ($his = 0; $his < count($oh); $his++) {
                                ?>

                                  <span><?php echo $oh[$his]["date_time"] ?></span>


                                  <span><?php echo $oh[$his]["process"] ?></span>



                                  <?php

                                  if ((count($oh) - 1) > $his) {
                                  ?>
                                    <hr>
                                <?php
                                  }
                                }
                                ?>







                              </div>

                            </div>

                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                  }
                  ?>

              <?php
                }
              }
            } else {
              ?>
              <script>
                window.location = "../";
              </script>
          <?php
            }
          }

          ?>





          <!-- ============================================================== -->
          <!-- End PAge Content -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Right sidebar -->
          <!-- ============================================================== -->
          <!-- .right-sidebar -->
          <!-- ============================================================== -->
          <!-- End Right sidebar -->
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
    <script src="../../../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../../../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../../../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../../../dist/js/custom.min.js"></script>
    <!-- this page js -->
    <script src="../../../assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="../../../assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="../../../assets/extra-libs/DataTables/datatables.min.js"></script>

    <script src="../../../assets/libs/toastr/build/toastr.min.js"></script>
    <script>
      const fileIcons = {
        'pdf': `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
</svg>`,
        'doc': `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-word" viewBox="0 0 16 16">
  <path d="M5.485 6.879a.5.5 0 1 0-.97.242l1.5 6a.5.5 0 0 0 .967.01L8 9.402l1.018 3.73a.5.5 0 0 0 .967-.01l1.5-6a.5.5 0 0 0-.97-.242l-1.036 4.144-.997-3.655a.5.5 0 0 0-.964 0l-.997 3.655L5.485 6.88z"/>
  <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
</svg>`,
        'xls': `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-filetype-xls" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM6.472 15.29a1.2 1.2 0 0 1-.111-.449h.765a.58.58 0 0 0 .254.384q.106.073.25.114.143.041.319.041.246 0 .413-.07a.56.56 0 0 0 .255-.193.5.5 0 0 0 .085-.29.39.39 0 0 0-.153-.326q-.152-.12-.462-.193l-.619-.143a1.7 1.7 0 0 1-.539-.214 1 1 0 0 1-.351-.367 1.1 1.1 0 0 1-.123-.524q0-.366.19-.639.19-.272.527-.422.338-.15.777-.149.457 0 .78.152.324.153.5.41.18.255.2.566h-.75a.56.56 0 0 0-.12-.258.6.6 0 0 0-.247-.181.9.9 0 0 0-.369-.068q-.325 0-.513.152a.47.47 0 0 0-.184.384q0 .18.143.3a1 1 0 0 0 .405.175l.62.143q.326.075.566.211a1 1 0 0 1 .375.358q.135.222.135.56 0 .37-.188.656a1.2 1.2 0 0 1-.539.439q-.351.158-.858.158-.381 0-.665-.09a1.4 1.4 0 0 1-.478-.252 1.1 1.1 0 0 1-.29-.375m-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94zm2.727 3.325H4.557v-3.325h-.79v4h2.487z"/>
</svg>`,
        'ppt': `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-filetype-ppt" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m2.817-1.333h-1.6v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474.162-.302.161-.677 0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H4.15V12.48h.66q.327 0 .512.181.185.183.185.522m2.767-.67v3.336H7.48v-3.337H6.346v-.662h3.065v.662z"/>
</svg>`,
        'jpg': `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-image" viewBox="0 0 16 16">
  <path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
  <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12z"/>
</svg>`,
        'zip': `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-zip-fill" viewBox="0 0 16 16">
  <path d="M8.5 9.438V8.5h-1v.938a1 1 0 0 1-.03.243l-.4 1.598.93.62.93-.62-.4-1.598a1 1 0 0 1-.03-.243"/>
  <path d="M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m2.5 8.5v.938l-.4 1.599a1 1 0 0 0 .416 1.074l.93.62a1 1 0 0 0 1.109 0l.93-.62a1 1 0 0 0 .415-1.074l-.4-1.599V8.5a1 1 0 0 0-1-1h-1a1 1 0 0 0-1 1m1-5.5h-1v1h1v1h-1v1h1v1H9V6H8V5h1V4H8V3h1V2H8V1H6.5v1h1z"/>
</svg>`,
        'txt': `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-fill" viewBox="0 0 16 16">
  <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z"/>
</svg>`
      };

      const defaultIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-richtext" viewBox="0 0 16 16">
  <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
  <path d="M4.5 12.5A.5.5 0 0 1 5 12h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5m0-2A.5.5 0 0 1 5 10h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5m1.639-3.708 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V8.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V8s1.54-1.274 1.639-1.208M6.25 6a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5"/>
</svg>`;


      function saveChat(chatroomId) {
        var chatText = document.getElementById("chatText");



        if (!chatroomId) {

          toastr.error(
            "Error Reload The Page",
            "Empty Details !"
          );


        } else if (!chatText.value) {

          toastr.error(
            "Please Type Something For Before Send",
            "Empty Details !"
          );

        } else {

          var formData = new FormData();
          formData.append("chatroomId", chatroomId);
          formData.append("chatText", chatText.value);

          fetch("api/saveDesignerChat.php", {
              method: "POST",
              body: formData,

            })
            .then(function(resp) {

              try {
                let response = resp.json();
                return response;
              } catch (error) {
                msg.classList = "alert alert-danger";
                msg.innerHTML = "Something wrong please try again";
                emailField.classList = "form-control";
                passwordField.classList = "form-control";
              }

            })
            .then(function(value) {

              if (value.type == "error") {
                toastr.error(
                  value.message,
                  "Error !"
                );


              } else if (value.type == "success") {
                toastr.success(value.message, "Success");

                loadAllChats(chatroomId);
                chatText.value = "";
              } else {
                toastr.error(
                  "Something Went Wrong Please Try Again",
                  "Error !"
                );
              }

            })
            .catch(function(error) {
              console.log(error);
            });


        }
      }

      async function downloadFile(url, suggestedName) {
        try {
          // Fetch the file as a blob
          const response = await fetch(url);
          const blob = await response.blob();

          // Check if the browser supports the File System Access API
          if ('showSaveFilePicker' in window) {
            const handle = await window.showSaveFilePicker({
              suggestedName: suggestedName,
              types: [{
                accept: {
                  'application/octet-stream': ['.pdf']
                }
              }]
            });

            const writable = await handle.createWritable();
            await writable.write(blob);
            await writable.close();
          } else {
            // Fallback method if File System Access API is not supported
            const anchor = document.createElement("a");
            anchor.href = URL.createObjectURL(blob);
            anchor.download = suggestedName;
            document.body.appendChild(anchor);
            anchor.click();
            document.body.removeChild(anchor);
            URL.revokeObjectURL(anchor.href);
          }
        } catch (error) {
          console.error("Error downloading file:", error);
        }
      }

      function loadAllChats(chatRoomId) {


        console.log(chatRoomId);

        var formData = new FormData();
        formData.append("chatRoomId", chatRoomId);

        fetch("api/getAllChats.php", {
            method: "POST",
            body: formData,
          })
          .then(function(resp) {

            try {
              let response = resp.json();
              return response;
            } catch (error) {

            }

          })
          .then(function(value) {

            var chatContainer = document.getElementById('chatContainer');
            chatContainer.innerHTML = "";



            var num = 1;

            value.forEach(element => { // var imgpath = "../../../assets/images/users/1.jpg";
              // if (element.img) {
              //   imgpath = "../../../resources/companyImg/" + element.img;
              // }

              var lastId = "";
              if (value.length == num) {
                lastId = "chat";
              }
              if (element.person == "designer") {

                if (element.type == "text") {


                  chatContainer.innerHTML = chatContainer.innerHTML + `<li class=" chat-item" id="lastId${lastId}">
                  <div class="chat-img">
                                    <img src="../../../assets/images/users/1.jpg" alt="user" />
                                  </div>
        <div class="chat-content">
          <div class="box bg-light-inverse">
${element.message}
          </div>
          <br />
        </div>
        <div class="chat-time">${element.datetime}</div>
      </li>`;
                } else if (element.type == "file") {

                  const ext = element.message.split('.').pop().toLowerCase();
                  const iconSVG = fileIcons[ext] || defaultIcon;

                  chatContainer.innerHTML = chatContainer.innerHTML + `<li class=" chat-item" onclick="downloadFile('../../../resources/chat/${element.message}', 'userfile${element.message}')" id="lastId${lastId}">
        <div class="chat-img">
                                    <img src="../../../assets/images/users/1.jpg" alt="user" />
                                  </div>
                  <div class="chat-content">
          <div class="box bg-dark-inverse text-warning">
${iconSVG}<div>${element.message}</div>
          </div>
          <br />
        </div>
        <div class="chat-time">${element.datetime}</div>
      </li>`;
                }

              } else if (element.person == "manufacturer") {

                if (element.type == "text") {


                  chatContainer.innerHTML = chatContainer.innerHTML + `<li class="odd chat-item" id="lastId${lastId}">
                          <div class="chat-content">
                            <div class="box bg-light-inverse">
    ${element.message}
                            </div>
                            <br />
                          </div>
                          <div class="chat-time">${element.datetime}</div>
                        </li>`;
                } else if (element.type == "file") {

                  const ext = element.message.split('.').pop().toLowerCase();
                  const iconSVG = fileIcons[ext] || defaultIcon;

                  chatContainer.innerHTML = chatContainer.innerHTML + `<li class="odd chat-item" onclick="downloadFile('../../../resources/chat/${element.message}', 'userfile${element.message}')" id="lastId${lastId}">
                          <div class="chat-content">
                            <div class="box bg-dark-inverse text-warning">
   ${iconSVG}<div>${element.message}</div>
                            </div>
                            <br />
                          </div>
                          <div class="chat-time">${element.datetime}</div>
                        </li>`;
                }
              }
              num++;
            });

            document.getElementById("lastIdchat").scrollIntoView(false);

          })
          .catch(function(error) {
            console.log(error);
          });

      }

      function saveFileChat(chatroomId) {
        var chatFile = document.getElementById("msgFile");



        if (!chatroomId) {

          toastr.error(
            "Error Reload The Page",
            "Empty Details !"
          );


        } else if (!chatFile.files[0]) {

          toastr.error(
            "Select A File For Before Send",
            "Empty Details !"
          );

        } else {

          var formData = new FormData();
          formData.append("chatroomId", chatroomId);
          formData.append("chatFile", chatFile.files[0]);

          fetch("api/saveDesignerFileChat.php", {
              method: "POST",
              body: formData,

            })
            .then(function(resp) {

              try {
                let response = resp.json();
                return response;
              } catch (error) {
                msg.classList = "alert alert-danger";
                msg.innerHTML = "Something wrong please try again";
                emailField.classList = "form-control";
                passwordField.classList = "form-control";
              }

            })
            .then(function(value) {

              if (value.type == "error") {
                toastr.error(
                  value.message,
                  "Error !"
                );


              } else if (value.type == "success") {

                $('#uploadFile').modal('hide');
                toastr.success(value.message, "Success");
                chatFile.value = null;

                loadAllChats(chatroomId);
              } else {
                toastr.error(
                  "Something Went Wrong Please Try Again",
                  "Error !"
                );
              }

            })
            .catch(function(error) {
              console.log(error);
            });


        }
      }

      function uploadQuotation() {

        var url = new URL(window.location.href);
        var orderNumber = url.searchParams.get("orderNum");
        var qzip = document.getElementById("qzip");

        if (orderNumber == null || orderNumber.length == 0) {
          window.location = "../";

        } else if (!qzip.files[0]) {

          toastr.error(
            "Add the Quotation zip file.",
            "Empty Details !"
          );

        } else {

          var formData = new FormData();
          formData.append("orderNumber", orderNumber);
          formData.append("qzip", qzip.files[0]);


          fetch("api/uploadQuetation.php", {
              method: "POST",
              body: formData,

            })
            .then(function(resp) {

              try {
                let response = resp.json();
                return response;
              } catch (error) {
                msg.classList = "alert alert-danger";
                msg.innerHTML = "Something wrong please try again";
                emailField.classList = "form-control";
                passwordField.classList = "form-control";
              }

            })
            .then(function(value) {

              if (value.type == "error") {
                toastr.error(
                  value.message,
                  "Error !"
                );


              } else if (value.type == "success") {
                toastr.success(value.message, "Success");

                setTimeout(() => {
                  window.location = "../orderView?orderNum=" + orderNumber;
                }, 1000);
              } else {
                toastr.error(
                  "Something Went Wrong Please Try Again",
                  "Error !"
                );
              }

            })
            .catch(function(error) {
              console.log(error);
            });


        }
      }

      function getAllOrders(stat) {

        var oname = document.getElementById("oname");

        var ostatus = document.getElementById("ostatus");
        var odate = document.getElementById("odate");

        var page = 1;

        if (stat == 2) {
          var pagi = document.getElementsByName('pagip');

          for (j = 0; j < pagi.length; j++) {
            if (pagi[j].checked) {
              page = Number(pagi[j].value);
            }

          }
        }

        var formData = new FormData();
        formData.append("page", page);
        formData.append("oname", oname.value);

        formData.append("ostatus", ostatus.value);
        formData.append("odate", odate.value);



        fetch("api/getAllOrders.php", {
            method: "POST",
            body: formData,
          })
          .then(function(resp) {

            try {
              let response = resp.json();
              return response;
            } catch (error) {
              msg.classList = "alert alert-danger";
              msg.innerHTML = "Something wrong please try again";
              emailField.classList = "form-control";
              passwordField.classList = "form-control";
            }

          })
          .then(function(value) {

            var pagicontainer = document.getElementById('pagicontainerph');
            pagicontainer.innerHTML = "";

            const manuLoader = document.getElementById("manuLoader");
            manuLoader.innerHTML = "";

            var num = 1;
            if (value.length == 0) {
              manuLoader.innerHTML = "No details";
            }
            value.message.forEach(element => {

              var imgpath = "../../../assets/images/users/1.jpg";
              if (element.img) {
                imgpath = "../../../resources/companyImg/" + element.img;
              }
              manuLoader.innerHTML = manuLoader.innerHTML +
                `    <tr role="button" onclick=window.location="orderView?id=${element.id}">
                          <th>${num}</th>
                          <td>${element.name}</td>
                          <td>${element.datetime}</td>
                          <td>${element.status}</td>
                      
                          <td>${element.note}</td>

                        </tr>`;
              num++;
            });


            var btnCount = value.buttoncount;


            var firstpagi = document.createElement('input');
            firstpagi.type = 'radio';
            firstpagi.className = 'btn-check';
            firstpagi.name = 'pagip';
            firstpagi.id = 'firstpagip';

            firstpagi.value = 1;
            firstpagi.onchange = function() {
              getAllOrders(2);
            }



            var firstlabel = document.createElement('label');
            firstlabel.className = 'btn btn-outline-info removeCorner';
            firstlabel.htmlFor = 'firstpagip';
            firstlabel.innerText = "First";



            pagicontainer.appendChild(firstpagi);
            pagicontainer.appendChild(firstlabel);



            var startPage = 1;

            var endpage = 5;



            var val = page + 4;





            if ((page + 4) < btnCount) {
              endpage = page + 4;
              startPage = page;

            } else {

              if (btnCount >= 5) {
                startPage = btnCount - 4;

              } else {

                startPage = 1;

              }
              endpage = btnCount;
            }



            if (page != 1 && btnCount > 5) {
              var frontPagi = document.createElement('input');
              frontPagi.type = 'radio';
              frontPagi.className = 'btn-check';
              frontPagi.name = 'pagig';
              frontPagi.id = 'btnpagifrontp';

              frontPagi.value = Number(startPage) - 1;
              frontPagi.onchange = function() {
                getAllOrders(2);
              }

              var labelfrontpagi = document.createElement('label');
              labelfrontpagi.className = 'btn btn-outline-info removeCorner';
              labelfrontpagi.htmlFor = 'btnpagifrontp';
              labelfrontpagi.innerText = Number(startPage) - 1;



              pagicontainer.appendChild(frontPagi);
              pagicontainer.appendChild(labelfrontpagi);

            }

            for (let i = startPage - 1; i < endpage; i++) {



              var radioButton = document.createElement('input');
              radioButton.type = 'radio';
              radioButton.className = 'btn-check';
              radioButton.name = 'pagip';
              radioButton.id = 'btnpagip' + i;
              var pageVal = i + 1;
              radioButton.value = pageVal;
              radioButton.onchange = function() {
                getAllOrders(2);
              }
              if (page == pageVal) {
                radioButton.checked = true;
              }


              var label = document.createElement('label');
              label.className = 'btn btn-outline-info removeCorner';
              label.htmlFor = 'btnpagip' + i;
              label.innerText = pageVal;



              pagicontainer.appendChild(radioButton);
              pagicontainer.appendChild(label);

            }


            var lastpagi = document.createElement('input');
            lastpagi.type = 'radio';
            lastpagi.className = 'btn-check';
            lastpagi.name = 'pagip';
            lastpagi.id = 'lastpagip';

            lastpagi.value = btnCount;
            lastpagi.onchange = function() {
              getAllOrders(2);
            }



            var lastlabel = document.createElement('label');
            lastlabel.className = 'btn btn-outline-info removeCorner';
            lastlabel.htmlFor = 'lastpagip';
            lastlabel.innerText = "Last (" + btnCount + ")";



            pagicontainer.appendChild(lastpagi);
            pagicontainer.appendChild(lastlabel);

          })
          .catch(function(error) {
            console.log(error);
          });

      }


      function changeTheOrderStatus() {
        var selectStatus = document.getElementById("statusChange");



        if (selectStatus.value == "0") {

          toastr.error(
            "Please Select the Status",
            "Not Selected !"
          );
        } else {
          document.getElementById("statusChangeText").value = selectStatus.value;
          document.getElementById("statInformText").innerHTML = '"' + selectStatus.value + '"';
          $('#stateChangeModel').modal('show');
        }

      }


      function changeTheOrderStatusByModel(id) {
        var orderNewStatus = document.getElementById("orderNewStatus");
        var field = document.getElementById("statusChangeText").value;
        if (orderNewStatus.value == field) {

          var formData = new FormData();
          formData.append("orderId", id);
          formData.append("status", field);

          fetch("api/changeStatus.php", {
              method: "POST",
              body: formData,

            })
            .then(function(resp) {

              try {
                let response = resp.json();
                return response;
              } catch (error) {
                msg.classList = "alert alert-danger";
                msg.innerHTML = "Something wrong please try again";
                emailField.classList = "form-control";
                passwordField.classList = "form-control";
              }

            })
            .then(function(value) {

              if (value.type == "error") {
                toastr.error(
                  value.message,
                  "Error !"
                );


              } else if (value.type == "success") {
                toastr.success(value.message, "Success");
                window.location.reload();

              } else {
                toastr.error(
                  "Something Went Wrong Please Try Again",
                  "Error !"
                );
              }

            })
            .catch(function(error) {
              console.log(error);
            });
        } else {

          toastr.error(
            "Please Type Correctly To Proceed",
            "Incorrect Type !"
          );
        }
      }





      function loadpaymentHistory(stat) {



        var searchtext = document.getElementById("searchnamePH");




        var page = 1;

        if (stat == 2) {
          var pagi = document.getElementsByName('pagip');

          for (j = 0; j < pagi.length; j++) {
            if (pagi[j].checked) {
              page = Number(pagi[j].value);
            }

          }
        }


        var formData = new FormData();
        formData.append("searchText", searchtext.value);
        formData.append("page", page);






        var tablebody = document.getElementById("tableBodyphistory");
        tablebody.innerHTML = "";
        fetch(baseUrl + "paymentHistoryLoadProcess.php", {
            method: "POST",
            body: formData,


          }).then(function(resp) {
            return resp.json();

          })
          .then(function(value) {

            var pagicontainer = document.getElementById('pagicontainerph');
            pagicontainer.innerHTML = "";

            if (value.type == "success") {
              var userSearchData = value.message;

              for (let index = 0; index < userSearchData.length; index++) {
                const user = userSearchData[index];

                const newRow = document.createElement('tr');

                const nocell = document.createElement('td');
                nocell.textContent = index + 1;
                const idCell = document.createElement('td');
                idCell.innerHTML = user[0] + " " + user[1] + "<br>" + user[2];




                let date2 = new Date(user[4]); // Convert to Date object
                date2.setDate(date2.getDate() - 1); // Subtract one day

                // Format the date as YYYY-MM-DD
                let year = date2.getFullYear();
                let month = String(date2.getMonth() + 1).padStart(2, '0'); // Ensure two digits
                let day = String(date2.getDate()).padStart(2, '0'); // Ensure two digits

                let date = new Date(date2);

                // Set the month to the current month minus 1
                // date.setMonth(date.getMonth() - 1);
                date.setDate(date.getDate() - 29);

                let reduceDate = date.toISOString().split('T')[0];

                const roleCell = document.createElement('td');

                var textInner = "";
                if (user[6] == 1) {
                  textInner = reduceDate + " to " + `${year}-${month}-${day}`;
                }

                if (textInner != "") {
                  textInner = textInner + "<br/>" + user[5];
                } else {
                  textInner = user[5];
                }


                roleCell.innerHTML = textInner;

                const addressCell = document.createElement('td');
                addressCell.textContent = user[3];

                const priceCell = document.createElement('td');
                priceCell.textContent = "$ " + user[7];



                newRow.appendChild(nocell);
                newRow.appendChild(idCell);
                newRow.appendChild(roleCell);
                newRow.appendChild(addressCell);
                newRow.appendChild(priceCell);


                tablebody.appendChild(newRow);
              }


              var btnCount = value.buttoncount;


              var firstpagi = document.createElement('input');
              firstpagi.type = 'radio';
              firstpagi.className = 'btn-check';
              firstpagi.name = 'pagip';
              firstpagi.id = 'firstpagip';

              firstpagi.value = 1;
              firstpagi.onchange = function() {
                loadpaymentHistory(2);
              }



              var firstlabel = document.createElement('label');
              firstlabel.className = 'btn btn-outline-info removeCorner';
              firstlabel.htmlFor = 'firstpagip';
              firstlabel.innerText = "First";



              pagicontainer.appendChild(firstpagi);
              pagicontainer.appendChild(firstlabel);



              var startPage = 1;

              var endpage = 5;



              var val = page + 4;





              if ((page + 4) < btnCount) {
                endpage = page + 4;
                startPage = page;

              } else {

                if (btnCount >= 5) {
                  startPage = btnCount - 4;

                } else {

                  startPage = 1;

                }
                endpage = btnCount;
              }



              if (page != 1 && btnCount > 5) {
                var frontPagi = document.createElement('input');
                frontPagi.type = 'radio';
                frontPagi.className = 'btn-check';
                frontPagi.name = 'pagig';
                frontPagi.id = 'btnpagifrontp';

                frontPagi.value = Number(startPage) - 1;
                frontPagi.onchange = function() {
                  loadpaymentHistory(2);
                }

                var labelfrontpagi = document.createElement('label');
                labelfrontpagi.className = 'btn btn-outline-info removeCorner';
                labelfrontpagi.htmlFor = 'btnpagifrontp';
                labelfrontpagi.innerText = Number(startPage) - 1;



                pagicontainer.appendChild(frontPagi);
                pagicontainer.appendChild(labelfrontpagi);

              }

              for (let i = startPage - 1; i < endpage; i++) {



                var radioButton = document.createElement('input');
                radioButton.type = 'radio';
                radioButton.className = 'btn-check';
                radioButton.name = 'pagip';
                radioButton.id = 'btnpagip' + i;
                var pageVal = i + 1;
                radioButton.value = pageVal;
                radioButton.onchange = function() {
                  loadpaymentHistory(2);
                }
                if (page == pageVal) {
                  radioButton.checked = true;
                }


                var label = document.createElement('label');
                label.className = 'btn btn-outline-info removeCorner';
                label.htmlFor = 'btnpagip' + i;
                label.innerText = pageVal;



                pagicontainer.appendChild(radioButton);
                pagicontainer.appendChild(label);

              }


              var lastpagi = document.createElement('input');
              lastpagi.type = 'radio';
              lastpagi.className = 'btn-check';
              lastpagi.name = 'pagip';
              lastpagi.id = 'lastpagip';

              lastpagi.value = btnCount;
              lastpagi.onchange = function() {
                loadpaymentHistory(2);
              }



              var lastlabel = document.createElement('label');
              lastlabel.className = 'btn btn-outline-info removeCorner';
              lastlabel.htmlFor = 'lastpagip';
              lastlabel.innerText = "Last (" + btnCount + ")";



              pagicontainer.appendChild(lastpagi);
              pagicontainer.appendChild(lastlabel);




            } else if (value.type = "error") {

              tablebody.innerHTML = value.message;

            }
          })
          .catch(function(error) {
            console.log(error);
          });



      }



      $("#zero_config").DataTable();
    </script>
  </body>

  </html>
<?php
} else {
?>
  <script>
    window.location = "../"
  </script>
<?php

}
?>