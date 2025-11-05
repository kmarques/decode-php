<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP1</title>
</head>
<body>
    <h1>TP1</h1>
    <h2>Exo 1</h2>
    <p>Aﬃcher une liste de tâches contenus dans un tableau simple</p>
    <?php $tasks = ["dormir", "manger", 'travailler']; ?>
    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li><?= $task ?></li>
        <?php endforeach; ?>
    </ul>
    <span>Version full php</span>
    <ul>
    <?php
    $tasks = ["dormir", "manger", 'travailler'];
    foreach ($tasks as $task) {
        echo "<li>{$task}</li>";
    }
    ?>
    </ul>
    <h2>Exo 2</h2>
    <p>Aﬃcher une liste de tâches ainsi que son statut completed (bool) contenus dans un tableau associatif</p>
    <?php //$tasks = ["dormir" => true, "manger" => false];?>
    <?php $tasks = [["title" => "dormir", "completed" => true], ["title" => "manger", "completed" => false]]; ?>
    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>"><?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?></li>
        <?php endforeach; ?>
    </ul>
    <h2>Exo 3</h2>
    <p>Selon la valeur de la variable isCompleted (bool), aﬃcher une liste de tâches ainsi que son statut
completed contenus dans un tableau associatif uniquement si son statut vaut la variable isCompleted</p>
    <?php
    $isCompleted = true;
    ?>
    <span>Version isCompleted true</span>
    <ul>
        <?php foreach ($tasks as $task) : ?>
            <?php if ($task['completed'] !== $isCompleted) {
                continue;
            } ?>
            <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>"><?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?></li>
            <?php endforeach; ?>
        </ul>
        <?php
    $isCompleted = false;
    ?>
    <span>Version isCompleted false</span>
    <ul>
        <?php foreach ($tasks as $task) : ?>
            <?php if ($task['completed'] !== $isCompleted) {
                continue;
            } ?>
            <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>"><?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?></li>
        <?php endforeach; ?>
    </ul>
    <span>Version php++</span>
    <?php $tasksFiltered = array_filter($tasks, fn ($task) => $task['completed'] === $isCompleted); ?>
    <ul>
        <?php foreach ($tasksFiltered as $task) : ?>
            <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>"><?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>