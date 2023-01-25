<?php 
    if(isset($_COOKIE["username"])){
        header("Location: ./login.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		Login
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

Welcome to Destiny Roca's TECH 3740 project!

<!-- Create a link to view all admins in the database -->
<ul>
  <li><a href="view_admin.php">View all admin</a></li>
</ul>

Enter a partial address to find admin
<br>
(* for listing all admin)

<!-- Create the Search Bar and Button -->
<form action="search_admin.php" method="get">
    <input type="text" name="search_box" required="">
    <button name = "search">Search</button>
</form>

<br>

<!-- Create the Username and Password inputs and Login button -->
<form action="login.php" method="post">
    <input type="text" name="username_box" placeholder="Username" required=""> <br>
    <input type="password" name="password_box" placeholder="Password" required=""> <br>
    <button name = "login">Login</button>
</form>


