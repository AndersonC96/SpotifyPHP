<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    require '../src/config.php';
    session_start();
    if(isset($_GET['code'])){
        $code = $_GET['code'];
        $token = SpotifyAuth::getAccessToken($code);
        $_SESSION['access_token'] = $token['access_token'];
        header('Location: dashboard.php');
        exit();
    }
?>