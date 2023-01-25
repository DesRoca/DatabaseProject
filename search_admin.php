<?php
    include 'dbconfig.php';

    //Connection to DB
    $connection = mysqli_connect($db_server, $db_login, $db_pass, $db_name)
        or die('Connection to DB unsuccessful');

    $search_query = $_GET['search_box'];

    //Query that needs to be ran
    $querytorun = "";

    if($search_query == "*"){
        $querytorun = "Select * from TECH3740.Admin";
    }
    else{
        $querytorun = "Select * from TECH3740.Admin where Address like '%$search_query%'";
    }

    //Run the query and store the result
    $query_result = mysqli_query($connection, $querytorun);


    //Check if the stored variable holds result
    if($query_result){

        //Check if the returned rows are greater than 0
        if(mysqli_num_rows($query_result) > 0){

            //# of rows
            $numofadmins = mysqli_num_rows($query_result);

            //Print Table
            echo "There are <b>$numofadmins</b> admin(s) in the database with keyword <b>$search_query</b>.";
            echo "<table\n>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Password</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Join Date</th>
                        <th>Gender</th>
                        <th>Address</th>
                    </tr>";
            
            //Loop through each row and print the results in the table
            while($eachrow = mysqli_fetch_array($query_result)){
                
                //Grab information from each row
                $ID = $eachrow['aid'];
                $Login = $eachrow['login'];
                $Password = $eachrow['password'];
                $Name = $eachrow['name'];
                $DOB = $eachrow['dob'];
                $Join_Date = $eachrow['join_date'];
                $Gender = $eachrow['gender'];
                $Address = $eachrow['Address'];

                echo "<tr>
                        <td>$ID</td>
                        <td>$Login</td>
                        <td>$Password</td>
                        <td>$Name</td>";
                if($DOB == NULL){
                    echo "  <td style='color:red;'>NULL</td>";
                    echo "  <td style='color:blue;'>$Join_Date</td>";
                }
                elseif($Join_Date < $DOB){
                    echo "  <td style='color:red;'>$DOB</td>";
                    echo "  <td style='color:red;'>$Join_Date</td>";

                }
                else{
                    echo "  <td style='color:blue;'>$DOB</td>";
                    echo "  <td style='color:blue;'>$Join_Date</td>";
                }

                echo "  <td>$Gender</td>
                        <td>$Address</td>
                    </tr>";
            }

            echo "</table>";
        }
        else{
            //If no results then print this
            echo "No records in the database for the keyword <b>$search_query</b>";
            mysqli_free_result($query_result);
        }
    }
    else{
        //If no result then print this
        echo "No records in the database for the keyword <b>$search_query</b>";
        mysqli_free_result($query_result);
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		Search Admins
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>