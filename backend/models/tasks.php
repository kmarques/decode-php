<?php

require_once __DIR__ . '/../lib/db.php';

function sanitizeData(&$data)
{
    array_walk($data, function (&$item, $key) {
        switch ($key) {
            case 'completed':
                $item = filter_var($item, FILTER_VALIDATE_BOOL);
                break;
            case 'authorid':
                $item = intval($item);
                break;
        }
    });
}

function getTasks($filters = [])
{
    global $db;
    sanitizeData($filters);
    $newData = array_map(function ($value, $key) {
        $value = match (gettype($value)) {
            'string' => "'{$value}'",
            'bool' => $value ? 'true' : 'false',
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOL) ? 'true' : 'false',
            default => $value
        };
        return "{$key}={$value}";
    }, $filters, array_keys($filters));
    $newData = implode(" AND ", $newData);

    $where = strlen($newData) > 0 ? " WHERE {$newData}" : "";
    $sql = "SELECT tasks.*, user_account.username author FROM tasks INNER JOIN user_account on authorid = user_account.id {$where}";
    var_dump($sql);
    $stmt = $db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTask($id)
{
    global $db;
    $sql = "SELECT tasks.*, user_account.username author FROM tasks INNER JOIN user_account on authorid = user_account.id WHERE tasks.id = {$id}";
    $stmt = $db->query($sql);
    return $stmt->fetch();
}

function deleteTask($id)
{
    global $db;
    $sql = "DELETE FROM tasks WHERE id = {$id}";
    $stmt = $db->query($sql);
    return $stmt->fetch() !== false;
}

function updateTask($id, $data)
{
    global $db;
    // marque=val1, model=val2, engine=val3
    $newData = array_map(function ($value, $key) {
        $value = match (gettype($value)) {
            'string' => "'{$value}'",
            'bool' => $value ? 'true' : 'false',
            'boolean' => $value ? 'true' : 'false',
            default => $value
        };
        return "{$key}={$value}";
    }, $data, array_keys($data));
    $newData = implode(", ", $newData);

    $sql = "UPDATE tasks SET {$newData} WHERE id = {$id}";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch() !== false ? getTask($id) : false;
}

function createTask($data)
{
    global $db;
    sanitizeData($data);
    $keys = implode(', ', array_keys($data));
    $values = implode(', ', array_map(function ($value) {
        return match (gettype($value)) {
            'string' => "'{$value}'",
            'bool' => $value ? 'true' : 'false',
            'boolean' => $value ? 'true' : 'false',
            default => $value
        };
    }, $data));
    $sql = "INSERT INTO tasks ({$keys}) VALUES ({$values})";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    if ($stmt->fetch() === false) {
        throw new \RuntimeException('Failed to insert');
    }
}
