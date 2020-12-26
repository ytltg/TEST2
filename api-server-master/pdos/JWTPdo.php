<?php

function isValidUser($ID, $pwd){
    $pdo = pdoSqlConnect();
    $query = "SELECT email, password as hash FROM User WHERE email= ?;";
    echo("2");

    $st = $pdo->prepare($query);
    echo("3");
    $st->execute([$ID]);
    echo("4");
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st=null;$pdo = null;
    echo("5");
    return password_verify($pwd, $res[0]['hash']);

}
function getUserIdxByID($ID)
{
    $pdo = pdoSqlConnect();
    $query = "SELECT ID FROM User WHERE email = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$ID]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['ID'];
}