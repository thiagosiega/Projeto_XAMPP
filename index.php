<?php

session_start();
if (isset($_SESSION['ID'])) {
    header('Location: Central/Home.php');
}else{
    header('Location: Home/Login.php');
}

?>