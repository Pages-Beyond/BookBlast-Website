<?php
include('connect.php');

session_start();

if (!isset($_SESSION['password'])) {
    header("Location: ../login/login.php");
}

$userID = $_SESSION['userID'];

if (isset($_POST['btnUpdate'])) {
    // Update Existing User
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $userID = $_POST['userID'];

    $formattedContactNumber = substr($contactNumber, 0, 4) . '-' . substr($contactNumber, 4, 3) . '-' . substr($contactNumber, 7);

    $updateInfoQuery = "UPDATE tbl_users SET contactNumber=' $formattedContactNumber', email='$email' WHERE userID='$userID' and role='admin'";
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
    WHERE role = 'admin' AND tbl_users.userID = '$userID'";

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
    $imgFolder = "../assets/shared/img/userpfp/";

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
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="../assets/admin/img/bookblast-logo.png" type="image/png">
    <link rel="stylesheet" href="../assets/admin/css/adminProfile.css">
</head>


<body>
    <?php include("../assets/admin/shared/navbarAdmin.php"); ?>

    <!-- Profile Photo Section -->
    <div class="container mt-5 pt-5 d-flex justify-content-center profile-photo-section">
        <div class="row align-items-center">
            <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                <div class="profile-photo-container d-flex justify-content-center">
                    <img id="profile-photo" src="../assets/shared/img/userpfp/<?php echo $user['userProfilePic'] ?>"
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
                                <div class="modal-content" style="background-color: #C29A7D;">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Book Blast</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label for="uploadProfilePic" class="form-label text-white">Upload Profile Picture </label>
                                            <input type="file" name="profileImg" class="form-control input-field"
                                                accept=".png, .jpg, .jpeg" required />
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="btnUpdateProfile" >Save changes</button>
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <?php include('process/adminProfileForm.php') ?>

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

            // Update the profile information on the page
            document.getElementById('username').textContent = newUsername; // Update Username
            document.getElementById('mobile-number').textContent = newMobileNumber;
            document.getElementById('email').textContent = newEmail;

            // Close the modal after saving changes
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserInfoModal'));
            modal.hide();
        });

    </script>

</body>

</html>