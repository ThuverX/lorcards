<?php
if (isset($_POST['signup-submit'])) {
    
    require 'connect.php';

    $username = $_POST[''];
    $email = $_POST[''];
    $password = $_POST[''];
    $passwordRepeat = $_POST[''];
    
    if ($password !== $passwordRepeat) {
        echo "password does not equal repeat password"
        return
    }
    else {
        $hashedPwd = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $hashedPwd, 'email' => $email]);
        $_SESSION['user'] = $username;
        header('location: localhost/lorcards/');
    }


}
?>