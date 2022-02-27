<?php 


$guestName = $_POST['guestName'];
$collegeName = $_POST['collegeName'];
$guestContact = $_POST['guestContact'];
$guestEmail = $_POST['guestEmail'];
$eventName = $_POST['eventName'];
$errors = array();
$success = array();

    if(!empty($guestName) || !empty($collegeName) || !empty($guestContact) || !empty($guestEmail) || !empty($eventName)) {
        //create a connection with the database
        $conn = new mysqli("localhost","root","","poornimaevents");
        
        if(mysqli_connect_error()) {
            die('Connection Error: '.mysqli_connect_error());
        } else {

            if(strlen($guestContact) > 10 || strlen($guestContact) < 10) {
                array_push($errors, "Invalid Phone Number");
            }
            $SELECT = "SELECT guestEmail FROM guests WHERE guestEmail = ? LIMIT 1";
            $INSERT = "INSERT INTO guests(guestName, collegeName, guestContact, guestEmail, eventName)
                              VALUES (?, ?, ?, ?, ?)";

                //Prepare statement 
                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param('s',$guestEmail);
                $stmt->execute();
                $stmt->bind_result($guestEmail);
                $stmt->store_result();
                $rnum = $stmt->num_rows;

                if($rnum==0) {
                    $stmt->close();

                    $stmt = $conn->prepare($INSERT);
                    $stmt->bind_param("ssiss", $guestName, $collegeName, $guestContact, $guestEmail, $eventName);
                    $stmt->execute();
                    //Set Refresh header using PHP.
                    
                    //Print out some content for example purposes.
                    array_push($success, "Your details are successfully registered. Please be patient You,ll be redirected to Home Page.");
                    header("refresh:3; url = ../index.html");
                } else {
                    array_push($errors, "This Guest is already registered. Please be patient You,ll be redirected to Register Page.");
                    header("refresh:3; url = ../register.html");
                }
                $stmt->close();
                $conn->close();
        }

    } else {
        array_push($errors, "All Fields are Required. Please check once again. Please be patient You,ll be redirected to Register Page.");
        header("refresh:3; url = ../register.html");
        die();
    }


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/yourcode.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="../css/main.css">
    <title>Exception Handling</title>
</head>
<body>
    <div class="alert alert-danger container my-5">
    <?php     
        $length = count($errors);
        for ($i = 0; $i < $length; $i++) {
        print $errors[$i];
        }; ?>
    </div>
    <div class="alert alert-success container my-5">
    <?php     
        $length = count($success);
        for ($i = 0; $i < $length; $i++) {
        print $success[$i];
        }; ?>
    </div>
</body>
</html>
