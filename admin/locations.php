<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (isset($_GET['delete'])) {
  $query = 'DELETE FROM location
    WHERE id = ' . $_GET['delete'] . '
    LIMIT 1';
  mysqli_query($connect, $query);

  set_message('Location has been deleted');

  header('Location: locations.php');
  die();
}

include('includes/header.php');

$query = 'SELECT *
  FROM location
  ' . (($_SESSION['id'] != 1 && $_SESSION['id'] != 4) ? 'WHERE id = ' . $_SESSION['id'] . ' ' : '') . '
  ORDER BY locationName, address, gMapLink';
$result = mysqli_query($connect, $query);

?>

<div class="container my-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Manage Locations</h2>
    <a href="locations_add.php" class="btn btn-primary"><i class="fas fa-plus-square"></i> Add Location</a>
  </div>

    <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle" style="background-color: white;">
        <thead class="table-primary text-white">
            <tr>
              <th>ID</th>
              <th>Location</th>
              <th>Address</th>
              <th>Map Link</th>
              <th>Actions</th>
            </tr>
        </thead>
      <tbody>
        <?php while ($record = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?php echo $record['id']; ?></td>
            <td><?php echo htmlentities($record['locationName']); ?></td>
            <td><?php echo htmlentities($record['address']); ?></td>
            <td>
              <?php if (!empty($record['gMapLink'])): ?>
              <a href="<?php echo htmlentities($record['gMapLink']); ?>" target="_blank">View Map</a>
              <?php else: ?>
              <span class="text-muted">N/A</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="d-flex justify-content-center gap-2">
                <a href="locations_edit.php?id=<?php echo $record['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="locations.php?delete=<?php echo $record['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this location?');">Delete</a>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('includes/footer.php');?>