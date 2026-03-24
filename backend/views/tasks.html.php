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
            <input name="authorid" type="text" value="<?= $filterOwner ?>"/>
            <input name="title" type="text" value="" placeholder="title"/>
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
                    <a href="/delete-task.php?id=<?= $task['id'] ?>">Delete</a>
                    <a href="/edit-task.php?id=<?= $task['id'] ?>">Edit</a>
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
    <a href="/create-task.php">Créer une tâche</a>
</body>
</html>