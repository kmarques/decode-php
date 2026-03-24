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
            'bool' => $value ? 'true' : 'false',
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOL) ? 'true' : 'false',
            default => $value
        };
        return "{$key} = :{$key}";
    }, $filters, array_keys($filters));
    $newData = implode(" AND ", $newData);
    //[
    //    "toto" => "titi",
    //    "tata" => "tutu"
    //] <=>
    //[
    //    "toto = :toto",
    //    "tata = :tata"
    //] <=>
    //  "toto = :toto AND tata = :tata"

    $where = strlen($newData) > 0 ? " WHERE {$newData}" : "";
    $sql = "SELECT tasks.*, user_account.username author FROM tasks INNER JOIN user_account on authorid = user_account.id {$where}";
    // SELECT tasks.*, user_account.username author FROM tasks INNER JOIN user_account on authorid = user_account.id WHERE toto = :toto AND tata = :tata
    $stmt = $db->prepare($sql);
    $stmt->execute($filters);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTask($id)
{
    global $db;
    $sql = "SELECT tasks.*, user_account.username author FROM tasks INNER JOIN user_account on authorid = user_account.id WHERE tasks.id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function deleteTask($id)
{
    global $db;
    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam('id', $id);
    $stmt->execute();
    return $stmt->fetch() !== false;
}

function updateTask($id, $data)
{
    global $db;
    // marque=val1, model=val2, engine=val3
    $newData = array_map(function ($value, $key) {
        $value = match (gettype($value)) {
            'bool' => $value ? 'true' : 'false',
            'boolean' => $value ? 'true' : 'false',
            default => $value
        };
        return "{$key}=:{$key}";
    }, $data, array_keys($data));
    $newData = implode(", ", $newData);

    $sql = "UPDATE tasks SET {$newData} WHERE id = :id";
    // UPDATE tasks SET marque=:marque, model=:model, engine=:engine WHERE id = :id
    $stmt = $db->prepare($sql);

    $stmt->bindParam('id', $id);
    $stmt->execute($data);
    return $stmt->fetch() !== false ? getTask($id) : false;
}

// ["toto" => "titi", "tata" => "tutu"]
function createTask($data)
{
    global $db;
    sanitizeData($data);
    $keys = implode(', ', array_keys($data));
    $newData = array_map(function ($value, $key) {
        $value = match (gettype($value)) {
            'bool' => $value ? 'true' : 'false',
            'boolean' => $value ? 'true' : 'false',
            default => $value
        };
        return ":{$key}";
    }, $data, array_keys($data));
    $implodedValues = implode(', ', $newData);
    // ":toto, :tata"


    $sql = "INSERT INTO tasks ({$keys}) VALUES ({$implodedValues})";
    // INSERT INTO tasks (toto, tata) VALUES (:toto, :tata)
    $stmt = $db->prepare($sql);
    $stmt->execute($data);
    if ($stmt->fetch() === false) {
        throw new \RuntimeException('Failed to insert');
    }
}
