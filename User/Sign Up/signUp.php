<?php 
include('../../shared/connect.php');

echo "Test";
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

    <div class="container mt-2">
        <div class="row justify-content-center g-1">
            <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                <input type="text" class="form-control" placeholder="First Name">
            </div>
            <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                <input type="text" class="form-control" placeholder="Last Name">
            </div>
        </div>
        <div class="row justify-content-center g-1 mt-2">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <input type="text" class="form-control" placeholder="Contact Number">
            </div>
        </div>
        <div class="row justify-content-center g-1 mt-2">
            <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                <input type="text" class="form-control" placeholder="Lot no./Street/House no.">
            </div>
            <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                <select class="form-select customSelect form-select-md">
                    <option selected>Select Province</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-center g-1 mt-2">
            <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
            <select class="form-select customSelect form-select-md">
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
                <input type="text" class="form-control" placeholder="Email">
            </div>
        </div>
        <div class="row justify-content-center g-1 mt-2">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <input type="password" class="form-control" placeholder="Password">
            </div>
        </div>
        <div class="row justify-content-center g-1 mt-2">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <input type="password" class="form-control" placeholder="Confirm Password">
            </div>
        </div>
        <div class="row justify-content-center g-1 mt-4">
            <button type="button" class="btn register-btn">Register</button>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>