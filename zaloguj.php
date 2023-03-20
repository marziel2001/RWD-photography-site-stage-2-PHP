<?php
session_start();

require "dbconnect.php";
$dbc=get_db();

$nick = $_POST['nick'];
$haslo = $_POST['haslo'];

$ile = $dbc->uzytkownicy->count(['nick'=>$nick]); //sprawdzamy czy znalazlo uzytkownika i nie ma duplikatów

if ($ile==1) {
    
    $user = $dbc->uzytkownicy->findOne(['nick'=>$nick]);
    $passMatches = false;
    $passMatches = password_verify($haslo,$user['haslo']);
    
    if($passMatches) {
        $_SESSION['zalogowany'] = true;
        $_SESSION['nick'] = $user['nick'];	
        $_SESSION['id'] = $user['_id'];
        $_SESSION['message'] = "zalogowano pomyślnie";
        header('Location:index.php');								//przenosi nas do gry
    } else {
       $_SESSION['error'] = "podano niepoprawne hasło";
       header('Location: formularzLogowania.php');
    }
} else {
    $_SESSION['error'] = "nie odnaleziono użytkownika o takim loginie";
    header('Location: formularzLogowania.php');
}
?>