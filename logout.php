<?php

require_once "utils/database.php";
require_once "utils/login.php";

$isLoggedIn = Login::isLoggedIn();

if (!$isLoggedIn) {
    die("Not logged in");
}

if (isset($_POST["logout"])) {
    if (isset($_POST["alldevices"])) {
        DB::query("DELETE FROM `login_tokens` WHERE user_id=:user_id", 
            array(":user_id" => $isLoggedIn));
    } else {
        if (isset($_COOKIE["SNID"])) {
            DB::query("DELETE FROM `login_tokens` WHERE token=:token", 
                array(":token" => sha1($_COOKIE["SNID"])));
                
            setcookie("SNID", "_", time() - 3600, "/", null, null, true);
            setcookie("SNID_", "_", time() - 3600, "/", null, null, true);
        }
    }
}

?>
<h1>Logout of your account</h1>
<p>Would you like to logout?</p>
<form action="logout.php" method="post">
    <input type="checkbox" name="alldevices" value="all">Logout of all devices?
    <br>
    <input type="submit" name="logout" value="Logout">
</form>
