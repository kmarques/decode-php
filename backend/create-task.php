<?php
// Model
require_once __DIR__.'/models/tasks.php';

$tasks = [["id" => "1", "author" => "dupond", "title" => "dormir", "completed" => true], ["id" => "2", "author" => "durand", "title" => "manger", "completed" => true], ["id" => "3", "author" => "durand", "title" => "manger", "completed" => false], ["id" => "4", "author" => "doe", "title" => "manger", "completed" => false]];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        createTask($_POST);
        http_response_code(302);
        header('Location: /tasks.php');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
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
<h3>Add task</h3>
<form method="POST">
    <span>Titre</span><input name="title"/>
    <span>Completed ?</span>
    <label>Not Completed <input name="completed" type="radio" value="false" /></label>
    <label>Completed <input name="completed" type="radio" value="true" /></label>
    <br/>
    <span>Author</span>
    <input name="authorid" type="number"/>
    <br/>
    <input type="submit" value="Create"/>
</form>
<?php if (isset($error)) : ?>
    <span style="color: red;"><?= $error ?></span>
<?php endif; ?>
</body>
</html>