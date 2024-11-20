<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (!isset($_GET['id'])) {
  header('Location: events.php');
  die();
}

if (isset($_FILES['photo'])) {
  if ($_FILES['photo']['error'] == 0) {
    switch ($_FILES['photo']['type']) {
      case 'image/png':$type = 'png';
      break;
      case 'image/jpg':
      case 'image/jpeg':$type = 'jpeg';
      break;
      case 'image/gif':$type = 'gif';
      break;
    }

    $query = 'UPDATE events SET
    photo = "data:image/' . $type . ';base64,' . base64_encode(file_get_contents($_FILES['photo']['tmp_name'])) . '"
    WHERE id = ' . $_GET['id'] . '
    LIMIT 1';
    mysqli_query($connect, $query);
    set_message('Event photo has been updated');
    header('Location: events.php');
    die();
  }
}

if (isset($_GET['delete'])) {
  $query = 'UPDATE events SET
    photo = ""
    WHERE id = ' . $_GET['id'] . '
    LIMIT 1';
  mysqli_query($connect, $query);
  set_message('Event photo has been deleted');
  header('Location: events.php');
  die();
}

$query = 'SELECT * FROM events WHERE id = ' . $_GET['id'] . ' LIMIT 1';
$result = mysqli_query($connect, $query);

if (!mysqli_num_rows($result)) {
  header('Location: events.php');
  die();
}

$record = mysqli_fetch_assoc($result);

include('includes/header.php');
?>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
  <h2>Edit Event Photo</h2>
  <a href="events.php" class="btn btn-secondary"><i class="fas fa-arrow-circle-left"></i> Return to Event List</a>
</div>

<div class="card shadow-sm p-4">

  <?php if ($record['photo']):?>
    <div class="mb-4 text-center">
      <img src="data:image/jpg;base64,<?php echo base64_encode(base64_decode(explode(',', $record['photo'])[1])); ?>" class="img-fluid rounded" style="max-width: 800px; height: auto;" alt="Event Photo">
      <p class="text-muted">Note: For best results, photos should be approximately 800 x 800 pixels.</p>
      <p>
        <a href="events_photo.php?id=<?php echo $_GET['id']; ?>&delete" class="btn btn-danger mt-2">
          <i class="fas fa-trash-alt"></i> Delete this Photo
        </a>
      </p>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="photo" class="form-label">Upload New Photo:</label>
      <input type="file" name="photo" id="photo" class="form-control" >
    </div>

  <div class="text-center">
    <button type="submit" class="btn btn-primary">Save Photo</button>
  </div>
  </form>

  </div>
</div>

<?php include('includes/footer.php'); ?>