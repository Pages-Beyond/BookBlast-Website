<?php
include('connect.php');

if (isset($_POST['btnAdd'])) {
    // Insert New User
    $userName = $_POST['userName'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $insertQuery = "INSERT INTO tbl_users (userName, contactNumber, email, address, role) VALUES ('$userName', '$contactNumber', '$email', '$address', 'admin')";
    executeQuery($insertQuery);
}

if (isset($_POST['btnUpdate'])) {
    // Update Existing User
    $userName = $_POST['userName'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $userID = $_POST['userID'];

    $updateQuery = "UPDATE tbl_users SET userName='$userName', contactNumber='$contactNumber', email='$email', address='$address' WHERE userID='$userID' and role='admin'";
    executeQuery($updateQuery);
}

$query = "SELECT * FROM tbl_users WHERE role = 'admin'";
$result = executeQuery($query);
$user = mysqli_fetch_assoc($result);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/img/bookblast-logo.png" />
    <link rel="stylesheet" href="../assets/admin/css/adminProfile.css">
</head>


<body>
<?php include("../assets/admin/shared/navbarAdmin.php"); ?>

    <!-- Profile Photo Section -->
    <div class="container mt-5 pt-5 d-flex justify-content-center profile-photo-section">
        <div class="row align-items-center">
            <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                <div class="profile-photo-container d-flex justify-content-center">
                    <img id="profile-photo" src="../assets/admin/img/artN.jpg"  alt="Profile Photo"
                        class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary" id="change-photo-btn">Change Photo</button>
                    <input type="file" id="file-input" style="display: none;" accept="image/*">
                </div>
            </div>


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
                            style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; white-space: nowrap;"><?php echo $user['userName']; ?></span>
                        <button class="btn btn-link text-primary p-0 ms-2" id="edit-username-btn"
                            style="line-height: 1; vertical-align: middle;">
                            <i class="fas fa-edit" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </div>

                <div id="user-info">
                    <p style="font-family: 'Poppins', sans-serif; font-size: 1.25rem;">
                        <strong>Mobile Number:</strong> <span
                            id="mobile-number"><?php echo $user['contactNumber']; ?></span>
                    </p>
                    <p style="font-family: 'Poppins', sans-serif; font-size: 1.25rem;">
                        <strong>Email:</strong> <span id="email"><?php echo $user['email']; ?></span>
                    </p>
                    <p style="font-family: 'Poppins', sans-serif; font-size: 1.25rem;">
                        <strong>Address:</strong> <span id="address"><?php echo $user['address']; ?></span>
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
                                <label for="edit-username" class="form-label text-black">Username</label>
                                <input type="text" class="form-control" name="userName"
                                    value="<?php echo $user['userName']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-mobile-number" class="form-label text-black">Mobile Number</label>
                                <input type="text" class="form-control" name="contactNumber"
                                    value="<?php echo $user['contactNumber']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-email" class="form-label text-black">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?php echo $user['email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-address" class="form-label text-black">Address</label>
                                <input type="text" class="form-control" name="address"
                                    value="<?php echo $user['address']; ?>" required>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        // Get references to the button and file input
        const changePhotoBtn = document.getElementById('change-photo-btn');
        const fileInput = document.getElementById('file-input');
        const profilePhoto = document.getElementById('profile-photo');
        const navbarProfilePhoto = document.getElementById('navbar-profile-photo');

        // Trigger file input when the button is clicked
        changePhotoBtn.addEventListener('click', () => {
            fileInput.click();
        });

        // Update the profile photo and navbar photo when a new file is selected
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                // Create a new object URL for the selected file and set it as the image source
                const reader = new FileReader();
                reader.onload = function (e) {
                    const newImageUrl = e.target.result;
                    profilePhoto.src = newImageUrl;
                    navbarProfilePhoto.src = newImageUrl;  // Update navbar photo as well
                };
                reader.readAsDataURL(file);
            }
        });

        // Trigger the modal when the edit button is clicked
        const editUsernameBtn = document.getElementById('edit-username-btn');
        const editUserInfoModal = new bootstrap.Modal(document.getElementById('editUserInfoModal'));

        editUsernameBtn.addEventListener('click', function () {
            // Open the modal for editing user information
            editUserInfoModal.show();
        });

        // Save changes when the save button is clicked
        const saveChangesBtn = document.getElementById('save-changes-btn');

        saveChangesBtn.addEventListener('click', function () {
            // Get new values from the form
            const newUsername = document.getElementById('edit-username').value;
            const newMobileNumber = document.getElementById('edit-mobile-number').value;
            const newEmail = document.getElementById('edit-email').value;
            const newAddress = document.getElementById('edit-address').value;

            // Update the profile information on the page
            document.getElementById('username').textContent = newUsername; // Update Username
            document.getElementById('mobile-number').textContent = newMobileNumber;
            document.getElementById('email').textContent = newEmail;
            document.getElementById('address').textContent = newAddress;

            // Close the modal after saving changes
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserInfoModal'));
            modal.hide();
        });

    </script>

</body>

</html>