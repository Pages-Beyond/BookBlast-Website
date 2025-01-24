<!-- FORM to ADD AUTHORS-->
<div class="add-form-container mt-5 ms-5 form-container">
    <form id="bookForm" class="form-layout" method="POST">
        <div class="row w-100">
            <div class="col-12 col-md-6 book-details mt-3">
                <div class="mb-3">
                    <label for="bookTitle" class="form-label text-white">Author's First Name</label>
                    <input type="text" class="form-control input-field" id="authorFName" name="authorFName" required>
                </div>
                <div class="mb-3">
                    <label for="bookAuthor" class="form-label text-white">Author's Last Name</label>
                    <input type="text" class="form-control input-field" id="authorLName" name="authorLName" required>
                </div>
            </div>
            <div class="col-12 col-md-6 preview-section d-flex justify-content-center align-items-center">
                <!-- Add Author Button -->
                <button type="submit" class="btn btn-light add-book-btn" name="btnSubmitAuthor">
                    Add Author
                </button>
            </div>
        </div>

        <?php 
        if (isset($_POST['btnSubmitAuthor'])) {
            if ($authorExists) { ?>

                <h4><i>Author Already Exists!</i></h4>

            <?php } else { ?>

                <h4><i>Author Added Successfully!</i></h4>

            <?php }
        } ?>

    </form>
</div>