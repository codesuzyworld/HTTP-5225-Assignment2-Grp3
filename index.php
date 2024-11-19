<?php

include( 'admin/includes/database.php' );
include( 'admin/includes/config.php' );
include( 'admin/includes/functions.php' );

?>
<!doctype html>
<html>
<head>
  
  <meta charset="UTF-8">
  <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
  
  <title>Find your Event</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>

<header class="bg-primary text-white py-3">
    <div class="container">
        <h1 class="mb-0">Find Your Event</h1>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="admin/index.php">Admin Section</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container mt-4">
  <?php

  $query = 'SELECT *
    FROM events
    ORDER BY dateAdded DESC';
  $result = mysqli_query( $connect, $query );

  ?>

  <p class="mb-4">There are <strong><?php echo mysqli_num_rows($result); ?></strong> events in the database!</p>

  <div class="row g-4">
    <?php while($record = mysqli_fetch_assoc($result)): ?>
      <div class="col-md-4">
        <div class="card">
          <?php if ($record['photo']): ?>
            <img src="<?php echo $record['photo']; ?>" class="card-img-top" alt="<?php echo htmlentities($record['title']); ?>">
          <?php else: ?>
            <img src="placeholder.jpg" class="card-img-top" alt="No image available">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlentities($record['title']); ?></h5>
            <p class="card-text">
              <strong>Date Added:</strong> <?php echo htmlentities($record['dateAdded']); ?><br>
              <strong>Type:</strong> <?php echo htmlentities($record['type']); ?><br>
              <strong>Start:</strong> <?php echo htmlentities($record['dateStart']); ?> <?php echo htmlentities($record['timeStart']); ?><br>
              <strong>End:</strong> <?php echo htmlentities($record['dateEnd']); ?> <?php echo htmlentities($record['timeEnd']); ?><br>
              <strong>Location:</strong> <?php echo htmlentities($record['locationID']); ?><br>
            </p>
            <?php if (!empty($record['eventLink'])): ?>
              <a href="<?php echo htmlentities($record['eventLink']); ?>" class="btn btn-primary" target="_blank">Event Link</a>
            <?php else: ?>
              <p class="text-muted">No event link available</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>


<?php

include( 'admin/includes/footer.php' );

?>