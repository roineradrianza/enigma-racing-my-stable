<?php
session_start();
$page = "";
require_once("../middleware/verifyAuth.php");
if (isset($_SESSION['position']) AND $_SESSION['position']=="admin")
{
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
  <!-- base:css -->
  <link rel="stylesheet" href="template/vendors/feather/feather.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="template/vendors/font-awesome/css/font-awesome.min.css">
  <!-- End plugin css for this page -->
  <!-- Datables css -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.css"/>
  <!-- inject:css -->
  <link rel="stylesheet" href="template/css/style.min.css">
  <link rel="stylesheet" href="template/css/button.css">
  <!-- endinject -->

  <link rel="shortcut icon" href="template/images/favicon.ico" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-flex mr-4 ">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Settings</p>
              <a class="dropdown-item preview-item" href="../panel/">               
                <i class="icon-monitor"></i> My stable
              </a>
              <a class="dropdown-item preview-item" href="../controller/members.php?op=logout">
                  <i class="icon-inbox"></i> Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="user-profile">
          <div class="user-name">
              <?php echo $_SESSION['name']; ?>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="icon-box menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="members.php">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Members</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="syndicates.php">
              <i class="icon-disc menu-icon"></i>
              <span class="menu-title">Syndicates</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="upload.php">
              <i class="icon-outbox menu-icon"></i>
              <span class="menu-title">Upload</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="documentation.php">
              <i class="icon-file menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-xl-12 grid-margin-lg-0 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Share Database</h4>
                    <div class="table-responsive mt-3">
                      <table class="table table-header-bg" id="tb_list_payment"  data-order='[[ 3, "desc" ]]' data-page-length='20'>
                        <thead>
                          <tr>
                            <th>
                               	Name
                            </th>
                            <th>
                              	Email
                            </th>
                            <th>
                                Horse
                            </th>
                            <th>
                                Sire
                            </th>
                            <th>
                            	Start
                            </th>
                            <th class="dt-head-center">
                            	No. share
                            </th>
                            <th>
                            	Method
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
        <footer class="footer">
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="template/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="template/js/template.js"></script>
  <!-- endinject -->
  <!-- Datables js -->
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <!-- Custom js for this page-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="template/js/dashboard.js"></script>
  <script src="template/js/member.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php  }else{
  header("Location: ../login.php");
}?>
