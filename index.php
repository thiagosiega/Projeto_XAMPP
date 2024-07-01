<?php

session_start();
if (isset($_SESSION['ID'])) {
    echo '<script>alert("Você já está logado")</script>';
}else{
    header('Location: Home/Login.php');
}

?>