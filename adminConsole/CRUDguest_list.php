<?php 

$conn = new mysqli("localhost", "root", "", "poornimaevents") OR die("Error: ".mysqli_error($conn));

session_start();

//code to save user's data 
if(isset($_POST['save'])) {
    if(!empty($_POST['guestName']) && !empty($_POST['collegeName']) && !empty($_POST['guestContact']) && !empty($_POST['guestEmail']) && !empty($_POST['eventName'])) {
        
        $guestName = $_POST['guestName'];
        $collegeName = $_POST['collegeName'];
        $guestContact = $_POST['guestContact'];
        $guestEmail = $_POST['guestEmail'];
        $eventName = $_POST['eventName'];
        

        $iQuery = "INSERT INTO guests (guestName, collegeName, guestContact, guestEmail, eventName) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($iQuery);
        $stmt->bind_param("ssiss", $guestName, $collegeName, $guestContact, $guestEmail, $eventName);
        if(!$stmt->execute()) {
            $_SESSION['msg'] = "New record is successfully inserted";
            $_SESSION['alert'] = "alert alert-success";
        }
        $stmt->close();
        $conn->close();
    }
    else {
        $_SESSION['msg'] = "All fields must be filled properly.";
        $_SESSION['alert'] = "alert alert-warning";
    }
}
?>
