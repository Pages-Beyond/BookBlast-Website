<div class="col-12 col-md-8 text-center text-md-start">
    <div
        class="d-flex flex-column flex-md-row align-items-center align-items-md-start justify-content-center justify-content-md-start mb-3">
        <h3 class="text-center text-md-start"
            style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; margin-bottom: 0;">
            <strong>Username:</strong>
        </h3>
        <div
            class="d-flex align-items-center justify-content-center justify-content-md-start ms-0 ms-md-2 mt-1 mt-md-0">
            <span id="username"
                style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; white-space: nowrap;"><?php echo $user['firstName'] . ' ' . $user['lastName'] ?></span>
            <button class="btn btn-link text-primary p-0 ms-2" id="edit-username-btn"
                style="line-height: 1; vertical-align: middle;">
                <i class="fas fa-edit" style="font-size: 1.2rem;"></i>
            </button>
        </div>
    </div>

    <div id="user-info">
        <p style="font-family: 'Poppins', sans-serif; font-size: 1.25rem;">
            <strong>Mobile Number:</strong> <span id="mobile-number"><?php echo $implodeContactNumber ?></span>
        </p>
        <p style="font-family: 'Poppins', sans-serif; font-size: 1.25rem;">
            <strong>Email:</strong> <span id="email"><?php echo $user['email']; ?></span>
        </p>
        <p style="font-family: 'Poppins', sans-serif; font-size: 1.25rem;">
            <strong>Address:</strong> <span id="address"> <?php echo $user['street'] . ", " . $user['brgyDesc'] . ", " .
                $user['citymunDesc'] . ", " . $user['provDesc'] ?></span>
        </p>
    </div>
</div>
</div>

<!-- Modal for editing user information -->
<div class="modal fade" id="editUserInfoModal" tabindex="-1" aria-labelledby="editUserInfoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #C29A7D;">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="editUserInfoModalLabel">Edit Admin Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST" id="editForm">
                    <div class="mb-3">
                        <label for="edit-username" class="form-label text-black">First Name</label>
                        <input type="text" class="form-control" name="firstName"
                            value="<?php echo $user['firstName']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-username" class="form-label text-black">Last Name</label>
                        <input type="text" class="form-control" name="lastName" value="<?php echo $user['lastName']; ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-mobile-number" class="form-label text-black">Mobile Number</label>
                        <input type="text" class="form-control" name="contactNumber" maxlength="11"
                            value="<?php echo str_replace(' ', '',$implodeContactNumber) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label text-black">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>"
                            required>
                    </div>

                    <input type="hidden" name="userID" value="<?php echo $user['userID']; ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Save Changes</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

