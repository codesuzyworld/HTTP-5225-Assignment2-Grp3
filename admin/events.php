<?php
// Error Reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (isset($_GET['delete'])) {
  $query = 'DELETE FROM events
    WHERE id = ' . $_GET['delete'] . '
    LIMIT 1';
  mysqli_query($connect, $query);

  set_message('Event has been deleted');

  header('Location: events.php');
  die();
}

include('includes/header.php');

$query = 'SELECT events.*, location.locationName
  FROM events
  LEFT JOIN location ON events.locationID = location.id
  ORDER BY dateAdded DESC';
$result = mysqli_query($connect, $query);

?>

<div class="container my-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Manage Events</h2>
    <a href="events_add.php" class="btn btn-primary"><i class="fas fa-plus-square"></i> Add Event</a>
  </div>

    <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle" style="background-color: white;">
      <thead class="table-primary text-white">
        <tr>
          <th>ID</th>
          <th>Photo</th>
          <th>Title</th>
          <th>Description</th>
          <th>Type</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Time Start</th>
          <th>Time End</th>
          <th>Location</th>
          <th>Event Link</th>
          <th>Date Added</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
          <?php while ($record = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo $record['id']; ?></td>
              <td>
                <?php if (!empty($record['photo'])): ?>
                  <img src="<?php echo $record['photo']; ?>" style="height: auto; width: 75px;">
                <?php else: ?>
                  <span class="text-muted">No Photo</span>
                <?php endif; ?>
              </td>
              <td><?php echo htmlentities($record['title']);?></td>
              <td><?php echo htmlentities($record['content']);?></td>
              <td><?php echo htmlentities($record['type']); ?></td>
              <td><?php echo htmlentities($record['dateStart']);?></td>
              <td><?php echo htmlentities($record['dateEnd']);?></td>
              <td><?php echo htmlentities($record['timeStart']);?></td>
              <td><?php echo htmlentities($record['timeEnd']);?></td>
              <td><?php echo htmlentities($record['locationName']);?></td>
              <td>
                <?php if (!empty($record['eventLink'])): ?>
                  <a href="<?php echo htmlentities($record['eventLink']); ?>" target="_blank">Link</a>
                <?php else: ?>
                  <span class="text-muted">N/A</span>
                <?php endif; ?>
              </td>
              <td><?php echo htmlentities($record['dateAdded']); ?></td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <a href="events_photo.php?id=<?php echo $record['id']; ?>" class="btn btn-sm btn-secondary">Image</a>
                  <a href="events_edit.php?id=<?php echo $record['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="events.php?delete=<?php echo $record['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('includes/footer.php');?>