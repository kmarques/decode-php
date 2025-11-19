<?php
// Model
$tasks = [["author" => "dupond", "title" => "dormir", "completed" => true], ["author" => "durand", "title" => "manger", "completed" => true], ["author" => "durand", "title" => "manger", "completed" => false], ["author" => "doe", "title" => "manger", "completed" => false]];

// Controller
$isCompleted = $_GET['completed'] === "all" ? null : filter_var($_GET['completed'], FILTER_VALIDATE_BOOL);
$filterOwner = trim($_GET['author']);

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
                <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>"><?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?> - <?= $task['author'] ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
    <h3>Add task</h3>
        <form method="POST">
            <input name="title"/>
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
        <span>Author: <?= $_POST['author'] ?>
        <span>Title: <?= $_POST['title'] ?>
        <span>Completed: <?= $_POST['completed'] ?>
</body>
</html>