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

$userDetailsQuery = "SELECT tbl_transactions.*, tbl_users.*, tbl_addresses.*, refbrgy.*, refcitymun.*, refprovince.*,
    CONCAT(tbl_userinfo.firstName, ' ' ,tbl_userinfo.lastName) AS userFullName
    FROM tbl_transactions 
    LEFT JOIN tbl_users ON tbl_transactions.userID = tbl_users.userID 
    LEFT JOIN tbl_addresses ON tbl_users.userID = tbl_addresses.userID 
    LEFT JOIN refbrgy ON tbl_addresses.barangayID = refbrgy.barangayID 
    LEFT JOIN refcitymun ON tbl_addresses.cityID = refcitymun.cityID 
    LEFT JOIN refprovince ON tbl_addresses.provinceID = refprovince.provinceID 
    LEFT JOIN tbl_userinfo ON tbl_users.userID = tbl_userinfo.userID 
    WHERE (isApproved = 'approved' AND status = 'reading' AND isActive = 'YES') GROUP BY userFullName";

$userDetailsResults = executeQuery($userDetailsQuery);

if(isset($_POST['btnRestrict'])){
    $userID = $_POST['userID'];

    $updateUserStatus = "UPDATE tbl_users SET isActive = 'NO' WHERE userID = '$userID'";
    executeQuery($updateUserStatus);

    header("Location: users.php");

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
    <link rel="stylesheet" href="../assets/admin/css/users.css">

</head>

<body>
    <!-- Navbar -->
    <?php include("../assets/admin/shared/navbar.php"); ?>

    <!-- Sidebar -->
    <?php include("../assets/admin/shared/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-content col-10 d-flex flex-column align-items-start">
        <div class="bookTitle my-3">
            <h1>Users</h1>
        </div>

        <?php include('process/viewUsers.php') ?>

    </div>

    <script>
        document.querySelectorAll('[id^="expandButton-"]').forEach(button => {
            button.addEventListener('click', function () {
                // Get the user ID from the button's ID
                const userID = this.id.split('-')[1];
                const expandable = document.getElementById('expandable-' + userID);
                expandable.style.display = expandable.style.display === 'none' ? 'block' : 'none';
            });
        });

        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>