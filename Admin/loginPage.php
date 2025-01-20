<?php
include("connect.php");

session_start();
session_destroy();
session_start();

$error = "";

if (isset($_POST['btnLogin'])) {
  $email = $_POST['info'];
  $contactNumber = $_POST['info'];
  $password = $_POST['password'];

  // $query = "SELECT * FROM tbl_users LEFT JOIN tbl_userinfo ON tbl_users.userInfoID = tbl_userinfo.userInfoID 
  // WHERE (email = '$email' OR contactNumber = '$contactNumber') AND password = '$password' AND role = 'admin'";
  $query = "SELECT * FROM tbl_users WHERE (email = '$email' OR contactNumber = '$contactNumber') AND (password = '$password' AND role = 'admin')";
  $result = executeQuery($query);

  if (mysqli_num_rows($result) > 0) {
    while ($admin = mysqli_fetch_assoc($result)) {
      // $_SESSION['firstName'] = $admin['firstName'];
      // $_SESSION['lastName'] = $admin['lastName'];
      // $_SESSION['phoneNumber'] = $admin['phoneNumber'];
      // $_SESSION['email'] = $admin['email'];
      // $_SESSION['userName'] = $admin['userName'];
      // $_SESSION['userID'] = $admin['userID'];
    }

    header("Location: index.php");
  } else {
    $error = "Not found";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="icon" href="assets/img/bookblast-logo.png" type="image/png">


</head>

<body>
  <!-- LOGO -->
  <div class="container text-center pt-4 d-flex justify-content-center">
    <img src="assets/img/login/bb logo.png" alt="Logo" class="img-fluid" style="max-width: 60px;">
  </div>

  <div class="container d-flex justify-content-center align-items-center mt-5 mt-md-5" style="height: 65%;">
    <div class="row w-100 text-md-start">
      <div class="col-12 col-md-6 text-center text-md-start">
        <!-- wordmark -->
        <img src="assets/img/login/bb wordmark.png" alt="Wordmark" class="img-fluid wordmark-img">
        <!-- description -->
        <p class="mt-3" style="font-size: 18px;">Organize, track, and manage library resources.</p>
      </div>

      <!-- EMAIL -->
      <div class="col-12 col-md-6" style="margin-top: 20px">
        <form method="POST">

          <div class="mb-5">
            <input type="text" class="form-control" name="info" placeholder="Email or Phone Number" required>
          </div>
          <!-- password -->
          <div class="mb-5">
            <input type="password" class="form-control" name="password" placeholder="Password" type="password" required>
          </div>
          <div class="d-flex justify-content-center">
            <div class="login-button-container">
              <button class="btn login-btn" name="btnLogin">Log In</button>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>


  <?php if ($error == "Not found") { ?>
    <div class="container">
      <div class="row">
        <div class="col">
          <div style="height: 50px; font-family: Georgia; font-size: 20px"
            class="alert alert-danger d-flex align-items-center justify-content-center text-center" role="alert">
            Incorrect Details
          </div>
        </div>
      </div>
    </div>
  <?php } ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>