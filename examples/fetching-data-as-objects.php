<?php
require '../cms/includes/database-connection.php';
require '../cms/includes/functions.php';

$sql = "select id, forename, surname, email, joined from member;"; //SQL Query
$statement = $pdo->query($sql);                     // execute
$statement->setFetchMode(PDO::FETCH_OBJ);           // Fetch Mode
$members = $statement->fetchAll();




?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Fetching data as objects</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
  </head>
  <body>

    <?php foreach($members as $member){ ?>

      <p>
        <?= html_escape($member->forename)?>
        <?= html_escape($member->surname) ?><br>
        <?= html_escape($member->email)?><br>
        <?= html_escape($member->joined) ?><br>
      </p>

    <?php } ?>
  </body>
</html>