<?php
if(!file_exists('sqlite/')) {
    mkdir('sqlite', 0755, true);
}

if(!file_exists('sqlite/db.sqlite')) {
    $db = new SQLite3('sqlite/db.sqlite');
    $db->enableExceptions(true);

    $db->query('CREATE TABLE IF NOT EXISTS "visits" (
        "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        "user_id" INTEGER,
        "url" VARCHAR,
        "time" DATETIME
    )');

    $db->query('CREATE TABLE IF NOT EXISTS "art_posts" (
        "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        "file_name" VARCHAR(255),
        "file_hash" VARCHAR,
        "title" VARCHAR(255),
        "upload_date" DATETIME,
        "creation_date" DATE,
        "description" TEXT,
        "hidden" INTEGER DEFAULT 0,
        "nsfw" INTEGER DEFAULT 0
    )');
}
?>