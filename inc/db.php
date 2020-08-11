<?php
// $DSN='mysql:host = localhost; dbname=allotment';
// $ConnectingDB = new PDO($DSN,'root','');

?>

<?php
// require_once '../pdoconfig.php';
    $host = 'shareddb-p.hosting.stackcp.net';
    $dbname = 'allotment-31313507cc';
    $username = 'allotment-31313507cc';
    $password = 'allotment@1';

    $ConnectingDB = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

?>