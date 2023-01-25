<?php
    if(!isset($_COOKIE["username"])){
        echo "Please login first!";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		Add Course
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <a href="./logout.php">Logout</a>
    <form action="insert_course.php" method="post">
        <input type="text" name="course_id_box" placeholder="Course ID" required="">(ex. CPS1231)<br>
        <input type="text" name="course_name_box" placeholder="Course Name" required=""><br>

        Term: <input type="checkbox" id="spring" name="spring" value="spring">
        <label for="spring">Spring</label>
        <input type="checkbox" id="fall" name="fall" value="fall">
        <label for="fall">Fall</label>
        <input type="checkbox" id="summer" name="summer" value="summer">
        <label for="summer">Summer</label><br>

        <input type="text" name="course_enrollment" placeholder="Enrollment" required="">(# of Registered Students)<br>

        <?php
            include 'dbconfig.php';

            //Connection to DB
            $connection = mysqli_connect($db_server, $db_login, $db_pass, $db_name)
                or die('Connection to DB unsuccessful');
        
            //Query that needs to be ran
            $querytorun = 'Select * from TECH3740.Faculty';
        
            //Run the query and store the result
            $query_result = mysqli_query($connection, $querytorun);
        
        
            //Check if the stored variable holds result
            if($query_result){
        
                //Check if the returned rows are greater than 0
                if(mysqli_num_rows($query_result) > 0){
                    
                    echo "Faculty: <select name='faculty'>";

                    echo "<option value='empty'></option>";
                    while($eachrow = mysqli_fetch_array($query_result)){
                        $fid = $eachrow['Fid'];
                        $Name = $eachrow['Name'];
                        echo "<option value='$fid'>$Name</option>";
                    }
                    echo "</select> <br>";
                }
            }

            $querytorun = 'Select * from TECH3740.Rooms';
        
            //Run the query and store the result
            $query_result = mysqli_query($connection, $querytorun);
        
        
            //Check if the stored variable holds result
            if($query_result){
        
                //Check if the returned rows are greater than 0
                if(mysqli_num_rows($query_result) > 0){
                    
                    echo "Room: <select name='room'>";

                    echo "<option value='empty'></option>";
                    while($eachrow = mysqli_fetch_array($query_result)){
                        $rid = $eachrow['Rid'];
                        $building = $eachrow['Building'];
                        $size = $eachrow['Size'];
                        $number = $eachrow['Number'];
                        echo "<option value='$rid'>$building$number has $size seats</option>";
                    }
                    echo "</select><br>";
                }
            }

        ?>

        <button name = "submit">Submit</button>
    </form>
