<?php

require_once __DIR__ . '/lib/db.php';

$db->query(<<<SQL
    CREATE TABLE IF NOT EXISTS user_account (
        id SERIAL PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        "password" VARCHAR(255) NOT NULL
    );
SQL);
$db->query(<<<SQL
    CREATE TABLE IF NOT EXISTS tasks (
        id SERIAL PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        authorid BIGINT NOT NULL REFERENCES "user_account"(id),
        completed BOOLEAN NOT NULL DEFAULT false
    );
SQL);

$db->query(<<<SQL
    INSERT INTO user_account (username, "password") values('admin', 'admin123');
SQL);
