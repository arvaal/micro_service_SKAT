<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/MySQLiDB.php');
$db = new MySQLiDB("localhost", "micro_service", "123456", "micro_service");

if (isset($_GET['route']) && $_GET["route"]) {

    $request_file = $_SERVER['DOCUMENT_ROOT'] . '/' . ucfirst($_GET['route']) . '.php';

    if (file_exists($request_file)) {

        require_once($request_file);

        if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_POST['json'])) {
            add($db, $_POST['json']);
        } else {
            get($db);
        }

    }


}

function add($db, $json)
{
    $users = new Users($db);

    $users->addUser($json);

    header("location: /index.php?route=user");
}

function get($db)
{
    $users = new Users($db);

    echo json_encode($users->getAllUsers());
}
?>

<html>
    <body>
    <form action="/index.php?route=users&action=add" method="post">
        <textarea placeholder="Вставте JSON" name="json"></textarea>
        <button type="submit">Сохранить</button>
    </form>
    </body>
</html>
