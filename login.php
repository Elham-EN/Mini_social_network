
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
                        <p>Password</p>
                    </td>
                    <td>
                        <p>
                            <input type="email" name="user_email" 
                                value="<?php echo isset($_POST["user_email"]) ? $_POST["user_email"] : ''; ?>">
                        </p>
                        <p>
                            <input type="password" name="user_password">
                        </p>
                    </td>
                </tr>
            </table>
            <input type="submit" name="post_form" value="Log in">
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
 

    if (isset($_POST['user_email'])) {
        $my_email = sanitise_input($_POST['user_email']);
    }

    if (isset($_POST['user_password'])) {
        $my_password = sanitise_input($_POST['user_password']);
    }

    if (isset($_POST['post_form'])) {
        include_once('functions/settings.php');
        //Check if the provided login credential is found inside the database
        if (login_info_in_DB($conn, $my_email, $my_password)) {
            $_SESSION['login'] = "success";
            get_current_login_session($conn, $my_password, $my_email); 
            header("Location: friendlist.php");  
        } else {
            echo "<p class=\"err-msg\">Your login attempt was not successful. Please try again.</p>";
        }
    }
?>