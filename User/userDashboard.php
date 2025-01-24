<?php

include('../shared/connect.php');

session_start();

// Fetch user information from the session
$userID = $_SESSION['userID'];  // Default to '1' for testing if session value is missing
$userPic = $_SESSION['userPic'];

$getUserNameQuery = "SELECT tbl_userInfo.firstName,  tbl_userInfo.lastName FROM `tbl_users` LEFT JOIN tbl_userinfo on tbl_users.userID = tbl_userinfo.userID WHERE tbl_users.userID = $userID";
$userNameResult = executeQuery($getUserNameQuery);

while ($userPicRows = mysqli_fetch_assoc($userNameResult)) {
    $userName = $userPicRows['firstName'] . " " . $userPicRows['lastName'];


}
// General function to execute delete query
function removeItemFromTable($table, $idColumn, $idValue, $additionalConditions = "")
{
    $query = "DELETE FROM $table WHERE $idColumn = '$idValue' $additionalConditions";
    return executeQuery($query);
}

// Handle item removals based on POST requests
if (isset($_POST['pendingRemove'])) {
    $transactionID = $_POST['transactionID'];
    if (!empty($transactionID)) {
        // Remove from transactions table where isApproved = 'pending'
        removeItemFromTable('tbl_transactions', 'transactionID', $transactionID, "AND isApproved = 'pending'");
        header('Location: userDashboard.php');
        exit;
    }
}

if (isset($_POST['wishListRemove'])) {
    $wishlistID = $_POST['wishListID'];
    if (!empty($wishlistID)) {
        // Remove from wishlist
        removeItemFromTable('tbl_wishlist', 'wishListID', $wishlistID);
        header('Location: userDashboard.php');
        exit;
    }
}

if (isset($_POST['favoriteRemove'])) {
    $favoriteID = $_POST['favoriteID'];
    if (!empty($favoriteID)) {
        // Remove from favorites
        removeItemFromTable('tbl_favorites', 'favoriteID', $favoriteID);
        header('Location: userDashboard.php');
        exit;
    }
}


function getBooks($userID, $additionalConditions = "")
{
    $query = "SELECT 
                tbl_books.bookTitle, tbl_books.bookID,  tbl_books.bookCover,
                CONCAT(tbl_authors.firstName, ' ', tbl_authors.lastName) AS AuthorsName, 
                tbl_transactions.transactionID
              FROM 
                tbl_transactions
              INNER JOIN 
                tbl_books ON tbl_books.bookID = tbl_transactions.bookID
              INNER JOIN 
                tbl_authors ON tbl_authors.authorID = tbl_books.authorID 
              WHERE 
                tbl_transactions.userID = '$userID' $additionalConditions";

    return executeQuery($query);
}

// Fetch different book statuses
$readingResult = getBooks($userID, "AND tbl_transactions.status = 'reading'");
$doneResult = getBooks($userID, "AND tbl_transactions.status = 'done'");
$pendingResult = getBooks($userID, "AND tbl_transactions.isApproved = 'pending' AND tbl_transactions.isDeclined = 'no'");
$declinedResult = getBooks($userID, "AND tbl_transactions.isApproved = 'no' AND tbl_transactions.isDeclined = 'yes'");

$wishListQuery = "SELECT 
    tbl_books.bookTitle,tbl_books.bookCover,tbl_books.bookID,
    CONCAT(tbl_authors.firstName, ' ', tbl_authors.lastName) AS AuthorsName, tbl_wishlist.wishListID
FROM 
    tbl_wishlist
INNER JOIN 
    tbl_books ON tbl_books.bookID = tbl_wishlist.bookID
INNER JOIN 
    tbl_authors ON tbl_authors.authorID = tbl_books.authorID WHERE userID = $userID";

$wishListResult = executeQuery($wishListQuery);

$favoriteQuery = "SELECT 
    tbl_books.bookTitle,tbl_books.bookCover, tbl_books.bookID,
    CONCAT(tbl_authors.firstName, ' ', tbl_authors.lastName) AS AuthorsName, tbl_favorites.favoriteID
FROM 
    tbl_favorites
INNER JOIN 
    tbl_books ON tbl_books.bookID = tbl_favorites.bookID
INNER JOIN 
    tbl_authors ON tbl_authors.authorID = tbl_books.authorID WHERE userID = $userID";

$favoriteResult = executeQuery($favoriteQuery);

