<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_POST['locationName'] ) )
{
  
  if( $_POST['locationName'] and $_POST['address'] and $_POST['gMapLink'])
  {
    
    $query = 'INSERT INTO location (
        locationName,
        address,
        gMapLink
       
      ) VALUES (
        "'.mysqli_real_escape_string( $connect, $_POST['locationName'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['address'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['gMapLink'] ).'"
      )';
    mysqli_query( $connect, $query );
    
    set_message( 'Location has been added' );
    
  }

  /*
  // Example of debugging a query
  print_r($_POST);
  print_r($query);
  die();
  */

  header( 'Location: locations.php' );
  die();
  
}

include( 'includes/header.php' );

?>

<h2>Add Location</h2>

<form method="post">
  
  <label for="location">Location:</label>
  <input type="text" name="locationName" id="locationName">
  
  <br>
  
  <label for="address">Address:</label>
  <input type="text" name="address" id="address">
  
  <br>
  
  <label for="map">Map:</label>
  <input type="text" name="gMapLink" id="gMapLink">
  <br>
  
  <label for="active">Active:</label>
  <?php
  
  $values = array( 'Yes', 'No' );
  
  echo '<select name="active" id="active">';
  foreach( $values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  
  ?>
  
  <br>
  
  <input type="submit" value="Add Location">
  
</form>

<p><a href="locations.php"><i class="fas fa-arrow-circle-left"></i> Return to Location List</a></p>


<?php

include( 'includes/footer.php' );

?>