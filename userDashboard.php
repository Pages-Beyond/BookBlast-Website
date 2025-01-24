<?php

include('connect.php');

session_start();

// Fetch user information from the session
$userID = $_SESSION['usersID'] ?? '1';  // Default to '1' for testing if session value is missing

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
        // Remove from transactions table where isApproved = 'till'
        removeItemFromTable('tbl_transactions', 'transactionID', $transactionID, "AND isApproved = 'till'");
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
                tbl_books.bookTitle,  tbl_books.bookCover,
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
$pendingResult = getBooks($userID, "AND tbl_transactions.isApproved = 'till' AND tbl_transactions.isDeclined = 'no'");
$declinedResult = getBooks($userID, "AND tbl_transactions.isApproved = 'no' AND tbl_transactions.isDeclined = 'yes'");

$wishListQuery = "SELECT 
    tbl_books.bookTitle, 
    CONCAT(tbl_authors.firstName, ' ', tbl_authors.lastName) AS AuthorsName, tbl_wishlist.wishListID
FROM 
    tbl_wishlist
INNER JOIN 
    tbl_books ON tbl_books.bookID = tbl_wishlist.bookID
INNER JOIN 
    tbl_authors ON tbl_authors.authorID = tbl_books.authorID WHERE userID = $userID";

$wishListResult = executeQuery($wishListQuery);

$favoriteQuery = "SELECT 
    tbl_books.bookTitle, 
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
    <link rel="icon" type="image/x-icon" href="assets/img/userDashboard/bookblast-logo.png" />
    <link rel="stylesheet" href="assets/css/user-profile.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/userDashboard/kween.png" alt="User" class="navbar-brand-img">
                <span class="navbar-brand-text">User Name</span>
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
                        <li class="nav-item"><a class="nav-link" href="userDashboard.html" id="navbar-wishlists">User</a></li>
                        <li class="nav-item"><a class="nav-link" href="profile.html" id="navbar-books">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="homepage.html" id="navbar-favorites">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="loginPage.html" id="navbar-wishlists">Log-out</a></li>
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
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="#" id="books-link"><span class="d-none d-md-inline">Books</span><i class="fas fa-book d-md-none"></i></a></li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="#" id="favorites-link"><span class="d-none d-md-inline">Favorites</span><i class="fas fa-heart d-md-none"></i></a></li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="#" id="wishlists-link"><span class="d-none d-md-inline">Wishlists</span><i class="fas fa-bookmark d-md-none"></i></a></li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="#" id="transactions-link"><span class="d-none d-md-inline">Transactions</span><i class="fas fa-bookmark d-md-none"></i></a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="main-content col-10 d-flex flex-column align-items-start">
                <a href="UserDashboard-Bookview.html" style="text-decoration: none; color: white;">
                    <!-- Books Section -->
                    <div class="book-section" id="book-section">
    <h1>Books</h1>
    
    <!-- Reading Now Section -->
    <div class="reading-now-section mb-4">
        <h3 class="reading-now-title mb-3" style="font-size: 1rem; padding: 4px 10px;">Reading Now</h3>
        <div class="row g-4">
            <?php if (mysqli_num_rows($readingResult) > 0) {
                while ($readingRow = mysqli_fetch_assoc($readingResult)) {
            ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card" style="max-width: 100%; min-width: 100%; min-height: 250px; box-sizing: border-box;">
                        <img src="assets/img/userDashboard/<?php echo $readingRow['bookCover']; ?>" class="card-img-top" alt="Dashboard Image" style="height: 160px; object-fit: cover;">
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $readingRow['bookTitle']; ?></h5>
                    </div>
                    <h6 style="margin-top: 4px;"><?php echo $readingRow['AuthorsName']; ?></h6>
                </div>
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
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card" style="max-width: 100%; min-width: 100%; display: flex; flex-direction: column; height: 100%; box-sizing: border-box;">
                        <div style="height: 160px; overflow: hidden;">
                            <img src="assets/img/userDashboard/peterpan.png" class="card-img-top" alt="Dashboard Image" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate mb-2" style="font-size: 1rem;"><?php echo $doneRow['bookTitle']; ?></h5>
                            <p class="card-text text-nowrap" style="font-size: 0.875rem;"><?php echo $doneRow['AuthorsName']; ?></p>
                        </div>
                    </div>
                </div>
            <?php
                }
            } ?>
        </div>
    </div>

