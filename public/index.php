<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    require '../src/config.php';
    session_start();
    $authUrl = SpotifyAuth::getAuthUrl();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Spotify Login</title>
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body{
                font-family: 'Montserrat', sans-serif;
                background: linear-gradient(135deg, #1db954, #191414);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                color: white;
            }
            .login-container{
                text-align: center;
            }
            .login-button{
                display: inline-block;
                background-color: #1db954;
                color: white;
                padding: 15px 30px;
                border-radius: 50px;
                text-decoration: none;
                font-weight: bold;
                transition: background-color 0.3s;
                margin-top: 20px;
            }
            .login-button:hover{
                background-color: #1aa34a;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h1 class="text-3xl font-bold mb-4">Spotify Login</h1>
            <a href="<?= $authUrl ?>" class="login-button">Sign in with Spotify</a>
        </div>
    </body>
</html>