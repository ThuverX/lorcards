<?php 

require 'connect.php';

if(isset($_GET['card']) && isset($_SESSION['user'])){

    $userStmt = $pdo->prepare("SELECT id FROM users WHERE username=?;");
    $userStmt->execute([$_SESSION['user']]);
    $userResult = $userStmt->fetch(PDO::FETCH_ASSOC);

    if($userStmt->rowCount() == 0) {
        echo "no user";
        return;
    }

    $id = $userResult['id'];

    $alreadyExistStmt = $pdo->prepare("SELECT * FROM wishlist WHERE cardid=? AND ownerid=?;");
    $alreadyExistStmt->execute([$_GET['card'],$id]);

    if($alreadyExistStmt->rowCount() != 0) {
        $setStmt = $pdo->prepare("DELETE FROM wishlist WHERE cardid=? AND ownerid=?;");
        $setStmt->execute([$_GET['card'],$id]);
        return;
    }


    $setStmt = $pdo->prepare("INSERT INTO wishlist (cardid,ownerid) VALUES (?,?)");
    $setStmt->execute([$_GET['card'],$id]);
    echo "worked";
} else {
    echo "ses";
}

?>