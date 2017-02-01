<?php

require_once "database.php";

// DB::connect()

if (isset($_POST["create"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $rpassword = $_POST["rpassword"];
    $email = $_POST["email"];
    
    if ($password == $rpassword) {
        DB::query("INSERT INTO `users` VALUES (:id, :username, :password, :email)", 
            array(":id" => null, 
                ":username" => $username, 
                ":password" => $password, 
                ":email" => $email));
        
        echo "Success!";
    } else {
        echo "Error: Password does not match";
    }
}

?>

<h1>Register</h1>
<form action="account.php" method="post">
    <input type="text" name="username" value="<?php 
        if (isset($_POST["username"])) echo $_POST["username"];
    ?>" placeholder="Username..."><p \>
    <input type="password" name="password" value="<?php 
        if (isset($_POST["password"])) echo $_POST["password"];
    ?>" 
        placeholder="Password..."><p \>
    <input type="password" name="rpassword" value="<?php 
        if (isset($_POST["rpassword"])) echo $_POST["rpassword"];
    ?>" 
        placeholder="Repeat password..."><p \>
    <input type="email" name="email" value="<?php 
        if (isset($_POST["email"])) echo $_POST["email"];
    ?>" 
        placeholder="youremail@domain.com"><p \>
    <input type="submit" name="create" value="Create Account">
</form>
