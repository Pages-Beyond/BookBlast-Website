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
function handlePost($pdo, $input)
{
    if (isset($input['bookID'], $input['authorID'], $input['categoryID'], $input['bookTitle'], $input['bookCover'], $input['datePublished'])) {
        $sql = "INSERT INTO tbl_books (bookID, authorID, categoryID, bookTitle, bookCover, datePublished) 
                VALUES (:bookID, :authorID, :categoryID, :bookTitle, :bookCover, :datePublished)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'bookID' => $input['bookID'],
            'authorID' => $input['authorID'],
            'categoryID' => $input['categoryID'],
            'bookTitle' => $input['bookTitle'],
            'bookCover' => $input['bookCover'],
            'datePublished' => $input['datePublished'],
        ]);
        echo json_encode(['message' => 'Book added successfully']);
    } else {
        echo json_encode(['message' => 'Invalid input', 'input' => $input]);
    }
}

// Function to handle PUT requests
function handlePut($pdo, $input)
{
    if (isset($input['bookID'], $input['authorID'], $input['categoryID'], $input['bookTitle'], $input['bookCover'], $input['datePublished'])) {
        $sql = "UPDATE tbl_books 
                SET bookID = :bookID, authorID = :authorID, categoryID = :categoryID, bookTitle = :bookTitle, bookCover = :bookCover, datePublished = :datePublished 
                WHERE bookID = :bookID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'bookID' => $input['bookID'],
            'authorID' => $input['authorID'],
            'categoryID' => $input['categoryID'],
            'bookTitle' => $input['bookTitle'],
            'bookCover' => $input['bookCover'],
            'datePublished' => $input['datePublished'],
        ]);
        echo json_encode(['message' => 'Book information updated successfully']);
    } else {
        echo json_encode(['message' => 'Invalid input', 'input' => $input]);
    }
}

// Function to handle DELETE requests
function handleDelete($pdo, $input)
{
    if (isset($input['bookID'])) {
        $sql = "DELETE FROM tbl_books WHERE bookID = :bookID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['bookID' => $input['bookID']]);
        echo json_encode(['message' => 'Book deleted successfully']);
    } else {
        echo json_encode(['message' => 'Invalid input']);
    }
}
?>