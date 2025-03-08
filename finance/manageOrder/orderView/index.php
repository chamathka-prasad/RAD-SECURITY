<?php
session_start();

if (isset($_SESSION["rb_user"]) && $_SESSION["rb_user"]["type"] == "finance") {
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
    <title>Finance Order DEtails View </title>
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

          require "../../../config/MySQLConnector.php";

          $db = new MySQLConnector();

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
              <div class="row">
                <div class="col-md-4 col-lg-4">
                  <div class="card">
                    <div class="card-body">
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
                        <div class="col-12 mt-2 mb-2">
                          <button class="btn btn-dark" onclick="downloadFile('<?php echo '../../../resources/orders/' . $orderDetails['path'] ?>', '<?php echo $orderDetails['name'] . $orderDetails['path'] ?>')">Download Order Zip</button>
                        </div>
                        <hr>
                        <div class="col-12">
                          <span class="fw-bolder"><?php echo $orderDetails["status"] ?> ORDER</span>
                        </div>


                      </div>
                    </div>

                  </div>
                </div>
                <div class="col-md-8 col-lg-8 col-12">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Quotations Details</h4>
                        </div>
                        <div class="comment-widgets scrollable">
                          <!-- Comment Row -->

                          <?php

                          $manuOrderQuery = "SELECT `order_has_manifacturer`.`id`,`manifacturer`.`name`,`manifacturer`.`img`,`order_has_manifacturer`.`status` FROM `order_has_manifacturer` INNER JOIN `manifacturer` ON `manifacturer`.`id`=`order_has_manifacturer`.`manifacturer_id` WHERE `order_id`=?";
                          $manuOrderResult = $db->search($manuOrderQuery, "i", [$orderDetails["id"]]);


                          for ($i = 0; $i < count($manuOrderResult); $i++) {
                            $manufacturer = $manuOrderResult[$i];

                            $imgpath = "../../../assets/images/users/d3.jpg";
                            if (!empty($manufacturer["img"])) {
                              $imgpath = "../../../resources/companyImg/" . $manufacturer["img"];
                            }

                            if ($orderDetails["status"] == "NEW") {
                          ?>
                              <div class="d-flex flex-row comment-row mt-0">
                                <div class="p-2">
                                  <img
                                    src="<?php echo $imgpath ?>"
                                    alt="user"
                                    width="60"
                                    height="60"
                                    class="rounded-circle" />
                                </div>
                                <div class="comment-text w-100">
                                  <h6 class="font-medium"><?php echo $manufacturer["name"] ?></h6>


                                  <?php
                                  $quotationQuery = "SELECT * FROM `quotation` WHERE `order_has_manifacturer_id`=?";
                                  $quotationResult = $db->search($quotationQuery, "i", [$manufacturer["id"]]);

                                  if (count($quotationResult) == 1) {
                                    $manuQuotation = $quotationResult[0];
                                  ?>
                                    <div class="comment-footer">
                                      <span class="text-muted float-start"><?php echo $manuQuotation["datetime"] ?></span><br>
                                      <button
                                        type="button"
                                        class="btn btn-cyan btn-sm text-white mt-2" onclick="downloadFile('<?php echo '../../../resources/quotations/' . $manuQuotation['path'] ?>', '<?php echo $manufacturer['name'] . $manuQuotation['path'] ?>')">
                                        Download Quotation
                                      </button>
                                      <button
                                        type="button"
                                        class="btn btn-success btn-sm text-white mt-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $manuQuotation["id"] ?>">
                                        Select The Quotation
                                      </button>

                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop<?php echo $manuQuotation["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">QUOTATION Selection confirmation</h1>
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
                                            <h5 class="card-title mb-0">Selcted Quotation Details</h5>
                                            <div class="row">

                                              <div class="col-12">
                                                <div class="p-2">
                                                  <img
                                                    src="<?php echo $imgpath ?>"
                                                    alt="user"
                                                    width="60"
                                                    height="60"
                                                    class="" />
                                                </div>
                                              </div>
                                              <div class="col-12 mt-2">
                                                <span><?php echo $manufacturer["name"] ?></span>
                                              </div>
                                              <div class="col-12">
                                                <span>Quotation Submit Date <?php echo $manuQuotation["datetime"] ?></span>
                                              </div>
                                              <hr>
                                              <div class="col-12 mt-4">
                                                <label for="" class="form-label">Type <b class="text-warning">"select"</b> to Select The Quotation</label>
                                                <input type="text" class="form-control" placeholder="select" id="select<?php echo $manuQuotation["id"] ?>" />
                                              </div>

                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="selectTheQuotation(<?php echo $orderDetails['id'] ?>,<?php echo $manufacturer['id'] ?>,<?php echo $manuQuotation['id'] ?>)">Confirm</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  <?php
                                  } else {
                                  ?>
                                    <div class="comment-footer">
                                      <span class="float-start-0 text-danger">Not Yet Submitted</span>

                                    </div>
                                  <?php
                                  }
                                  ?>

                                </div>
                              </div>
                            <?php
                            } else {

                            ?>
                              <div class="d-flex flex-row comment-row mt-0">
                                <div class="p-2">
                                  <img
                                    src="<?php echo $imgpath ?>"
                                    alt="user"
                                    width="60"
                                    height="60"
                                    class="rounded-circle" />
                                </div>
                                <div class="comment-text w-100">
                                  <h6 class="font-medium"><?php echo $manufacturer["name"] ?>

                                  </h6>


                                  <?php
                                  $quotationQuery = "SELECT * FROM `quotation` WHERE `order_has_manifacturer_id`=?";
                                  $quotationResult = $db->search($quotationQuery, "i", [$manufacturer["id"]]);

                                  if (count($quotationResult) == 1) {
                                    $manuQuotation = $quotationResult[0];
                                  ?>
                                    <div class="comment-footer">
                                      <span class="text-muted float-start">Quotation Submit Date: <?php echo $manuQuotation["datetime"] ?></span><br>


                                      <?php
                                      if ($manufacturer['status'] == "PROCESSING" || $manufacturer['status'] == "COMPLETED") {
                                      ?>
                                        <h6 class="font-medium fw-bolder text-success">SELECTED</h6>
                                      <?php
                                      } else if ($manufacturer['status'] == "LOSS") {
                                      ?>
                                        <h6 class="font-medium fw-bolder text-warning">NOT SELECTED</h6>
                                      <?php
                                      }
                                      ?>

                                      <button
                                        type="button"
                                        class="btn btn-cyan btn-sm text-white" onclick="downloadFile('<?php echo '../../../resources/quotations/' . $manuQuotation['path'] ?>', '<?php echo $manufacturer['name'] . $manuQuotation['path'] ?>')">
                                        Download Quotation
                                      </button>


                                    </div>
                                    <!-- Modal -->

                                  <?php
                                  } else {
                                  ?>
                                    <div class="comment-footer">
                                      <span class="float-start-0 text-danger"><?php echo $manufacturer["status"] ?></span>

                                    </div>
                                  <?php
                                  }
                                  ?>

                                </div>
                              </div>
                            <?php

                            }

                            ?>

                          <?php

                          }
                          ?>
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

      function selectTheQuotation(orderId, ordrManuId, quatationId) {


        var select = document.getElementById("select" + quatationId);

        if (select.value != "select") {
          toastr.error(
            "Please Type 'select' to Select the Quotaion",
            "Confirmation Error !"
          );
        } else {

          var formData = new FormData();
          formData.append("orderId", orderId);
          formData.append("orderManuId", ordrManuId);
          formData.append("quotationId", quatationId);


          fetch("api/selectAQuotationProcess.php", {
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
                  window.location = "../orderView?id=" + orderId;
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



      $("#zero_config").DataTable();
    </script>
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