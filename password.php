<?php

require_once "utils/database.php";
require_once "utils/login.php";

$isLoggedIn = Login::isLoggedIn();

if ($isLoggedIn) {
    if (isset($_POST["change"])) {
        $currentpass = $_POST["current"];
        $newpass = $_POST["newpass"];
        $rnewpass = $_POST["rnewpass"];
        
        $get_user = DB::query("SELECT `password` FROM `users` WHERE 
            id=:userid", 
            array(":userid" => $isLoggedIn));
        $dbpswd = $get_user[0]["password"];
            
        if (password_verify($currentpass, $dbpswd)) {
            if ($newpass == $rnewpass) {
                if (strlen($newpass) >= 8 && strlen($newpass) <= 256) {
                    DB::query("UPDATE `users` SET password=:newpass WHERE 
                        id=:userid", 
                        array(":userid" => $isLoggedIn,
                            ":newpass" => 
                                password_hash($newpass, PASSWORD_BCRYPT)));
                    echo "Success!";
                } else {
                    echo "Password is invalid";
                }
            } else {
                echo "Repeat does not match new password";
            }
        } else {
            echo "Incorrect old password!";
        }
    }
} else {
    die("Not logged in :(");
}

?>

<h1>Change Your Password</h1>
<form action="password.php" method="post">
    <input type="password" name="current" value="" placeholder="Current...">
    <input type="password" name="newpass" value="" placeholder="New...">
    <input type="password" name="rnewpass" value="" placeholder="Repeat...">
    <input type="submit" name="change" value="Change Password">
</form>
