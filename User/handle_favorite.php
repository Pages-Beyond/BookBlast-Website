<?php

session_start();

include('../shared/connect.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookID = $_POST['bookID'];
    $isFavorite = $_POST['isFavorite'];
    $userID = $_SESSION['userID'];

    if ($isFavorite) {

        $query = "INSERT INTO tbl_favorites (bookID, userID) 
                  VALUES ('$bookID', '$userID')
                  ON DUPLICATE KEY UPDATE bookID = '$bookID'";
        if (executeQuery($query)) {
            echo "Book added to favorites.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $query = "DELETE FROM tbl_favorites WHERE bookID = '$bookID' AND userID = '$userID'";
        if (executeQuery($query)) {
            echo "Book removed from favorites.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

?>