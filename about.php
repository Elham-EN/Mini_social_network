<?php include("functions/header.php");?>

<h2 style="padding-left: 10px;">
    What tasks you have not attempted or not completed?
</h2>
<p style="padding-left: 10px;">
    I have not done task 9 mutual frined count in 'add friend page'
</p>
<br><hr/>
<h2 style="padding-left: 10px;">
    What special features have you done, or attempted, in creating <br>
    the site that we should know about?
</h2>
<p style="padding-left: 10px;">
    <ul>
        <li>Reusable header.php file in every page</li>
        <li>functions.php handle majority of the backend operations </li>
        <li>used switch statement in header.php file to display the title of the<br>
            of the page when navigated</li>
    </ul>
</p>
<br><hr/>
<h2 style="padding-left: 10px;">
    Which parts did you have trouble with?
</h2>
<p style="padding-left: 10px;">
    It has to be task 9, which i did my best to get the mutual friend count <br>
    infomration but i had problem with the query and the logic behind it. 
</p>
<br><hr/>
<h2 style="padding-left: 10px;">
    What would you like to do better next time?
</h2>
<p style="padding-left: 10px;">
    I would like to use object oriend programming stlye which makes much easier like <br>
    resuability, becuase my current programming style is mixed of procedural and functional
    <br> and there are duplicate logic and implmentation. Using OOP will reduce this problem
</p>
<br><hr/>
<h2 style="padding-left: 10px;">
    What additional features did you add to the assignment? 
</h2>
<p style="padding-left: 10px;">
    used header() function to prevent form resubmission when friendadd page is refreshed
</p>
<br><hr/>
<h3>I have not participated on any of the discussion relavent questions to the 
    assignment</h3>
<?php
    echo '
    <div class="homepage-links">
            <a href="friendlist.php">Friends List (Must log in first)</a>
            <a href="friendadd.php">Add Friends (Must log in first)</a></li>
            <a href="index.php">Homepage</a>
        </div>
    ';
?>