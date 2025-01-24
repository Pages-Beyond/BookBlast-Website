<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
    $rating = $_POST['rating']; 
    $_SESSION['rating'] = $rating; 
    echo "Received rating: " . $rating;
} else {
    echo "Invalid request.";
}
?>
