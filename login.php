<?php
    include 'dbconfig.php';

    //Connection to DB
    $connection = mysqli_connect($db_server, $db_login, $db_pass, $db_name)
        or die('Connection to DB unsuccessful');

    $username = "";
    $password = "";
    //Credential Info
    if(isset($_POST['login'])){
        $username = mysqli_real_escape_string($connection,$_POST['username_box']);
        $password = mysqli_real_escape_string($connection,$_POST['password_box']);
    }
    else{
        if(isset($_COOKIE['username'])){
            $username = $_COOKIE['username'];
            $passquery = "Select * from TECH3740.Admin where login = '$username'";
            $passqueryresult = mysqli_query($connection, $passquery);
            if(mysqli_num_rows($passqueryresult) > 0){
                $passrow = mysqli_fetch_array($passqueryresult);
                $password = $passrow['password'];
            }
            else{
                header("Location: ./logout.php");
            }
        }
        else{
            header("Location: ./index.php");
        }
    }

    //Query that needs to be ran
    $querytorun = "Select * from TECH3740.Admin where login = '$username'";

    //Run the query and store the result
    $query_result = mysqli_query($connection, $querytorun);


    //Check if the stored variable holds result
    if($query_result){

        //Check if the returned rows are greater than 0
        if(mysqli_num_rows($query_result) > 0){

            //# of rows
            $querytorun = "Select * from TECH3740.Admin where login = '$username' and password = '$password'";
            $query_result = mysqli_query($connection, $querytorun);
            $numofadmins = mysqli_num_rows($query_result);

            if($numofadmins > 0){
                $passrow = mysqli_fetch_array($query_result);
                $serverpass = $passrow["password"];
                if($password == $serverpass){

                    //Create cookie if it doesn't exist
                    if(!isset($_COOKIE['username'])){
                        setcookie('username', $username, time() + 86400);
                    }
                    
                    //IP Address
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    echo "Your IP: $ip_address <br>";
                    $split_ip = explode(".", $ip_address);
                    if($split_ip[0] == "10" || $split_ip[0] == "131"){
                        echo "You are from Kean University <br>";
                    }
                    else{
                        echo "You are NOT from Kean University <br>";
                    }

                    echo "<a href='./logout.php'>Logout</a><br><br>";

                    $Name = $passrow['name'];
                    $DOB = $passrow['dob'];
                    $Join_Date = $passrow['join_date'];
                    $Gender = $passrow['gender'];
                    $Address = $passrow['Address'];

                    echo "Welcome user: $Name <br>";
                    echo "DOB: $DOB <br>";
                    echo "Address: $Address <br>";
                    echo "Gender: $Gender <br>";

                    date_default_timezone_set('America/New_York');
                    $current_date = date("Y-m-d");
                    $age = floor((strtotime($current_date) - strtotime($DOB))/(365*60*60*24));
                    echo "Age: $age <br>";
                    echo "Join Date: $Join_Date <br>";

                    echo "<br><a href='./add_course.php'>Add Course</a><br>";
                    echo "Search course (ID or Name)";
                    echo "
                        <form action='search_course.php' method='post'>
                            <input type='text' name='search_box' required=''>
                            <button name='search'>Search</button>
                        </form>
                    ";
                }
                else{
                    echo "User <b>$username</b> is in the system, but wrong password was entered.";
                    mysqli_free_result($query_result);
                }
            }
            else{
                echo "User <b>$username</b> is in the system, but wrong password was entered.";
                mysqli_free_result($query_result);
            }
        }
        else{
            //If no results then print this
            echo "Login <b>$username</b> is not in the system.";
            mysqli_free_result($query_result);
        }
    }
    else{
        //If no result then print this
        echo "Login <b>$username</b> is not in the system.";
        mysqli_free_result($query_result);
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		View Admins
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>