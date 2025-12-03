<?php
// Model
$tasks = [["id" => "1", "author" => "dupond", "title" => "dormir", "completed" => true], ["id" => "2", "author" => "durand", "title" => "manger", "completed" => true], ["id" => "3", "author" => "durand", "title" => "manger", "completed" => false], ["id" => "4", "author" => "doe", "title" => "manger", "completed" => false]];
$_GET["completed"] ??= "all";
$_GET["author"] ??= "";


// Controller
$isCompleted = $_GET['completed'] === "all" ? null : filter_var($_GET['completed'], FILTER_VALIDATE_BOOL);
$filterOwner = trim($_GET['author']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'Create':
            $_POST['id'] = uniqid();
            $tasks[] = $_POST;
            //ou
            // array_push($tasks, $_POST);
            break;
        case 'Delete':
            // $tasks = array_filter($tasks, function ($task) {
            //     return $task['id'] !== $_POST['id'];
            // });
            foreach ($tasks as $index => $task) {
                if ($task['id'] === $_POST['id']) {
                    $found = true;
                    break;
                }
            }
            if (($found ?? false) !== false) {
                unset($tasks[$index]);
            }
            break;
        case 'Edit':
            // $tasks = array_map(function ($task) {
            //     if ($task['id'] === $_POST['id']) {
            //         return $_POST;
            //     } else {
            //         return $task;
            //     }
            // }, $tasks);
            foreach ($tasks as $index => $task) {
                if ($task['id'] === $_POST['id']) {
                    $tasks[$index] = $_POST;
                    break;
                }
            }
    }
}

$tasksFiltered = array_filter($tasks, function ($task) use ($isCompleted, $filterOwner) {
    return
        // Test isCompleted
        (
            // Vrai si isCompleted === null => Aucune filtre sur completed
            $isCompleted === null
            // Ou Vrai si isCompleted vaut le status de la tâche
            || $task['completed'] === $isCompleted
        )
        // Test author : Vrai si author commence par filterOwner
        && str_starts_with($task['author'], $filterOwner);

    /**
     * if ($isCompleted !== null && $task['completed'] !== $isCompleted) {
     *     return false;
     * }
     *
     * if (!str_starts_with($task['author'], $filterOwner)) {
     *    return false;
     * }
     *
     * return true;
     */
});


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
    <h1>Liste des tâches</h1>
    <?php if (count($tasks) === 0): ?>
        Aucune tâche créée
    <?php else :?>
        <h3>Filtres</h3>
        <form>
            <span>Completed ?</span>
            <label>
                All
                <input
                    name="completed"
                    type="radio"
                    value="all"
                    <?= $_GET['completed'] === 'all' ? 'checked' : '' ?>
                />
            </label>
            <label>Not Completed <input name="completed" type="radio" value="false" <?= $_GET['completed'] === 'false' ? 'checked' : '' ?>/></label>
            <label>Completed <input name="completed" type="radio" value="true" <?= $_GET['completed'] === 'true' ? 'checked' : '' ?>/></label>
            <br/>
            <span>Author</span>
            <input name="author" type="text" value="<?= $filterOwner ?>"/>
            <br/>
            <input type="submit" value="Search"/>
        </form>
        <br/>
        <?php if (count($tasksFiltered) === 0) : ?>
            Aucune tâche correspondant aux critères
        <?php else : ?>
            <ul>
            <?php foreach ($tasksFiltered as $task) : ?>
                <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>">
                    <?= $task['id'] ?> - <?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?> - <?= $task['author'] ?>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $task['id'] ?>"/>
                        <input name="action" type="submit" value="Delete"/>
                    </form>
                </li>
                <li>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $task['id'] ?>"/>
                        <span>Titre</span><input name="title" value="<?= $task['title'] ?>"/>
                        <span>Completed ?</span>
                        <label>Not Completed <input name="completed" type="radio" value="false" <?=  $task['completed'] ? 'checked' : '' ?> /></label>
                        <label>Completed <input name="completed" type="radio" value="true" <?=  $task['completed'] ? 'checked' : '' ?> /></label>
                        <br/>
                        <span>Author</span>
                        <input name="author" type="text" value="<?= $task['author'] ?>"/>
                        <br/>
                        <input name="action" type="submit" value="Edit"/>
                    </form>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
    <h3>Add task</h3>
        <form method="POST">
            <span>Titre</span><input name="title"/>
            <span>Completed ?</span>
            <label>Not Completed <input name="completed" type="radio" value="false" /></label>
            <label>Completed <input name="completed" type="radio" value="true" /></label>
            <br/>
            <span>Author</span>
            <input name="author" type="text"/>
            <br/>
            <input name="action" type="submit" value="Create"/>
        </form>
</body>
</html>