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
    <h2>Exo 4/5</h2>
    <p>
        Afficher une liste de tâches ainsi que son statut completed et son auteur (string) contenus dans un tableau associatif<br/>
        Selon la valeur de la variable isCompleted et filterOwner (string), afficher une liste de tâches ainsi que son statut completed et son auteur contenus dans un tableau associatif uniquement si son statut vaut la variable isCompleted et son auteur commence par filterOwner
    </p>
    <?php
        $tasks = [["author" => "dupond", "title" => "dormir", "completed" => true], ["author" => "durand", "title" => "manger", "completed" => true], ["author" => "durand", "title" => "manger", "completed" => false], ["author" => "doe", "title" => "manger", "completed" => false]];
    $isCompleted = true;
    $filterOwner = trim("durand ");
    $tasksFiltered = array_filter($tasks, fn ($task) => $task['completed'] === $isCompleted && str_starts_with($task['author'], $filterOwner));
    ?>
    <?php foreach ($tasksFiltered as $task) : ?>
        <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>"><?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?> - <?= $task['author'] ?></li>
    <?php endforeach; ?>

    <h2>Exo 6/7</h2>
    <p>
        Si le tableau associatif est vide, afficher “Aucune tâche créée”
        <br/>
        Si après filtres aucun élément est affiché, alors afficher “Aucune tâche correspondant aux critères”
    </p>
    <?php
        $tasks = [["author" => "dupond", "title" => "dormir", "completed" => true], ["author" => "durand", "title" => "manger", "completed" => true], ["author" => "durand", "title" => "manger", "completed" => false], ["author" => "doe", "title" => "manger", "completed" => false]];
    $isCompleted = true;
    $filterOwner = trim("durand ");
    $tasksFiltered = array_filter($tasks, fn ($task) => $task['completed'] === $isCompleted && str_starts_with($task['author'], $filterOwner));
    ?>
    <?php if (count($tasks) === 0): ?>
        Aucune tâche créée
    <?php elseif (count($tasksFiltered) === 0) : ?>
        Aucune tâche correspondant aux critères
    <?php else : ?>
        <ul>
        <?php foreach ($tasksFiltered as $task) : ?>
            <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>"><?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?> - <?= $task['author'] ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <span>Version débutant</span>
    <?php
        $tasks = [["author" => "dupond", "title" => "dormir", "completed" => true], ["author" => "durand", "title" => "manger", "completed" => true], ["author" => "durand", "title" => "manger", "completed" => false], ["author" => "doe", "title" => "manger", "completed" => false]];
    $isCompleted = true;
    $filterOwner = trim("jean ");
    $found = false;
    ?>
    <?php if (count($tasks) === 0): ?>
        Aucune tâche créée
    <?php else :?>
        <ul>
        <?php foreach ($tasks as $task) : ?>
            <?php if (!($task['completed'] === $isCompleted && str_starts_with($task['author'], $filterOwner))) {
                continue;
            } else {
                $found = true;
            } ?>
            <li style="text-decoration: <?= $task['completed'] ? 'line-through' : 'none' ?>"><?= $task['title'] ?> - <?= $task['completed'] ? 'completed' : 'not completed' ?> - <?= $task['author'] ?></li>
        <?php endforeach; ?>
        </ul>
        <?php if (!$found): ?>
            Aucune tâche correspondant aux critères
        <?php endif; ?>
    <?php endif; ?>
    <pre>
    <?php
        print_r($_REQUEST);
    print_r($_SERVER);
    ?>
    </pre>
</body>
</html>