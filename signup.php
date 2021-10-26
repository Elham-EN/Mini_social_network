
<?php
    include("functions/header.php");
    include("functions/functions.php");
?>
    <main class="signup-main">
        <!--$_SERVER"PHP_SELF" sends the submitted form data to the page itself,-->
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table>
                <tr>
                    <td>
                        <p>Email</p>
                        <p>Profile Name</p>
                        <p>Password</p>
                        <p>Confirm Password</p>
                    </td>
                    <td>
                        <p>
                            <input type="email" name="user_email" 
                                value="<?php echo isset($_POST["user_email"]) ? $_POST["user_email"] : ''; ?>">
                        </p>
                        <p>
                            <input type="text" name="user_profile_name" 
                                value="<?php echo isset($_POST["user_profile_name"]) ? $_POST["user_profile_name"] : ''; ?>">
                        </p>
                        <p>
                            <input type="password" name="user_password">
                        </p>
                        <p>
                            <input type="password" name="user_confirm_password">
                        </p>
                    </td>
                </tr>
            </table>
            <input type="submit" name="post_form" value="Register">
            <input type="reset" name="reset_Form" value="Clear">
            
        </form>
        <?php
            echo '
                <div class="signup-link">
                    <p class="menu"><a href="index.php">Home</a></p>   
                </div>
            ';
        ?>
    </main>
</body>
</html>

<?php
    $form_validated = true;
    //Return clean input 
    if(isset($_POST['user_email'])) { //check if variable is declred and not null
        $my_email = sanitise_input($_POST['user_email']);
    }
    if(isset($_POST['user_profile_name'])) {
        $my_profile_name = sanitise_input($_POST['user_profile_name']);
    }
    if(isset($_POST['user_password'])) {
        $my_password = sanitise_input($_POST['user_password']);
    }
    if(isset($_POST['user_confirm_password'])) {
        $my_confirm_password = sanitise_input($_POST['user_confirm_password']);
    }

    if (isset($_POST['post_form'])) { //if form is submitted
        require_once('functions/settings.php');

        //Validating email form input
        if ($my_email == "") { //if email input is empty
            echo "<p class=\"err-msg\" >Email input is require</p>";
            $form_validated = false;
        } else if (duplicate_email($conn, $my_email)) { //check if this email input already exit
            echo "<p class=\"err-msg\" >This email " . $my_email . " already exist</p>";
            $form_validated = false;
        }
        if (strlen($my_email) > 50) { //check if email length exceed it's specified size
            echo "<p class=\"err-msg\" >Email characters length cannot be greater than 50 characters</p>";
            $form_validated = false;
        }
        
        //Validating profile name form input
        $regex_exp_name = "/^([A-Za-z][\s]*){1,20}$/";
        if ($my_profile_name == "") {
            echo "<p class=\"err-msg\" >Profile name input is require</p>";
            $form_validated = false;
        // if it does not match the regular expression
        } else if (!preg_match($regex_exp_name, $my_profile_name)) {
            if (strlen($my_profile_name) > 30) { //if name exceed than it's specified length 
                echo "<p class=\"err-msg\" >Profile name length cannot be greater than 50 characters</p>";
                $form_validated = false;
            } else {
                echo "<p class=\"err-msg\" >Profile name input cannot have non-alpha characters</p>";
                $form_validated = false;
            }
        }

        //Validating password form input
        $regex_exp_password = "/^(\w*){1,20}$/"; //match only alphanumeric characters
        if ($my_password == "") {
            echo "<p class=\"err-msg\" >Password input is require</p>";
            $form_validated = false;
        } else if (!preg_match($regex_exp_password, $my_password)) {
            if (strlen($my_password) > 20) {
                echo "<p class=\"err-msg\" >Password must not be greater than 20 characters</p>";
                $form_validated = false;
            } else {
                echo "<p class=\"err-msg\" >Password cannot have non-alphanumeric characters </p>";
                $form_validated = false;
            }
        }

        //Check if password does not matched with confirm password. IF password & confirm_password
        //match then it return 0 which is false in if statement and not execute the code block. 
        //Otherwise if matched, then it will return a number greater than 0, which is true
        if (strcmp($my_password, $my_confirm_password)) {
            echo "<p class=\"err-msg\" >Password do not match. Please try again </p>";
            $form_validated = false;
        }

        if ($form_validated == true) { //if all form inputs are valid 
            require_once('functions/settings.php');
            $current_date = date("Y/m/d");
            if ($conn) { //If connected to the database server
                $query = "INSERT INTO friends (friend_email, password, profile_name, date_started) 
                VALUES ('" . $my_email ."', '" . $my_password . "', '". $my_profile_name ."', '" . $current_date . "')";
                $user_inserted = mysqli_query($conn, $query); //add to friends table

                if ($user_inserted) {
                    $_SESSION['login'] = "success";
                    $_SESSION['profile_name'] = $my_profile_name;
                    $_SESSION['num_of_friends'] = 0;
                    header("Location: friendadd.php");
                } else {
                    echo "<p>Cannot fulfil your last request</p>";
                }
            }
            mysqli_close($conn);
        } 
    }
?>