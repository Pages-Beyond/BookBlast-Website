<?php
include("connect.php");

$categoryFilter = '';
$authorFilter = '';
$imgNumber = '';

$categoryQuery = "SELECT * FROM tbl_categories";
$categoryResults = executeQuery($categoryQuery);

$authorQuery = "SELECT DISTINCT(CONCAT(firstName, ' ', lastName)) AS fullName, authorID FROM tbl_authors ORDER BY fullName ASC";
$authorResults = executeQuery($authorQuery);


$lastNumberQuery ="SELECT MAX(bookID + 1) AS imgNumber from tbl_books";
$lastNumberResult = executeQuery($lastNumberQuery);
while($lastNumberRow = mysqli_fetch_assoc($lastNumberResult)){
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
	$imgFolder = "assets/img/books/";

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
    <link rel="icon" href="assets/img/bookblast-logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/add.css">

</head>

<body>
    <!-- Navbar -->
    <?php include("assets/shared/navbar.php"); ?>

    <!-- Sidebar -->
    <?php include("assets/shared/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="main-column col-10 d-flex flex-column align-items-start ps-3">
        <div class="bookTitle text-end">
            <h1 class="ms-0 my-3">Add Books Form</h1>
        </div>

        <!-- FORM to ADD BOOKS-->
        <div class="add-form-container mt-2 ms-5 form-container">
            <form id="bookForm" class="form-layout" method="POST" enctype="multipart/form-data">
                <div class="row w-100">
                    <div class="col-12 col-md-6 book-details">
                        <div class="mb-3">
                            <label for="bookTitle" class="form-label text-white">Title</label>
                            <input type="text" class="form-control input-field" id="bookTitle" name="bookTitle"
                                required>
                        </div>

                        <div class="mb-3">

                            <label for="bookAuthor" class="form-label text-white">Author</label>
                            <select id="categoryNameSelect" name="authorID" class="form-control input-field">
                                <option value="">Select Author Name</option>

                                <?php
                                if (mysqli_num_rows($categoryResults) > 0) {
                                    while ($authorRow = mysqli_fetch_assoc($authorResults)) {
                                        ?>

                                        <option <?php if ($authorFilter == ($authorRow['fullName'])) {
                                            echo "selected";
                                        } ?>
                                            value="<?php echo $authorRow['authorID']?>">
                                            <?php echo $authorRow['fullName']?>
                                        </option>

                                        <?php
                                    }
                                }
                                ?>

                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="bookAuthor" class="form-label text-white">Published Year</label>
                            <input type="text" class="form-control input-field" id="yearPublished" name="yearPublished"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="bookCategory" class="form-label text-white">Book Category</label>
                            <select id="categoryNameSelect" name="categoryID" class="form-control input-field">
                                <option value="">Select a Book Category</option>

                                <?php
                                    while ($categoryRow = mysqli_fetch_assoc($categoryResults)) {
                                        ?>

                                        <option <?php if ($categoryFilter == $categoryRow['categoryName']) {
                                            echo "selected";
                                        } ?>
                                            value="<?php echo $categoryRow['categoryID']?>">
                                            <?php echo $categoryRow['categoryName']?>
                                        </option>

                                        <?php
                                    }
                                ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="uploadBookCover" class="form-label text-white">Upload Book Cover</label>
                            <input type="file" name="imgFile" class="form-control input-field"
                                accept=".png, .jpg, .jpeg" required />
                        </div>
                    </div>

                    <!-- Right side: Preview next to the book fields -->
                    <div class="col-12 col-md-6 preview-section">
                        <label for="previewImage" class="form-label text-white">Preview</label>
                        <img src="assets/img/peterpan.png" alt="Preview Image" class="preview-image">

                        <!-- Add Book Button moved below the image -->
                        <button type="submit" class="btn btn-light add-book-btn"
                            name="btnSubmit">
                            Add Book
                        </button>
                    </div>
                </div>

            </form>
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