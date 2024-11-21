<?php
include('admin/includes/database.php');
include('admin/includes/config.php');
include('admin/includes/functions.php');
?>

<!doctype html>
<html>
<head>
  
  <meta charset="UTF-8">
  <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
  
  <title>Find Your Event</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
</head>
<body>

<header class="bg-primary text-white py-3">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="#">EventSphere</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link text-white" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="admin/index.php">Admin Section</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    main {
      flex-grow: 1;
    }

  .card-img-fixed {
    height: 250px;
    width: 100%;
    object-fit: cover;
    border-bottom: 1px solid #ddd;
  }
  .card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }
</style>

<!-- Filters and Searches -->
<div class="container">
  <form method="get" action="index.php" class="mt-3">
    
    <!-- Search Bar -->
    <div class="row mb-3">
      <div class="col-md-12">
        <div class="input-group">
          
          <!-- Search Input and Btn -->
          <input type="text" class="form-control" name="search" placeholder="Search by Event Name" 
            value="<?php echo isset($_GET['search']) ? htmlentities($_GET['search']) : ''; ?>">
          <button class="btn btn-primary px-4" type="submit">Search</button>

          <!-- Reset Search Results -->
          <?php if (isset($_GET['search']) || isset($_GET['type'])): ?>
            <a href="index.php" class="btn btn-danger ms-1 px-4">Reset</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="row mb-3 align-items-center">
      <div class="col-md-10">
        <!-- Event Type Filter -->
        <div class="d-flex flex-wrap">
          <?php
          $eventTypes = ['All', 'Conference', 'Webinar', 'Concert', 'Meetup', 'Network'];
          foreach ($eventTypes as $eventType) {
            // If event type = all, then the type string will be empty
            $typeValue = $eventType === 'All' ? '' : $eventType;
            // Set active if 'type' matches the event type
           // Set inactive if it doesnt match or it's all event type
            $isActive = (isset($_GET['type']) && $_GET['type'] === $eventType) || (!isset($_GET['type']) && $eventType === 'All');
            $btnClass = $isActive ? 'btn-primary' : 'btn-outline-primary';
            // If the the event search is active, then apply the class button primary
            echo '<button type="submit" name="type" value="' . htmlentities($typeValue) . '" class="btn ' . $btnClass . ' me-2 mb-2 px-4">' . $eventType . '</button>';
          }
          ?>
        </div>
      </div>
      <div class="col-md-2 text-end">
        <!-- Date Order Buttons -->
        <div class="btn-group">
          <button 
            type="submit" name="dateOrder" value="asc" class="btn btn-outline-primary px-4">
            <i class="fas fa-arrow-up-wide-short me-2"></i>
          </button>
          <button 
            type="submit" name="dateOrder" value="desc" class="btn btn-outline-primary px-4">
            <i class="fas fa-arrow-down-wide-short me-2"></i>
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

<main class="container mt-4">
  <?php
  // Error Reporting
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // Search Query, Type Filter, and Date Descending/Ascending
  $search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
  $type = isset($_GET['type']) ? mysqli_real_escape_string($connect, $_GET['type']) : '';
  $dateOrder = isset($_GET['dateOrder']) && in_array($_GET['dateOrder'], ['asc', 'desc']) ? $_GET['dateOrder'] : 'desc';

  // SQL Query
  $query = "SELECT * FROM events WHERE 1";
          
  if (!empty($search)) {
    $query .= " AND title LIKE '%$search%'";
  }
  
  if (!empty($type)) {
    $query .= " AND type = '$type'";
  }

  $query .= " ORDER BY dateStart $dateOrder";

  $result = mysqli_query($connect, $query);
  ?>

  <p class="mb-4">There are <strong><?php echo mysqli_num_rows($result); ?></strong> events available!</p>

  <div class="row row-cols-1 row-cols-md-3 g-4">
  <?php while ($record = mysqli_fetch_assoc($result)): ?>
    <div class="col">
      <div class="card h-100">
        <?php if (!empty($record['photo'])): ?>
          <img src="<?php echo $record['photo']; ?>" class="card-img-fixed" alt="<?php echo htmlentities($record['title']); ?>">
        <?php else: ?>
          <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-fixed" alt="No image available">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title text-primary"><?php echo htmlentities($record['title']); ?></h5>
          <?php if (!empty($record['type'])): ?>
            <span class="badge bg-info"><?php echo htmlentities($record['type']); ?></span>
          <?php endif; ?>
          <ul class="list-unstyled small text-muted mt-3">
              <li>
                  <i class="fas fa-calendar-alt me-2"></i>
                  <strong>Date:</strong> 
                  <?php 
                  echo htmlentities($record['dateStart']) . ' - ' . htmlentities($record['dateEnd']); 
                  ?>
              </li>
              <li>
                  <i class="fas fa-clock me-2"></i>
                  <strong>Time:</strong> 
                  <?php 
                  echo htmlentities($record['timeStart']) . ' - ' . htmlentities($record['timeEnd']); 
                  ?>
              </li>
          </ul>
          <button class="btn btn-link text-decoration-none p-0 mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $record['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $record['id']; ?>">
            Event Description
          </button>
          <div id="collapse<?php echo $record['id']; ?>" class="collapse">
            <div class="card-body">
              <p class="card-text"><?php echo htmlentities($record['content']);?></p>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <?php if (!empty($record['eventLink'])): ?>
            <a href="<?php echo htmlentities($record['eventLink']); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-external-link-alt"></i> View Event</a>
          <?php else: ?>
            <span class="text-muted">No event link available</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
  </div>
</main>
<?php include('admin/includes/footer.php'); ?>
</body>
</html>
