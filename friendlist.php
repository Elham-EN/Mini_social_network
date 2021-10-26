<?php
   include("functions/header.php");
   include("functions/functions.php");

    if(!isset($_SESSION['login'])){
        header("Location: index.php");
        exit();
    }

    //if pageNum doesn't exist, set var pageNum as a GET method
    //else set it as 1
    if(isset($_GET['page_number'])){
        $page_number = $_GET['page_number'];
    }else{
        $page_number = 1;
    }

    require_once("functions/settings.php");
    $number_friend_per_page = 5;
    $off_set = ($page_number - 1) * $number_friend_per_page;
    $total_friends = $_SESSION['num_of_friends'];
    //round totalPage as a whole number
    $total_page = ceil($total_friends / $number_friend_per_page);

?>


    <h2 class="homepage-header">
        Total number of friends is <?php echo $_SESSION['num_of_friends']; ?>
    </h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <table class="friendList">
            <?php
                require_once("functions/settings.php");
                display_friends_list($conn, $off_set, $number_friend_per_page);
            ?>
            </table>
        </form>
    <?php
        if($total_friends > 5){
            if($page_number < 2){
                echo "<a class='button' href='?page_number=".($page_number+1)."'> Next </a>";
            }elseif($page_number > $total_page-1){
                echo "<a class='button' href='?page_number=".($page_number-1)."'> Prev </a>";
            }else{
                echo "<a class='button' href='?page_number=".($page_number-1)."'> Prev </a>";
                echo "<a class='button' href='?page_number=".($page_number+1)."'> Next </a>";
            }
        }
            echo '
            <div class="friend_list_link">
                <p class="menu"><a href="friendadd.php">Add Friend</a></p> &nbsp;&nbsp;   
                <p class="menu"><a href="logout.php">Log out</a></p>
            </div>
            '; 
    ?>
    </body>
</html>