<?php
// Model
require_once './models/tasks.php';

$task = getTask($_GET['id']);

// Controller
if (!$task) {
    require_once 'page404.php';
}

$alert = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleted = deleteTask($_GET['id']);
    if ($deleted) {
        http_response_code(302);
        header('Location: /tasks.php');
    } else {
        $alert = "Tâche non trouvée";
    }
}

// View
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Suppression de la tâche #<?= $_GET['id'] ?></h1>
    <?php if (($deleted ?? false) === false): ?>
        <h3>Êtes-vous sûr de vouloir supprimer <?= $task['title'] ?></h3>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $task['id'] ?>"/>
            <input name="action" type="submit" value="Delete"/>
        </form>
    <?php endif; ?>
    <?php if ($alert): ?>
        <span style="color: green;"><?=  $alert ?></span>
    <?php endif; ?>
</body>
</html>