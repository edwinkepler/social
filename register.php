<?php
    session_start();

    $con = mysqli_connect("localhost", "root", "", "social");
    if(mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
    }

    $fname = "";
    $lname = "";
    $em = "";
    $em2 = "";
    $password = "";
    $password2 = "";
    $date = "";
    $error_array = array();

    if(isset($_POST["register_button"])) {
        $fname = strip_tags($_POST["reg_fname"]); // Remove html tags
        $fname = str_replace(" ", "", $fname); // Remove spaces
        $fname = ucfirst(strtolower($fname)); // Uppercase only first letter
        $_SESSION["req_fname"] = $fname; // Store first name into session variable

        $lname = strip_tags($_POST["reg_lname"]); // Remove html tags
        $lname = str_replace(" ", "", $lname); // Remove spaces
        $lname = ucfirst(strtolower($lname)); // Uppercase only first letter
        $_SESSION["req_lname"] = $lname; // Store last name into session variable

        $em = strip_tags($_POST["reg_email"]); // Remove html tags
        $em = str_replace(" ", "", $em); // Remove spaces
        $em = ucfirst(strtolower($em)); // Uppercase only first letter
        $_SESSION["req_em"] = $em; // Store email into session variable

        $em2 = strip_tags($_POST["reg_email2"]); // Remove html tags
        $em2 = str_replace(" ", "", $em2); // Remove spaces
        $em2 = ucfirst(strtolower($em2)); // Uppercase only first letter
        $_SESSION["req_em2"] = $em2; // Store first name into session variable

        $password = strip_tags($_POST["reg_password"]); // Remove html tags
        $password2 = strip_tags($_POST["reg_password2"]); // Remove html tags

        $date = date("Y-m-d"); // Current date

        if($em == $em2) {
            if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
                $em = filter_var($em, FILTER_VALIDATE_EMAIL);
                // Check if email already exist
                $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");
                // Count nymbers of rows returned
                $num_rows = mysqli_num_rows($e_check);
                if($num_rows > 0) {
                    array_push($error_array, "Email already in use<br>");
                }
            } else {
                array_push($error_array, "Invalid email format<br>");
            }
        } else {
            array_push($error_array, "Emails dont match<br>");
        }

        if(strlen($fname) > 25 || strlen($fname) < 2) {
            array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
        }

        if(strlen($lname) > 25 || strlen($lname) < 2) {
            array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
        }

        if($password != $password2) {
            array_push($error_array, "Your password do not match<br>");
        } else {
            if(preg_match("/[^A-Za-z0-9]/", $password)) {
                array_push($error_array, "Your password can only contain english characters or numbers<br>");
            }
        }

        if(strlen($password) > 30 || strlen($password) < 5) {
            array_push($error_array, "Your password must be between 5 and 30 characters<br>");
        }

        if(empty($error_array)) {
            $password = password_hash($password, PASSWORD_DEFAULT); // Encrypt password before sending to database

            // Generate username by concatinating first name and last name
            $username = strtolower($fname . "_" . $lname);
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

            $i = 0;
            while(mysqli_num_rows($check_username_query) != 0) {
                $i++;
                $new_username = $username . "_" . $i;
                $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$new_username'");
            }

            if($i > 0) {
                $username = $username . "_" . $i;
            }

            // Profile picture assignment
            $rand = rand(1, 2);
            if($rand == 1) {
                $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
            } elseif($rand == 2) {
                $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
            }

            $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

            array_push($error_array, "<span style='color: red'>You're all set. Go ahead and login</span>");

            // Clear session variables
            $_SESSION["req_fname"] = "";
            $_SESSION["req_lname"] = "";
            $_SESSION["req_em"] = "";
            $_SESSION["req_em2"] = "";
        }
    }
?>
<html>
<head>
    <title>Welcome to Swirlfeed</title>
</head>
<body>
    <form action="register.php" method="POST">
        <input type="text" name="reg_fname" placeholder="First name" 
        value="<?php if(isset($_SESSION['req_fname'])) { echo $_SESSION['req_fname']; } ?>" required>
        <br>
        <?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) { echo "Your first name must be between 2 and 25 characters<br>"; } ?>
        <input type="text" name="reg_lname" placeholder="Last name" 
        value="<?php if(isset($_SESSION['req_lname'])) { echo $_SESSION['req_lname']; } ?>" required>
        <br>
        <?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) { echo "Your last name must be between 2 and 25 characters<br>"; } ?>
        <input type="email" name="reg_email" placeholder="Email" 
        value="<?php if(isset($_SESSION['req_em'])) { echo $_SESSION['req_em']; } ?>" required>
        <br>
        <input type="email" name="reg_email2" placeholder="Confirm email" 
        value="<?php if(isset($_SESSION['req_em2'])) { echo $_SESSION['req_em2']; } ?>" required>
        <br>
        <?php 
            if(in_array("Email already in use<br>", $error_array)) { 
                echo "Email already in use<br>"; 
            } elseif(in_array("Invalid email format<br>", $error_array)) { 
                echo "Invalid email format<br>"; 
            } elseif(in_array("Emails dont match<br>", $error_array)) { 
                echo "Emails dont match<br>"; 
            }
        ?>
        <input type="password" name="reg_password" placeholder="Password" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm password" required>
        <br>
        <?php 
            if(in_array("Your password do not match<br>", $error_array)) { 
                echo "Your password do not match<br>"; 
            } elseif(in_array("Your password can only contain english characters or numbers<br>", $error_array)) { 
                echo "Your password can only contain english characters or numbers<br>"; 
            } elseif(in_array("Your password must be between 5 and 30 characters<br>", $error_array)) { 
                echo "Your password must be between 5 and 30 characters<br>"; 
            }
        ?>
        <input type="submit" name="register_button" value="Register">
        <br>
        <?php if(in_array("<span style='color: red'>You're all set. Go ahead and login</span>", $error_array)) { echo "<span style='color: red'>You're all set. Go ahead and login</span>"; } ?>
    </form>
</body>
</html>
