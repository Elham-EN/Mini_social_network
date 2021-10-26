<?php
    //create tables if it does not exit
    function create_database_tables($conn) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else { //else connected to the databse
            //Create Table friends 
            $query = "CREATE TABLE IF NOT EXISTS friends (
                friend_id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                friend_email varchar(50) NOT NULL,
                password varchar(20) NOT NULL,
                profile_name varchar(30) NOT NULL,
                date_started date NOT NULL,
                num_of_friends int(10) UNSIGNED NOT NULL
                );";
            mysqli_query($conn, $query);
            //Create Table myfriends
            $query = "CREATE TABLE IF NOT EXISTS myfriends (
                friend_id1 int(10) NOT NULL, 
                friend_id2 int(10) NOT NULL,
                FOREIGN KEY (friend_id1) REFERENCES friends(friend_id),
                FOREIGN KEY (friend_id2) REFERENCES friends(friend_id)
                );";
            mysqli_query($conn, $query);
        }
    }

    //Check to see if any of these tables have values
    function if_table_contain_value($conn) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else { //connected to the database
            $query = "SELECT * FROM myfriends";
            $result = mysqli_query($conn, $query);
            if ($result) {
                if (mysqli_num_rows($result) == 0) { //if myfriends table has no record/row
                    add_record_to_friends_table($conn);
                    add_record_to_myfriends_table($conn);
                    update_number_of_friends($conn); 
                    echo "<p>Tables successfully created and populated.</p>";                
                } else { //both table have records/data
                    echo "<p>Table 'friends' already populated</p>";
                    echo "<p>Table 'myfriends' already populated</p>";                   
                }
            }
        }
    }

    //Add records to friends table
    function add_record_to_friends_table($conn) {
        $current_date = date("Y/m/d");
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            for ($i = 0; $i < 20; $i++) { //populate with 20 users
                $profile_name = random_generator_name();
                $email = random_genrator_email();
                $password = random_generator_password();
                
                $query = "INSERT INTO friends 
                (friend_email, password, profile_name, date_started) 
                VALUES ('" . $email . "', '" . $password . "', '" . $profile_name . "', '" . $current_date . "')";
                mysqli_query($conn, $query);
            }
        }
    }

    //Add records to myfriends table
    function add_record_to_myfriends_table($conn) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $my_id = 1;

            for ($j=0; $j < get_total_friends_from_friends_table($conn); $j++) {
                $array_my_friends = array();
                $my_friends_totals = rand(1,12); //random number from 1 to 12

                for ($i=0; $i < $my_friends_totals; $i++) {
                    $my_friend_id = rand(1, get_total_friends_from_friends_table($conn));
                    
                    if ($my_id != $my_friend_id) {
                        //add/push my_friend_id to the end of array_my_friends array
                        array_push($array_my_friends, $my_friend_id);
                    }
                }
                //Remove duplicate values from an array
                $array_my_friends = array_unique($array_my_friends);
                sort($array_my_friends);

                for ($i = 0; $i < count($array_my_friends); $i++) {
                    $query = "INSERT INTO myfriends VALUES ('" . $my_id . "', '" . $array_my_friends[$i] . "')";
                    mysqli_query($conn, $query);
                }
                $my_id++;
            }
        }
    }
    
    //update number of friends from the myfriends table to the frineds table
    function update_number_of_friends($conn) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "UPDATE friends SET num_of_friends = (SELECT COUNT(*) FROM myfriends WHERE friend_id1 = friends.friend_id)";
            mysqli_query($conn, $query);
        }   
    }

    //Get total friends from the friends table
    function get_total_friends_from_friends_table($conn) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "SELECT friend_id FROM friends";
            $result = mysqli_query($conn, $query);
            if ($result){
                $total_records = mysqli_num_rows($result);
                mysqli_free_result($result);
                return $total_records; //return number of friends from the friends table
            }
        }
    } 

    //generate Profile Name using random function and return 1 firstname and 1 lastname
    function random_generator_name(){
        $fNames = ["Adam", "Austin", "Bart", "Ben", "Billy", "Blaze", "Cal", "David", "Edward", "Fred", 
            "Frank", "George", "Hank", "John", "Jack", "Joe", "Larry", "Monte", "Matthew", "Mark", "Nathan", 
            "Otto", "Paul", "Peter", "Roger", "Roger", "Steve", "Thomas", "Tim", "Ty", "Victor", "Walter", 
            "Clay", "Cody", "Flint"];
        $lNames = ["Anderson", "Buck", "Bo", "Boyd", "Casey" , "Carson", "Denver", "Ebner", "Frick", "Ali", "Hancock", "Han", 
            "Haworth", "Hoffman", "Muhammad", "Kassing", "Knutson", "Lawless", "Lawicki", "Mccord", "McCormack", "Miller", "Solo", 
            "Myers", "Nugent", "Ortiz", "Orwig", "Ory", "Paiser", "Pak", "Pettigrew", "Quinn", "Reyes", "Schmitt", "Charles", 
            "Schwager", "Thompson", "Murad" , "Abdul", "Kasim", "Yamato", "Lee", "Misuki", "Masada", "Liam", "Wayne", "Willaim"];
        $randFName = rand(0, count($fNames)-1); //index start at 0 
        $randLName = rand(0, count($lNames)-1);
        return "$fNames[$randFName] $lNames[$randLName]";
    }

    //Generate random email
    function random_genrator_email() {
        $at_email = ["@gmail", "@hotmail", "@yahoo"];
        $profile_names = random_generator_name();
        $at_email_temp = rand(0, count($at_email)-1);
        $temp = substr($profile_names, 0, 1);
        $temp_name = explode(" ", "$profile_names");
        $email = strtolower($temp.$temp_name[1]);
        $email = "$email$at_email[$at_email_temp].com";
        return $email;
    }

    //Generate random password
    function random_generator_password() {
        $random_number = rand(8, 20);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $pass = array();
        $length = strlen($chars) - 1;
        for ($i = 0; $i < $random_number; $i++) {
            $length_number = rand(0, $length);
            $pass[] = $chars[$length_number];
        }
        return implode($pass);
    }

    //Clean user input
    function sanitise_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //if there are any duplicate email 
    function duplicate_email($conn, $user_email_input) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "SELECT friend_email FROM friends";
            $result = mysqli_query($conn, $query);
            //Loop until noting left to fetch from the table
            while ($row = mysqli_fetch_assoc($result)) {
                //If user input match email from the databse then return true
                if ($row['friend_email'] == $user_email_input) {
                    return true;
                }
            }
            return false;
        }
    }

    //see if the provided login credentials exist inside the friends table
    function login_info_in_DB($conn, $user_email_login, $user_pass_login) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "SELECT * FROM friends";
            $result = mysqli_query($conn, $query);

            if (empty($result)) { // if result does not contain mysqli_result object
                echo "<p>Could not fetch the requested query</p>";
            } else { //otherwise result contain the mysqli_result object (records from friends table)
                //Loop as long as there are data to fetch from the friends table
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row["friend_email"] == $user_email_login && $row["password"] == $user_pass_login) {
                        $_session['profile_name'] = $row['profile_name'];
                        $_session['num_of_friends'] = $row['num_of_friends'];
                        return true;
                    } 
                }
                return false;
            }
        }
    }

    //Display the current user's friends list
    function display_friends_list($conn, $off_set, $number_of_page) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "SELECT * FROM friends ORDER BY profile_name ASC";
            $result = mysqli_query($conn, $query);

            if (!$result) { // if result does not contain mysqli_result object
                echo "<p>Could not fetch the requested query</p>";
            } else {
                get_current_session_user_id($conn);
                while ($row = mysqli_fetch_assoc($result)) {
                    $friend_id = $row['friend_id'];
                    $friend_profile_name = $row['profile_name'];

                    //pagination uisng limit 
                    $query_search = "SELECT * FROM myfriends WHERE friend_id1 = '".$_SESSION['friend_id']."' LIMIT 
                        $off_set, $number_of_page";
                    $result_search = mysqli_query($conn, $query_search);

                    while ($row = mysqli_fetch_assoc($result_search)) {
                        $my_friend_id_2 = $row['friend_id2'];
                        if ($my_friend_id_2 == $friend_id) {
                            echo "
                            <tr>
                                <td>
                                    <p> $friend_profile_name </p>
                                </td>
                                <td>
                                    <input type='submit' name='FRIEND_".$friend_id."' value='unfriend'>
                                </td>
                            </tr>
                            ";
                        }  
                    }
                }
                mysqli_free_result($result);
                mysqli_free_result($result_search);
                remove_friend_from_friendlist($conn);
            }
        }
    }

    function remove_friend_from_friendlist($conn) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "SELECT * FROM myfriends WHERE friend_id1 = '".$_SESSION['friend_id']."'";
            $result = mysqli_query($conn, $query);
            
            if (!$result) { // if result does not contain mysqli_result object
                echo "<p>Could not fetch the requested query</p>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $my_friend_id2 = $row['friend_id2'];
                    /*set the buttons to FRND_(their id) and called removeFriend to get functions*/
                    echo((isset($_POST["FRIEND_$my_friend_id2"]))? remove_friend_operation($conn, $my_friend_id2): "");
                }
                mysqli_free_result($result);
                mysqli_close($conn);
            }
        }
    }
    //Remove friend from the friend list when unfriend button clicked
    function remove_friend_operation($conn, $friend_user_id) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "DELETE FROM myfriends WHERE friend_id1 = ".$_SESSION['friend_id']." AND friend_id2 = $friend_user_id";
            $result = mysqli_query($conn, $query);

            if (!$result) { // if result does not contain mysqli_result object
                echo "<p>Could not fetch the requested query</p>";
            } else {
                $_SESSION['num_of_friends']--;
                $query = "UPDATE friends SET num_of_friends = '".$_SESSION['num_of_friends']."' WHERE friend_id  = '".$_SESSION['friend_id']."'";
                $result = mysqli_query($conn, $query);

                $query = "SELECT profile_name FROM friends WHERE friend_id  = '$friend_user_id'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>" . $row['profile_name'] . " is no longer in your friend list</p><br>
                        You must refresh your page to see the updates";
                }
            }
        }
    }

    function get_current_session_user_id($conn) {
        $query = "SELECT * FROM friends ORDER BY profile_name ASC";
        $result = mysqli_query($conn, $query);

        if (!$result) { // if result does not contain mysqli_result object
            echo "<p>Could not fetch the requested query</p>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($_SESSION['profile_name'] == $row['profile_name']) {
                    $_SESSION['friend_id'] = $row['friend_id'];
                }
            }
        }
    }

    function display_registered_users($conn, $off_set, $number_of_page) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            get_current_session_user_id($conn);
            
            $query = "SELECT friend_id, profile_name FROM friends 
            WHERE friend_id NOT IN (SELECT friend_id2 FROM myfriends where friend_id1=".$_SESSION['friend_id'].")  AND friend_id != ".$_SESSION['friend_id']."
            GROUP BY profile_name ASC LIMIT $off_set, $number_of_page"; 
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Could not fetch the requested query</p>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $friend_id = $row['friend_id'];
                    $friend_profile_name = $row['profile_name'];
                    echo "
                        <tr>
                            <td>
                                <p>$friend_profile_name</p>
                            </td>
                            <td>
                                <input type='submit' name='FRIEND_".$friend_id."' value='Add Friend'>
                            </td>
                        </tr>
                    ";
                }
                mysqli_free_result($result);
                add_friend($conn);
            }
        } 
    }

    function add_friend($conn) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "SELECT * FROM friends WHERE friend_id != '".$_SESSION['friend_id']."'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Could not fetch the requested query</p>";
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $friend_id = $row['friend_id'];
                    echo ((isset($_POST["FRIEND_$friend_id"]))? add_friend_operation($conn, $friend_id): "");
                }
                mysqli_free_result($result);
                mysqli_close($conn);
            }
        }
    }

    function add_friend_operation($conn, $friend_id) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            get_current_session_user_id($conn);
            $query = "INSERT INTO myfriends VALUES(".$_SESSION['friend_id'].", $friend_id)";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Could not fetch the requested query</p>";
            } else {
                $_SESSION['num_of_friends']++;
                $query = "UPDATE friends SET num_of_friends = '".$_SESSION['num_of_friends']."' WHERE friend_id = '".$_SESSION['friend_id']."'";
                $result = mysqli_query($conn, $query);

                $query = "SELECT profile_name FROM friends WHERE friend_id  = '$friend_id'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $message = "<p>Now ". $row['profile_name'] . " is added to your friend list</p>";
                }
                header("Location: friendadd.php?Message=".$message);
            }
        }
    }

    function get_total_user($conn) {
        $query = "SELECT COUNT(*) total FROM friends";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<p>Could not fetch the requested query</p>";
        } else {
            $row = mysqli_fetch_assoc($result);
            return $row['total'];
        }
    }

    function get_current_login_session($conn, $user_login_pass, $_user_login_email) {
        if (!$conn) { //if not connected to the database
            die("Could not connect to the Mercury Database Server" . mysqli_connect_error($conn));
        } else {
            $query = "SELECT * FROM friends WHERE password = '". $user_login_pass ."' AND 
                friend_email = '" . $_user_login_email . "'";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "<p>Could not fetch the requested query</p>";
            } else {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['profile_name'] = $row['profile_name'];
                $_SESSION['num_of_friends'] = $row['num_of_friends'];
            }
        }
    }
?>