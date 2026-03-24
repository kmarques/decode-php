<?php

$_ENV['DSN'] = 'pgsql:host=database;port=5432;dbname=app;';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASSWORD'] = 'password';

function getTasksController()
{
    // Model
    require_once './backend/models/tasks.php';

    // Controller
    if (($_GET['completed'] ?? '') === "all") {
        unset($_GET['completed']);
    }
    $tasks = getTasks(array_filter($_GET, function ($value) {
        return $value !== '';
    }));
    $_GET["completed"] ??= "all";
    $_GET["author"] ??= "";


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
    require './backend/views/tasks.html.php';
}

$path = $_SERVER['REQUEST_URI'];
var_dump($path);
$realPath = strtok($path, '?');
var_dump($realPath);

switch (true) {
    case preg_match("#/tasks/(?<id>\d+)#", $realPath, $matches):
        $matches['id'] = intval($matches['id']);
        getTaskController($matches['id']);
        break;
    case preg_match("#/tasks/(?<id>\d+)/comments/(?<comment_id>\d+)#", $realPath, $matches):
        $matches['id'] = intval($matches['id']);
        $matches['comment_id'] = intval($matches['comment_id']);
        deleteCommentController($matches['id'], $matches['comment_id']);
        break;
    case $realPath === '/tasks':
        getTasksController();
        break;
    case 
}
