
<?php


include('../shared/connect.php');

session_start();

if(isset($_SESSION['rating'])){
    $rating = $_SESSION['rating'];
}else {
    $rating = 0;
}

$userID = $_SESSION['userID'];
$userPic = $_SESSION['userPic'];

$disabled = '';
$review = '';


$getUserNameQuery = "SELECT tbl_userInfo.firstName,  tbl_userInfo.lastName FROM `tbl_users` LEFT JOIN tbl_userinfo on tbl_users.userID = tbl_userinfo.userID WHERE tbl_users.userID = $userID";
$userNameResult = executeQuery($getUserNameQuery);

while ($userPicRows = mysqli_fetch_assoc($userNameResult)) {
    $userName = $userPicRows['firstName'] . " " . $userPicRows['lastName'];


}

if (isset($_GET['bookID']) && $_GET['bookID'] != '') {
    $bookID = $_GET['bookID'];

} else {
    header('location: userDashboard.php');

}

if ($bookID != '') {
    $getBookDataQuery = "SELECT * from tbl_Books 
    LEFT JOIN tbl_authors ON tbl_books.authorID = tbl_authors.authorID 
    WHERE tbl_books.bookID = '$bookID';";

    $getBookRatingQuery = "SELECT ROUND(AVG(userRating),1) as bookRating from tbl_reviews WHERE bookID = '$bookID';";

    $bookDataResult = executeQuery($getBookDataQuery);

    while ($bookDataRow = mysqli_fetch_assoc($bookDataResult)) {
        $bookTitle = $bookDataRow['bookTitle'];
        $bookAuthor = $bookDataRow['firstName'] . " " . $bookDataRow['lastName'];
        $bookCover = $bookDataRow['bookCover'];
        $bookStock = $bookDataRow['stocks'];

    }





}



if (isset($_POST['btnDone'])) {
    $updateTransactionQuery = "UPDATE `tbl_transactions` SET `status`='done',`dateReturned`= CURRENT_TIMESTAMP() WHERE userID = $userID AND bookID = $bookID";
    executeQuery($updateTransactionQuery);

    $updateBookStocksQuery = "UPDATE `tbl_books` SET `stocks`='$bookStock'+1 WHERE bookID = $bookID";
    executeQuery($updateBookStocksQuery);



}






$getUserTransactionQuery = "SELECT tbl_transactions.datetoReturn, tbl_transactions.status FROM `tbl_transactions` LEFT JOIN tbl_users ON tbl_transactions.userID = tbl_users.userID LEFT JOIN tbl_books ON tbl_transactions.bookID = tbl_books.bookID WHERE tbl_transactions.userID = '$userID' AND tbl_transactions.bookID='$bookID';";
$userTransactionResult = executeQuery($getUserTransactionQuery);

while ($row = mysqli_fetch_assoc($userTransactionResult)) {
    $datetoReturn = $row['datetoReturn'];
    $status = $row['status'];

    $readStatus = ($status == 'reading') ? 'Reading Now' : 'Done';

}

if ($status == 'done') {
    $disabled = 'disabled';
    $review = 'open';
}

$getUserFavoriteQuery = "SELECT `bookID`, `userID` FROM `tbl_favorites` WHERE userID = '$userID' and bookID = '$bookID'";
$userFavoriteResult = executeQuery($getUserFavoriteQuery);

$favorite = (mysqli_num_rows($userFavoriteResult) > 0) ? 'checked' : '';


$getUserWishlistQuery = "SELECT `bookID`, `userID` FROM `tbl_wishlist` WHERE userID = '$userID' and bookID = '$bookID'";
$userWishlistResult = executeQuery($getUserWishlistQuery);

$wishlist = (mysqli_num_rows($userWishlistResult) > 0) ? 'checked' : '';



if(isset($_POST['btnSubmitReview'])){
    $userReview = $_POST['review'];
    $userReview = str_replace('\'', '', $userReview);


    $insertUserReviewQuery = "INSERT INTO `tbl_reviews`(`userID`, `bookID`, `userReview`, `userRating`) VALUES ('$userID','$bookID','$userReview','$rating');";
    executeQuery( $insertUserReviewQuery);
    
}

$getReviewQuery ="SELECT `reviewID` FROM `tbl_reviews` WHERE userID = '$userID' AND bookID='$bookID';";
$reviewQuery = executeQuery($getReviewQuery);

if (mysqli_num_rows($reviewQuery) > 0){
   $review = 'close';
}

