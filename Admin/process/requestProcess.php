<?php
if (mysqli_num_rows($transactionInfoResult) > 0) {
    while ($transactionInfoRows = mysqli_fetch_assoc($transactionInfoResult)) { ?>

        <!-- Card Row -->
        <div class="row ms-1 g-5 d-flex mx-4">
            <div class="card mb-5" style="max-width: 600px">
                <div class="row g-0">
                    <div class="col-md-4 p-2 d-flex justify-content-center align-items-center">
                        <img src="../assets/shared/img/bookCovers/<?php echo $transactionInfoRows['bookCover'] ?>"
                            class="img-fluid rounded-start" alt="...">
                    </div>

                    <div class="col-md-8">
                        <div class="card-header">
                            <b>Request #<?php echo $transactionInfoRows['transactionID'] ?></b>
                        </div>
                        <div class="card-body justify-content-center">
                            <h4 class="card-title text-center"><?php echo $transactionInfoRows['bookTitle'] ?></h4>
                            <h6 class="text-center"><i>Written by
                                    <?php echo $transactionInfoRows['authorFullName'] ?></i></h6>

                            <h5 class="mt-3">
                                Requested by: <?php echo $transactionInfoRows['userFullName'] ?>
                            </h5>
                            <h6 class="mb-1"><?php echo $transactionInfoRows['email'] ?></h6>
                            <h6 class="mb-0"><?php echo $transactionInfoRows['contactNumber'] ?></h6>
                        </div>

                        <form method="POST">
                            <div class="mt-2">
                                <div class="col-6 col-sm-12 d-flex flex-column align-items-center">

                                    <input type="hidden" value="<?php echo $transactionInfoRows['transactionID'] ?>"
                                        name="transactionID">
                                    <button class="btn w-75" type="submit" name="btnAccept"
                                        style="background-color: #7D97A0; border-radius: 30px; color: white;">Allow</button>

                                    <input type="hidden" value="<?php echo $transactionInfoRows['transactionID'] ?>"
                                        name="transactionID">
                                    <button class="btn w-75 my-3" type="submit" name="btnDecline"
                                        style="background-color: #B26424; border-radius: 30px; color: white;">Decline</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}
?>