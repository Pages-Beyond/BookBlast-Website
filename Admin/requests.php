<?php
include("connect.php");

$transactionInfoQuery = " SELECT * FROM tbl_transactions 
    LEFT JOIN tbl_users ON tbl_transactions.userID = tbl_users.userID
    LEFT JOIN tbl_userinfo ON tbl_users.userID = tbl_userinfo.userID
    LEFT JOIN tbl_books ON tbl_transactions.bookID = tbl_books.bookID
    LEFT JOIN tbl_authors ON tbl_books.authorID = tbl_authors.authorID
    WHERE isApproved = 'pending'
    ";

$transactionInfoResult = executeQuery($transactionInfoQuery);

if (isset($_POST['btnAccept'])) {

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
    <div class="main-content col-10 d-flex flex-column align-items-start">
        <div class="bookTitle my-3">
            <h1>Requests</h1>
        </div>


        <?php
        if (mysqli_num_rows($transactionInfoResult) > 0) {
            while ($transactionInfoRows = mysqli_fetch_assoc($transactionInfoResult)) { ?>

                <!-- Card Row -->
                <div class="row ms-1 g-5">
                    <!-- Transaction Creation -->
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="card" style="max-width: 16rem; min-width: 12rem;">
                            <img src="../assets/shared/img/bookCovers/<?php echo $transactionInfoRows['bookCover'] ?>"
                                class="card-img-top" alt="Dashboard Image" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="mb-5">
                            <h2 class="mb-0" style="white-space: nowrap;"><?php echo $transactionInfoRows['bookTitle'] ?></h2>
                            <h6 class="mb-0" style="white-space: nowrap;">
                                <?php echo $transactionInfoRows['firstName'] . " " . $transactionInfoRows['lastName'] ?>
                            </h6>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 d-flex flex-column align-items-start justify-content-center mt-0 order-md-1 order-2 ms-md-auto"
                        style="margin-right: 20px;">
                        <div class="d-flex flex-column align-items-start">
                            <h1 class="mb-0" style="white-space: nowrap;"><?php echo $transactionInfoRows[''] ?></h1>
                            <h6 class="mb-1"><?php echo $transactionInfoRows['email'] ?></h6>
                            <h6 class="mb-0"><?php echo $transactionInfoRows['contactNumber'] ?></h6>
                        </div>

                        <form method="POST">
                            <div class="mt-4 d-flex justify-content-between" style="gap: 70px;">
                                <div class="col-6 col-sm-12">
                                    <button class="btn w-100"
                                        style="background-color: #7D97A0; border-radius: 30px; color: white;">Allow</button>
                                </div>
                                <div class="col-6 col-sm-12">
                                    <button class="btn w-100"
                                        style="background-color: #B26424; border-radius: 30px; color: white;">Decline</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?php
            }
        }
        ?>
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