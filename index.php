<?php
include('shared/connect.php');

session_start();
$userID = $_SESSION['userID'];
$userPic = '';
$categoryName = '';
$feedbackStat = 'sent';



if (!isset($_SESSION['userID'])) {
    header('location:Login/login.php');

}

$getUserPicQuery = "SELECT `userProfilePic` FROM `tbl_users` WHERE userID = $userID";
$userPicResult = executeQuery($getUserPicQuery);

while ($userPicRows = mysqli_fetch_assoc($userPicResult)) {
    $userPic = $userPicRows['userProfilePic'];
}

if (isset($_POST['feedbackBtn'])) {
    $feedBack = $_POST['feedBack'];
    $feedBack = str_replace('\'', '', $feedBack);
    $feedBack = addslashes($feedBack);

    $insertFeedback = "INSERT INTO `tbl_feedbacks`(`userID`, `feedBack`) VALUES ('$userID','$feedBack');";
    executeQuery($insertFeedback);

    $feedbackStat = "sent";


}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookBlast | Website</title>
    <link rel="icon" type="image/x-icon" href="assets/user/img/homepage/bookblast-logo.png" />
    <link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    body {
        background-color: #5E4447;
        font-family: 'Poppins', sans-serif;
    }

    .navbar {
        padding: 5px 0;
    }

    .navbar-nav {
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 25px;
        align-items: center;
        padding: 10px 20px;
    }

    .nav-link {
        color: white;
    }

    .navbar-nav .nav-link {
        padding: 5px 10px;
        font-size: 14px;
    }

    .nav-link:hover {
        color: #f5c6cb;
        text-decoration: underline;
    }

    .navbar-brand img {
        max-height: 40px;
    }

    .profile img {
        width: auto;
        max-height: 35px;
        border-radius: 50%;
        transition: all 0.3s ease;
        margin-top: -5px;
        object-fit: contain;

    }

    .navbar-toggler {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .navbar-toggler .profile img {
        position: relative;
        width: 5vw;
        height: auto;
        border-radius: 50%;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .navbar-toggler .profile img:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        transform: scale(1.05);
    }

    .bbWordmark-container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        margin-top: 2%;
        width: 100%;
    }

    .bbWordmark {
        max-width: 90%;
        height: auto;
        max-height: 600px;
    }

    .accordion-item {
        margin-bottom: 10px;
    }

    /* star */
    .checked {
        color: yellow;
    }

    .rating {
        display: flex;
        align-items: center;
    }

    .rating .fa-star {
        margin-right: 5px;
    }

    .rating .card-text {
        margin: 0;
    }

    a {
        text-decoration: none;
        color: inherit;
    }
</style>

