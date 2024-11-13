<?php

$connect = mysqli_connect( 
    'localhost', 
    'root', 
    'root', //write your password
    'eventcms' // write your database name
);
if(!$connect){
    echo "Connection Failed: " . mysqli_connect_error();
  }
mysqli_set_charset( $connect, 'UTF8' );
