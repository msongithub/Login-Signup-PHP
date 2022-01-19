<?php
include "partials/db.php";
session_start();

if (isset($_SESSION["user_email"])) {  // If user loggedin ,it'll be redirected to welcome page
    header("location: welcome.php");
}
$showError = false; // Error for wrong credentials initialized false
$userExistsError = false; // Error if user not exists initialized false
$inActiveUser = false; // Error if user is active or not initialized false
if (isset($_POST['login_user'])) {
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']); // posting form input 
    $user_pass = md5($_POST['user_pass']); // posting form input 
    // checking whether user with given email exists or not 
    $checkUser = "SELECT  `user_email`, `user_status` FROM `user_registration` WHERE `user_email`='{$user_email}'";
    $userResult = mysqli_query($conn, $checkUser);
    // $userResult = mysqli_query(mysqli_connect("localhost", "root", " ", "bst"), $checkUser);
    $numExistRows = mysqli_num_rows($userResult);
    if ($numExistRows > 0) { // checking number of rows

        // if yes than it'll fetch active status of that email address
        $checkUserStatus = "SELECT `user_status` FROM `user_registration` WHERE `user_email`='{$user_email}'";
        $userStatusResult = mysqli_query($conn, $checkUserStatus);
        if (mysqli_num_rows($userStatusResult) > 0) {
            while ($row = mysqli_fetch_assoc($userStatusResult)) {
                $check_User_Status = $row['user_status']; // fetched active status of user
            }
        }
        if ($check_User_Status == 1) { // checking if given email's active status is equal to 1 or not
            // if yes it will hit this block of code and call some data to store in session
            $sql = "SELECT `first_name`, `last_name`, `user_email`, `user_status` FROM `user_registration` WHERE `user_email`='{$user_email}' AND `user_password`='{$user_pass}' AND `user_status`='1'";

            $result = mysqli_query($conn, $sql) or die("Query Failed");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    session_start();
                    $_SESSION["user_email"] = $row['user_email']; // User's Email Address
                    $_SESSION["first_name"] = $row['first_name']; // User's First Name
                    $_SESSION["last_name"] = $row['last_name']; // User's Last Name
                    $_SESSION["user_status"] = $row['user_status']; // User's Active Status (Optional)

                    header('location: welcome.php'); // changing headers to move user from index/login page to welcome page
                }
            } else { // if credentials are wrong/mismatch than it'll throw this statement
                $showError = '<strong>Warning!</strong> Please enter valid credentials.';
            }
        } else { // if not it'll throw this statement
            $inActiveUser = "Sorry Can't Login now ) ;";
        }
    } else { // if not it'll throw an error stating this statement
        $userExistsError = "User Not Registered: Click register button below to register";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="partials/style.css">
    <title>PHP login System</title>
</head>

<body>
    <div class="login-form">
        <h1>Login</h1>
        <h4><?php echo $showError; ?></h4>
        <h4><?php echo $userExistsError; ?></h4>
        <h4><?php echo $inActiveUser; ?></h4>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <p>Enter Your Email</p>
            <input type="email" name="user_email" placeholder="Enter Your Email" required>
            <p>Enter Your Password</p>
            <input type="password" name="user_pass" placeholder="Enter Password" required>
            <input type="submit" value="Login" name="login_user" id="login_submit"> <a href="register.php" id="register_page">Register Now</a>
        </form>
    </div>
</body>

</html>