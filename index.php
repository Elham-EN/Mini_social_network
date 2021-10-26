
<?php 
    include("functions/header.php");
    include("functions/functions.php");
?>

    <main class="homepage-main">
        <div class="homepage-intro">
            <div style="display: flex; justify-content: space-between;">
                <p style="flex-basis: 49.5%;">Name: Elham Najeebullah</p>
                <p style="flex-basis: 90.5%;">Student ID: 101571578</p>
            </div>
            <p>Email: <a href="mailto:101571578@student.swin.edu.au">101571578@student.swin.edu.au</a></p>
            <p class="homepage-declare">
                I declare that this assignment is my individual work. I have not worked collaboratively
                nor have I copied from any other student’s work or from any other source.
            </p>
        </div>
        <?php
            require_once('functions/settings.php');
            if ($conn) {
                require_once('functions/settings.php');
                create_database_tables($conn);
                if_table_contain_value($conn);
            } else {
                echo "<p>Not able to connect to the database, please check if you correct credential</p>";
            }
            mysqli_close($conn);
        ?>
        <?php
            echo '
            <div class="homepage-links">
                <p class="menu"><a href="signup.php">Sign-Up</a></p> 
                <p class="menu"><a href="login.php">Log-In</a></p> 
                <p class="menu"><a href="about.php">About</a></p>   
            </div>
            ';
        ?>
    </main>
</body>
</html>