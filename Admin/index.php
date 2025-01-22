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
        <div class="bookTitle my-3">
            <h1>Books</h1>
        </div>

        <!-- Card Row -->
        <div class="row mx-auto g-5 justify-content-start">

            <!-- Card that Add Books -->
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <a href="add.php" style="text-decoration: none;">
                    <div style="margin-top: 23px"></div>
                    <div class="card"
                        style="max-width: 100%; min-width: 100%; min-height: 250px; box-sizing: border-box;">
                        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                            <i class="fa-solid fa-plus" style="font-size: 96px;"></i> <!-- 6rem = 96px -->
                        </div>
                    </div>
                    <div class="mt-2 text-white" style="text-align: center">
                        <h3>Add Book</h3>
                    </div>
                </a>
            </div>


            <?php
            if (mysqli_num_rows($booksResult) > 0) {
                while ($bookRows = mysqli_fetch_assoc($booksResult)) { ?>

                    <!-- Book Creation -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                        <!-- Delete Book Button -->
                        <form method="POST">
                            <input type="hidden" value="<?php echo $bookRows['bookID'] ?>" name="bookID">

                            <button class="btn btn-danger" name="btnDelete" style="float: right">
                                <div class="d-flex justify-content-end mb-1" style="position: relative;">
                                    <i class="fa-solid fa-trash" style="cursor: pointer; font-size: large"></i>
                                </div>
                            </button>

                        </form>

                        <div class="card" style="max-width: 100%; min-width: 100%; min-height: 250px; box-sizing: border-box;">
                            <img src="../assets/shared/img/bookCovers/<?php echo $bookRows['bookCover'] ?>" class="card-img-top"
                                alt="Book Cover not Available" style="height: 250px; object-fit: cover;">
                        </div>

                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <h3 class="mb-0"><?php echo $bookRows['bookTitle'] ?></h3>
                        </div>
                        <h6 style="margin-top: 4px;">
                            <?php echo $bookRows['firstName'] . ' ' . $bookRows['lastName'] ?>
                        </h6>
                    </div>

                    <?php
                }
            }
            ?>

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