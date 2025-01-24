<?php

include('connect.php');

session_start();

if (!isset($_SESSION['password'])) {
    header("Location: ../login/login.php");
}

$userID = $_SESSION['userID'];

$userID = 2;

if (isset($_POST['btnUpdate'])) {
    // Update Existing User
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $userID = $_POST['userID'];

    $formattedContactNumber = substr($contactNumber, 0, 4) . '-' . substr($contactNumber, 4, 3) . '-' . substr($contactNumber, 7);

    $updateInfoQuery = "UPDATE tbl_users SET contactNumber=' $formattedContactNumber', email='$email' WHERE userID='$userID' and role='user'";
    executeQuery($updateInfoQuery);

    $updateUserQuery = "UPDATE tbl_userinfo SET firstName ='$firstName', lastName ='$lastName' WHERE userID='$userID'";
    executeQuery($updateUserQuery);

}

$userQuery = "SELECT * FROM tbl_users 
    LEFT JOIN tbl_userinfo ON tbl_users.userID = tbl_userinfo.userID 
    LEFT JOIN tbl_addresses ON tbl_users.userID = tbl_addresses.userID 
    LEFT JOIN refbrgy ON tbl_addresses.barangayID = refbrgy.barangayID 
    LEFT JOIN refcitymun ON tbl_addresses.cityID = refcitymun.cityID 
    LEFT JOIN refprovince ON tbl_addresses.provinceID = refprovince.provinceID 
    WHERE role = 'user' AND tbl_users.userID = '$userID'";

$userResult = executeQuery($userQuery);
$user = mysqli_fetch_assoc($userResult);

$explodeContactNumber = explode('-', $user['contactNumber']);
$implodeContactNumber = implode('', $explodeContactNumber);

if (isset($_POST['btnUpdateProfile'])) {

    $imgFileUpload = $_FILES['profileImg']['name'];
    $imgFileUploadTMP = $_FILES['profileImg']['tmp_name'];

    //RENAME THE FILE
    $imgFileExt = substr($imgFileUpload, strripos($imgFileUpload, '.'));
    $imgNewName = "profile" . "" . "$userID";

    $profileNewFileName = $imgNewName . $imgFileExt;

    //SET THE LOCATION
    $imgFolder = "assets/shared/img/userpfp/";

    move_uploaded_file($imgFileUploadTMP, $imgFolder . $profileNewFileName);

    $updateProfile = "UPDATE tbl_users SET userProfilePic = '$profileNewFileName' WHERE userID = '$userID'";
    executeQuery($updateProfile);
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/img/bookblast-logo.png" />
    <link rel="stylesheet" href="assets/user/css/user-profile.css">
</head>


<body>
    <!-- Navbar ONLY IN USER Profile -->
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/shared/img/userpfp/<?php echo $user['userProfilePic'] ?>" alt="User" class="navbar-brand-img">
                <span class="navbar-brand-text">User Name</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
                <button type="button" class="btn-close text-reset position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
                <div class="offcanvas-body">
                    <h5 class="text-white fw-bold mb-4 m-0" style="font-size: 2rem;">Menu</h5>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="userDashboard.php" id="navbar-wishlists">User</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="profile.php" id="navbar-books">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="homepage.html" id="navbar-favorites">Home</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="loginPage.html" id="navbar-wishlists">Log-out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Photo Section -->
    <div class="container mt-5 pt-5 d-flex justify-content-center profile-photo-section">
        <div class="row align-items-center">
            <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                <div class="profile-photo-container d-flex justify-content-center">
                    <img id="profile-photo" src="assets/shared/img/userpfp/<?php echo $user['userProfilePic'] ?>"
                        alt="Profile Photo" class="rounded-circle"
                        style="width: 200px; height: 200px; object-fit: cover;">
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mt-3">
                        <input type="file" id="file-input" name="profileImg" style="display: none;"
                            class="form-control input-field" accept=".png, .jpg, .jpeg">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Change Photo
                        </button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Book Blast</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label for="uploadProfilePic" class="form-label text-white">Upload
                                                    Profile Picture </label>
                                                <input type="file" name="profileImg" class="form-control input-field"
                                                    accept=".png, .jpg, .jpeg" required />
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="btnUpdateProfile">Save
                                                changes</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                </form>
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
                    <strong>Address:</strong> <span id="address"><?php echo $user['street'] . ", " . $user['brgyDesc'] . ", " .
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
                            <input type="text" class="form-control" name="lastName"
                                value="<?php echo $user['lastName']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-mobile-number" class="form-label text-black">Mobile Number</label>
                            <input type="text" class="form-control" name="contactNumber"
                                value="<?php echo str_replace(' ', '', $implodeContactNumber) ?>" required>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>

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