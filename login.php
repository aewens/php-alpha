<?php

require_once "database.php";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if (DB::query("SELECT `username` FROM `users` WHERE username=:username", 
        array(":username" => $username))) {
            
        $dbpswd = DB::query("SELECT `password` FROM `users` WHERE 
            username=:username", 
            array(":username" => $username))[0]["password"];
            
        if (password_verify($password, $dbpswd)) {
            echo "Welcome, " . $username . "!";
        } else {
            echo "Error: Incorrect password";
        }
    } else {
        echo "Error: User is not registered";
    }
}

?>
<h1>Login to your account</h1>
<form action="login.php" method="post">
    <input type="text" name="username" value="" placeholder="Username...">
    <input type="password" name="password" value="" placeholder="Password...">
    <input type="submit" name="login" value="Login">
</form>
