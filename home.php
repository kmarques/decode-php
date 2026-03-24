<?php

session_start();

$hasVisited = isset($_SESSION['visited']);
$isConnected = isset($_SESSION['user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['email'] === 'admin' && $_POST['password'] === "Azerty1234!") {
        $_SESSION['user'] = [
            "username" => 'JeanDupond'
        ];
        $isConnected = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <?php if ($hasVisited) : ?>
            Welcome back
            <?php endif; ?>
            <h1><?=  $isConnected ? $_SESSION['user']['username'] : "Please login" ?></h1>

            <?php if (!$isConnected): ?>
                <form method="POST" action="">
                    <input type="text" name="email">
                    <input type="password" name="password">
                    <input type="submit" value="Se connecter">
                </form>
            <?php else: ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
    </body>
</html>

<?php
    $_SESSION['visited'] = true;
?>