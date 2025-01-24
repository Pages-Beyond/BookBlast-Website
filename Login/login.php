<?php
include('../shared/connect.php');
session_start();
session_destroy();
session_start();

$error = "";

if (isset($_POST['loginButton'])) {

  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $contactNumber = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $role = '';

  $email = str_replace('\'', '', $email);
  $contactNumber = str_replace('\'', '', $contactNumber);
  $password = str_replace('\'', '', $password);

  $formattedContactNumber = substr($contactNumber, 0, 4) . '-' . substr($contactNumber, 4, 3) . '-' . substr($contactNumber, 7);


  $_SESSION['email'] = '';
  $_SESSION['password'] = '';
  $_SESSION['userID'] = '';
  $_SESSION['role'] ='';


  $email = str_replace('\'', '', $email);
  $password = str_replace('\'', '', $password);

  $loginUserQuery = "SELECT * FROM `tbl_users` WHERE (email = '$email' OR contactNumber = '$formattedContactNumber') AND password = '$password' and isActive = 'YES' ";
  $userResult = executeQuery($loginUserQuery);

  if (mysqli_num_rows($userResult) > 0) {
    while ($userRows = mysqli_fetch_assoc($userResult)){
      $_SESSION['email'] = $userRows ['email'];
      $_SESSION['password'] =$userRows ['password'];
      $_SESSION['userID'] = $userRows ['userID'];
      $_SESSION['role'] = $userRows['role'];
      $role = $userRows['role'];

    }
    if ( $role == 'user'){
      header ('location:../');

    }else{
      header ('location:../Admin/index.php');
    }
    
    
   
  } else {
    $error = "Invalid Credentials";

  }



}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log In Page</title>
  <link rel="icon" type="image/x-icon" href="../assets/user/img/login/bookblast-logo.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/user/css/login.css">
</head>

<body>
  <!-- LOGO -->
  <div class="container text-center pt-4 d-flex justify-content-center">
    <img src="../assets/user/img/login/bb logo.png" alt="Logo" class="img-fluid" style="max-width: 60px;">
  </div>

  <div class="container d-flex justify-content-center align-items-center mt-5 mt-md-5" style="height: 65%;">

    <div class="row w-100 text-md-start">
      <?php if ($error == "Invalid Credentials") { ?>
        <div class="alert alert-danger mb-3" role="alert">
          Invalid Credentials.
        </div>
      <?php } ?>
      <div class="col-12 col-md-6 text-center text-md-start">
        <!-- wordmark -->
        <img src="../assets/user/img/login/bb wordmark.png" alt="Wordmark" class="img-fluid wordmark-img">
        <!-- description -->
        <p class="mt-3" style="font-size: 18px;">Organize, track, and manage library resources.</p>
      </div>
      <!-- EMAIL -->
      <div class="col-12 col-md-6" style="margin-top: 20px">
        <form method="POST">
          <div class="mb-5">
            <input type="text" class="form-control" placeholder="Email or Phone Number" name="email" required>
          </div>
          <!-- password -->
          <div class="mb-5">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
          </div>
          <div class="d-flex justify-content-center">
            <div class="login-button-container">
              <button type=submit class="btn login-btn" name="loginButton">Log In</button>
            </div>
            <div class="ms-4 sign-up-button-container">

              <button class="btn sign-up-btn" onclick="document.location.href='../User/Sign Up/signUp.php'">Sign Up</button>

              <p class="text-white mt-2">didn't have an account?</p>
            </div>
          </div>
        </form>
      </div>


    </div>


  </div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>