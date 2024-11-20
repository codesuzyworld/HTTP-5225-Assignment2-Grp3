<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (isset($_POST['locationName'])) {
    if ($_POST['locationName'] && $_POST['address'] && $_POST['gMapLink']) {
        $query = 'INSERT INTO location (
            locationName,
            address,
            gMapLink
        ) VALUES (
            "' . mysqli_real_escape_string($connect, $_POST['locationName']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['address']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['gMapLink']) . '"
        )';
        mysqli_query($connect, $query);

        set_message('Location has been added');
        header('Location: locations.php');
        die();
    }
}

include('includes/header.php');
?>

<style>
    .custom-bg {
        background-color: #f0f2f2;
        padding: 20px;
    }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Add Location</h2>
        <a href="locations.php" class="btn btn-secondary"><i class="fas fa-arrow-circle-left"></i> Return to Location List</a>
    </div>
    <div class="card shadow-sm custom-bg">
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="locationName" class="form-label">Location Name:</label>
                    <input type="text" name="locationName" id="locationName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="gMapLink" class="form-label">Google Maps Link:</label>
                    <input type="text" name="gMapLink" id="gMapLink" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Add Location</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>