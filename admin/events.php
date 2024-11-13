<?php
  // Error Reporting
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM events
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
    
  set_message( 'Event has been deleted' );
  
  header( 'Location: events.php' );
  die();
  
}

include( 'includes/header.php' );

$query = 'SELECT *
  FROM events
  ORDER BY dateAdded DESC';
$result = mysqli_query( $connect, $query );

?>

<h2>Manage Events</h2>

<table>
  <tr>
    <th></th>
    <th align="center">ID</th>
    <th align="left">Title</th>
    <th align="left">Description</th>
    <th align="center">Type</th>
    <th align="center">Date Start</th>
    <th align="center">Date End</th>
    <th align="center">Time Start</th>
    <th align="center">Time End</th>
    <th align="center">Location</th>
    <th align="center">Event Link</th>
    <th align="center">Date Added</th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  <?php while ($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td align="center">
              <?php if (!empty($record['photo'])): ?>
                <img src="image.php?type=project&id=<?php echo $record['id']; ?>&width=300&height=300&format=inside">
              <?php else: ?>
                      No Photo
              <?php endif; ?>
            </td>
            <td align="center"><?php echo $record['id']; ?></td>
            <td align="left">
                <?php echo htmlentities($record['title']); ?>
            </td>
            <td align="left">
                <?php echo htmlentities($record['content']); ?>
            </td>
            <td align="center"><?php echo htmlentities($record['type']); ?></td>
            <td align="center" style="white-space: nowrap;"><?php echo htmlentities($record['dateStart']); ?></td>
            <td align="center" style="white-space: nowrap;"><?php echo htmlentities($record['dateEnd']); ?></td>
            <td align="center"><?php echo htmlentities($record['timeStart']); ?></td>
            <td align="center"><?php echo htmlentities($record['timeEnd']); ?></td>
            <td align="center"><?php echo htmlentities($record['locationID']); ?></td>
            <td align="center">
                <?php if (!empty($record['eventLink'])): ?>
                    <a href="<?php echo htmlentities($record['eventLink']); ?>" target="_blank">Link</a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
            <td align="center"><?php echo htmlentities($record['dateAdded']); ?></td>
            <td align="center"><a href="events_photo.php?id=<?php echo $record['id']; ?>">Photo</a></td>
            <td align="center"><a href="events_edit.php?id=<?php echo $record['id']; ?>">Edit</a></td>
            <td align="center">
                <a href="events.php?delete=<?php echo $record['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<p><a href="events_add.php"><i class="fas fa-plus-square"></i> Add Event</a></p>


<?php

include( 'includes/footer.php' );

?>