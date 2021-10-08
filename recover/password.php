<?php 
session_start();
if (!isset($_SESSION['name']))
{
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Recover password</title>
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
  <div class="container mt-5">
    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <form id="recoverPasswordForm">
          <h3 class="text-center">Reset your password</h3>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password">
          </div>
         <div class="form-group">
            <label for="confirm_password">Confirm password</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password" Required>
          </div>
              <button type="submit" id="btnRestorePassword" class="btn btn-primary center">Reset</button>
        </form>
      </div>
      <div class="col-2"></div>
    </div>
  </div> 

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
  <!-- Custom js for this page-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="../dashboard/template/js/dashboard.js"></script>
  <script src="../dashboard/template/js/recoverPassword.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<?php  }else{
  header("Location: ../panel/");
}?>
