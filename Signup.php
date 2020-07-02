<?php
require 'connect.php';

if (isset($_POST['password2'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password2'];
    
    $usernameExists = $pdo->prepare("SELECT * FROM users WHERE username=?;");
    $usernameExists->execute([$username]);

    $emailExists = $pdo->prepare("SELECT * FROM users WHERE email=?;");
    $emailExists->execute([$email]);

    if ($password !== $passwordRepeat) {
        header("location: ".$_SERVER['PHP_SELF']."?error=Passwords don't match");
        return;
    }

    if($usernameExists->rowCount() != 0) {
        header("location: ".$_SERVER['PHP_SELF']."?error=Username already exists");
        return;
    }

    if($emailExists->rowCount() != 0){ 
        header("location: ".$_SERVER['PHP_SELF']."?error=Email already exists");
        return;
    }
    

    $hashedPwd = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->execute([$username, $hashedPwd, $email]);
    $_SESSION['user'] = $username;
    header('location: /lorcards/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legends Of Runeterra Cards | Register</title>
    <link rel="stylesheet" href="design/default.css">
</head>
<body>
    <div class="topbar">
        <div class="titleCard"></div>

        <div class="all button">
            <a href="index.php">ALL CARDS</a>
        </div>

        <?php if(isset($_SESSION['user'])) { ?>
            <div class="login button">
                <a href="logout.php">LOGOUT</a>
            </div>
            <div class="register button">
                <a href="profile.php?user=<?=$_SESSION['user']?>">PROFILE</a>
            </div>
        <?php } else {?>
            <div class="login button">
                <a href="login.php">LOGIN</a>
            </div>

            <div class="register button active">
                <a href="signup.php">REGISTER</a>
            </div>
        <?php } ?>
    </div>
    <div class="form">
        <div class="title">REGISTER</div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="error"><?=$_GET ? $_GET['error'] : ""?></div>
            <input type="text" required name="username" placeholder="Username..."/>
            <input type="email" required name="email" placeholder="example@example.com"/>
            <input type="password" required name="password" placeholder="Password..."/>
            <input type="password" required name="password2" placeholder="Repeat password..."/>

            <input type="submit" value="REGISTER"/>
        </form>
    </div>
</body>
</html>

