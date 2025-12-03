<?php

$tasks = [["id" => "1", "author" => "dupond", "title" => "dormir", "completed" => true], ["id" => "2", "author" => "durand", "title" => "manger", "completed" => true], ["id" => "3", "author" => "durand", "title" => "manger", "completed" => false], ["id" => "4", "author" => "doe", "title" => "manger", "completed" => false]];

function getTasks()
{
    global $tasks;
    return $tasks;
}

function getTask($id)
{
    $task = null;
    foreach (getTasks() as $item) {
        if ($item['id'] === $id) {
            $task = $item;
            break;
        }
    }
    return $task;
}

function deleteTask($id)
{
    global $tasks;
    foreach ($tasks as $index => $item) {
        if ($item['id'] === $id) {
            $found = true;
            break;
        }
    }
    if (($found ?? false) !== false) {
        unset($tasks[$index]);
        return true;
    } else {
        return false;
    }
}

function updateTask($id, $data)
{
    global $tasks;
    foreach ($tasks as $index => $item) {
        if ($item['id'] === $id) {
            $tasks[$index] = $data;
            return $tasks[$index];
        }
    }
    return null;
}
