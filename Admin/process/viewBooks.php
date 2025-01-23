<?php
            if (mysqli_num_rows($booksResult) > 0) {
                while ($bookRows = mysqli_fetch_assoc($booksResult)) { ?>

                    <!-- Book Creation -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                        <!-- Delete Book Button -->
                        <form method="POST">
                            <input type="hidden" value="<?php echo $bookRows['bookID'] ?>" name="bookID">

                            <button class="btn btn-danger" name="btnDelete" style="float: right">
                                <div class="d-flex justify-content-end mb-1" style="position: relative;">
                                    <i class="fa-solid fa-trash" style="cursor: pointer; font-size: large"></i>
                                </div>
                            </button>

                        </form>

                        <div class="card" style="max-width: 100%; min-width: 100%; min-height: 250px; box-sizing: border-box;">
                            <img src="../assets/shared/img/bookCovers/<?php echo $bookRows['bookCover'] ?>" class="card-img-top"
                                alt="Book Cover not Available" style="height: 250px; object-fit: cover;">
                        </div>

                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <h3 class="mb-0"><?php echo $bookRows['bookTitle'] ?></h3>
                        </div>
                        <h6 style="margin-top: 4px;">
                            <?php echo $bookRows['firstName'] . ' ' . $bookRows['lastName'] ?>
                        </h6>
                    </div>

                    <?php
                }
            }
            ?>
