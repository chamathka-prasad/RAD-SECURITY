<?php
session_start();
if (isset($_SESSION["rb_user"]) && ($_SESSION["rb_user"]["type"] == "admin"))  {
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
    <title>Designer Manage Orders</title>
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
                  <a class="dropdown-item" href="../profile/"><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a>
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
                  href="newOrder/"
                  aria-expanded="false"> <i class="me-2 mdi mdi-cart"></i><span class="hide-menu">New Order</span></a>
              </li>

              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href=""
                  aria-expanded="false"><i class="me-2 mdi mdi-truck"></i><span class="hide-menu">Order Details</span></a>
              </li>

              <?php
              if ($_SESSION["rb_user"]["type"] == "designer_head") {
              ?>
                <li class="sidebar-item ">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="../manageDesigner/"
                    aria-expanded="false"><i class="me-2 mdi mdi-account"></i><span class="hide-menu">Manage Designer</span></a>
                </li>
                <li class="sidebar-item ">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="../manageManifacturer/"
                    aria-expanded="false"><i class="me-2 mdi mdi-account-multiple"></i><span class="hide-menu">Manage Manufacturer</span></a>
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
              <h4 class="page-title">Manage Order</h4>
              <a class="btn btn-primary ms-lg-5 ms-0" href="newOrder/">Create New Order</a>

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
              <div class="card mb-3">
                <div class="row p-10">
                  <h4 class="card-title text-center mb-2 mt-2">All Orders</h4>
                  <h6 class="card-title mt-2">Search Orders By</h6>
                  <hr>
                  <div class="row">
                    <div class="col-12 col-lg-4">
                      <div class="form-group row">
                        <label
                          for="fname"
                          class="col-sm-3 text-start control-label col-form-label">Name</label>
                        <div class="col-sm-9">
                          <input
                            type="text"
                            class="form-control"
                            id="oname"
                            placeholder="Order Name" onkeyup="getAllOrders(0)" />
                        </div>
                      </div>
                    </div>



                    <div class="col-12 col-lg-3">
                      <div class="form-group row">
                        <label
                          for="fname"
                          class="col-sm-3 text-start control-label col-form-label">Status</label>
                        <div class="col-sm-9">
                          <select name="" class="form-select" id="ostatus" onchange="getAllOrders(0)">
                            <option value="ALL">ALL</option>
                            <option value="NEW">NEW</option>
                            <option value="PROCESSING">PROCESSING</option>
                            <option value="INITIAL GERBER">INITIAL GERBER</option>
                            <option value="ENGINEER QUESTION">ENGINEER QUESTION</option>
                            <option value="PROCESSED GERBER">PROCESSED GERBER</option>
                            <option value="MANUFACTURING">MANUFACTURING</option>
                            <option value="DISPATCH BOARDS">DISPATCH BOARDS</option>
                            <option value="BOARDS RECEIVE">BOARDS RECEIVE</option>
                            <option value="BOARDS TEST">BOARDS TEST</option>
                            <option value="HOLD">HOLD</option>
                            <option value="CANCELED">CANCELED</option>
                            <option value="COMPLETED">COMPLETED</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-4">
                      <div class="form-group row">
                        <label
                          for="fname"
                          class="col-sm-3 text-start control-label col-form-label">date</label>
                        <div class="col-sm-9">
                          <input
                            type="date"
                            class="form-control"
                            id="odate"
                            placeholder="Order Name" onchange="getAllOrders(0)" />
                        </div>
                      </div>
                    </div>

                    <div class="col-12 col-lg-1 text-center">
                      <button type="button" class="btn btn-dark" onclick="clearData()">
                        Clear
                      </button>
                    </div>

                  </div>
                </div>

              </div>
              <div class="col-12 bg-white">
                <div class="row table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>

                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Date</th>
                      <th scope="col">Status</th>

                      <th scope="col">Note</th>

                    </thead>
                    <tbody id="manuLoader">


                    </tbody>
                  </table>
                </div>

                <div class="row mt-3">
                  <div class="col-12 text-center">
                    <!-- Card start -->
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group" id="pagicontainerph">

                        </div>
                      </div>
                    </div>
                    <!-- Card end -->
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
      function clearData() {
        var oname = document.getElementById("oname");

        var ostatus = document.getElementById("ostatus");
        var odate = document.getElementById("odate");
        oname.value = "";
        odate.value = "";
        ostatus.value = "ALL";

        getAllOrders(0);
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

              var imgpath = "../../assets/images/users/1.jpg";
              if (element.img) {
                imgpath = "../../resources/companyImg/" + element.img;
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
    window.location = "../../";
  </script>
<?php
}
?>