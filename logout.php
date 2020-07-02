<?php 
    require 'connect.php';
    
    unset($_SESSION['user']);
    header('location: /lorcards/');
?>