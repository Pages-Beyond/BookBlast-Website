<?php
include('../../shared/connect.php');

if (isset($_POST['btnRegister'])) {
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $password = $_POST['password'];
    $firstName = $_POST ['firstName'];
    $lastName = $_POST ['lastName'];

    $insertUserQuery = "INSERT INTO `tbl_users`(`email`, `contactNumber`, `password`) VALUES ('$email','$contactNumber','$password')";
    
    $userID = mysqli_insert_id($conn);
    $insertUserInfoQuery ="INSERT INTO 'tbl_userinfo (`firstName`, `lastName`, `addressID`, `userID`) VALUES ('$firstName','$lastName','$id', $id)";

}



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up Page</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/signup/bookblast-logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/signup.css">
   
</head>

<body>
    <!-- LOGO AND WORDMARK -->
    <div class="container text-center pt-4 d-flex justify-content-center">
        <img src="../../assets/img/signup/bb logo.png" alt="Logo" class="img-fluid" style="max-width: 60px;">
    </div>

    <div class="container-fluid text-center pt-3">
        <img src="../../assets/img/signup/bb wordmark sp.png" alt="Wordmark" class="img-fluid">
    </div>

    <form method="POST">
        <div class="container mt-2">
            <div class="row justify-content-center g-1">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <input type="text" class="form-control" placeholder="First Name" name="firstName">
                </div>
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <input type="text" class="form-control" placeholder="Last Name" name="lastName">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <small>Format: 0912-345-6789</small>
                    <input type="tel" pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" class="form-control"
                        placeholder="Contact Number" name="contactNumber" maxlength="13">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <input type="text" class="form-control" placeholder="Lot no./Street/House no." name="Street">
                </div>
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <select class="form-select customSelect form-select-md" onchange="updateProvinceSelection()">
                        <option selected>Select Province</option>
                        <?php 
                        $getProvinceQuery = "SELECT provinceID, provCode, provDesc  FROM `refprovince` ORDER BY provDesc ASC;";
                        $provinceResult = executeQuery($getProvinceQuery);
                        
                        while ($provinceRows = mysqli_fetch_assoc($provinceResult)){                        
                        ?>
                        
                        <option value="1"><?php echo $provinceRows['provDesc']; ?></option>

                        <?php 
                        }
                        ?>
                        
                    </select>
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <select class="form-select customSelect form-select-md <?php echo empty($provinceSelectResult) ? 'disabled' : ''; ?>>">
                        <option selected>Select City</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <select class="form-select customSelect form-select-md">
                        <option selected>Select Barangay</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <input type="text" class="form-control" placeholder="Email" name="email">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirmPassword">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-4">
                <button type="submit" class="btn register-btn" name="btnRegister">Register</button>
            </div>
        </div>
    </form>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>