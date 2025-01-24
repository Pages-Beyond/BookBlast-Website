<?php
include("connect.php");

session_start();

if (!isset($_SESSION['password'])) {
    header("Location: ../login/login.php");
}

$userID = $_SESSION['userID'];

$userQuery = "SELECT * FROM tbl_users WHERE role = 'admin' AND tbl_users.userID = '$userID'";
$userResult = executeQuery($userQuery);

while($row = mysqli_fetch_assoc($userResult)){
    $userProfilePic = $row['userProfilePic'];
};

date_default_timezone_set('Asia/Manila');

$currentTime = date("F d, Y : H:i A");
$dateBorrowed = date("Y-m-d H:i:s");
$timestamp = strtotime(datetime: $dateBorrowed);

$returnDate = date('Y-m-d H:i:s', strtotime("+30 days", $timestamp));

$transactionInfoQuery = " SELECT tbl_transactions.*, tbl_users.*, tbl_books.*, tbl_authors.*,
    CONCAT(tbl_userinfo.firstName, ' ' ,tbl_userinfo.lastName) AS userFullName, 
    CONCAT(tbl_authors.firstName, ' ' ,tbl_authors.lastName) AS authorFullName
    FROM tbl_transactions 
    LEFT JOIN tbl_users ON tbl_transactions.userID = tbl_users.userID 
    LEFT JOIN tbl_userinfo ON tbl_users.userID = tbl_userinfo.userID 
    LEFT JOIN tbl_books ON tbl_transactions.bookID = tbl_books.bookID 
    LEFT JOIN tbl_authors ON tbl_books.authorID = tbl_authors.authorID 
    WHERE isApproved = 'pending' ORDER BY transactionID; 
    ";

$transactionInfoResult = executeQuery($transactionInfoQuery);


if (isset($_POST['btnAccept'])) {
    $transactionID = $_POST['transactionID'];

    $updateRequest = "UPDATE tbl_transactions SET isApproved = 'approved', status = 'reading', dateBorrowed ='$dateBorrowed', datetoReturn ='$returnDate' WHERE transactionID = '$transactionID'";
    executeQuery($updateRequest);
    header("Location: requests.php");

}

if (isset($_POST['btnDecline'])) {
    $transactionID = $_POST['transactionID'];

    $updateRequest = "UPDATE tbl_transactions SET isDeclined = 'declined' WHERE transactionID = '$transactionID'";
    executeQuery($updateRequest);
    header("Location: requests.php");
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="../assets/admin/img/bookblast-logo.png" type="image/png">
    <link rel="stylesheet" href="../assets/admin/css/requests.css">

</head>

<body>
    <!-- Navbar -->
    <?php include("../assets/admin/shared/navbar.php"); ?>

    <!-- Sidebar -->
    <?php include("../assets/admin/shared/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-content col-10 d-flex flex-column">
        <div class="bookTitle my-3">
            <h1>Requests</h1>
        </div>

        <?php include('process/requestProcess.php') ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });
    </script>
</body>

</html>