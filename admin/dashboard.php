<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

include('includes/header.php');

?>

<style>
    /* Cool Hover animation for cards */
    .card:hover {
        background-color: #f8f9fa; 
        transform: translateY(-5px); 
        transition: all 0.3s ease;
    }

    .card:hover .card-title {
        color: #0d6efd; 
    }

    .card:hover .text-danger {
        color: #dc3545;
    }

   
    .card-logout .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    
</style>

<div class="container my-4">
    <h1 class="text-center mb-4">Dashboard</h1>
    <div class="row g-4">
        <!-- Manage Events -->
        <div class="col-md-3">
            <a href="events.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title">Events</h5>
                        <p class="card-text text-muted">View and manage Events.</p>
                    </div>
                </div>
            </a>
        </div>
        <!-- Manage Users -->
        <div class="col-md-3">
            <a href="users.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title">User Accounts</h5>
                        <p class="card-text text-muted">View and manage users.</p>
                    </div>
                </div>
            </a>
        </div>
        <!-- Manage Locations -->
        <div class="col-md-3">
            <a href="locations.php" class="text-decoration-none">
                <div class="card text-center shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title">Locations</h5>
                        <p class="card-text text-muted">View and manage event locations.</p>
                    </div>
                </div>
            </a>
        </div>
        <!-- Logout -->
        <div class="col-md-3">
            <a href="logout.php" class="text-decoration-none">
                <div class="card text-center shadow h-100 card-logout">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Logout</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="text-center">
      <a href="../index.php" class="btn btn-link">Return to Main Page</a>
</div>
<?php

include('includes/footer.php');

?>