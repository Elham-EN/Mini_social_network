<?php
    //Returns the current session status & equal to it's return 
    //value which is if sessions are enabled, but none exists.
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start new or resume existing session
        session_unset();
        session_destroy();
        header("location: index.php");
        exit();
    }
?>