<?php

require_once "utils/database.php";
require_once "utils/login.php";

$isLoggedIn = Login::isLoggedIn();

if ($isLoggedIn) {
    echo "Logged in<br>";
    echo $isLoggedIn;
} else {
    echo "Not logged in :(";
}
