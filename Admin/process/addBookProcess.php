<!-- FORM to ADD BOOKS-->
<div class="add-form-container mt-2 ms-5 form-container">

    <form id="bookForm" class="form-layout" method="POST" enctype="multipart/form-data">
        <div class="row w-100">
            <div class="col-12 col-md-6 book-details">
                <div class="mb-3">
                    <label for="bookTitle" class="form-label text-white">Title</label>
                    <input type="text" class="form-control input-field" id="bookTitle" name="bookTitle" required>
                </div>

                <div class="mb-3">

                    <label for="bookAuthor" class="form-label text-white">Author</label>
                    <select id="categoryNameSelect" name="authorID" class="form-control input-field" required>
                        <option value="">Select Author Name</option>

                        <?php
                        if (mysqli_num_rows($categoryResults) > 0) {
                            while ($authorRow = mysqli_fetch_assoc($authorResults)) {
                                ?>

                                <option <?php if ($authorFilter == ($authorRow['fullName'])) {
                                    echo "selected";
                                } ?>
                                    value="<?php echo $authorRow['authorID'] ?>">
                                    <?php echo $authorRow['fullName'] ?>
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
                     required maxlength="4" pattern="^\d{4}$" min="1800" max="2025" required>
                </div>

                <div class="mb-3">
                    <label for="bookCategory" class="form-label text-white">Book Category</label>
                    <select id="categoryNameSelect" name="categoryID" class="form-control input-field" required>
                        <option value="">Select a Book Category</option>

                        <?php
                        while ($categoryRow = mysqli_fetch_assoc($categoryResults)) {
                            ?>

                            <option <?php if ($categoryFilter == $categoryRow['categoryName']) {
                                echo "selected";
                            } ?>
                                value="<?php echo $categoryRow['categoryID'] ?>">
                                <?php echo $categoryRow['categoryName'] ?>
                            </option>

                            <?php
                        }
                        ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label for="uploadBookCover" class="form-label text-white">Upload Book Cover</label>
                    <input type="file" name="imgFile" class="form-control input-field" accept=".png, .jpg, .jpeg"
                        required />
                </div>
            </div>

            <!-- Right side: Preview next to the book fields -->
            <div class="col-12 col-md-6 preview-section">
                <label for="previewImage" class="form-label text-white">Preview</label>
                <img src="../assets/admin/img/peterpan.png" alt="Preview Image" class="preview-image">

                <!-- Add Book Button moved below the image -->
                <button type="submit" class="btn btn-light add-book-btn" name="btnSubmit">
                    Add Book
                </button>
            </div>
        </div>

    </form>

</div>