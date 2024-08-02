<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    session_start();
    if(isset($_GET['logout'])){
        session_destroy();
        header('Location: index.php');
        exit();
    }
    $authUrl = SpotifyAuth::getAuthUrl();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Spotify Auth</title>
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
        <style>
            body{
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background: linear-gradient(135deg, #1db954, #191414);
                color: white;
            }
            .login-container{
                text-align: center;
            }
            .login-button, .logout-button{
                display: inline-block;
                background-color: #1db954;
                color: white;
                padding: 10px 20px;
                border-radius: 50px;
                text-decoration: none;
                font-weight: bold;
                transition: background-color 0.3s;
                margin-top: 20px;
            }
            .login-button:hover, .logout-button:hover{
                background-color: #1aa34a;
            }
            .logout-button{
                background-color: #ff4b5c;
            }
            .logout-button:hover{
                background-color: #e04353;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h1 class="text-3xl font-bold mb-4">Spotify Auth</h1>
            <a href="<?= $authUrl ?>" class="login-button">Sign in with Spotify</a>
            <a href="?logout=true" class="logout-button">Clear Session</a>
        </div>
    </body>
</html>