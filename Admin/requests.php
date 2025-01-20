<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="assets/img/bookblast-logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/requests.css">

</head>

<body>
    <!-- Navbar -->
    <?php include("assets/shared/navbar.php"); ?>

    <!-- Sidebar -->
    <?php include("assets/shared/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-content col-10 d-flex flex-column align-items-start">
        <div class="bookTitle my-3">
            <h1>Requests</h1>
        </div>

        <!-- Card Row -->
        <div class="row ms-1 g-5">
            <!-- First Card -->
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="card" style="max-width: 16rem; min-width: 12rem;">
                    <img src="assets/img/peterpan.png" class="card-img-top" alt="Dashboard Image"
                        style="height: 160px; object-fit: cover;">
                </div>
                <div class="mt-2">
                    <h2 class="mb-0" style="white-space: nowrap;">Peter Pan</h2>
                    <h6 class="mb-0" style="white-space: nowrap;">John Doe</h6>
                </div>
            </div>

            <!-- Right Aligned Name, Email, Phone, and Buttons-->
            <div class="col-md-4 col-lg-4 d-flex flex-column align-items-start justify-content-center mt-0 order-md-1 order-2 ms-md-auto"
                style="margin-right: 20px;">
                <div class="d-flex flex-column align-items-start">
                    <h1 class="mb-0" style="white-space: nowrap;">John Doe</h1>
                    <h6 class="mb-1">johndoe@gmail.com</h6>
                    <h6 class="mb-0">097624168632</h6>
                </div>

                <!-- Buttons below phone number -->
                <div class="mt-4 d-flex justify-content-between" style="gap: 70px;">
                    <div class="col-6 col-sm-12">
                        <button class="btn w-100"
                            style="background-color: #7D97A0; border-radius: 30px; color: white;">Allow</button>
                    </div>
                    <div class="col-6 col-sm-12">
                        <button class="btn w-100"
                            style="background-color: #B26424; border-radius: 30px; color: white;">Decline</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Card Row -->
        <div class="row mt-2 ms-1 g-5">
            <!-- Second Card -->
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="card" style="max-width: 16rem; min-width: 12rem;">
                    <img src="assets/img/peterpan.png" class="card-img-top" alt="Dashboard Image"
                        style="height: 160px; object-fit: cover;">
                </div>
                <div class="mt-2">
                    <h2 class="mb-0" style="white-space: nowrap;">Peter Pan</h2>
                    <h6 class="mb-0" style="white-space: nowrap;">John Doe</h6>
                </div>
            </div>

            <!-- Right Aligned Name, Email, Phone, and Buttons -->
            <div class="col-md-4 col-lg-4 d-flex flex-column align-items-start justify-content-center mt-0 order-md-1 order-2 ms-md-auto"
                style="margin-right: 20px;">
                <div class="d-flex flex-column align-items-start">
                    <h1 class="mb-0" style="white-space: nowrap;">John Doe</h1>
                    <h6 class="mb-1">johndoe@gmail.com</h6>
                    <h6 class="mb-0">097624168632</h6>
                </div>

                <!-- Buttons below phone number -->
                <div class="mt-4 d-flex justify-content-between " style="gap: 70px;">
                    <div class="col-6 col-sm-12">
                        <button class="btn w-100"
                            style="background-color: #7D97A0; border-radius: 30px; color: white;">Allow</button>
                    </div>
                    <div class="col-6 col-sm-12">
                        <button class="btn w-100"
                            style="background-color: #B26424; border-radius: 30px; color: white;">Decline</button>
                    </div>
                </div>
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