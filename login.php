<?php
if (isset($_POST['login-submit'])) {

    require 'connect.php';
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)){
        header('location: localhost/lorcards/?error=Field empty');
        exit();
    }
    else {
        $sql = "SELECT * FROM users WHERE username=?;";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(['username' => $username]);
        echo $result;
    }
    
}
else {
    header('location: lorcards/');
    exit();
}
?>