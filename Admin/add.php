<?php
include("connect.php");

$categoryFilter = '';
$authorFilter = '';
$imgNumber = '';

$categoryQuery = "SELECT * FROM tbl_categories";
$categoryResults = executeQuery($categoryQuery);

$authorQuery = "SELECT DISTINCT(CONCAT(firstName, ' ', lastName)) AS fullName, authorID FROM tbl_authors ORDER BY fullName ASC";
$authorResults = executeQuery($authorQuery);


$lastNumberQuery = "SELECT MAX(bookID + 1) AS imgNumber from tbl_books";
$lastNumberResult = executeQuery($lastNumberQuery);
while ($lastNumberRow = mysqli_fetch_assoc($lastNumberResult)) {
    $imgNumber = $lastNumberRow['imgNumber'];
}


if (isset($_POST['btnSubmit'])) {
    $bookTitle = $_POST['bookTitle'];
    $categoryID = $_POST['categoryID'];
    $yearPublished = $_POST['yearPublished'];
    $authorID = $_POST['authorID'];

    $imgFileUpload = $_FILES['imgFile']['name'];
    $imgFileUploadTMP = $_FILES['imgFile']['tmp_name'];

    //RENAME THE FILE
    $imgFileExt = substr($imgFileUpload, strripos($imgFileUpload, '.'));
    $imgNewName = "book" . "" . "$imgNumber";

    $imgNewFileName = $imgNewName . $imgFileExt;

    //SET THE LOCATION
    $imgFolder = "../assets/img/bookCovers/";

    move_uploaded_file($imgFileUploadTMP, $imgFolder . $imgNewFileName);

    $insertBook = "INSERT INTO tbl_books (bookTitle, authorID, categoryID, bookCover, datePublished) VALUES ('$bookTitle', '$authorID', ' $categoryID', '$imgNewFileName', '$yearPublished')";
    executeQuery($insertBook);
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
    <link rel="stylesheet" href="../assets/admin/css/add.css">

</head>

<body>
    <!-- Navbar -->
    <?php include("../assets/admin/shared/navbar.php"); ?>

    <!-- Sidebar -->
    <?php include("../assets/admin/shared/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-column col-10 d-flex flex-column align-items-start ps-3">
        <div class="bookTitle text-end">
            <h1 class="ms-0 my-3">Add Books Form</h1>
        </div>

        <?php include('process/addBookProcess.php') ?>

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