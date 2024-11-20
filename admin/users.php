<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (isset($_GET['delete'])) {
  $query = 'DELETE FROM users
    WHERE id = ' . $_GET['delete'] . '
    LIMIT 1';
  mysqli_query($connect, $query);

  set_message('User has been deleted');

  header('Location: users.php');
  die();
}

include('includes/header.php');

$query = 'SELECT *
  FROM users
  ' . (($_SESSION['id'] != 1 && $_SESSION['id'] != 4) ? 'WHERE id = ' . $_SESSION['id'] . ' ' : '') . '
  ORDER BY last, first';
$result = mysqli_query($connect, $query);

?>

<div class="container my-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="mb-0">Manage Users</h2>
  <a href="users_add.php" class="btn btn-primary"><i class="fas fa-plus-square"></i> Add User</a>
  </div>

    <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle" style="background-color: white;">
      <thead class="table-primary text-white">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Active</th>
            <th>Actions</th>
          </tr>
      </thead>
      <tbody>
          <?php while ($record = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo $record['id']; ?></td>
              <td><?php echo htmlentities($record['first'] . ' ' . $record['last']); ?></td>
              <td>
                <a href="mailto:<?php echo htmlentities($record['email']); ?>">
                  <?php echo htmlentities($record['email']); ?>
                </a>
              </td>
              <td><?php echo htmlentities($record['active']); ?></td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <a href="users_edit.php?id=<?php echo $record['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <?php if ($_SESSION['id'] != $record['id']): ?>
                    <a href="users.php?delete=<?php echo $record['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('includes/footer.php');?>