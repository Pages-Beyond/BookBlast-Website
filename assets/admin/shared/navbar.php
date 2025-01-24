<nav class="navbar navbar-fixed-top" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="container-fluid">
            <div class="navbar-brand d-flex align-items-center mx-3">
                <img src="../assets/shared/img/userpfp/<?php echo $userProfilePic?>" alt="Admin" class="navbar-brand-img">
                <span class="navbar-brand-text">Admin</span>
            </div>
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
                        <li class="nav-item"><a class="nav-link" href="adminProfile.php" id="navbar-edit">Edit Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Login/login.php" id="navbar-logout">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>