<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_POST['locationName'] ) )
{
  
  if( $_POST['locationName'] and $_POST['address'] )
  {
    
    $query = 'INSERT INTO location (
        locationName,
        address,
        gMapLink
       
      ) VALUES (
        "'.mysqli_real_escape_string( $connect, $_POST['LocationName'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['address'] ).'",
        "'.mysqli_real_escape_string( $connect, $_POST['gMapLink'] ).'"
      )';
    mysqli_query( $connect, $query );
    
    set_message( 'User has been added' );
    
  }

  /*
  // Example of debugging a query
  print_r($_POST);
  print_r($query);
  die();
  */

  header( 'Location: users.php' );
  die();
  
}

include( 'includes/header.php' );

?>

<h2>Add User</h2>

<form method="post">
  
  <label for="first">First Name:</label>
  <input type="text" name="first" id="first">
  
  <br>
  
  <label for="last">Last Name:</label>
  <input type="text" name="last" id="last">
  
  <br>
  
  <label for="email">Email:</label>
  <input type="email" name="email" id="email">
  
  <br>
  
  <label for="password">Password:</label>
  <input type="password" name="password" id="password">
  
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

<p><a href="users.php"><i class="fas fa-arrow-circle-left"></i> Return to Location List</a></p>


<?php

include( 'includes/footer.php' );

?>