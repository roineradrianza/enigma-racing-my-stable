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
  <title>Dashboard - Documentation</title>
  <!-- base:css -->
  <link rel="stylesheet" href="template/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="template/vendors/feather/feather.css">
  <link rel="stylesheet" href="template/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="template/vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="template/vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="template/vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="template/vendors/jquery-bar-rating/fontawesome-stars.css">
  <!-- End plugin css for this page -->
  <!-- Datables css -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
  <!-- inject:css -->
  <link rel="stylesheet" href="template/css/style.css">
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
            <div class="col-xl-10 grid-margin-lg-0 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center" style="font-size: 1.5em;">Documentation</h2>
                    <div id="accordion">
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-toggle="collapse" data-target="#question1" aria-expanded="true" aria-controls="question1">
                                ¿How can I Upload my workbook?
                              </button>
                            </h5>
                          </div>

                          <div id="question1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <h5>
                                  <strong>First:</strong> you have to go to <a href="upload.php">upload section.</a>
                                </h5>
                                <img class="img-fluid img-thumbnail mb-3" src="documentation/upload-section.PNG">                               
                                 <h5>
                                  <strong>Second:</strong> Once you are in the upload section, you have to select the file clicking on <strong>"Load"</strong> button.
                                </h5>
                                <img class="img-fluid img-thumbnail mb-3" src="documentation/workbook-load.PNG">
                                <h5>
                                  <strong>Third:</strong> You have to upload the file clicking on <strong>"Upload"</strong> button and then wait until the uploading finishes.
                                </h5>
                                <img class="img-fluid img-thumbnail mb-3" src="documentation/workbook-uploading.PNG"> 
                                <img class="img-fluid img-thumbnail mb-3" src="documentation/workbook-success.PNG"> 
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                ¿How can manage users?
                              </button>
                            </h5>
                          </div>
                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                              <h5>You can manage the users in the <a href="members.php">members section</a>, there you can manage the details of the users, creating them or deleting them as well.</h5>
                            <img class="img-fluid img-thumbnail mb-3" src="documentation/workbook-success.PNG"> 
                            <h5><strong>¿How to create an user?</strong></h5>
                            <h5>You have to click in the <strong>"Add new user"</strong> button, after that you just have to fill the form with the data of the user.</h5>
                            <img class="img-fluid img-thumbnail mb-3" src="documentation/member-creation.PNG"> 
                            <h5><strong>¿How to edit an user?</strong></h5>
                            <h5>You have to click in the <strong><i class="fa fa-pencil"></i> pencil</strong> button, after that you just have to fill the form with the  new data of the user.</h5>
                            <img class="img-fluid img-thumbnail mb-3" src="documentation/member-edit.PNG"> 
                            <h5><strong>Note:</strong></h5>
                            <h5>You have to keep in mind that <strong>every email has to be unique</strong>, if you try to insert an email that already exist in the database, you will have an <strong>error</strong> like this:</h5>
                            <img class="img-fluid img-thumbnail mb-3" src="documentation/members-error.PNG"> 
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Template of the workbook
                              </button>
                            </h5>
                          </div>
                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                             <h5>The template that is handled by the system is the following:</h5>
                            <img class="img-fluid img-thumbnail mb-3" src="documentation/workbook-template.PNG"> 
                            <h5>Keep in mind that <strong>any change made</strong> on the workbook template that is going to be uploaded will mean in a <strong>possible error</strong> and the data couldn't upload properly to the database.</h5>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingFourth">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFourth" aria-expanded="false" aria-controls="collapseFourth">
                                ¿How can the system display the information for the stable of each member?
                              </button>
                            </h5>
                          </div>
                          <div id="collapseFourth" class="collapse" aria-labelledby="headingFourth" data-parent="#accordion">
                            <div class="card-body">
                             <h5>When you upload the workbook, the system automatically will display the information of the stable by the email of the member on each page of the workbook, <strong>for that reason is important that the member who is going to register, he/she do it with the email that appears in the workbook</strong>.</h5>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingFifth">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFifth" aria-expanded="false" aria-controls="collapseFifth">
                                ¿Where the users can see their stable?
                              </button>
                            </h5>
                          </div>
                          <div id="collapseFifth" class="collapse" aria-labelledby="headingFifth" data-parent="#accordion">
                            <div class="card-body">
                               <h5>They can see their stable at <strong><a href="../panel/">my stable panel</a></strong>, they can see their horse once they appear in the workbook and this one it have been uploaded.</h5>
                              <img class="img-fluid img-thumbnail mb-3" src="documentation/my-stable.PNG">
                            </div>
                          </div>
                        </div>
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
  <!-- plugin js for this page -->
  <script src="template/vendors/chart.js/Chart.min.js"></script>
  <script src="template/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Datables js -->
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
  <!-- Custom js for this page-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="template/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php  }else{
  header("Location: ../login.php");
}?>
