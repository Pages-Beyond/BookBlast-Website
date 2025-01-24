<?php
class Book {
    public $bookID;
    public $categoryID;
    public $bookTitle;
    public $authorID;
    public $bookCover;
    public $authorName;


    public function __construct($bookID, $categoryID, $bookTitle, $authorID, $bookCover, $firstName, $lastName) {
        $this->bookID = $bookID;
        $this->categoryID = $categoryID;
        $this->bookTitle = $bookTitle;
        $this->authorID = $authorID;
        $this->bookCover = $bookCover;
        $this->authorName = $firstName . ' ' . $lastName;
    }

    public function buildBooks() {
        return "
        <div class='col'>
            <div class='card' style='background-color: transparent; border: none; line-height: 0.1;'>
                <a href='books-viewingPage.html?id={$this->bookID}' style='text-decoration: none; color: white;'>
                    <img src='{$this->bookCover}' class='card-img-top' alt='{$this->bookTitle}'>
                </a>
                <div class='card-body' style='color: white;'>
                    <div class='heart'>
                        <div class='title-and-icons'>
                            <a href='books-viewingPage.html?id={$this->bookID}' style='text-decoration: none; color: white;'>
                                <h4 class='card-title'>{$this->bookTitle}</h4>
                            </a>
                            <div class='icons'>
                                <input type='checkbox' class='heart-checkbox' id='heart-checkbox-{$this->bookID}'>
                                <label for='heart-checkbox-{$this->bookID}' class='heart'>&#10084;</label>
                                <input type='checkbox' class='wishlist-checkbox' id='wishlist-checkbox-{$this->bookID}'>
                                <label for='wishlist-checkbox-{$this->bookID}' class='wishlist'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-bookmark-star-fill' viewBox='0 0 16 16'>
                                        <path fill-rule='evenodd' d='M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z'></path>
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>
                    <h1 class='display-6' style='font-size: 1rem;'>Author: {$this->authorName}</h1>
                    <div class='rating'>
                        <span class='fa fa-star checked'></span>
                        <p class='card-text'>4/5</p>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
}
?>
