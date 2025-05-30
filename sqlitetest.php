<?php

include "sql_init.php";
$db = new SQLite3('sqlite/db.sqlite');
$db->enableExceptions(true);

$statement = $db->prepare('INSERT INTO "visits" ("user_id", "url", "time")
    VALUES (:uid, :url, :time)');
$statement->bindValue(':uid', 1337);
$statement->bindValue(':url', '/test');
$statement->bindValue(':time', date('Y-m-d H:i:s'));
$statement->execute(); // you can reuse the statement with different values


// Fetch today's visits of user #42.
// We'll use a prepared statement again, but with numbered parameters this time:

$statement = $db->prepare('SELECT * FROM "visits" WHERE "user_id" = ? AND "time" >= ?');
$statement->bindValue(1, 42);
$statement->bindValue(2, '2017-01-14');
$result = $statement->execute();

echo("Get the 1st row as an associative array:\n");
print_r($result->fetchArray(SQLITE3_ASSOC));
echo("\n");

echo("Get the next row as a numeric array:\n");
print_r($result->fetchArray(SQLITE3_NUM));
echo("\n");

// If there are no more rows, fetchArray() returns FALSE.

// free the memory, this in NOT done automatically, while your script is running
$result->finalize();


// A useful shorthand for fetching a single row as an associative array.
// The second parameter means we want all the selected columns.
//
// Watch out, this shorthand doesn't support parameter binding, but you can
// escape the strings instead.
// Always put the values in SINGLE quotes! Double quotes are used for table
// and column names (similar to backticks in MySQL).

$query = 'SELECT * FROM "visits" WHERE "url" = \'' .
    SQLite3::escapeString('/test') .
    '\' ORDER BY "id" DESC LIMIT 1';

$lastVisit = $db->querySingle($query, true);

echo("Last visit of '/test':\n");
print_r($lastVisit);
echo("\n");


// Another useful shorthand for retrieving just one value.

$userCount = $db->querySingle('SELECT COUNT(DISTINCT "user_id") FROM "visits"');

echo("User count: $userCount\n");
echo("\n");


// Finally, close the database.
// This is done automatically when the script finishes, though.

$db->close();

?>