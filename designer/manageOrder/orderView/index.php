<?php
session_start();
if (isset($_SESSION["rb_user"]) && ($_SESSION["rb_user"]["type"] == "designer" || $_SESSION["rb_user"]["type"] == "designer_head")) {

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
    <title>Designer Order Details View </title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../../../assetss/images/logotitle.jpg" />
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

    <style>

    </style>
  </head>

  <body onload="getAllOrders()">
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
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <span class="d-none d-md-block">Create New <i class="fa fa-angle-down"></i></span>
                  <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Order</a></li>
                  <li><a class="dropdown-item" href="#">Manufacturer</a></li>

                </ul>
              </li>
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


                  if (isset($_GET["id"])) {
                    $chatResultThisOrder = $db->search("SELECT chat.id,chat.type,chat.datetime,chat.message,order_has_manifacturer.uid FROM `chat` INNER JOIN `chat_room` ON `chat_room`.`id`=`chat`.`chat_room_id` INNER JOIN `order_has_manifacturer` ON `order_has_manifacturer`.`id`=`chat_room`.`order_has_manifacturer_id` WHERE `chat`.`person`='manufacturer' AND `chat`.`is_view`='0' AND order_has_manifacturer.order_id='" . $_GET["id"] . "'");
                    for ($notwach = 0; $notwach < count($chatResultThisOrder); $notwach++) {
                      $db->iud("UPDATE `chat` SET `is_view`='1' WHERE `id`='" . $chatResultThisOrder[$notwach]["id"] . "'");
                    }
                  }

                  $chatResult = $db->search("SELECT chat.type,chat.datetime,chat.message,order_has_manifacturer.uid FROM `chat` INNER JOIN `chat_room` ON `chat_room`.`id`=`chat`.`chat_room_id` INNER JOIN `order_has_manifacturer` ON `order_has_manifacturer`.`id`=`chat_room`.`order_has_manifacturer_id` WHERE `chat`.`person`='manufacturer' AND `chat`.`is_view`='0'");

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
                          <a href="../orderView/?id=<?= $chat["uid"] ?>" class="link border-top">
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
                  if (!empty($_SESSION["rb_user"]["img"])) {
                    $imagePath = "../../../resources/userImg/" . $_SESSION["rb_user"]["img"];
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
                  href="../newOrder/"
                  aria-expanded="false"> <i class="me-2 mdi mdi-cart"></i><span class="hide-menu">New Order</span></a>
              </li>

              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="../"
                  aria-expanded="false"><i class="me-2 mdi mdi-truck"></i><span class="hide-menu">Order Details</span></a>
              </li>

              <?php
              if ($_SESSION["rb_user"]["type"] == "designer_head") {
              ?>
                <li class="sidebar-item ">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="../../manageDesigner/"
                    aria-expanded="false"><i class="me-2 mdi mdi-account"></i><span class="hide-menu">Manage Designer</span></a>
                </li>
                <li class="sidebar-item ">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="../../manageManifacturer/"
                    aria-expanded="false"><i class="me-2 mdi mdi-account-multiple"></i><span class="hide-menu">Manage Manufacturer</span></a>
                </li>
              <?php
              }
              ?>
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
                <h4 class="page-title">Manage Order </h4>
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

          <?php


          if (!isset($_GET["id"])) {
          ?>
            <script>
              window.location = "../"
            </script>
            <?php
          } else {
            $id = $_GET["id"];
            $sql = "SELECT `order`.`id`,`order`.`status`,`order`.`name`,`order`.`dead_line`,`order`.`datetime`,`order`.`path`  FROM `order` WHERE `id`=?";
            $result = $db->search($sql, "i", [$id]);


            if (count($result) == 1) {

              $orderDetails = $result[0];
            ?>

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
                          <span><?php echo $orderDetails["name"] ?></span>
                        </div>
                        <div class="col-12">
                          <span>Order Date : <?php echo $orderDetails["datetime"] ?></span>
                        </div>
                        <div class="col-12">
                          <span>Deadline : <?php echo $orderDetails["dead_line"] ?></span>
                        </div>

                        <hr>



                      </div>

                      <div class="row">
                        <div class="col-12 mt-2">
                          <span>Order Status <b><?php echo $orderDetails["status"] ?></b></span>
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
                      <button type="button" class="btn btn-primary" onclick="changeTheOrderStatusByModel(<?php echo $orderDetails['id'] ?>)">Confirm</button>
                    </div>
                  </div>
                </div>
              </div>
              <?php



              $manuOrderQuery = "SELECT `order_has_manifacturer`.`id`,`manifacturer`.`name`,`manifacturer`.`img`,`order_has_manifacturer`.`status` FROM `order_has_manifacturer` INNER JOIN `manifacturer` ON `manifacturer`.`id`=`order_has_manifacturer`.`manifacturer_id` WHERE `order_id`=? AND order_has_manifacturer.`status` IN (?,?,?,?,?,?,?,?,?,?,?)";
              $manuOrderResult = $db->search($manuOrderQuery, "isssssssssss", [$orderDetails["id"], "PROCESSING", "CANCEL", "COMPLETED", "INITIAL GERBER", "ENGINEER QUESTION", "PROCESSED GERBER", "MANUFACTURING", "DISPATCH BOARDS", "BOARDS RECEIVE", "BOARDS TEST", "HOLD"]);


              if (count($manuOrderResult) == 1) {
                $manuDetails = $manuOrderResult[0];
                $imgpath = "../../../assets/images/users/d3.jpg";
                if (!empty($manuDetails["img"])) {
                  $imgpath = "../../../resources/companyImg/" . $manuDetails["img"];
                }

              ?>
                <script>
                  var imagPath = <?php echo $imgpath ?>;
                </script>

                <?php

                $resultCharRooms = $db->search("SELECT * FROM `chat_room` WHERE `order_has_manifacturer_id`=?", "i", [$manuDetails["id"]]);


                if (count($resultCharRooms) == 1) {

                  $chatRoom = $resultCharRooms[0];
                ?>
                  <script>
                    document.addEventListener('DOMContentLoaded', function() {
                      loadAllChats(<?php echo $chatRoom['id'] ?>)
                    }, false);
                  </script>
                  <div class="row">
                    <div class="col-md-4 col-lg-3">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title mb-0">Order Details</h5>
                          <div class="row mt-2">
                            <div class="col-12">
                              <span><?php echo $orderDetails["name"] ?></span>
                            </div>
                            <div class="col-12">
                              <span><?php echo $orderDetails["datetime"] ?></span>
                            </div>
                            <div class="col-12 mt-2 mb-2">
                              <button class="btn btn-dark" onclick="downloadFile('<?php echo '../../../resources/orders/' . $orderDetails['path'] ?>', '<?php echo $orderDetails['name'] . $orderDetails['path'] ?>')">Download Order Zip</button>
                            </div>
                            <hr>
                            <div class="col-12">
                              <h5 class="card-title mb-0">Company </h5>
                              <span><?php echo $manuDetails["name"] ?></span>
                              <div class="p-2">
                                <img
                                  src="<?php echo $imgpath ?>"
                                  alt="user"
                                  width="60"
                                  height="60"
                                  class="rounded-circle" />
                              </div>
                            </div>
                            <span>Order Status : <?php echo $orderDetails["status"] ?></span><br>
                            <hr>
                            <div class="col-12 <?php
                                                if ($orderDetails["status"] == "COMPLETED") {
                                                  echo "d-none";
                                                }
                                                ?>">

                              <span>Change Status</span>
                              <select name="" id="statusChange" class="form-select ">
                                <option value="0">Select</option>
                                <option value="INITIAL GERBER">INITIAL GERBER</option>
                                <option value="ENGINEER QUESTION">ENGINEER QUESTION</option>
                                <option value="PROCESSED GERBER">PROCESSED GERBER</option>
                                <option value="MANUFACTURING">MANUFACTURING</option>
                                <option value="DISPATCH BOARDS">DISPATCH BOARDS</option>
                                <option value="BOARDS RECEIVE">BOARDS RECEIVE</option>
                                <option value="BOARDS TEST">BOARDS TEST</option>
                                <option value="HOLD">HOLD</option>
                                <option value="COMPLETE">COMPLETED</option>
                                <option value="CANCEL">CANCLED</option>
                              </select>
                            </div>
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

                        </div>

                      </div>



                      <!--  -->

                      <!--  -->
                    </div>
                    <div class="col-md-8 col-lg-9 col-12">
                      <div class="row">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">Chat With Manufacturer</h4>
                            <div class="chat-box scrollable" style="height: 440px">
                              <!--chat Row -->
                              <ul class="chat-list" id="chatContainer">
                                <!--chat Row -->

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
                <?php
                } else {
                ?>
                  <script>
                    window.location = "../"
                  </script>
                <?php

                }
              } else {
                ?>
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title mb-0">Order Details</h5>
                        <div class="row mt-2">
                          <div class="row">
                            <div class="col-12 col-lg-4">
                              <div class="row">
                                <div class="col-12">
                                  <span><?php echo $orderDetails["name"] ?></span>
                                </div>
                                <div class="col-12">
                                  <span><?php echo $orderDetails["datetime"] ?></span>
                                </div>
                                <div class="col-12 mt-2 mb-2">
                                  <button class="btn btn-dark" onclick="downloadFile('<?php echo '../../../resources/orders/' . $orderDetails['path'] ?>', '<?php echo $orderDetails['name'] . $orderDetails['path'] ?>')">Download Order Zip</button>
                                </div>
                              </div>

                            </div>
                            <div class="col-12 col-lg-4 mt-2">
                              <div class="row">
                                <div class="col-12">
                                  <span>Order Status <br> <?php echo $orderDetails["status"] ?></span><br>
                                </div>
                              </div>

                            </div>
                            <div class="col-12 col-lg-4 mt-2">
                              <div class="row">
                                <div class="col-12">

                                  <span class="fw-bold">Change Status</span>
                                  <select name="" id="statusChange" class="form-select">
                                    <option value="0">Select</option>

                                    <option value="CANCELED">CANCELED</option>
                                  </select>
                                </div>
                                <div class="col-12 mt-2 ">
                                  <span><button class="btn btn-info w-100" onclick="changeTheOrderStatus()">Submit</button></span>
                                </div>
                              </div>
                            </div>
                          </div>





                        </div>
                      </div>

                    </div>
                  </div>


                </div>
              <?php
              }


              ?>



              <div class="row">
                <div class="col-12 col-lg-6 offset-lg-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-0">Order History</h5>
                      <div class="row mt-2">
                        <div class="col-12 justify-content-between">


                          <?php

                          $oh = $db->search("SELECT * FROM `order_history` WHERE `order_id`=? ORDER BY `date_time` ASC", 'i', [$id]);
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

              <?php
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
                  chatText.value = "";
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
                  window.location = "?id=" + id;

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

              value.forEach(element => {

                // var imgpath = "../../../assets/images/users/1.jpg";
                // if (element.img) {
                //   imgpath = "../../../resources/companyImg/" + element.img;
                // }

                var lastId = "";
                if (value.length == num) {
                  lastId = "chat";
                }
                if (element.person == "manufacturer") {

                  if (element.type == "text") {


                    chatContainer.innerHTML = chatContainer.innerHTML + `<li class="chat-item" id="lastId${lastId}">
                  <div class="chat-img">
                                    <img src="<?php echo $imgpath ?>" height="42" width="42" alt="user" />
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
                                    <img src="<?php echo $imgpath ?>" height="42" width="42" alt="user" />
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

                } else if (element.person == "designer") {

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








        $("#zero_config").DataTable();
      </script>
  </body>

  </html>
<?php
} else {
?>
  <script>
    window.location = "../../../";
  </script>
<?php
}
?>