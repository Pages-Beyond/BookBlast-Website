<?php
if (mysqli_num_rows($userDetailsResults) > 0) {
    while ($userDetailsRows = mysqli_fetch_assoc($userDetailsResults)) {
        // Assign a unique ID for each user
        $userID = $userDetailsRows['userID'];

        // Query to fetch the books borrowed by this user
        $borrowedBooksQuery = "SELECT tbl_books.*, tbl_authors.*,
                CONCAT(tbl_authors.firstName, ' ' ,tbl_authors.lastName) AS authorFullName
                FROM tbl_transactions
                LEFT JOIN tbl_books ON tbl_transactions.bookID = tbl_books.bookID 
                LEFT JOIN tbl_authors ON tbl_books.authorID = tbl_authors.authorID 
                WHERE userID = '$userID' AND status = 'reading'";

        $borrowedBooksResults = executeQuery($borrowedBooksQuery);
        ?>

        <div class="container ms-3 my-3"
            style="width: 90%; height: 60px; background-color: #C29A7D; display: flex; align-items: center; justify-content: space-between; margin-right: 10px;">
            <span><?php echo $userDetailsRows['userFullName'] ?></span>

            <!-- Dropdown Button -->
            <button class="btn" type="button" id="expandButton-<?php echo $userID ?>"
                style="background-color: #C29A7D; border: none;">
                <i class="fa-solid fa-caret-down" style="font-size: 24px;"></i>
            </button>
        </div>

        <!-- Expandable Section Below the Container -->
        <div id="expandable-<?php echo $userID ?>" class="ms-3"
            style="display: none; background-color: #9B775D; width: 90%; height: auto; padding-top: 30px;">
            <p style="color: white; text-align: left; padding-left: 20px; margin-bottom: 0; margin-left: 10px;">
                Contact No: <?php echo $userDetailsRows['contactNumber'] ?>
            </p>
            <p style="color: white; text-align: left; padding-left: 20px; margin-bottom: 0; margin-left: 10px;">
                Email: <?php echo $userDetailsRows['email'] ?>
            </p>
            <p style="color: white; text-align: left; padding-left: 20px; margin-bottom: 3px; margin-left: 10px;">
                Address: <?php echo $userDetailsRows['street'] . ", " . $userDetailsRows['brgyDesc'] . ", " .
                    $userDetailsRows['citymunDesc'] . ", " . $userDetailsRows['provDesc'] ?></p>
            <p
                style="color: white; text-align: left; padding-left: 20px; margin-bottom: 0; border-bottom: 1px solid rgba(255, 255, 255, 0.651); width: 90%; margin-left: 20px;">
            </p>

            <!-- Table Header -->
            <div class="mt-4" style="display: flex; justify-content: space-between; padding: 10px 20px;">
                <p style="color: white; font-weight: bold; margin: 0; flex: 1; margin-top: -20px;">Title</p>
                <p style="color: white; font-weight: bold; margin: 0; flex: 1; margin-top: -20px;">Author</p>
                <p style="color: white; font-weight: bold; margin: 0; flex: 1; margin-top: -20px;">Return By</p>
            </div>

            <!-- Loop through each borrowed book for this user -->
            <?php
            if (mysqli_num_rows($borrowedBooksResults) > 0) {
                while ($book = mysqli_fetch_assoc($borrowedBooksResults)) {
                    ?>
                    <div style="display: flex; justify-content: space-between; padding: 10px 20px;">
                        <h6 style="color: white; margin: 0; flex: 1; margin-top: 2px;">
                            <?php echo $book['bookTitle'] ?>
                        </h6>
                        <h6 style="color: white; margin: 0; flex: 1; margin-top: 2px;">
                            <?php echo $book['authorFullName'] ?>
                        </h6>
                        <h6 style="color: white; margin: 0; flex: 1; margin-top: 2px;">
                            2022-04-08
                        </h6>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='color: white; text-align: center;'>No books borrowed.</p>";
            }
            ?>

            <!-- Restrict Button -->
            <div style="display: flex; justify-content: flex-end; padding: 10px 20px;">
                <button style="background-color: #B26424; color: white; padding: 10px 40px; border: none; border-radius: 5px;">
                    Restrict
                </button>
            </div>
        </div>

        <?php
    }
}
?>