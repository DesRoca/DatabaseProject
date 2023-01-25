<?php
    unset($_COOKIE["username"]);
    setcookie('username', '', time() - 86400);
    header('Location: ./index.php')
?>