?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/user/img/userDashboard/bookblast-logo.png" />
    <link rel="stylesheet" href="../assets/user/css/user-profile.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../assets/shared/img/userpfp/<?php echo $userPic ?>" alt="User" class="navbar-brand-img">
                <span class="navbar-brand-text"><?php echo $userName ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
                <button type="button" class="btn-close text-reset position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
                <div class="offcanvas-body">
                    <h5 class="text-white fw-bold mb-4 m-0" style="font-size: 2rem;">Menu</h5>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="userDashboard.php" id="navbar-wishlists">User</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="User/profile.php" id="navbar-books">Profile</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../" id="navbar-favorites">Home</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../Login/login.php"
                                id="navbar-wishlists">Log-out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="container-fluid">
        <div class="row d-flex flex-nowrap">
            <!-- Sidebar -->
            <div class="sidebar col-2 d-flex flex-column p-2 text-white m-0" style="height: 50vh;">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="#" id="books-link"><span
                                class="d-none d-md-inline">Books</span><i class="fas fa-book d-md-none"></i></a></li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="#" id="favorites-link"><span
                                class="d-none d-md-inline">Favorites</span><i class="fas fa-heart d-md-none"></i></a>
                    </li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="#" id="wishlists-link"><span
                                class="d-none d-md-inline">Wishlists</span><i class="fas fa-bookmark d-md-none"></i></a>
                    </li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="#" id="transactions-link"><span
                                class="d-none d-md-inline">History</span><i class="fas fa-bookmark d-md-none"></i></a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="main-content col-10 align-items-start">

                <!-- Books Section -->
                <div class="book-section" id="book-section">

                    <h1>Books</h1>

                    <!-- Reading Now Section -->
                    <div class="reading-now-section mb-4">
                        <h3 class="reading-now-title mb-3" style="font-size: 1rem; padding: 4px 10px;">Reading Now
                        </h3>
                        <div class="row">
                            <?php if (mysqli_num_rows($readingResult) > 0) {
                                while ($readingRow = mysqli_fetch_assoc($readingResult)) {
                                    ?>
                                    <a href="userDashboard-BookView.php?bookID=<?php echo $readingRow['bookID'] ?>"
                                        style="text-decoration: none; color: inherit;">


                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-0">
                                            <div class="card" style="max-width: 14rem; min-width: 12rem; margin-bottom: 1rem;">
                                                <img src="../assets/shared/img/bookCovers/<?php echo $readingRow['bookCover'] ?>"
                                                    class="card-img-top" alt="Dashboard Image"
                                                    style="height: 160px; object-fit: cover;">
                                            </div>
                                            <div class="mt-2" style="max-width: 14rem;">
                                                <h2 class="mb-0 me-2" style="font-size: 1.25rem;">
                                                    <?php echo $readingRow['bookTitle']; ?>
                                                </h2>

                                                <h5 class="text-wrap" style="font-size: 1rem;">
                                                    <?php echo $readingRow['AuthorsName']; ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>

                    <!-- Done Section -->
                    <div class="done-section mb-4">
                        <h3 class="done-title mb-3" style="font-size: 1rem; padding: 4px 10px;">Done</h3>
                        <div class="row g-4">
                            <?php if (mysqli_num_rows($doneResult) > 0) {
                                while ($doneRow = mysqli_fetch_assoc($doneResult)) {
                                    ?>

                                    <a href="bookView.php?bookID=<?php echo $doneRow['bookID'] ?>"
                                        style="text-decoration: none; color: inherit;">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-0">
                                            <div class="card" style="max-width: 14rem; min-width: 12rem; margin-bottom: 1rem;">
                                                <img src="../assets/shared/img/bookCovers/<?php echo $doneRow['bookCover'] ?>"
                                                    class="card-img-top" alt="Dashboard Image"
                                                    style="height: 160px; object-fit: cover;">
                                            </div>
                                            <div class="mt-2" style="max-width: 14rem;">
                                                <h2 class="mb-0 me-2" style="font-size: 1.25rem;">
                                                    <?php echo $doneRow['bookTitle']; ?>
                                                </h2>

                                                <h5 class="text-wrap" style="font-size: 1rem;">
                                                    <?php echo $doneRow['AuthorsName']; ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>

                </div>



                <!-- Favorites Section -->
                <div class="favorites-section" id="favorites-section" style="display: none;">
                    <h1>Favorites</h1>
                    <div class="row g-4" id="favorites-list">
                        <?php if (mysqli_num_rows($favoriteResult) > 0) {
                            while ($favoritesRow = mysqli_fetch_assoc($favoriteResult)) {
                                ?>
                                <a href="userDashboard-BookView.php?bookID=<?php echo $favoritesRow['bookID'] ?>"
                                    style="text-decoration: none; color: inherit;">

                                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-0">
                                        <div class="card" style="max-width: 14rem; min-width: 12rem; margin-bottom: 1rem;">
                                            <img src="../assets/shared/img/bookCovers/<?php echo $favoritesRow['bookCover']; ?>"
                                                class="card-img-top" alt="Dashboard Image"
                                                style="height: 160px; object-fit: cover;">
                                        </div>
                                        <div class="mt-2" style="max-width: 14rem;">
                                            <h2 class="mb-0 me-2" style="font-size: 1.25rem;">
                                                <?php echo $favoritesRow['bookTitle']; ?>
                                            </h2>
                                            <form method="post" action="userDashboard.php" id="removefavoriteForm">
                                                <input type="hidden" name="favoriteID"
                                                    value="<?php echo $favoritesRow['favoriteID']; ?>">
                                                <button type="submit" name="favoriteRemove" class="btn btn-danger"
                                                    style="float: right; position: relative;">
                                                    <div class="d-flex justify-content-end mb-1">
                                                        <i class="fas fa-heart" style="cursor: pointer; font-size: large;"></i>
                                                    </div>
                                                </button>
                                            </form>

                                            <h5 class="text-wrap" style="font-size: 1rem;">
                                                <?php echo $favoritesRow['AuthorsName']; ?>
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            <?php }
                        } ?>
                    </div>
                </div>

                <!-- Wishlists Section -->
                <div class="wishlists-section" id="wishlists-section" style="display: none;">
                    <h1>Wishlists</h1>
                    <div class="row g-4" id="wishlists-list">
                        <?php if (mysqli_num_rows($wishListResult) > 0) {
                            while ($wishListRow = mysqli_fetch_assoc($wishListResult)) {
                                ?>
                                <a href="bookView.php?bookID=<?php echo $wishListRow['bookID'] ?>"
                                    style="text-decoration: none; color: inherit;">

                                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-0">
                                        <div class="card" style="max-width: 14rem; min-width: 12rem; margin-bottom: 1rem;">
                                            <img src="../assets/shared/img/bookCovers/<?php echo $wishListRow['bookCover']; ?>"
                                                class="card-img-top" alt="Dashboard Image"
                                                style="height: 160px; object-fit: cover;">
                                        </div>
                                        <div class="mt-2" style="max-width: 14rem;">
                                            <h2 class="mb-0 me-2" style="font-size: 1.25rem;">
                                                <?php echo $wishListRow['bookTitle']; ?>
                                            </h2>
                                            <form method="post" action="userDashboard.php" id="removeWishlistForm">
                                                <input type="hidden" name="wishListID"
                                                    value="<?php echo $wishListRow['wishListID']; ?>">
                                                <button type="submit" name="wishListRemove" class="btn btn-primary"
                                                    style="float: right; position: relative;">
                                                    <div class="d-flex justify-content-end mb-1">
                                                        <i class="fas fa-bookmark"
                                                            style="cursor: pointer; font-size: large;"></i>
                                                    </div>
                                                </button>
                                            </form>

                                            <h5 class="text-wrap" style="font-size: 1rem;">
                                                <?php echo $wishListRow['AuthorsName']; ?>
                                            </h5>
                                        </div>
                                    </div>

                                </a>
                            <?php }
                        } ?>
                    </div>
                </div>

                <!-- Transactions Section -->
                <div class="transactions-section" id="transactions-section" style="display: none;">
                    <h1>History</h1>

                    <!-- Pending Section -->
                    <div class="pending-now-section mb-4">
                        <h3 class="reading-now-title mb-3" style="font-size: 1rem; padding: 4px 10px;">Pending</h3>
                        <div class="row g-2">
                            <?php if (mysqli_num_rows($pendingResult) > 0) {
                                while ($pendingRow = mysqli_fetch_assoc($pendingResult)) {
                                    ?>
                                    <a href="bookView.php?bookID=<?php echo $pendingRow['bookID'] ?>"
                                        style="text-decoration: none; color: inherit;">

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-0">
                                            <div class="card" style="max-width: 14rem; min-width: 12rem; margin-bottom: 1rem;">
                                                <img src="../assets/shared/img/bookCovers/<?php echo $pendingRow['bookCover'] ?>"
                                                    class="card-img-top" alt="Dashboard Image"
                                                    style="height: 160px; object-fit: cover;">
                                            </div>
                                            <div class="mt-2" style="max-width: 14rem;">
                                                <h2 class="mb-0 me-2" style="font-size: 1.25rem;">
                                                    <?php echo $pendingRow['bookTitle']; ?>
                                                </h2>

                                                <h5 class="text-wrap" style="font-size: 1rem;">
                                                    <?php echo $pendingRow['AuthorsName']; ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>

                    <!-- Decline Section -->
                    <div class="done-section mb-4">
                        <h3 class="done-title mb-3" style="font-size: 1rem; padding: 4px 10px;">Declined</h3>
                        <div class="row g-4">
                            <?php if (mysqli_num_rows($declinedResult) > 0) {
                                while ($declinedRow = mysqli_fetch_assoc($declinedResult)) {
                                    ?>
                                    <a href="bookView.php?bookID=<?php echo $declinedRow['bookID'] ?>"
                                        style="text-decoration: none; color: inherit;">

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-0">
                                            <div class="card" style="max-width: 14rem; min-width: 12rem; margin-bottom: 1rem;">
                                                <img src="../assets/shared/img/bookCovers/<?php echo $declinedRow['bookCover'] ?>"
                                                    class="card-img-top" alt="Dashboard Image"
                                                    style="height: 160px; object-fit: cover;">
                                            </div>
                                            <div class="mt-2" style="max-width: 14rem;">
                                                <h2 class="mb-0 me-2" style="font-size: 1.25rem;">
                                                    <?php echo $declinedRow['bookTitle']; ?>
                                                </h2>

                                                <h5 class="text-wrap" style="font-size: 1rem;">
                                                    <?php echo $declinedRow['AuthorsName']; ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>
                </div>

            </div> <!-- End of Main Content -->

        </div>
    </div> <!-- End of Container Fluid -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to toggle heart icon and remove from favorites
        function toggleFavorite(button) {
            const card = button.closest('.favorite-card');
            const heartIcon = button.querySelector('i');

            // Toggle the heart icon (filled/empty)
            heartIcon.classList.toggle('fas');
            heartIcon.classList.toggle('far');

            // If unhearted (empty heart), remove the card from favorites
            if (heartIcon.classList.contains('far')) {
                card.remove();
            }
        }

        // Function to toggle wishlist state and remove item if unfilled
        function toggleWishlist(button) {
            const icon = button.querySelector('i');
            const card = button.closest('.wishlist-card');

            if (icon.classList.contains('fas')) {
                // Change to unfilled icon
                icon.classList.remove('fas');
                icon.classList.add('far');

                // Remove the card from the wishlist
                card.remove();
            } else {
                // Change to filled icon
                icon.classList.remove('far');
                icon.classList.add('fas');

                // Optionally, you can add code here to move the item back to the wishlist if needed
            }
        }

        // Select all sidebar links
        const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');

        // Function to handle the active state on click
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function () {
                // Remove 'active' class from all sidebar links
                sidebarLinks.forEach(link => link.classList.remove('active'));

                // Add 'active' class to the clicked link
                this.classList.add('active');

                // Show the corresponding section
                const sectionId = this.id.replace('-link', '-section');
                document.querySelectorAll('.book-section, .favorites-section, .wishlists-section, .transactions-section').forEach(section => {
                    section.style.display = 'none';
                });
                document.getElementById(sectionId).style.display = 'block';
            });
        });

        // Automatically highlight the first link ('Books') as active when the page loads
        document.getElementById('books-link').classList.add('active');
        document.getElementById('book-section').style.display = 'block';


        // Get all the sidebar links
        const bookLink = document.getElementById('books-link');
        const userLink = document.getElementById('favorites-link');
        const requestLink = document.getElementById('wishlists-link');
        const transactionLink = document.getElementById('transactions-link');

        // Get the content sections
        const bookSection = document.getElementById('book-section');
        const favoritesSection = document.getElementById('favorites-section');
        const wishlistsSection = document.getElementById('wishlists-section');
        const transactionsSection = document.getElementById('transactions-section');

        // Function to hide all sections
        function hideAllSections() {
            bookSection.style.display = 'none';
            favoritesSection.style.display = 'none';
            wishlistsSection.style.display = 'none';
        }

        // Add click event listeners to each link
        bookLink.addEventListener('click', () => {
            hideAllSections();
            bookSection.style.display = 'block';
        });

        userLink.addEventListener('click', () => {
            hideAllSections();
            favoritesSection.style.display = 'block';
        });

        requestLink.addEventListener('click', () => {
            hideAllSections();
            wishlistsSection.style.display = 'block';
        });

        transactionLink.addEventListener('click', () => {
            hideAllSections();
            transactionsSection.style.display = 'block';
        });

        // Show the default section (Books)
        hideAllSections();
        bookSection.style.display = 'block';
    </script>
</body>

</html>