<?php
session_start();
if (isset($_SESSION["rb_user"]) && $_SESSION["rb_user"]["type"] == "finance_head") {
  require "../../config/MySQLConnector.php";


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
    <title>Finance - Manage Finance</title>
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

  <body onload="getAllManufacturer()">
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
             
              <!-- ============================================================== -->
              <!-- Search -->
              <!-- ============================================================== -->

            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">

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
              <!-- End Messages -->
              <!-- ============================================================== -->

              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
              
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
                  href="../manageOrder/"
                  aria-expanded="false"><i class="me-2 mdi mdi-truck"></i><span class="hide-menu">Order Details</span></a>
              </li>

              <?php
              if ($_SESSION["rb_user"]["type"] == "finance_head") {
              ?>
                <li class="sidebar-item ">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href=""
                    aria-expanded="false"><i class="me-2 mdi mdi-account"></i><span class="hide-menu">Manage Finance</span></a>
                </li>
      
              <?php
              }
              ?>

              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="../profile/"
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
              <h4 class="page-title">Manage Finance Accounts</h4>

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
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a
                      class="nav-link active"
                      data-bs-toggle="tab"
                      href="#home"
                      role="tab"><span class="hidden-sm-up"></span>
                      <span class="hidden-xs-down">Finance Account List</span></a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      data-bs-toggle="tab"
                      href="#profile"
                      role="tab"><span class="hidden-sm-up"></span>
                      <span class="hidden-xs-down">Register</span></a>
                  </li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                  <div class="tab-pane active" id="home" role="tabpanel">
                    <div class="row table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>

                          <th scope="col">#</th>
                          <th scope="col"></th>
                          <th scope="col">Name</th>
                          <th scope="col">Email</th>
                          <th scope="col">Username</th>
                          <th scope="col">Status</th>


                        </thead>
                        <tbody id="manuLoader">


                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane p-2" id="profile" role="tabpanel">
                    <div class="p-2">


                      <div class="col-12">

                        <form class="form-horizontal">
                          <div class="card-body">

                            <h4 class="card-title text-center mb-5">Register a New Finance Officer</h4>
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
                                      id="cname"
                                      placeholder="Name" />
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
                                      id="email"
                                      placeholder="email" />
                                  </div>
                                </div>
                              </div>

                              <div class="col-12">
                                <div class="form-group row ">
                                  <label
                                    for="cono1"
                                    class="col-sm-3 text-start control-label col-form-label">Image</label>
                                  <div class="col-sm-9 justify-content-lg-between justify-content-center">
                                    <img src="../../assets/images/users/1.jpg" id="view1" alt="" height="200px">
                                    <input type="file" class="d-none" id="mImage">
                                    <label for="mImage" class="btn btn-primary " onclick="changeImg()">+</label>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 text-center">
                                <button type="button" class="btn btn-dark w-75" onclick="addNewManufacturer()">
                                  Register
                                </button>
                              </div>

                            </div>


                          </div>

                        </form>
                      </div>
                    </div>
                  </div>

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


      function getAllManufacturer() {


        fetch("api/getAllDesigners.php", {
            method: "POST",
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

            const manuLoader = document.getElementById("manuLoader");
            manuLoader.innerHTML = "";

            var num = 1;
            value.forEach(element => {
            
              var imgpath = "../../assets/images/users/1.jpg";
              if (element.img) {
                imgpath = "../../resources/userImg/" + element.img;
              }

              var act = "";
              var deac = "";
              if (element.u_status == "DEACTIVE") {
                deac = "selected";
              } else {
                act = "selected"
              }

              manuLoader.innerHTML = manuLoader.innerHTML +
                `    <tr role="button" data-bs-toggle="modal" data-bs-target="#manuView${element.id}">
                          <th>${num}</th>
                          <td><img
                              class=""
                              width="70"
                              height="70"
                              src="${imgpath}"
                              alt="Designer"
                              data-toggle="tooltip"
                              data-placement="top"
                              title=""
                             
                            /></td>
                          <td>${element.name}</td>
                          <td>${element.email}</td>
                          <td>${element.username}</td>
                          <td>${element.u_status}</td>
                         

                        </tr>

<!-- Modal -->
<div class="modal fade" id="manuView${element.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Finance Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="col-12">

                      <form class="form-horizontal">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-12 col-lg-6">
                              <div class="form-group row">
                                <label
                                  for="fname"
                                  class="col-sm-3 text-start control-label col-form-label">Name<span class="text-danger">&#8727;</span></label>
                                <div class="col-sm-9">
                                  <input
                                    type="text"
                                    value="${element.name}"
                                    class="form-control"
                                    id="uname${element.id}"
                                    placeholder="Company Name" />
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
                                    id="uemail${element.id}"
                                    value="${element.email}"
                                    placeholder="company email" />
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group row ">
                                <label
                                  for="cono1"
                                  class="col-sm-3 text-start control-label col-form-label">Image</label>
                                <div class="col-sm-9 justify-content-lg-between justify-content-center">
                                  <img src="${imgpath}" id="view2${element.id}" alt="" height="200px">
                                  <input type="file" class="d-none" id="uimage${element.id}">
                                  <label for="uimage${element.id}" class="btn btn-primary " onclick="changeUpdateImg(${element.id})">+</label>
                                </div>
                              </div>
                            </div>
                            <hr/>
                             
                            <div class="col-12 col-lg-6">
                              <div class="form-group row">
                                <label
                                  for="lname"
                                  class="col-sm-3 text-start control-label col-form-label">Status<span class="text-danger">&#8727;</span></label>
                                <div class="col-sm-9" >
                                <select class="form-select" id="status${element.id}">
                                <option value="ACTIVE" ${act}>ACTIVE</option>
                                <option value="DEACTIVE" ${deac}>DEACTIVE</option>
                                </select>
                                </div>
                              </div>
                            </div>
                            
                            <hr/>
                            <div class="col-12 col-lg-6">
                              <div class="form-group row">
                                <label
                                  for="lname"
                                  class="col-sm-3 text-start control-label col-form-label">Username</label>
                                <div class="col-sm-9">
                                  <input
                                    type="text"
                                    class="form-control"
                                    id="uusername${element.id}"
                                    value="${element.username}"
                                    placeholder="company mobile" />
                                </div>
                              </div>
                            </div>

                           
                            

                            <div class="col-12 col-lg-6">
                              <div class="form-group row">
                                <label
                                  for=""
                                  class="col-sm-3 text-start control-label col-form-label">Password</label>
                                <div class="col-sm-9">
                                  <input 
                                    type="text"
                                    class="form-control"
                                    id="upassword${element.id}"
                                    value="${element.password}"
                                    placeholder="company mobile" />
                                </div>
                              </div>
                            </div>
                            

                          </div>


                        </div>

                      </form>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-dark"  onclick="updateManufacturer(${element.id})">Update Profile</button>
      </div>
    </div>
  </div>
</div>
                        `;
              num++;
            });

          })
          .catch(function(error) {
            console.log(error);
          });

      }



      function addNewManufacturer() {

        var cname = document.getElementById("cname");
        var email = document.getElementById("email");

        var cimage = document.getElementById("mImage");


        if (!cname.value) {

          toastr.error(
            "Company Name Is Empty.",
            "Empty Details !"
          );


        } else if (!email.value) {

          toastr.error(
            "Company Email Is Empty.",
            "Empty Details !"
          );

        } else {

          var formData = new FormData();
          formData.append("cname", cname.value);
          formData.append("email", email.value);
          formData.append("cimg", cimage.files[0]);

          fetch("api/addDesigner.php", {
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
                  window.location = "../manageFinance/";
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

      function updateManufacturer(id) {

        var cname = document.getElementById("uname" + id);
        var email = document.getElementById("uemail" + id);
        var username = document.getElementById("uusername" + id);
        var password = document.getElementById("upassword" + id);

        var status = document.getElementById("status" + id);



        var cimage = document.getElementById("uimage" + id);


        if (!cname.value) {

          toastr.error(
            "Name Is Empty.",
            "Empty Details !"
          );


        } else if (!email.value) {

          toastr.error(
            "User Email Is Empty.",
            "Empty Details !"
          );

        } else if (!username.value) {

          toastr.error(
            "usernane Is Empty.",
            "Empty Details !"
          );

        } else if (!password.value) {

          toastr.error(
            "password Is Empty.",
            "Empty Details !"
          );

        } else {

          var formData = new FormData();
          formData.append("cname", cname.value);
          formData.append("id", id);
          formData.append("email", email.value);
          formData.append("username", username.value);
          formData.append("password", password.value);
          formData.append("status", status.value);
          formData.append("cimg", cimage.files[0]);

          fetch("api/updatedesigner.php", {
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
                  window.location = "../manageFinance/";
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