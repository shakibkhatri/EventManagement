<?php

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'poornimaevents');

// REGISTER USER
if (isset($_POST['deleteEvent'])) {
    $event_name = $_POST['event_name'];

    if($event_name == 'select') {
        echo 'Please enter the event name to be deleted';
    }
    else {

        $user_check_query = "SELECT event_name FROM events WHERE event_name='$event_name' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $event = mysqli_fetch_assoc($result);
        
        if($event) {
            if($event['event_name'] === $event_name) {
                mysqli_query($db, "DELETE FROM events WHERE event_name = '$event_name'");
                echo 'deleted success';
            }
            else {
                echo 'delete error';
            }
        }
    }
    header("Location: event_list.php");
}
?>