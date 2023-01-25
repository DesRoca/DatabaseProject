<?php
    if(!isset($_COOKIE["username"])){
        echo "Please login first!";
        exit();
    }

    include 'dbconfig.php';

    //Connection to DB
    $connection = mysqli_connect($db_server, $db_login, $db_pass, $db_name)
        or die('Connection to DB unsuccessful');

    $search_query = $_POST['search_box'];

    //Query that needs to be ran
    $querytorun = "";

    if($search_query == "*"){
        $querytorun = "Select * from TECH3740_2021F.Courses_rocad";
    }
    else{
        $querytorun = "Select * from TECH3740_2021F.Courses_rocad where cid like '%$search_query%' or name like '%$search_query%'";
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
            echo "The following course ID and name were matched the search keyword <b>$search_query</b>.";
            echo "<table\n>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Faculty Name</th>
                        <th>Term</th>
                        <th>Enrollment</th>
                        <th>Building Room</th>
                        <th>Size</th>
                        <th>Added by Admin</th>
                    </tr>";
            
            $total_enrollment = 0;
            //Loop through each row and print the results in the table
            while($eachrow = mysqli_fetch_array($query_result)){
                
                //Grab information from each row
                $course_id = $eachrow['cid'];
                $course_name = $eachrow['name'];
                $fid = (int)$eachrow['Fid'];
                $term = $eachrow['term'];
                $enrollment = $eachrow['enrollment'];
                $rid = (int)$eachrow['Rid'];
                $aid = (int)$eachrow['aid'];

                $total_enrollment = $total_enrollment + $enrollment;

                $faculty_name = "";
                $query = "Select * from TECH3740.Faculty where Fid = '$fid'";
                $result = mysqli_query($connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                    $faculty_name = $row['Name'];
                }

                $building_room = "";
                $size = "";
                $query = "Select * from TECH3740.Rooms where Rid = $rid";
                $result = mysqli_query($connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                    $building_room = $row['Building'] . " " . $row['Number'];
                    $size = $row['Size'];
                }

                $admin_name = "";
                $query = "Select * from TECH3740.Admin where aid = $aid";
                $result = mysqli_query($connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                    $admin_name = $row['name'];
                }

                echo "<tr>
                        <td>$course_id</td>
                        <td>$course_name</td>
                        <td>$faculty_name</td>
                        <td>$term</td>";

                if(((int)$size - (int)$enrollment) < 3){
                    echo "<td style='color:red;'>$enrollment</td>";
                }
                else{
                    echo "<td>$enrollment</td>";
                }
                echo "  <td>$building_room</td>
                        <td>$size</td>
                        <td>$admin_name</td>";

                echo "</tr>";
            }

            echo "</table>";

            echo "Total Enrollment: $total_enrollment";
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
		Search Courses
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>