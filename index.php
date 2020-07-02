<?php 
require 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legends Of Runeterra Cards</title>
    <link rel="stylesheet" href="design/default.css">
</head>
<body>
    <div class="topbar">
        <div class="titleCard"></div>

        <div class="all button active">
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
    </div>
</body>
<script>
    cards_ready = () => {
        let cardlist = document.getElementById("cardlist");
        for(let i = 0; i < cards.length;i++){
            let el = document.createElement('div')
                el.className = "card"
                el.style.backgroundImage = `url(${cards[i].assets[0].gameAbsolutePath})`

                el.onclick = () => addOrRemoveCard(cards[i].cardCode)

            if(!cards[i - 1] || cards[i-1].regionRef != cards[i].regionRef) {
                let refEl = document.createElement('div')
                    refEl.className = "region"
                    refEl.innerText = cards[i].region

                cardlist.appendChild(refEl)
            }

            cardlist.appendChild(el)
        }
    }
</script>
<script src="main.js"></script>
</html>