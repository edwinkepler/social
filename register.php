<?php
    require("config/config.php");
    require("includes/form_handlers/register_handler.php");
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
