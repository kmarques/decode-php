<?php

session_start();
// hard logout
// session_destroy();

// soft logout
// unset($_SESSION['user']);
// unset($_SESSION['visited']);

header('Location: /home.php');
