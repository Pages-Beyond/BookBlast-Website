<?php
include("connect.php");

// if (!isset($_SESSION['email']) || ($_SESSION['contactNumber'])) {
//     header("Location: loginPage.php");
// }

$booksQuery = "SELECT DISTINCT(bookTitle), tbl_books.bookID, tbl_books.categoryID, tbl_books.bookCover, tbl_authors.* FROM tbl_books 
                INNER JOIN tbl_authors ON tbl_books.authorID = tbl_authors.authorID";
$booksResult = executeQuery($booksQuery);

if (isset($_POST['btnDelete'])) {
    $bookID = $_POST['bookID'];

    $deleteBookInfoQuery = "DELETE FROM tbl_books WHERE bookID = $bookID";
    executeQuery($deleteBookInfoQuery);

    header("Location: index.php");

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
    <link rel="stylesheet" href="../assets/admin/css/index.css">
</head>

<body>
    <!-- Navbar -->
    <?php include("../assets/admin/shared/navbar.php"); ?>

    <!-- Sidebar -->
    <?php include("../assets/admin/shared/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-column col-10 d-flex flex-column align-items-start ps-3">
        <div class="row w-100 align-items-center mt-3 mb-5">
            <!-- Book Title -->
            <div class="col-auto">
                <h1 class="mb-0">Books</h1>
            </div>

            <!-- Add Book Button -->
            <div class="col-auto ms-3">
                <a href="add.php" style="text-decoration: none;">
                    <div style="width: auto; height: auto; display: flex; align-items: center; 
                    padding: 10px; background-color: #EBDDAE; max-width: 400px; border-radius: 5px;">
                    
                        <!-- Text "Add Book" -->
                        <h3 class="mb-0 mx-2" style="flex-grow: 1; color: black">Add Book</h3>

                        <!-- Plus Icon -->
                        <i class="fa-solid fa-plus mx-3" style="font-size: 48px; color: black"></i>
                    </div>
                </a>
            </div>
        </div>


        <!-- Card Row -->
        <div class="row mx-auto g-5 justify-content-start">

            <?php include('process/viewBooks.php') ?>

        </div>
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