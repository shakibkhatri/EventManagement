<?php

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'poornimaevents');

// REGISTER USER
if (isset($_POST['registerEvent'])) {
  // receive all input values from the form
  $event_name = mysqli_real_escape_string($db, $_POST['event_name']);
  $no_of_participents = mysqli_real_escape_string($db, $_POST['no_of_participents']);
  $price = mysqli_real_escape_string($db, $_POST['price']);
  $event_date = mysqli_real_escape_string($db, $_POST['event_date']);
  $event_time = mysqli_real_escape_string($db, $_POST['event_time']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if(empty($event_name) || empty($no_of_participents)  || empty($price)  || empty($event_date)  || empty($event_time) ) {
    echo 'make sure no fields are empty';
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT event_name FROM events WHERE event_name='$event_name' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $event = mysqli_fetch_assoc($result);
  
  if ($event) { // if user exists
    if ($event['event_name'] === $event_name) {
        echo 'Event Already Registered';
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    echo 'registered successfully';

  	$query = "INSERT INTO events (event_name, no_of_participents, price, event_date, event_time) 
  			  VALUES('$event_name', '$no_of_participents', '$price', '$event_date', '$event_time')";
  	mysqli_query($db, $query);
    header('location: event_list.php');
}
}
?>