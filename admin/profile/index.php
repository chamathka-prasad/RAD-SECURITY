<?php
session_start();
if (isset($_SESSION["rb_user"]) && ($_SESSION["rb_user"]["type"] == "admin")) {

  require "../../config/MySQLConnector.php";


  $db = new MySQLConnector();
  $userResult = $db->search("SELECT * FROM `user` WHERE `id`=?", "i", [$_SESSION["rb_user"]["id"]]);
  if (count($userResult) == 1) {

    $user = $userResult[0];
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
      <title>Admin Profile</title>
      <!-- Favicon icon -->
      <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="../../assetss/images/logotitle.jpg" />
      <!-- Custom CSS -->
      <link
        rel="stylesheet"
        type="text/css"
        href="../../assets/extra-libs/multicheck/multicheck.css" />
      <link
        href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
        rel="stylesheet" />
      <link href="../../dist/css/style.min.css" rel="stylesheet" />
      <link href="../../assets/libs/toastr/build/toastr.min.css" rel="stylesheet" />
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
              <a class="navbar-brand" href="../">
                <!-- Logo icon -->
                <b class="logo-icon ps-2">
                  <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                  <!-- Dark Logo icon -->
                  <img
                    src="../../assetss/images/logo.webp"
                    alt="homepage"
                    class="light-logo"
                    width="25" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text ms-2">
                  <!-- dark Logo text -->
                  <img
                    src="../../assetss/images/logo.webp"
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

                    $chatResult = $db->search("SELECT chat.type,chat.datetime,chat.message,order_has_manifacturer.order_id FROM `chat` INNER JOIN `chat_room` ON `chat_room`.`id`=`chat`.`chat_room_id` INNER JOIN `order_has_manifacturer` ON `order_has_manifacturer`.`id`=`chat_room`.`order_has_manifacturer_id` WHERE  `chat`.`person`='manufacturer' AND `chat`.`is_view`='0'");

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
                            <a href="../manageOrder/orderView/?id=<?= $chat["order_id"] ?>" class="link border-top">
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
                                    <span class="mail-desc">Manufacturer Uploaded A File</span>
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

                    $imagePath = "../../assets/images/users/1.jpg";
                    if (!empty($_SESSION["rb_user"]["img"])) {
                      $imagePath = "../../resources/userImg/" . $_SESSION["rb_user"]["img"];
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
                    <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../logout.php"><i class="fa fa-power-off me-1 ms-1"></i> Logout</a>


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
                    href="../"
                    aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="../manageOrder/newOrder/"
                    aria-expanded="false"> <i class="me-2 mdi mdi-cart"></i><span class="hide-menu">New Order</span></a>
                </li>

                <li class="sidebar-item">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="../manageOrder/"
                    aria-expanded="false"><i class="me-2 mdi mdi-truck"></i><span class="hide-menu">Order Details</span></a>
                </li>


                <li class="sidebar-item ">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="../manageUser/"
                    aria-expanded="false"><i class="me-2 mdi mdi-account"></i><span class="hide-menu">Manage User</span></a>
                </li>
                <li class="sidebar-item ">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="../manageManifacturer/"
                    aria-expanded="false"><i class="me-2 mdi mdi-account-multiple"></i><span class="hide-menu">Manage Manufacturer</span></a>
                </li>

                <li class="sidebar-item">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href=""
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
                <h4 class="page-title">Manage Profile</h4>

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
            <div class="row">
              <div class="col-12">


                <div class="card">
                  <div class="col-12">

                    <form class="form-horizontal">
                      <div class="card-body">

                        <h4 class="card-title text-center mb-5">Edit Profile Details</h4>
                        <div class="row">
                          <div class="col-12 col-lg-6">
                            <div class="form-group row">
                              <label
                                for="fname"
                                class="col-sm-3 text-start control-label col-form-label">Name<span class="text-danger">&#8727;</span></label>
                              <div class="col-sm-9">
                                <input
                                  type="text"
                                  class="form-control"
                                  id="uname"
                                  placeholder="Profile Name" value="<?= $user["name"] ?>" />
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-lg-6">
                            <div class="form-group row">
                              <label
                                for="lname"
                                class="col-sm-3 text-start control-label col-form-label">Email<span class="text-danger">&#8727;</span></label>
                              <div class="col-sm-9">
                                <input
                                  type="text"
                                  class="form-control"
                                  id="uemail"
                                  placeholder="email" value="<?= $user["email"] ?>" />
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row ">
                              <label
                                for="cono1"
                                class="col-sm-3 text-start control-label col-form-label">Image</label>
                              <div class="col-sm-9 justify-content-lg-between justify-content-center">

                                <?php
                                $image = "../../assets/images/users/1.jpg";
                                if (!empty($user["img"])) {
                                  $image = "../../resources/userImg/" . $user["img"];
                                }
                                ?>
                                <img src="<?= $image ?>" id="view1" alt="" height="200px">
                                <input type="file" class="d-none" id="mImage">
                                <label for="mImage" class="btn btn-primary " onclick="changeImg()">+</label>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 col-lg-6">
                            <div class="form-group row">
                              <label
                                for="lname"
                                class="col-sm-3 text-start control-label col-form-label">Username</label>
                              <div class="col-sm-9">
                                <input
                                  type="text"
                                  class="form-control"
                                  id="username"
                                  placeholder="Username" value="<?= $user["username"] ?>" />
                              </div>
                            </div>
                          </div>
                          <div class="col-12 text-center mb-3">
                            <button type="button" class="btn btn-dark w-75" onclick="updateUserProfile()">
                              Update Profile
                            </button>
                          </div>
                          <hr>
                          <h4 class="card-title text-center mb-5">Edit Password</h4>


                          <div class="col-12 col-lg-6">
                            <div class="form-group row">
                              <label
                                for="lname"
                                class="col-sm-3 text-start control-label col-form-label">Old Password</label>
                              <div class="col-sm-9">
                                <input
                                  type="password"
                                  class="form-control"
                                  id="opassword"
                                  placeholder="Old Password" />
                              </div>
                            </div>
                          </div>

                          <div class="col-12 col-lg-6">
                            <div class="form-group row">
                              <label
                                for="lname"
                                class="col-sm-3 text-start control-label col-form-label">New Password</label>
                              <div class="col-sm-9">
                                <input
                                  type="password"
                                  class="form-control"
                                  id="npassword"
                                  placeholder="New Password" />
                              </div>
                            </div>
                          </div>

                          <div class="col-12 text-end  mb-3">
                            <button type="button" class="btn btn-danger w-50" onclick="updatePassword()">
                              Update Password
                            </button>
                          </div>





                        </div>


                      </div>

                    </form>
                  </div>

                </div>



              </div>
            </div>
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
      <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
      <!-- Bootstrap tether Core JavaScript -->
      <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
      <!-- slimscrollbar scrollbar JavaScript -->
      <script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
      <script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
      <!--Wave Effects -->
      <script src="../../dist/js/waves.js"></script>
      <!--Menu sidebar -->
      <script src="../../dist/js/sidebarmenu.js"></script>
      <!--Custom JavaScript -->
      <script src="../../dist/js/custom.min.js"></script>
      <!-- this page js -->
      <script src="../../assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
      <script src="../../assets/extra-libs/multicheck/jquery.multicheck.js"></script>
      <script src="../../assets/extra-libs/DataTables/datatables.min.js"></script>

      <script src="../../assets/libs/toastr/build/toastr.min.js"></script>
      <script>
        function changeImg() {
          var image = document.getElementById("mImage");
          var view = document.getElementById("view1");


          image.onchange = function() {
            var file = this.files[0];
            var url = window.URL.createObjectURL(file);

            view.src = url;

          }
        }

        function changeUpdateImg(id) {
          var image = document.getElementById("uimage" + id);
          var view = document.getElementById("view2" + id);


          image.onchange = function() {
            var file = this.files[0];
            var url = window.URL.createObjectURL(file);

            view.src = url;

          }
        }




        function updateUserProfile() {

          var username = document.getElementById("username");
          var email = document.getElementById("uemail");
          var uname = document.getElementById("uname");


          var cimage = document.getElementById("mImage");


          if (!uname.value) {

            toastr.error(
              "User Profile Name Is Empty.",
              "Empty Details !"
            );


          } else if (!email.value) {

            toastr.error(
              "User Email Is Empty.",
              "Empty Details !"
            );

          } else if (!username.value) {

            toastr.error(
              "Username Is Empty.",
              "Empty Details !"
            );

          } else {

            var formData = new FormData();
            formData.append("username", username.value);
            formData.append("email", email.value);
            formData.append("name", uname.value);

            formData.append("image", cimage.files[0]);

            fetch("api/updateUserProfile.php", {
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
                    window.location = "";
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


        function updatePassword() {

          var opassword = document.getElementById("opassword");
          var npassword = document.getElementById("npassword");

          if (!opassword.value) {

            toastr.error(
              "Old Password Is Empty.",
              "Empty Details !"
            );


          } else if (!npassword.value) {

            toastr.error(
              "New Password Is Empty.",
              "Empty Details !"
            );

          } else {

            var formData = new FormData();
            formData.append("opassword", opassword.value);
            formData.append("npassword", npassword.value);


            fetch("api/updatepassword.php", {
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
                    window.location = "";
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

<?php
} else {
?>
  <script>
    window.location = "../";
  </script>
<?php
}
?>