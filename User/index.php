<?php 
include ('../shared/connect.php');

session_start();

if (!isset($_SESSION['userID'])){
    header ('location:Login/login.php');
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookBlast | Website</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/homepage/bookblast-logo.png" />
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
    <nav class="navbar navbar-expand-lg shadow" style="background-color: #5E4447;">
        <div class="container-fluid">
            <!-- BookBlast Logo -->
            <a href="homepage.html" class="navbar-brand" style="padding-left: 30px;">
                <img src="../assets/img/homepage/bookblast-logoSmall.png" alt="BookBlast Logo">
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
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#help">Help</a>
                    </li>
                    <!-- Profile Image -->
                    <a class="profile" href="userDashboard.html">
                        <img src="../assets/img/homepage/img-profile.png" alt="Profile">
                    </a>
                </ul>

            </div>
        </div>

    </nav>


    <!-- WORDMARK -->
    <div class="bbWordmark-container text-center">
        <div class="row">
            <div class="col">
                <img src="../assets/img/homepage/bookblast-wordmark.png" class="bbWordmark" alt="wordmark"
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
            <div class="col">
                <a href="books-viewingPage.html">
                    <div class="card" style="background-color: transparent; border: none; line-height: 0.1;">
                        <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                        <div class="card-body" style="color: white;">
                            <h4 class="card-title">Peter Pan</h4>

                            <h1 class="display-6" style="font-size: 1rem;">John Doe</h1>
                            <div class="rating">
                                <span class="fa fa-star checked"></span>
                                <p class="card-text">4/5</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col ">
                <a href="books-viewingPage.html">
                <div class="card" style="background-color: transparent; border: none; line-height: 0.1;">
                    <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                    <div class="card-body" style="color: white;">
                        <h4 class="card-title">Peter Pan</h4>
                        <h1 class="display-6" style="font-size: 1rem;">John Doe</h1>
                        <div class="rating">
                            <span class="fa fa-star checked"></span>
                            <p class="card-text">4/5</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col">
                <a href="books-viewingPage.html">
                <div class="card" style="background-color: transparent; border: none; line-height: 0.1;">
                    <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                    <div class="card-body" style="color: white;">
                        <h4 class="card-title">Peter Pan</h4>
                        <h1 class="display-6" style="font-size: 1rem;">John Doe</h1>
                        <div class="rating">
                            <span class="fa fa-star checked"></span>
                            <p class="card-text">4/5</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col">
                <a href="books-viewingPage.html">
                <div class="card" style="background-color: transparent; border: none; line-height: 0.1;">
                    <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                    <div class="card-body" style="color: white;">
                        <h4 class="card-title">Peter Pan</h4>
                        <h1 class="display-6" style="font-size: 1rem;">John Doe</h1>
                        <div class="rating">
                            <span class="fa fa-star checked"></span>
                            <p class="card-text">4/5</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col">
                <a href="books-viewingPage.html">
                <div class="card" style="background-color: transparent; border: none; line-height: 0.1;">
                    <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                    <div class="card-body" style="color: white;">
                        <h4 class="card-title">Peter Pan</h4>
                        <h1 class="display-6" style="font-size: 1rem;">John Doe</h1>
                        <div class="rating">
                            <span class="fa fa-star checked"></span>
                            <p class="card-text">4/5</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>

        </div>

        <!-- FEATURED TOPICS -->
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col" style="color: white; font-weight: 500;">
                    <h3>Featured Topics</h3>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-5 g-4 m-0 text-center"
                style="max-width: 100%; text-decoration: none;">
                <div class="col">
                    <a href="books.html#fiction">
                        <div class="card" style="background-color: transparent; border: none;">
                            <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                            <div class="card-body" style="color: white;">
                                <h1 class="display-6" style="font-size: 1.5rem;">Fiction</h1>
                    </a>

                </div>
            </div>
        </div>

        <div class="col">
            <a href="books.html#non-fiction">
                <div class="card" style="background-color: transparent; border: none;">
                    <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                    <div class="card-body" style="color: white;">
                        <h1 class="display-6" style="font-size: 1.5rem;">Non-Fiction</h1>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="books.html#scienceTech">
                <div class="card" style="background-color: transparent; border: none;">
                    <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                    <div class="card-body" style="color: white;">
                        <h1 class="display-6" style="font-size: 1.5rem;">Science</h1>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="books.html#healthWelness">
                <div class="card" style="background-color: transparent; border: none;">
                    <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                    <div class="card-body" style="color: white;">
                        <h1 class="display-6" style="font-size: 1.5rem;">Health</h1>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="books.html#literature">
                <div class="card" style="background-color: transparent; border: none;">
                    <img src="../assets/img/homepage/peterpan.png" class="card-img-top" alt="...">
                    <div class="card-body" style="color: white;">
                        <h1 class="display-6" style="font-size: 1.5rem;">Literature</h1>
                    </div>
                </div>
        </div>
        </a>
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
                    <img src="../assets/img/homepage/bookblast-logo.png" class="bbLogo" alt="bbLogo"
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
                        <div class="accordion-item" style="border-radius: 5px;  background-color: #EADCAE; gap: 10px;">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne"
                                    style="border-radius: 5px;  background-color: #EADCAE; gap: 10px;">
                                    Accordion Item #1
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion,
                                    which is intended to demonstrate the <code>.accordion-flush</code>
                                    class. This is the first item's accordion body.</div>
                            </div>
                        </div>
                        <div class="accordion-item" style="border-radius: 5px; background-color: #EADCAE; gap: 10px;">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo"
                                    style="border-radius: 5px; background-color: #EADCAE; gap: 10px;">
                                    Accordion Item #2
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion,
                                    which is intended to demonstrate the <code>.accordion-flush</code>
                                    class. This is the second item's accordion body. Let's imagine this
                                    being filled with some actual content.</div>
                            </div>
                        </div>
                        <div class="accordion-item" style="border-radius: 5px; background-color: #EADCAE; gap: 10px;">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree"
                                    style="border-radius: 5px; background-color: #EADCAE; gap: 30px;">
                                    Accordion Item #3
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion,
                                    which is intended to demonstrate the <code>.accordion-flush</code>
                                    class. This is the third item's accordion body. Nothing more
                                    exciting happening here in terms of content, but just filling up the
                                    space to make it look, at least at first glance, a bit more
                                    representative of how this would look in a real-world application.
                                </div>
                            </div>
                        </div>
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

        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                            style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Comments</label>
                    </div>
                    <div class="container" style="padding-top: 10px; color: #7D97A0;">
                        <button type="button" class="btn ms-auto d-block"
                            style="background-color: #7D97A0; border-color: #7D97A0; color: white;">
                            Submit
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- FOOTER -->
    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3"
                style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                <img src="../assets/img/homepage/p&b-logo.png" class="pbLogo" style="width: 150px; max-height: 150px;">
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
</body>

</html>