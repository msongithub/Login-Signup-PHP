<?php
include 'partials/db.php'; // including database config
session_start(); // starting session

if (!isset($_SESSION["user_email"])) { // checking if user is loggedin or not
    header("location: index.php"); // if not he/she will be redirected to inex/login page | they can not access welcome page directly without login
}
$user_email = $_SESSION["user_email"]; // fetching eamil stored in current session

// fetching first name of user whose mail is stored in the session
$sql = "SELECT `first_name`FROM `user_registration` WHERE `user_email`='{$user_email}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $first_name = $row['first_name']; // fetched user's first name
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Welcoming User</title>
</head>

<body>
    <div class="user-container">
        <h1>Hello User :
            <i><?php echo $first_name; ?></i>
        </h1>
        <br>

        <h3>Click here to <a href="logout.php">Logout</a> from this page : </h3>
    </div>
</body>

</html>