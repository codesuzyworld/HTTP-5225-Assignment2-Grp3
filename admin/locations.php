<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM location
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
  
  set_message( 'Location has been deleted' );
  
  header( 'Location: locations.php' );
  die();
  
}

include( 'includes/header.php' );

$query = 'SELECT *
  FROM location 
  '.( ( $_SESSION['id'] != 1 and $_SESSION['id'] != 4 ) ? 'WHERE id = '.$_SESSION['id'].' ' : '' ).'
  ORDER BY locationName, address, gMapLink';
$result = mysqli_query( $connect, $query );

?>

<h2>Manage Locations</h2>

<table>
  <tr>
    <th align="center">ID</th>
    <th align="left">Location</th>
    <th align="left">Address</th>
    <th align="left">Map</th>
    <th></th>
    <th></th>
  </tr>
  <?php while( $record = mysqli_fetch_assoc( $result ) ): ?>
    <tr>
      <td align="center"><?php echo $record['id']; ?></td>
      <td align="left"><?php echo htmlentities( $record['locationName'] ); ?></td>
      <td align="left"><?php echo htmlentities( $record['address'] ); ?></td>
      <td align ="left"><a href="_blank"><?php echo htmlentities( $record['gMapLink'] ); ?></a></td>
      <td align="center"><a href="users_edit.php?id=<?php echo $record['id']; ?>">Edit</a></td>
      <td align="center"> <a href="locations.php?delete=<?php echo $record['id']; ?>" onclick="javascript:confirm('Are you sure you want to delete this location?');">Delete</a></td>
    </tr>
  <?php endwhile; ?>
</table>

<p><a href="locations_add.php"><i class="fas fa-plus-square"></i> Add Location</a></p>


<?php

include( 'includes/footer.php' );

?>