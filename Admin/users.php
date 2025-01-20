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
    <link rel="stylesheet" href="assets/css/users.css">

</head>

<body>
    <!-- Navbar -->
    <?php include("assets/shared/navbar.php"); ?>

    <!-- Sidebar -->
    <?php include("assets/shared/sidebar.php"); ?>


    <!-- Main Content -->
    <div class="main-content col-10 d-flex flex-column align-items-start">
        <div class="bookTitle my-3">
            <h1>Users</h1>
        </div>

        <div class="container ms-3"
            style="width: 90%; height: 60px; background-color: #C29A7D; display: flex; align-items: center; justify-content: space-between; margin-right: 10px;">
            <span>John Doe</span>

            <!-- Dropdown Button -->
            <button class="btn" type="button" id="expandButton" style="background-color: #C29A7D; border: none;">
                <i class="fa-solid fa-caret-down" style="font-size: 24px;"></i>
            </button>
        </div>

        <!-- Expandable Section Below the Container -->
        <div id="expandable" class="ms-3"
            style="display: none; background-color: #9B775D; width: 90%; height: 350px; padding-top: 30px;">
            <p style="color: white; text-align: left; padding-left: 20px; margin-bottom: 0; margin-left: 10px;">
                Name: John Doe</p>
            <p style="color: white; text-align: left; padding-left: 20px; margin-bottom: 0; margin-left: 10px;">
                Contact No:
                123-456-7890</p>
            <p style="color: white; text-align: left; padding-left: 20px; margin-bottom: 0; margin-left: 10px;">
                Email:
                example@example.com</p>
            <p style="color: white; text-align: left; padding-left: 20px; margin-bottom: 0; margin-left: 10px;">
                Address: 123 Main
                St, City, Country</p>
            <p
                style="color: white; text-align: left; padding-left: 20px; margin-bottom: 0; border-bottom: 1px solid rgba(255, 255, 255, 0.651); width: 90%; margin-left: 20px;">
            </p>

            <!-- Table Header -->
            <div class="mt-4" style="display: flex; justify-content: space-between; padding: 10px 20px;">
                <h5 style="color: white; font-weight: bold; margin: 0; flex: 1;">Borrowed Books</h5>
                <p style="color: white; font-weight: bold; margin: 0; flex: 1; margin-top: -20px;">Title</p>
                <p style="color: white; font-weight: bold; margin: 0; flex: 1; margin-top: -20px;">Author</p>
                <p style="color: white; font-weight: bold; margin: 0; flex: 1; margin-top: -20px;">Return By</p>
            </div>

            <!-- Table Content (Aligned Columns with p tags for Title, Author, Return By) -->
            <div style="display: flex; justify-content: space-between; padding: 10px 20px;">
                <p style="color: white; margin: 0; flex: 1;"></p>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">Book 1</h5>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">John Doe</h5>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">04-08-2025</h5>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px 20px;">
                <p style="color: white; margin: 0; flex: 1;"></p>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">Book 2</h5>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">Stephen G</h5>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">04-08-2025</h5>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px 20px;">
                <p style="color: white; margin: 0; flex: 1;"></p>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">Book 3</h5>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">JohnB C</h5>
                <h5 style="color: white; margin: 0; flex: 1; margin-top: -30px;">04-08-2025</h5>
            </div>


            <!-- Restrict Button -->
            <div style="display: flex; justify-content: flex-end; padding: 10px 20px;">
                <button
                    style="background-color: #B26424; color: white; padding: 10px 40px; border: none; border-radius: 5px;">
                    Restrict
                </button>
            </div>
        </div>
        <div class="container ms-3 my-5"
            style="width: 90%; height: 60px; background-color: #C29A7D; display: flex; align-items: center; justify-content: space-between;">
            <span>Michael Jackson</span>

            <!-- Dropdown Button -->
            <button class="btn" type="button" id="expandButton" style="background-color: #C29A7D; border: none;">
                <i class="fa-solid fa-caret-down" style="font-size: 24px;"></i>
            </button>
        </div>
    </div>
    </div>

    </div>

    <script>
        // Toggle expandable section
        document.getElementById('expandButton').addEventListener('click', function () {
            const expandable = document.getElementById('expandable');
            expandable.style.display = expandable.style.display === 'none' ? 'block' : 'none';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>