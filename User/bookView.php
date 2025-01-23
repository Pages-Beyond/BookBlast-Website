<?php
include('../shared/connect.php');
session_start();


$userID = $_SESSION['userID'];
$bookTitle = '';
$bookAuthor = '';
$bookCover = '';
$bookRating = '';

if (isset($_GET['bookID'])){
    $bookID = $_GET['bookID'];
    $getBookDataQuery = "SELECT * from tbl_Books 
    LEFT JOIN tbl_authors ON tbl_books.authorID = tbl_authors.authorID 
    WHERE tbl_books.bookID = '$bookID';";

    $getBookRatingQuery = "SELECT ROUND(AVG(userRating),1) as bookRating from tbl_reviews WHERE bookID = '$bookID';";
    
    $bookDataResult = executeQuery($getBookDataQuery);

    while ($bookDataRow = mysqli_fetch_assoc($bookDataResult)){
        $bookTitle = $bookDataRow['bookTitle'];
        $bookAuthor = $bookDataRow['firstName']." ". $bookDataRow['lastName'];
        $bookCover = $bookDataRow['bookCover'];
      
    }

    $bookRatingResult = executeQuery($getBookRatingQuery);
    while ($bookRatingRow = mysqli_fetch_assoc($bookRatingResult)){
        $bookRating = $bookRatingRow['bookRating'];
    }





}else{
    header('Location: ../');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookBlast | Website</title>
    <link rel="icon" type="image/x-icon" href="../assets/user/img/homepage/bookblast-logo.png" />
    <link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #5E4447;
            font-family: 'Poppins', sans-serif;
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

        .title-container {
            position: relative;
            width: 100%;
            padding-left: 3rem;
        }

        .back-arrow {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .title-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .icons-wrapper {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .author-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-left: 310px;
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
                padding-left: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <!-- Header -->
        <h1 class="text-white fw-bold mb-4" style="font-size: 4rem;">Book</h1>

        <div class="mb-4">
            <!-- Title Section with Back Arrow -->
            <div class="title-container">
                <a href="#" onclick="history.go(-1)">
                    <div class="back-arrow">
                        <i class="fa fa-chevron-left text-white" style="font-size: 2rem;"></i>
                    </div>
                </a>

                <div class="title-content">
                    <h2 class="text-white m-0" style="font-size: 4rem;">
                        <?php echo $bookTitle ?>
                    </h2>
                    <div class="icons-wrapper">
                        <input type="checkbox" class="heart-checkbox" id="heart-checkbox">
                        <label for="heart-checkbox" class="heart">❤</label>
                        <input type="checkbox" class="wishlist-checkbox" id="wishlist-checkbox">
                        <label for="wishlist-checkbox" class="wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-bookmark-star-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z" />
                            </svg>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Author and Rating -->
            <div class="author-section mt-2">
                <h3 class="text-white mb-1" style="font-size: 2rem;"><?php echo $bookAuthor?></h3>
                <div class="d-flex align-items-center gap-2">
                    <span class="fa fa-star checked"></span>
                    <span class="text-white"><?php echo $bookRating?>/5</span>
                </div>
            </div>
        </div>


        <!-- Book Image and Button -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card" style="border-radius: 10px;">
                    <img src="../assets/shared/img/bookCovers/<?php echo $bookCover?>" class="card-img-top img-fluid" alt="Book Image"
                        style="max-width: 100%; height: auto;">
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button class="btn"
                        style="background-color: #7D97A0; color: white; padding: 8px 14px; font-size: 16px;">Borrow</button>
                </div>
            </div>
        </div>


        <!-- Reviews Section -->
        <h2 class="text-white mb-4">Reviews</h2>
        <div class="row g-4">
            <?php 
            $getUserReviewQuery = "SELECT tbl_reviews.userID, tbl_reviews.userReview, tbl_reviews.userRating, tbl_users.userProfilePic, tbl_userinfo.firstName, tbl_userinfo.firstName FROM `tbl_reviews` 
            LEFT JOIN tbl_users ON tbl_reviews.userID = tbl_users.userID
            LEFT JOIN tbl_userinfo ON tbl_users.userID = tbl_userinfo.userID 
            WHERE bookID = $bookID;";
            $userReviewResult = executeQuery($getUserReviewQuery);
            while ($userReviewRows = mysqli_fetch_assoc($userReviewResult) ){
                $userReview = $userReviewRows['userReview'];
                $userRating = $userReviewRows['userRating'];
                $userProfilePic = $userReviewRows['userProfilePic'];
                

          
            ?>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="d-flex p-3">
                        <img src="../assets/shared/img/userpfp/<?php echo $userProfilePic?>" class="rounded-circle"
                            style="width: 80px; height: 80px;" alt="Profile">
                        <div class="ms-3">
                            <h5 class="card-title">Janna Macatangay</h5>
                            <p class="card-text"><?php echo $userReview?></p>
                            <div>
                                <?php
                               
                                for ($i=0; $i<5; $i++){
                                    for ($j=0; $j<4; $j++){
                                        $checked = 'checked';
                                        if ($j == 3) {
                                            $checked =' ';
                                        }
                                    }
                              
                                    ?>
                                  
                                 <span class="fa fa-star <?php echo $checked?>" ></span>
                                <?php
                                };
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            }
            ?>
          
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>