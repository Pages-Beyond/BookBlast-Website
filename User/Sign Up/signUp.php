<?php
include('../../shared/connect.php');

session_start();

$_SESSION['email'] = '';
$_SESSION['password'] = '';
$_SESSION['userID'] = '';
$_SESSION['firstName'] = '';
$_SESSION['lastName'] = '';

$passwordError = '';


$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$contactNumber = isset($_POST['contactNumber']) ? $_POST['contactNumber'] : '';
$street = isset($_POST['street']) ? $_POST['street'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

$firstName = str_replace('\'', '', $firstName);
$lastName = str_replace('\'', '', $lastName);
$email = str_replace('\'', '', $email);
$contactNumber = str_replace('\'', '', $contactNumber);
$street = str_replace('\'', '', $street);
$password = str_replace('\'', '', $password);
$confirmPassword = str_replace('\'', '', $confirmPassword);

$formattedContactNumber = substr($contactNumber, 0, 4) . '-' . substr($contactNumber, 4, 3) . '-' . substr($contactNumber, 7);


$provinceSelectResult = isset($_POST['provinceSelect']) ? $_POST['provinceSelect'] : '';
$provinceIDarr = '';
$provinceCodearr = '';
if ($provinceSelectResult != '') {
    list($provinceIDarr, $provinceCodearr) = explode(",", $provinceSelectResult);
}

$citySelectResult = isset($_POST['citySelect']) ? $_POST['citySelect'] : '';

$cityIDarr = '';
$citymunCodearr = '';
if ($citySelectResult != '') {
    list($cityIDarr, $citymunCodearr) = explode(",", $citySelectResult);
}
$barangaySelectResult = isset($_POST['barangaySelect']) ? $_POST['barangaySelect'] : '';
$barangayID = '';
if ($barangaySelectResult != '') {
    $barangayID = $barangaySelectResult;

}


if (isset($_POST['btnRegister'])) {


    if ($password == $confirmPassword) {
        $insertUserQuery = "INSERT INTO tbl_users(email, contactNumber, password) VALUES ('$email','$formattedContactNumber','$password')";
        executeQuery($insertUserQuery);
        $lastID = mysqli_insert_id($conn);
        $insertUserInfoQuery = "INSERT INTO tbl_userinfo (firstName, lastName, addressID, userID) VALUES ('$firstName','$lastName','$lastID', '$lastID')";
        executeQuery($insertUserInfoQuery);
        $insertUserAddressQuery = "INSERT INTO `tbl_addresses`(`userID`, `provinceID`, `cityID`, `barangayID`, `street`) VALUES ('$lastID','$provinceIDarr','$cityIDarr','$barangayID','$street')";
        executeQuery($insertUserAddressQuery);

        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['userID'] = $lastID;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;


        header('location: ../../');
    } else {
        $passwordError = "Password Unmatched";

    }
   


}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up Page</title>
    <link rel="icon" type="image/x-icon" href="../../assets/user/img/signup/bookblast-logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/user/css/signup.css">
</head>

<body>
    <!-- LOGO AND WORDMARK -->
    <div class="container text-center pt-4 d-flex justify-content-center">
        <a href="../../Login/login.php"><img src="../../assets/user/img/signup/bb logo.png" alt="Logo" class="img-fluid"
                style="max-width: 60px;"></a>
    </div>

    <div class="container-fluid text-center pt-3">
        <img src="../../assets/user/img/signup/bb wordmark sp.png" alt="Wordmark" class="img-fluid">
    </div>

    <form method="POST" action="signUp.php">
        <div class="container mt-2">
        <?php if ($passwordError == "Password Unmatched") { ?>
            <div class="alert alert-danger mb-3" role="alert">
                Password not matched.
            </div>
        <?php } ?>
            <div class="row justify-content-center g-1">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <input type="text" class="form-control" placeholder="First Name" name="firstName"
                        value="<?php echo htmlspecialchars($firstName); ?>">
                </div>
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <input type="text" class="form-control" placeholder="Last Name" name="lastName"
                        value="<?php echo htmlspecialchars($lastName); ?>">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <small>Format: 09xx-xxx-xxxx</small>
                    <input type="text" class="form-control"
                        placeholder="Contact Number" name="contactNumber" maxlength="11"
                        value="<?php echo htmlspecialchars($contactNumber); ?>">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <input type="text" class="form-control" placeholder="Lot no./Street/House no." name="street"
                        value="<?php echo htmlspecialchars($street); ?>">
                </div>
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <select class="form-select customSelect form-select-md" onchange="this.form.submit()"
                        name="provinceSelect">
                        <option value='' selected>Select Province</option>
                        <?php
                        $getProvinceQuery = "SELECT provinceID, provCode, provDesc  FROM `refprovince` ORDER BY provDesc ASC;";
                        $provinceResult = executeQuery($getProvinceQuery);

                        while ($provinceRows = mysqli_fetch_assoc($provinceResult)) {
                            $selected = ($provinceSelectResult == $provinceRows['provinceID'] . ',' . $provinceRows['provCode']) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $provinceRows['provinceID'] . ',' . $provinceRows['provCode'] ?>"
                                <?php echo $selected ?>>
                                <?php echo $provinceRows['provDesc']; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <select class="form-select customSelect form-select-md" name="citySelect"
                        onchange="this.form.submit()" <?php echo empty($provinceSelectResult) ? 'disabled' : ''; ?>>
                        <option value="" selected>Select City</option>
                        <?php
                        if ($provinceCodearr) {
                            $getCityQuery = "SELECT cityID, citymunCode, citymunDesc FROM `refcitymun` WHERE provCode = '$provinceCodearr' ORDER BY citymunDesc ASC;";
                            $cityResult = executeQuery($getCityQuery);
                            while ($cityRows = mysqli_fetch_assoc($cityResult)) {
                                $selected = ($citySelectResult == $cityRows['cityID'] . ',' . $cityRows['citymunCode']) ? 'selected' : '';



                                ?>
                                <option value="<?php echo $cityRows['cityID'] . ',' . $cityRows['citymunCode'] ?>" <?php echo $selected ?>><?php echo $cityRows['citymunDesc'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                    <select class="form-select customSelect form-select-md" name="barangaySelect"
                        onchange="this.form.submit()" <?php echo empty($citySelectResult && $provinceSelectResult) ? 'disabled' : ''; ?>>
                        <option value="" selected>Select Barangay</option>
                        <?php
                        if ($citymunCodearr) {
                            $getBarangayQuery = "SELECT barangayID, brgyCode, brgyDesc FROM `refbrgy` WHERE citymunCode = '$citymunCodearr' ORDER BY brgyDesc ASC;";
                            $brgyResult = executeQuery($getBarangayQuery);
                            while ($brgyRows = mysqli_fetch_assoc($brgyResult)) {
                                $selected = ($barangaySelectResult == $brgyRows['barangayID']) ? 'selected' : '';



                                ?>
                                <option value="<?php echo $brgyRows['barangayID'] ?>" <?php echo $selected ?>>
                                    <?php echo $brgyRows['brgyDesc'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <input type="text" class="form-control" placeholder="Email" name="email"
                        value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <input type="password" class="form-control" placeholder="Password" name="password"
                        value="<?php echo htmlspecialchars($password); ?>">
                </div>
            </div>
            <div class="row justify-content-center g-1 mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirmPassword"
                        value="<?php echo htmlspecialchars($confirmPassword); ?>">
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