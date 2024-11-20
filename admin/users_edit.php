<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (!isset($_GET['id'])) {
  header('Location: users.php');
  die();
}

if (isset($_POST['first'])) {
  if ($_POST['first'] && $_POST['last'] && $_POST['email']) {
    $query = 'UPDATE users SET
      first = "' . mysqli_real_escape_string($connect, $_POST['first']) . '",
      last = "' . mysqli_real_escape_string($connect, $_POST['last']) . '",
      email = "' . mysqli_real_escape_string($connect, $_POST['email']) . '",
      active = "' . $_POST['active'] . '"
      WHERE id = ' . $_GET['id'] . '
      LIMIT 1';
      mysqli_query($connect, $query);

    if ($_POST['password']) {
      $query = 'UPDATE users SET
        password = "' . md5($_POST['password']) . '"
        WHERE id = ' . $_GET['id'] . '
        LIMIT 1';
      mysqli_query($connect, $query);
    }

    set_message('User has been updated');
  }

  header('Location: users.php');
  die();
}

$query = 'SELECT * FROM users WHERE id = ' . $_GET['id'] . ' LIMIT 1';
$result = mysqli_query($connect, $query);

if (!mysqli_num_rows($result)) {
  header('Location: users.php');
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
    <h2 class="mb-0">Edit User</h2>
    <a href="users.php" class="btn btn-secondary"><i class="fas fa-arrow-circle-left"></i> Return to User List</a>
  </div>

  <div class="card shadow-sm custom-bg">
    <div class="card-body">
      <form method="post">
        <div class="mb-3">
          <label for="first" class="form-label">First Name:</label>
          <input type="text" name="first" id="first" class="form-control" value="<?php echo htmlentities($record['first']); ?>" required>
        </div>

        <div class="mb-3">
          <label for="last" class="form-label">Last Name:</label>
          <input type="text" name="last" id="last" class="form-control" value="<?php echo htmlentities($record['last']); ?>" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlentities($record['email']); ?>" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" name="password" id="password" class="form-control">
          <small class="form-text text-muted">Leave blank if you do not want to change the password.</small>
        </div>

        <div class="mb-3">
          <label for="active" class="form-label">Active:</label>
          <select name="active" id="active" class="form-select">
            <?php
            $values = array('Yes', 'No');
            foreach ($values as $value) {
              echo '<option value="' . $value . '"';
              if ($value == $record['active']) echo ' selected="selected"';
              echo '>' . $value . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>