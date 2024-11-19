<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( !isset( $_GET['id'] ) )
{
  
  header( 'Location: locations.php' );
  die();
  
}

if( isset( $_POST['locationName'] ) )
{
  
  if( $_POST['locationName'] and $_POST['address'] and $_POST['gMapLink'] )
  {
    
    $query = 'UPDATE location SET
      locationName= "'.mysqli_real_escape_string( $connect, $_POST['locationName'] ).'",
      address = "'.mysqli_real_escape_string( $connect, $_POST['address'] ).'",
      gMapLink = "'.mysqli_real_escape_string( $connect, $_POST['gMapLink'] ).'"
      WHERE id = '.$_GET['id'].'
      LIMIT 1';
    mysqli_query( $connect, $query );
    
    set_message( 'Location has been updated' );
    
  }

  header( 'Location: locations.php' );
  die();
  
}


if( isset( $_GET['id'] ) )
{
  
  $query = 'SELECT *
    FROM location
    WHERE id = '.$_GET['id'].'
    LIMIT 1';
  $result = mysqli_query( $connect, $query );
  
  if( !mysqli_num_rows( $result ) )
  {
    
    header( 'Location: locations.php' );
    die();
    
  }
  
  $record = mysqli_fetch_assoc( $result );
  
}

include( 'includes/header.php' );

?>

<h2>Edit Location</h2>

<form method="post">
  
  <label for="location">Location:</label>
  <input type="text" name="locationName" id="locationName" value="<?php echo htmlentities( $record['locationName'] ); ?>">
  
  <br>
  
  <label for="address">Address:</label>
  <input type="text" name="address" id="address" value="<?php echo htmlentities( $record['address'] ); ?>">
  
  <br>
  
  <label for="map">Map:</label>
  <input type="text" name="gMapLink" id="gMapLink" value="<?php echo htmlentities( $record['gMapLink'] ); ?>">
  
  <br>
  
  <input type="submit" value="Edit Location">
  
</form>

<p><a href="locations.php"><i class="fas fa-arrow-circle-left"></i> Return to Location List</a></p>


<?php

include( 'includes/footer.php' );

?>