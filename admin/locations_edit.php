<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (!isset($_GET['id'])) {
  header('Location: locations.php');
  die();
}

if (isset($_POST['locationName'])) {
  if ($_POST['locationName'] && $_POST['address'] && $_POST['gMapLink']) {
    $query = 'UPDATE location SET
      locationName = "' . mysqli_real_escape_string($connect, $_POST['locationName']) . '",
      address = "' . mysqli_real_escape_string($connect, $_POST['address']) . '",
      gMapLink = "' . mysqli_real_escape_string($connect, $_POST['gMapLink']) . '"
      WHERE id = ' . $_GET['id'] . '
      LIMIT 1';
    mysqli_query($connect, $query);

    set_message('Location has been updated');
    header('Location: locations.php');
    die();
  }
}

$query = 'SELECT * FROM location WHERE id = ' . $_GET['id'] . ' LIMIT 1';
$result = mysqli_query($connect, $query);

if (!mysqli_num_rows($result)) {
  header('Location: locations.php');
  die();
}

$record = mysqli_fetch_assoc($result);

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
    <h2 class="mb-0">Edit Location</h2>
    <a href="locations.php" class="btn btn-secondary"><i class="fas fa-arrow-circle-left"></i> Return to Location List</a>
  </div>
  <div class="card shadow-sm custom-bg">
    <div class="card-body">
      <form method="post">
        <div class="mb-3">
          <label for="locationName" class="form-label">Location Name:</label>
          <input type="text" name="locationName" id="locationName" value="<?php echo htmlentities($record['locationName']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="address" class="form-label">Address:</label>
          <input type="text" name="address" id="address" value="<?php echo htmlentities($record['address']); ?>" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="gMapLink" class="form-label">Google Maps Link:</label>
          <input type="text" name="gMapLink" id="gMapLink" value="<?php echo htmlentities($record['gMapLink']); ?>" class="form-control" required>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Update Location</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>