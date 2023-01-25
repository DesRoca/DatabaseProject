<?php
    if(!isset($_COOKIE["username"])){
        echo "Please login first!";
        exit();
    }

    include 'dbconfig.php';

    //Connection to DB
    $connection = mysqli_connect($db_server, $db_login, $db_pass, $db_name)
        or die('Connection to DB unsuccessful');

    $username = $_COOKIE['username'];
    $course_id = $_POST['course_id_box'];
    $course_name = $_POST['course_name_box'];
    $input_spring = "";
    $input_term = "";
    if(isset($_POST['spring'])){
        $input_spring = $_POST['spring'];
        $input_term = $input_term . $input_spring . ",";
    }
    $input_fall = "";
    if(isset($_POST['fall'])){
        $input_fall = $_POST['fall'];
        $input_term = $input_term . $input_fall . ",";
    }
    $input_summer = "";
    if(isset($_POST['summer'])){
        $input_summer = $_POST['summer'];
        $input_term = $input_term . $input_summer . ",";
    }
    $input_term = substr($input_term, 0, strlen($input_term)-1);

    $input_enrollment = $_POST['course_enrollment'];

    if($_POST['faculty'] == "empty"){
        echo "Please choose a faculty!";
        exit();
    }
    $input_faculty = $_POST['faculty'];

    if($_POST['room'] == "empty"){
        echo "Please choose a room!";
        exit();
    }
    $input_room = $_POST['room'];

    $querytorun = "Select * from TECH3740.Rooms where Rid = $input_room";
        
    //Run the query and store the result
    $query_result = mysqli_query($connection, $querytorun);

    $room_size = 0;

    //Check if the stored variable holds result
    if($query_result){

        //Check if the returned rows are greater than 0
        if(mysqli_num_rows($query_result) > 0){
            $eachrow = mysqli_fetch_array($query_result);
            $room_size = $eachrow['Size'];
        }
    }

    if($input_spring != "spring" && $input_fall != "fall" && $input_summer != "summer"){
        echo "Choose a term!";
        exit();
    }
    if($input_enrollment < 0){
        echo "Course enrollment must be above 0!";
        exit();
    }
    if($input_enrollment > $room_size){
        echo "Course enrollment must be less than room size!";
        exit();
    }

    $querytorun = "Select * from TECH3740_2021F.Courses_rocad where cid = '$course_id'";
        
    //Run the query and store the result
    $query_result = mysqli_query($connection, $querytorun);

    $room_size = 0;

    //Check if the stored variable holds result
    if($query_result){
        //Check if the returned rows are greater than 0
        if(mysqli_num_rows($query_result) > 0){
            echo "Cannot have the same course ID.";
            exit();
        }
    }

    $querytorun = "Select * from TECH3740.Admin where login = '$username'";
        
    //Run the query and store the result
    $query_result = mysqli_query($connection, $querytorun);

    $room_size = 0;

    $aid = "";

    //Check if the stored variable holds result
    if($query_result){
        //Check if the returned rows are greater than 0
        if(mysqli_num_rows($query_result) > 0){
            $eachrow = mysqli_fetch_array($query_result);
            $aid = $eachrow['aid'];
        }
    }


    $querytorun =  "Insert into TECH3740_2021F.Courses_rocad 
            (cid, name, term, enrollment, Fid, Rid, aid)
            VALUES ('$course_id', '$course_name', '$input_term', $input_enrollment, $input_faculty, $input_room, $aid)";
    if(mysqli_query($connection, $querytorun)){
        echo "Course $course_name has been added successfully";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		Insert Course
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>