<?php
include 'partials/db.php';
$showError = false;
$showAlert = false;
$userError = false;
$emailError=false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
    $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
    $user_email = mysqli_real_escape_string($conn, $_POST["user_email"]);
    $user_pass = md5($_POST["user_pass"]);
    $user_rpass = md5($_POST["user_rpass"]);
if(filter_var($user_email, FILTER_VALIDATE_EMAIL)){
    $emailError="don't be smart";
}
    if (empty($first_name) && empty($last_name) && empty($user_email) && empty($user_pass) && empty($user_rpass)) {
        $userError = "One or more fields are empty don't be oversmart &#128514; !!";
    } else {

        // Check whether username already exists or not..
        $checkUser = "SELECT * FROM `user_registration` WHERE `user_email`='$user_email'";
        $userResult = mysqli_query($conn, $checkUser);
        $numExistRows = mysqli_num_rows($userResult);
        if ($numExistRows > 0) {
            $showError = "User already Exists";
        } else {
            if ($user_pass == $user_rpass) {
                $sql = "INSERT INTO `user_registration` (`first_name`, `last_name`, `user_email`, `user_password`, `user_status` ) VALUES ('$first_name', '$last_name', '$user_email', '$user_pass', '1')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $showAlert = "User Successfully registered !! Click <a href='index.php'>here</a> to login now. ";
                }
            }
        }
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
    <title>BST login System</title>
</head>

<body>
    <div class="signup-form">
        <h1>User Registration</h1>
        <h4><?php echo $showError; ?></h4>
        <h3><?php echo $showAlert; ?></h3>
        <h4 id="smart-error"><?php echo $userError; ?></h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <p>Enter Your First Name</p>
            <input type="text" name="first_name" placeholder="Enter Your First Name" required>
            <p>Enter Your Last Name</p>
            <input type="text" name="last_name" placeholder="Enter Your Last Name" required>
            <p>Enter Your Email</p>
            <input type="email" name="user_email" placeholder="Enter Your Email" required>
            <span><?php echo $emailError; ?></span>
            <p>Enter Your Password</p>
            <input type="password" name="user_pass" placeholder="Enter Password" required>
            <p>Re-Enter Your Password</p>
            <input type="password" name="user_rpass" placeholder="Re-Enter Password" required>
            <input type="submit" value="Register" name="register_user" id="signup_submit"> <a href="index.php" id="login_page">Login
                Now</a>
        </form>
        <!-- <h3>Already have account? </h3><a href="index.php">Login Now</a> -->
    </div>
</body>

</html>