<?php 
require 'connect.php';

if(!isset($_GET['user'])) header('location: /lorcards/');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legends Of Runeterra Cards | <?=$_GET?$_GET['user']:""?>'s profile</title>
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

            <div class="register button">
                <a href="signup.php">REGISTER</a>
            </div>
        <?php } ?>
    </div>
    <div class="cardList" id="cardlist">
        <div class="region"><?=$_GET?$_GET['user']:""?>'s Wishlist</div>
    </div>
</body>
<?php

    $userStmt = $pdo->prepare("SELECT id FROM users WHERE username=?;");
    $userStmt->execute([$_GET['user']]);
    $userResult = $userStmt->fetch(PDO::FETCH_ASSOC);

    if($userStmt->rowCount() == 0) {
        header('location: /lorcards/');
    }

    $id = $userResult['id'];
    
    $cardListStmt = $pdo->prepare("SELECT * FROM wishlist WHERE ownerid=?;");
    $cardListStmt->execute([$id]);

    $cardList = $cardListStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<script>
    let cardlist = document.getElementById("cardlist");

    let userData = <?=json_encode($cardList)?>

    function cards_ready() {
        for(let i = 0; i < userData.length;i++){
            let card = cards.find(x => x.cardCode == userData[i].cardid)
            if(card) {
                let el = document.createElement('div')
                el.className = "card"
                el.style.backgroundImage = `url(${card.assets[0].gameAbsolutePath})`

                el.onclick = () => addOrRemoveCard(card.cardCode,true)

                cardlist.appendChild(el)
            }

        }
    }

</script>
<script src="main.js"></script>
</html>