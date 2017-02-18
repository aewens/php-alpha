<?php

require_once "utils/database.php";

if (isset($_COOKIE["SNID"])) {
    $check_token = DB::query("SELECT `user_id` FROM `login_tokens` WHERE 
        token=:token", array(":token" => sha1($_COOKIE["SNID"])));
    
    if ($check_token) {
        header("Location: index.php");
    }
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if (DB::query("SELECT `username` FROM `users` WHERE 
        username=:username", array(":username" => $username))) {
        
        $get_user = DB::query("SELECT * FROM `users` WHERE 
            username=:username", 
            array(":username" => $username));
        $dbpswd = $get_user[0]["password"];
            
        if (password_verify($password, $dbpswd)) {
            echo "Welcome, " . $username . "!<br>";
            
            $cstrong = true;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $user_id = $get_user[0]["id"];
            
            DB::query("INSERT INTO `login_tokens` VALUES 
                (:id, :token, :user_id)",
                array(":id" => null,
                    ":token" => sha1($token),
                    ":user_id" => $user_id));
                    
            # 60 * 60 * 24 * 7 = 604800
            # 60 * 60 * 24 * 3 = 259200
            # name, content, expiration, where, domain, ssl, httponly
            setcookie("SNID", $token, time() + 604800, "/", null, null, true);
            setcookie("SNID_", "_", time() + 259200, "/", null, null, true);
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