</div>

                </a>

                <!-- Favorites Section -->
                <div class="favorites-section" id="favorites-section" style="display: none;">
                    <h1>Favorites</h1>
                    <div class="row g-4" id="favorites-list">
                        <?php if (mysqli_num_rows($favoriteResult) > 0) {
                            while ($favoritesRow = mysqli_fetch_assoc($favoriteResult)) {
                        ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                    <div class="card" style="max-width: 100%; min-width: 100%; min-height: 250px; box-sizing: border-box;">
                                        <img src="assets/img/userDashboard/peterpan.png" class="card-img-top" alt="Dashboard Image" style="height: 160px; object-fit: cover;">
                                    </div>
                                    <div class="mt-2 d-flex justify-content-between align-items-center">
                                        <h3 class="mb-0"><?php echo $favoritesRow['bookTitle']; ?></h3>
                                    </div>
                                    <form method="post" action="userDashboard.php" id="removefavoriteForm">
                                        <input type="hidden" name="favoriteID" value="<?php echo $favoritesRow['favoriteID']; ?>">
                                        <button type="submit" name="favoriteRemove" class="btn btn-danger" style="float: right; position: relative;">
                                            <div class="d-flex justify-content-end mb-1">
                                                <i class="fas fa-heart" style="cursor: pointer; font-size: large;"></i>
                                            </div>
                                        </button>
                                    </form>
                                    <h6 style="margin-top: 4px;"><?php echo $favoritesRow['AuthorsName']; ?></h6>
                                </div>
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
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                    <div class="card" style="max-width: 100%; min-width: 100%; min-height: 250px; box-sizing: border-box;">
                                        <img src="assets/img/userDashboard/peterpan.png" class="card-img-top" alt="Dashboard Image" style="height: 160px; object-fit: cover;">
                                    </div>
                                    <div class="mt-2 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="mb-0"><?php echo $wishListRow['bookTitle']; ?></h3>
                                            <h6 style="margin-top: 4px;"><?php echo $wishListRow['AuthorsName']; ?></h6>
                                        </div>
                                        <form method="post" action="userDashboard.php" id="removeWishlistForm" style="padding: 0; margin: 0;">
                                            <input type="hidden" name="wishListID" value="<?php echo $wishListRow['wishListID']; ?>">
                                            <button type="submit" name="wishListRemove" class="btn btn-outline-primary bookmark-btn" style="border: none; padding: 0;">
                                                <i class="fas fa-bookmark" style="cursor: pointer; font-size: large;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>

   <!-- Transactions Section -->
<div class="transactions-section" id="transactions-section">
    <h1>Transactions</h1>

   <!-- Pending Section -->
   <div class="pending-now-section mb-4">
        <h3 class="pending-now-title mb-3" style="font-size: 1rem; padding: 4px 10px;">Pending</h3>
        <div class="row g-4">
            <?php if (mysqli_num_rows($pendingResult) > 0) {
                while ($pendingRow = mysqli_fetch_assoc($pendingResult)) {
            ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card" style="max-width: 100%; min-width: 100%; min-height: 250px; box-sizing: border-box;">
                        <img src="assets/img/userDashboard/peterpan.png" class="card-img-top" alt="Dashboard Image" style="height: 160px; object-fit: cover;">
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $pendingRow['bookTitle']; ?></h5>
                        <form method="post" action="userDashboard.php" id="removePendingForm" class="ms-2">
                            <input type="hidden" name="transactionID" value="<?php echo $pendingRow['transactionID']; ?>">
                            <button type="submit" name="pendingRemove" class="btn btn-danger btn-sm">
                                <i class="fas fa-times" style="font-size: 1rem;"></i>
                            </button>
                        </form>
                    </div>
                    <h6 style="margin-top: 4px;"><?php echo $pendingRow['AuthorsName']; ?></h6>
                </div>
            <?php
                }
            } ?>
        </div>
    </div>

    <!-- Decline Section -->
    <div class="done-section mb-4">
        <h3 class="done-title mb-3" style="font-size: 1rem; padding: 4px 10px;">Decline</h3>
        <div class="row g-4">
            <?php if (mysqli_num_rows($declinedResult) > 0) {
                while ($declinedRow = mysqli_fetch_assoc($declinedResult)) {
            ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                        <div class="card" style="max-width: 100%; min-width: 100%; min-height: 250px; box-sizing: border-box;">
                            <img src="assets/img/userDashboard/peterpan.png" class="card-img-top" alt="Dashboard Image" style="height: 160px; object-fit: cover;">
                        </div>
                        <div class="mt-2">
                            <h5 class="mb-0"><?php echo $declinedRow['bookTitle']; ?></h5>
                            <h6 class="text-nowrap"><?php echo $declinedRow['AuthorsName']; ?></h6>
                        </div>
                    </div>
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
            link.addEventListener('click', function() {
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