<body id="home">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg shadow" style="background-color: #5E4447;">
        <div class="container-fluid">
            <a href="../" class="navbar-brand" style="padding-left: 30px;">
                <img src="assets/user/img/homepage/bookblast-logoSmall.png" alt="BookBlast Logo" class="img-fluid">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="homepage.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="books.html">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#help">Help</a>
                    </li>
                </ul>

                <!-- Profile Image -->
                <div class="d-flex justify-content-center mt-3 mt-lg-0">
                    <a class="profile" href="userDashboard.html">
                        <img src="assets/user/img/<?php echo $userPic; ?>" alt="Profile" class="rounded-circle"
                            style="width: 40px; height: 40px;">
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <?php if ($feedbackStat == "sent") {

        ?>
        <div id="feedbackAlert" class="alert alert-success" role="alert">
            Feedback and Suggestions sent!
        </div>

        <?php
    }
    ?>


    <!-- WORDMARK -->
    <div class="bbWordmark-container text-center">
        <div class="row">
            <div class="col">
                <img src="assets/user/img/homepage/bookblast-wordmark.png" class="bbWordmark" alt="wordmark"
                    style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>

    <!-- FEATURED BOOKS -->
    <div class="container">
        <div class="row">
            <div class="col" style="color: white; font-weight: 500;">
                <h3>Featured Books</h3>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-5 g-4 m-0" style="max-width: 100%;">
            <?php
            $getFeaturedBooksQuery = "SELECT tbl_transactions.bookID, COUNT(tbl_transactions.bookID) AS topBooks, tbl_books.bookTitle as bookTitle, tbl_books.bookCover as bookCover, tbl_authors.firstName as firstName, tbl_authors.lastName, ROUND (AVG(tbl_reviews.userRating), 1) as avgRating 
            FROM tbl_transactions 
            LEFT JOIN tbl_books ON tbl_transactions.bookID = tbl_books.bookID 
            LEFT JOIN tbl_authors ON tbl_books.authorID = tbl_authors.authorID 
            LEFT JOIN tbl_reviews ON tbl_books.bookID = tbl_reviews.bookID 
            WHERE tbl_transactions.isApproved = 'approved' and tbl_transactions.status = 'done' 
            GROUP BY tbl_transactions.bookID ORDER BY tbl_transactions.bookID ASC LIMIT 5;";
            $featuredBooksResult = executeQuery($getFeaturedBooksQuery);

            while ($featureBooksRow = mysqli_fetch_assoc($featuredBooksResult)) {
                $featuredBookID = $featureBooksRow['bookID'];
                $featuredBookTitle = $featureBooksRow['bookTitle'];
                $featuredBookCover = $featureBooksRow['bookCover'];
                $featuredAuthor = $featureBooksRow['firstName'] . " " . $featureBooksRow['lastName'];
                $featuredRating = $featureBooksRow['avgRating']


                    ?>

                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <a href="books-viewingPage.html?bookID=<?php echo $featuredBookID ?>">
                        <div class="card" style="background-color: transparent; border: none; line-height: 0.1;">
                            <img src="assets/shared/img/bookCovers/<?php echo $featuredBookCover ?>" class="card-img-top"
                                style="max-height: 380px;" alt="...">
                            <div class="card-body" style="color: white;">
                                <h4 class="card-title"><?php echo $featuredBookTitle ?></h4>

                                <h1 class="display-6" style="font-size: 1rem;"><?php echo $featuredAuthor ?></h1>
                                <div class="rating">
                                    <span class="fa fa-star checked"></span>
                                    <p class="card-text"><?php echo $featuredRating . "/5" ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>

        </div>

    </div>

    <!-- FEATURED TOPICS -->
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col" style="color: white; font-weight: 500;">
                <h3>Featured Topics</h3>
            </div>
        </div>

        <div class="row row row-cols-1 row-cols-md-5 g-4 m-0" style="max-width: 100%; text-decoration: none;">
            <?php
            $getBookCategoriesQuery = "SELECT tbl_categories.categoryID, tbl_categories.categoryName, tbl_books.bookCover from tbl_categories LEFT JOIN tbl_books ON tbl_categories.categoryID = tbl_books.categoryID GROUP BY categoryName;";
            $getBookCategoriesResult = executeQuery($getBookCategoriesQuery);
            while ($categoryRows = mysqli_fetch_assoc($getBookCategoriesResult)) {
                $categoryID = $categoryRows['categoryID'];
                $categoryName = $categoryRows["categoryName"];
                $categoryBookCover = $categoryRows["bookCover"];
                ?>


                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <a href="books.html?category=<?php echo $categoryID ?>">
                        <div class="card" style="background-color: transparent; border: none;">
                            <img src="assets/shared/img/bookCovers/<?php echo $categoryBookCover ?>" class="card-img-top"
                                style="max-height: 380px;" alt="...">
                            <div class="card-body" style="color: white;">
                                <h1 class="display-6" style="font-size: 1.5rem;"><?php echo $categoryName ?></h1>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>

        </div>






    </div>














    <!-- ABOUT -->
    <div class="container" id="about" style="margin-top: 30px;">
        <div class="row">
            <div class="col m-0" style="color: white; font-weight: 500;">
                <h3>About</h3>
            </div>
        </div>

        <!-- First paragraph -->
        <div class="container">
            <div class="row">
                <div class="col" style="color: white;text-align: justify;">
                    <p><mark><b>BookBlast</b></mark> is a <b>modern digital library platform</b> designed to
                        make reading and book
                        management effortless for everyone. Whether you're a student, teacher, or book lover,
                        BookBlast provides a seamless experience with features like personalized dashboards,
                        advanced book search, and tailored recommendations. Users can borrow, reserve, or return
                        books with ease, while automated reminders help avoid overdue returns. With tools to
                        save favorites, create wishlists, and leave reviews or ratings,
                        <mark><b>BookBlast</b></mark>
                        turns reading into a dynamic and engaging experience. Discover your next favorite book,
                        track your reading journey, and explore a world of literature—all in one convenient
                        platform. <strong>BookBlast makes the joy of reading more accessible and enjoyable than
                            ever!</strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- BB LOGO -->
        <div class=" container">
            <div class="row">
                <div class="col text-center">
                    <img src="assets/user/img/homepage/bookblast-logo.png" class="bbLogo" alt="bbLogo"
                        style="max-width: 30%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- Frequently Asked Questions (Help) -->
    <div class="container" id="help" style="margin-top: 30px;">
        <div class="row">
            <div class="col" style="color: white; font-weight: 500;">
                <h3>Frequently Asked Questions</h3>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="accordion accordion-flush" id="accordionFlushExample"
                        style="border-radius: 10px; background-color: #EADCAE; gap: 10px;">
                        <?php
                        $getFAQSQuery = "SELECT * from tbl_questions";
                        $faqsResult = executeQuery($getFAQSQuery);

                        while ($faqsRow = mysqli_fetch_assoc($faqsResult)) {
                            $question = $faqsRow['question'];
                            $answer = $faqsRow['answer'];
                            $questionNumber = $faqsRow['questionID'];
                            ?>
                            <div class="accordion-item" style="border-radius: 5px;  background-color: #EADCAE; gap: 10px;">
                                <h2 class="accordion-header" id="flush-heading<?php echo $questionNumber ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse<?php echo $questionNumber ?>" aria-expanded="false"
                                        aria-controls="flush-collapse<?php echo $questionNumber ?>"
                                        style="border-radius: 5px;  background-color: #EADCAE; gap: 10px;">
                                        <?php echo $question ?>
                                    </button>
                                </h2>
                                <div id="flush-collapse<?php echo $questionNumber ?>" class="accordion-collapse collapse"
                                    aria-labelledby="flush-heading<?php echo $questionNumber ?>"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body"><?php echo $answer ?></div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Feedback and Suggestions -->
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col" style="color: white; font-weight: 500;">
                <h3>Feedback and Suggestions</h3>
            </div>

        </div>
        <form method="POST">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="form-floating">
                            <textarea name="feedBack" class="form-control" placeholder="Leave a comment here"
                                id="floatingTextarea2" style="height: 100px" required></textarea>
                            <label for="floatingTextarea2">Comments</label>
                        </div>
                        <div class="container" style="padding-top: 10px; color: #7D97A0;">
                            <button type="submit" name="feedbackBtn" class="btn ms-auto d-block"
                                style="background-color: #7D97A0; border-color: #7D97A0; color: white;"
                                data-toggle="modal" data-target="#exampleModalCenter">
                                Submit
                            </button>


                        </div>

                    </div>
                </div>
            </div>


        </form>


    </div>
    </div>

    <!-- FOOTER -->
    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3"
                style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                <img src="assets/user/img/homepage/p&b-logo.png" class="pbLogo"
                    style="width: 150px; max-height: 150px;">
                <h3 style="letter-spacing: 1rem; color: white;">PAGES & BEYOND</h3>
            </ul>
            <p class="text-center text-white" style="font-size: 0.9rem;">©2025 Organization</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const feedbackAlert = document.getElementById('feedbackAlert');
            if (feedbackAlert) {
                setTimeout(() => {
                    feedbackAlert.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>

</html>