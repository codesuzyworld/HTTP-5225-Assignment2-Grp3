<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (isset($_POST['first'])) {
  if ($_POST['first'] && $_POST['last'] && $_POST['email'] && $_POST['password']) {
    $query = 'INSERT INTO users (
      first,
      last,
      email,
      password,
      active
    ) VALUES (
      "' . mysqli_real_escape_string($connect, $_POST['first']) . '",
      "' . mysqli_real_escape_string($connect, $_POST['last']) . '",
      "' . mysqli_real_escape_string($connect, $_POST['email']) . '",
      "' . md5($_POST['password']) . '",
      "' . $_POST['active'] . '"
    )';
    mysqli_query($connect, $query);
    set_message('User has been added');
  }

  header('Location: users.php');
  die();
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
      <h2 class="mb-0">Add User</h2>
      <a href="users.php" class="btn btn-secondary"><i class="fas fa-arrow-circle-left"></i> Return to User List</a>
  </div>

  <div class="card shadow-sm custom-bg">
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label for="first" class="form-label">First Name:</label>
            <input type="text" name="first" id="first" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="last" class="form-label">Last Name:</label>
            <input type="text" name="last" id="last" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="active" class="form-label">Active:</label>
            <select name="active" id="active" class="form-select">
            <?php
            $values = array('Yes', 'No');
            foreach ($values as $value) {
                echo '<option value="' . $value . '">' . $value . '</option>';
            }
            ?>
            </select>
          </div>

          <div class="text-center">
              <button type="submit" class="btn btn-primary">Add User</button>
          </div>
        </form>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>