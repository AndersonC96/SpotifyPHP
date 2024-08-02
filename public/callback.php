<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    require '../src/config.php';
    session_start();
    if(isset($_GET['code'])){
        $code = $_GET['code'];
        $token = SpotifyAuth::getAccessToken($code);
        if(isset($token['access_token'])){
            $_SESSION['access_token'] = $token['access_token'];
            header('Location: dashboard.php');
            exit();
        }else{
            echo "Failed to get access token.";
            echo '<pre>';
            print_r($token);
            echo '</pre>';
        }
    }else{
        echo "No code parameter in URL.";
    }
?>