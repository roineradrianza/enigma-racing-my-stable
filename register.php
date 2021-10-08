<?php 
session_start();
$page = "register";
require_once("middleware/verifyAuth.php");
if ($isLoggedIn == true) {
  if ($_SESSION['position'] === "admin" or $_SESSION['position'] === "Admin") {
    header("Location: dashboard/");
  }
  else{
    header("Location: panel/");
  }
}
else{
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Enigma Racing - Register</title>
  <!-- base:css -->
  <link rel="stylesheet" href="dashboard/template/vendors/feather/feather.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="dashboard/template/css/style.min.css">
  <link rel="stylesheet" href="dashboard/template/css/custom.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="dashboard/template/images/favicon.ico" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center" id="registerContainer">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <img src="dashboard/template/images/logo.png" alt="logo">
              </div>
              <h4>Register for MyStable</h4>
              <h6 class="font-weight-light"> Password does not need to be the same as ENIGMA forum</h6>
              <form class="pt-3" id="registerForm">
                <div class="form-group">
                  <label>Full name</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" name="fullname" id="fullname" class="form-control form-control-lg border-left-0" placeholder="e.g John Doe" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-email-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="email" name="email" id="email" class="form-control form-control-lg border-left-0" placeholder="Email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" id="password" placeholder="Password" required>                        
                  </div>
                </div>
                <div class="form-group">
                  <label>Confirm password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" id="confirm_password" placeholder="Repeat again the password">                        
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an <b class="font-weight-bold" style="color: black;">MyStable</b> account? <a href="login.php" class="text-primary">Login</a>
                </div>
                 <p class="text-black font-weight-medium text-center flex-grow align-self-end mt-3">Copyright &copy; 2020  All rights reserved.</p>
              </form>
            </div>
          </div>
          <div class="col-lg-6 register-half-bg d-flex d-none d-md-flex flex-row">
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="dashboard/template/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="dashboard/template/js/off-canvas.js"></script>
  <script src="dashboard/template/js/hoverable-collapse.js"></script>
  <script src="dashboard/template/js/template.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script type="text/javascript" src="ajax/app.js"></script>
  <!-- endinject -->
</body>

</html>
<?php } ?>
