<!doctype html>
<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
  
  <title>Event Management Admin</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>

  <!-- Message display if needed -->
  <?php if (get_message()):?>
    <div class="container mt-3">
      <div class="alert alert-info" role="alert">
        <?php echo get_message();?>
      </div>
    </div>
  <?php endif;?>

  <!-- Dashboard Nav -->
  <?php if(isset($_SESSION['id'])): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="#">Event Management</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="events.php">Manage Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="locations.php">Manage Locations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="users.php">Manage Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
    </nav>
  <?php endif; ?>
  

  
  
</body>
</html>