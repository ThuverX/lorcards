<?php
require 'connect.php';

if (isset($_POST['password'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?;");
    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($stmt->rowCount() == 0) {
        header("location: ".$_SERVER['PHP_SELF']."?error=No account found");
        return;
    }

    if(password_verify($password,$result['password'])) {
        $_SESSION['user'] = $username;
        header('location: /lorcards/');
        return;
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legends Of Runeterra Cards | Login</title>
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
            <div class="login button active">
                <a href="login.php">LOGIN</a>
            </div>

            <div class="register button">
                <a href="signup.php">REGISTER</a>
            </div>
        <?php } ?>
    </div>
    <div class="form">
    <div class="title">LOGIN</div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="error"><?=$_GET ? $_GET['error'] : ""?></div>
            <input type="text" required name="username" placeholder="Username..."/>
            <input type="password" required name="password" placeholder="Password..."/>

            <input type="submit" value="LOGIN"/>
        </form>
    </div>
</body>
</html>