?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../assets/user/img/homepage/bookblast-logo.png" />
    <link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="../assets/pictures/bookblast-logo.png" type="image/png">
    <style>
        body {
            background-color: #5E4447;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .navbar,
        .offcanvas {
            background-color: #5E4447;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }

        .navbar-brand-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .navbar-nav .nav-link {
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #cec39e !important;
        }

        .navbar-brand-text {
            font-size: 1.8rem;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='white' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .navbar-collapse {
            justify-content: flex-end;
        }

        .nav-item .nav-link {
            font-size: 20px;
            color: white;
        }

        h1,
        h2 {
            margin-bottom: 1px;
        }

        h1 {
            font-size: 3rem;
        }

        h3 {
            font-size: 1.5rem;
        }

        h4 {
            font-size: 1rem;
            background-color: #BAAA74;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        h5 {
            font-size: 0.7rem;
        }

        .reading-now-btn,
        .done-btn {
            display: inline-block;
            background-color: #b26424;
            color: white;
            border: none;
            padding: 4px 10px;
            border-radius: 20px;
            cursor: pointer;
        }

        .reading-now-btn:hover {
            background-color: #b47643;
        }

        .done-btn {
            background-color: #5a6268;
        }

        .done-btn:hover {
            background-color: #7d97a0;
        }

        @media (max-width: 991px) {
            .navbar-brand-img {
                width: 30px;
                height: 30px;
            }

            .navbar-nav .nav-link {
                font-size: 18px;
            }

            .navbar-brand-text {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand-text {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar .nav-link {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .card .mt-2 h2 {
                font-size: 1.5rem;
            }
        }

        .navbar-nav .nav-link.active-link,
        .sidebar .nav-link.active-link {
            background-color: #BAAA74;
            border-radius: 10px;
            color: white;
            padding: 5px 15px;
        }

        .book-section,
        .favorites-section,
        .wishlists-section {
            margin-right: 5rem;
        }

        .favorite-card,
        .book-card {
            margin-right: 3rem;
        }

        .sidebar .nav-link {
            border-radius: 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: #cec39e;
            color: white;
        }

        .sidebar .nav-link.active {
            background-color: #BAAA74;
            color: white;
        }

        .checked {
            color: yellow;
        }

        .heart-checkbox,
        .wishlist-checkbox {
            display: none;
        }

        .heart {
            font-size: 30px;
            cursor: pointer;
            color: #d5d5d5;
        }

        .wishlist {
            font-size: 20px;
            cursor: pointer;
            color: #d5d5d5;
        }

        .heart-checkbox:checked+.heart {
            color: red;
        }

        .wishlist-checkbox:checked+.wishlist {
            color: #a2b1d8;
        }

        .icons-wrapper {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        @media (max-width: 1050px) {
            .title-container {
                padding-left: 2.5rem;
            }

            .back-arrow i {
                font-size: 1.5rem !important;
            }

            .title-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .title-content h2 {
                font-size: 2.5rem !important;
            }

            .icons-wrapper {
                margin-top: 0.5rem;
                margin-left: 0;
            }

            .author-section {
                margin-top: 1rem;
                padding-left: 2.5rem;
            }
        }
    </style>
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

    <!-- Sidebar navigation -->
    <div class="container-fluid">
        <div class="row d-flex flex-nowrap">
            <!-- Sidebar -->
            <div class="sidebar col-2 d-flex flex-column p-2 text-white m-0" style="height: 50vh;">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="userDashboard.php"
                            id="books-link"><span class="d-none d-md-inline">Books</span><i
                                class="fas fa-book d-md-none"></i></a></li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="userDashboard.php"
                            id="favorites-link"><span class="d-none d-md-inline">Favorites</span><i
                                class="fas fa-heart d-md-none"></i></a>
                    </li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="userDashboard.php"
                            id="wishlists-link"><span class="d-none d-md-inline">Wishlists</span><i
                                class="fas fa-bookmark d-md-none"></i></a>
                    </li>
                    <li class="nav-item"><a class="nav-link mb-4 text-white" href="userDashboard.php"
                            id="transactions-link"><span class="d-none d-md-inline">History</span><i
                                class="fas fa-bookmark d-md-none"></i></a>
                    </li>
                </ul>
            </div>


            <!-- Main content section -->
            <div class="main-content col-10 d-flex flex-column align-items-start">
                <div class="d-flex justify-content-between align-items-center mb-2" style="gap: 15px;">
                    <h1><?php echo $bookTitle ?></h1>
                    <div class="icons-wrapper" style="gap: 10px;">
                        <input type="checkbox" class="heart-checkbox" id="heart-checkbox"
                            onchange="handleFavorite(this)" <?php echo $favorite ?>>
                        <label for="heart-checkbox" class="heart">❤</label>
                        <input type="checkbox" class="wishlist-checkbox" id="wishlist-checkbox"
                            onchange="handleWishlist(this)" <?php echo $wishlist ?>>
                        <label for="wishlist-checkbox" class="wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-bookmark-star-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z" />
                            </svg>
                        </label>
                    </div>
                </div>
                <h3><?php echo $bookAuthor ?></h3>
                <h4><?php echo $readStatus ?></h4>
                <h5>Due: <?php echo $datetoReturn ?></h5>

                <!-- Book image and review section -->


                <div class="container">
                    <div class="row">
                        <div class="col-md-6" style="margin-left: -15px;">
                            <div class="card" style="background-color: transparent; border: none; line-height: 0.1;">
                                <div class="image-box"
                                    style="width: 100%; height: 400px; border: 2px solid #EADCAE; display: flex; align-items: center; justify-content: center; margin: auto; background-color: #EADCAE; border-radius: 5px;">
                                    <img src="../assets/shared/img/bookCovers/<?php echo $bookCover ?>" alt="Book Image"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                            </div>
                        </div>

                        <!-- Review and rating -->
                        <div class="col-md-6 mt-3">
                            <h3>Status</h3>
                            <form method="POST">
                                <button class="btn reading-now-btn mb-3 rounded-pill" type=submit name="btnDone"
                                    style="cursor: pointer;" <?php echo $disabled ?>>Done</button>
                            </form>

                            <?php
                            if ($review == 'open') {

                            
                                ?>

                                <!-- Star ratings -->
                                <div class="mb-2">
                                    <span class="fa fa-star" data-value="1" onclick="toggleStar(this)"></span>
                                    <span class="fa fa-star" data-value="2" onclick="toggleStar(this)"></span>
                                    <span class="fa fa-star" data-value="3" onclick="toggleStar(this)"></span>
                                    <span class="fa fa-star" data-value="4" onclick="toggleStar(this)"></span>
                                    <span class="fa fa-star" data-value="5" onclick="toggleStar(this)"></span>
                                </div>
                                <script>
                                    function toggleStar(star) {
                                        const selectedValue = parseInt(star.getAttribute('data-value')); 
                                        const stars = document.querySelectorAll('.fa-star');

                                       
                                        stars.forEach(s => {
                                            const value = parseInt(s.getAttribute('data-value'));
                                            s.style.color = value <= selectedValue ? 'gold' : '#ccc'; 
                                        });


                                       
                                        const formData = new FormData();
                                        formData.append('rating', selectedValue);

                                   
                                        fetch('process_rating.php', {
                                            method: 'POST',
                                            body: formData,
                                        })
                                            .then(response => response.text())
                                            .then(data => {
                                                console.log(data); 
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                            });
                                    }
                                </script>
                                <form method="POST" class="mt-4">
                                    <div class="mb-1">
                                        <textarea class="form-control" id="statusNote" name="review" rows="3"
                                            placeholder="Write your review here..."></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="submit" name="btnSubmitReview" class="btn btn-primary rounded-pill"
                                            style="background-color: #a89450; border: none; padding: 4px 10px; font-size: 1rem;">Submit
                                            and Return</button>
                                    </div>
                                </form>
                            </div>
                        <?php 
                          }
                          ?>
                    </div>
                </div>



                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    function handleFavorite(checkbox) {
                        const isFavorite = checkbox.checked; // True if checked, false otherwise
                        const bookID = <?php echo $bookID ?>;

                        const formData = new FormData();
                        formData.append('bookID', bookID);
                        formData.append('isFavorite', isFavorite ? 1 : 0);

                        fetch('handle_favorite.php', {
                            method: 'POST',
                            body: formData,
                        })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    }
                </script>


                <script>
                    function handleWishlist(checkbox) {
                        const isWishlist = checkbox.checked; // True if checked, false otherwise
                        const bookID = <?php echo $bookID ?>;

                        const formData = new FormData();
                        formData.append('bookID', bookID);
                        formData.append('isWishlist', isWishlist ? 1 : 0);

                        fetch('handle_wishlist.php', {
                            method: 'POST',
                            body: formData,
                        })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    }
                </script>
</body>

</html>