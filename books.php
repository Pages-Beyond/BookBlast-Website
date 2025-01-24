<?php
include("connect.php");
include("classes.php");

$books = array();
$categoryID = null;
$categoryName = "";

if (isset($_GET['category'])) {
    $categoryID = $_GET['category'];
}

if ($categoryID !== null && isset($categoryNames[$categoryID])) {
    $categoryName = $categoryNames[$categoryID];
}

$booksQuery = "SELECT 
        tbl_books.bookID, 
        tbl_books.categoryID, 
        tbl_books.bookTitle, 
        tbl_books.authorID, 
        tbl_books.bookCover,
        tbl_authors.firstName, 
        tbl_authors.lastName 
    FROM tbl_books
    INNER JOIN tbl_authors ON tbl_books.authorID = tbl_authors.authorID";

if ($categoryID !== null) {
    $booksQuery .= " WHERE tbl_books.categoryID = '$categoryID'";

    $categoryQuery = "SELECT categoryName FROM tbl_categories WHERE categoryID = '$categoryID'";
    $categoryResult = executeQuery($categoryQuery);
    $categoryRow = mysqli_fetch_assoc($categoryResult);
    $categoryName = $categoryRow['categoryName'];
}

$booksResults = executeQuery($booksQuery);

while ($bookRow = mysqli_fetch_assoc($booksResults)) {
    array_push($books, new Book(
        $bookRow['bookID'],
        $bookRow['categoryID'],
        $bookRow['bookTitle'],
        $bookRow['authorID'],
        $bookRow['bookCover'],
        $bookRow['firstName'],
        $bookRow['lastName']
    ));
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookBlast | Website</title>
    <link rel="icon" type="image/x-icon" href="assets/img/books/bookblast-logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="assets/user/css/books.css">

</head>

<body id="home">
    <nav class="navbar navbar-expand-lg shadow" style="background-color: #5E4447;">
        <div class="container-fluid">
            <!-- BookBlast Logo -->
            <a href="homepage.html" class="navbar-brand" style="padding-left: 30px;">
                <img src="assets/user/img/homepage/bookblast-logoSmall.png" alt="BookBlast Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- Navbar links -->
                    <li class="nav-item active-main-item">
                        <a class="nav-link" href="homepage.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.html">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.html#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.html#help">Help</a>
                    </li>
                    <!-- Profile Image -->
                    <a class="profile" href="userDashboard.html">
                        <img src="assets/user/img/homepage/img-profile.png" alt="Profile">
                    </a>
                </ul>

            </div>
        </div>

    </nav>

    <!-- Main Content Row -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Categories) -->
            <div class="col-12 col-md-3">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h3><strong>Books</strong></h3>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="d-flex flex-column flex-shrink-0 p-1 text-white m-0"
                    style="background-color: #5E4447; margin-left: 15px;">
                    <div class="row">
                        <div class="col">
                            <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"
                                href="#" data-bs-toggle="collapse" data-bs-target="#categoriesDropdown"
                                aria-expanded="false" aria-controls="categoriesDropdown">
                                <span class="fs-4">Categories</span>

                                <!-- Button for Expand -->
                                <div class="btn" id="btnExpand">
                                    <i class="fas fa-chevron-down" style="color: white;"></i>
                                </div>
                            </a>
                        </div>
                        <!-- Sort By button -->
                        <div class="col d-flex align-items-center justify-content-center">
                            <button type="button" class="btn mx-1"
                                style="background-color: #7D97A0; border-color: #7D97A0; color: white;" >
                                Sort
                            </button>
                            <button type="button" class="btn mx-1"
                                style="background-color: #7D97A0; border-color: #7D97A0; color: white;">
                                Order
                            </button>
                        </div>

                        <!-- <div class="col" style="background-color: red;">
                            <div class="container d-flex align-items-center justify-content-center">
                            <button type="button" class="btn"
                                style="background-color: #7D97A0; border-color: #7D97A0; color: white;">
                                Order
                            </button>
                            </div>
                        </div> -->
                    </div>
                    <hr>
                </div>


                <div class="collapse" id="categoriesDropdown">
                    <ul class="nav nav-pills flex-column mb-auto" style="padding-left: 50px;">
                        <li class="nav-item category-item">
                            <a href="books.php?category=1" class="nav-link">Fiction</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=2" class="nav-link">Non-Fiction</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=3" class="nav-link">Science and Technology</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=4" class="nav-link">Literature</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=5" class="nav-link">Children's Books</a>
                        </li>
                        <li class="nav-item category-item">
                            <a href="books.php?category=6" class="nav-link">Textbooks</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=7" class="nav-link">Arts and Music</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=8" class="nav-link">Health and Wellness</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=9" class="nav-link">Travel</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=10" class="nav-link">Business and Economics</a>
                        </li>
                        <li class="category-item">
                            <a href="books.php?category=11" class="nav-link">Philosophy and Religion</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Books -->
            <div class="col-12 col-md-9">
                <?php if ($categoryName): ?>
                <div class="container mt-4">
                    <h3 class="text-center text-uppercase" style="color: white;">
                        <?php echo $categoryName; ?>
                    </h3>
                </div>
                <?php endif; ?>

                <div class="row">
                    <?php
                    foreach ($books as $book) {
                        echo $book->buildBooks();
                    }
                    ?>
                </div>
            </div>


            <!-- JS for categories dropdown toggle -->
            <script>
                var display = "none";

                function expandContent() {
                    var navbarCollapse = document.getElementById("categoriesDropdown");
                    var expandImage = document.getElementById("expandImage");

                    if (display == "none") {
                        navbarCollapse.classList.add("show");
                        display = "block";
                        expandImage.src = "assets/collapse.png";
                    } else {
                        navbarCollapse.classList.remove("show");
                        display = "none";
                        expandImage.src = "assets/expand.png";
                    }
                }
            </script>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>

</html>