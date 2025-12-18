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
    $updatedTask = updateTask(intval($_GET['id']), $_POST);
    if ($updatedTask !== null) {
        $alert = "Tâche mise à jour";
        $task = $updatedTask;
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
    <h1>Mise à jour de la tâche #<?= $_GET['id'] ?></h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $task['id'] ?>"/>
        <span>Titre</span><input name="title" value="<?= $task['title'] ?>"/>
        <span>Completed ?</span>
        <label>Not Completed <input name="completed" type="radio" value="false" <?=  $task['completed'] ? 'checked' : '' ?> /></label>
        <label>Completed <input name="completed" type="radio" value="true" <?=  $task['completed'] ? 'checked' : '' ?> /></label>
        <br/>
        <span>Author</span>
        <input name="authorid" type="text" value="<?= $task['authorid'] ?>"/>
        <br/>
        <input type="submit" value="Edit"/>
    </form>
    <?php if ($alert): ?>
        <span style="color: green;"><?=  $alert ?></span>
        <pre><?= print_r($updatedTask); ?></pre>
    <?php endif; ?>
</body>
</html>