<?php
session_start(); 
$page = "";
require_once("../middleware/verifyAuth.php");
if ($_SESSION['status'] == 'unverified') {
?>
 <!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Required meta tags --> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Stable</title>
    <!-- base:css -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../dashboard/template/css/style.min.css">
    <link rel="stylesheet" href="../dashboard/template/css/custom.css">
    <!-- endinject -->

    <link rel="shortcut icon" href="../dashboard/template/images/favicon.ico" />
  </head>
  <body>
    <script src="../dashboard/template/vendors/base/vendor.bundle.base.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../dashboard/template/js/noverified.js"></script>
  </body>
</html>
<?php
 } else{ ?>
<?php 
if (isset($_SESSION['name']))
{
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>My Stable</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../dashboard/template/vendors/feather/feather.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../dashboard/template/vendors/font-awesome/css/font-awesome.min.css">
  <!-- End plugin css for this page -->
  <!-- Datables css -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
  <!-- inject:css -->
  <link rel="stylesheet" href="../dashboard/template/css/style.min.css">
  <link rel="stylesheet" href="../dashboard/template/css/custom.css">
  <!-- endinject -->

  <link rel="shortcut icon" href="../dashboard/template/images/favicon.ico" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="../panel"><img src="../dashboard/template/images/logo.png" alt="logo" ></a>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-flex mr-4 ">
           <i id="greetings">Hello, <?php echo $_SESSION['name']; ?></i>
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Settings</p>
              <?php if ($_SESSION['position'] === "admin") {
                echo '
                    <a class="dropdown-item preview-item" href="../dashboard/">               
                      <i class="icon-content-left"></i> Administration panel
                    </a>';
              } ?>         
              <a class="dropdown-item preview-item" data-toggle="modal" data-target="#memberFormModal" href="#">
                  <i class="icon-head"></i> Change password
              </a>              
              <a class="dropdown-item preview-item" href="../controller/members.php?op=logout">
                  <i class="icon-inbox"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>                         
    <div class="modal fade" id="memberFormModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="memberModalLabel">Change password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cancelForm();">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-4">
            <form id="memberForm">
              <div class="form-group">
                <label for="password">password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password">
              </div>
             <div class="form-group">
                <label for="confirm_password">Confirm password</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelForm();">Close</button>
            <button type="submit" id="btnSave" class="btn btn-primary">Create</button>
          </form>
          </div>
          
        </div>
      </div>
    </div>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper" id="panel-wrapper">
          <div class="row">
            <div class="col-xl-12 grid-margin-lg-0 grid-margin stretch-card">
              <div class="card card mt-4 mt-md-0 mt-lg-0">
                <div class="card-body">
                    <h4 class="text-center">ENIGMA <strong>MyStable</strong></h4>
                    <div class="table-responsive mt-3">
                      <table class="table table-header-bg" id="tb_list_stable"  data-order='[[0,"asc"],[6,"asc"]]' data-page-length='25'>
                        <thead>
                          <tr>
                            <th>
                               	Type
                            </th>
                            <th>
                                Horse
                            </th>
                            <th>
                              	Sire
                            </th>
                            <th>
                                Trainer
                            </th>
                            <th>
                            	%
                            </th>
                            <th>
                            	Shares
                            </th>
                            <th>
                            	Next vote
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
  <script src="../dashboard/template/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../dashboard/template/js/off-canvas.js"></script>
  <script src="../dashboard/template/js/hoverable-collapse.js"></script>
  <script src="../dashboard/template/js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../dashboard/template/vendors/chart.js/Chart.min.js"></script>
  <script src="../dashboard/template/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Datables js -->
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
  <!-- Custom js for this page-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="../dashboard/template/js/dashboard.js"></script>
  <script src="../dashboard/template/js/panel.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php  
    }
    else{
      header("Location: ../login.php");
    }
}?>
