<?php

session_start();

include('../shared/connect.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookID = $_POST['bookID'];
    $isWishlist = $_POST['isWishlist'];
    $userID = $_SESSION['userID'];

    if ($isWishlist) {

        $query = "INSERT INTO tbl_wishlist (bookID, userID) 
                  VALUES ('$bookID', '$userID')
                  ON DUPLICATE KEY UPDATE bookID = '$bookID'";
        if (executeQuery($query)) {
            echo "Book added to wishlist.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $query = "DELETE FROM tbl_wishlist WHERE bookID = '$bookID' AND userID = '$userID'";
        if (executeQuery($query)) {
            echo "Book removed from wishlist.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

?>