<?php
header("Content-Type: application/json");
include 'connect.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        handleGet($pdo);
        break;
    case 'POST':
        handlePost($pdo, $input);
        break;
    case 'PUT':
        handlePut($pdo, $input);
        break;
    case 'DELETE':
        handleDelete($pdo, $input);
        break;
    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}

// Function to handle GET requests
function handleGet($pdo)
{
    $sql = "SELECT bookID, authorID, categoryID, bookTitle, bookCover, datePublished FROM tbl_books";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

// Function to handle POST requests
function handlePost($pdo, $inputs)
{
    $sql = "INSERT INTO tbl_books (bookID, authorID, categoryID, bookTitle, bookCover, datePublished) 
                VALUES (:bookID, :authorID, :categoryID, :bookTitle, :bookCover, :datePublished)";

    foreach ($inputs as $input) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'bookID' => $input['bookID'],
            'authorID' => $input['authorID'],
            'categoryID' => $input['categoryID'],
            'bookTitle' => $input['bookTitle'],
            'bookCover' => $input['bookCover'],
            'datePublished' => $input['datePublished'],
        ]);
    }
    echo json_encode(['message' => 'Book added successfully']);
}

// Function to handle PUT requests
function handlePut($pdo, $inputs)
{
    $sql = "UPDATE tbl_books 
                SET bookID = :bookID, authorID = :authorID, categoryID = :categoryID, bookTitle = :bookTitle, bookCover = :bookCover, datePublished = :datePublished 
                WHERE bookID = :bookID";

    foreach ($inputs as $input) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'bookID' => $input['bookID'],
            'authorID' => $input['authorID'],
            'categoryID' => $input['categoryID'],
            'bookTitle' => $input['bookTitle'],
            'bookCover' => $input['bookCover'],
            'datePublished' => $input['datePublished'],
        ]);
    }
    echo json_encode(['message' => 'Book information updated successfully']);

}

// Function to handle DELETE requests
function handleDelete($pdo, $inputs)
{
        $sql = "DELETE FROM tbl_books WHERE bookID = :bookID";

        foreach ($inputs as $input) {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['bookID' => $input['bookID']]);
        }
        echo json_encode(['message' => 'Book deleted successfully']);
}
?>