<?php
    //Returns the current session status & equal to it's return 
    //value which is if sessions are enabled, but none exists.
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start new or resume existing session
    }

    //Returns the filename from a path from the current page
    $current_file_location = basename($_SERVER['PHP_SELF']); //e.g. header.php
    $current_file_location = str_replace('.php', '', $current_file_location); //e.g. header
    $current_file_location = ucfirst($current_file_location); //e.g. Header
    $head_title = $current_file_location;

    date_default_timezone_set('Australia/Melbourne');
    $current_date = date("Y/m/d");

    switch ($current_file_location) {
        case "Friendadd": 
            $current_file_location = $_SESSION['profile_name'] . "'s Add Friend Page";
            break;
        case "Friendlist":
            $current_file_location = $_SESSION['profile_name']."'s Friend List Page";
            break;
        case "Index":
            $current_file_location = "Assignment Home Page";
            break;
        case "Signup":
            $current_file_location = "Registration Page";
            break;
        case "Login":
            $current_file_location = "Log in Page";
            break;
        case "About":
            $current_file_location = "About Page";
            break;
        default: 
            $current_file_location = "Unknown Page";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="description" content="My Friend System Social network"/>
    <meta name="keywords" content="assignment 2, My Friend System, Social Network"/>
    <meta name="author" content="Elham 101571578"/>
    <link href="style.css" rel="stylesheet"/>
    <title><?php echo $head_title; ?></title>
</head>
<body>
    <!--Page Title and Navgation links-->
    <header class="homepage-header">
        <h1>My Friend System</h1>
        <h1><?php echo $current_file_location; ?></h1>
    </header>
