 <!-- Navbar ONLY IN Admin Profile -->
 <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img id="navbar-profile-photo" src="../assets/shared/img/profile/<?php echo $user['userProfilePic']?>" alt="Admin" class="navbar-brand-img">
                <span class="navbar-brand-text">Admin Profile</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
                <button type="button" class="btn-close text-reset position-absolute top-0 end-0 m-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                <div class="offcanvas-body">
                    <h5 class="text-white mb-4">Menu</h5>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="index.php" id="navbar-books">Books</a></li>
                        <li class="nav-item"><a class="nav-link" href="users.php" id="navbar-users">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="requests.php" id="navbar-requests">Requests</a></li>
                        <li class="nav-item"><a class="nav-link" href="../Login/login.php" id="navbar-logout">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>