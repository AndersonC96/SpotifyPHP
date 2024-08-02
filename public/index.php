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
        <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/7/75/Spotify_icon.png"/>
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body{
                font-family: 'Montserrat', sans-serif;
                background: linear-gradient(135deg, #1db954, #191414);
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .login-container{
                background: rgba(255, 255, 255, 0.7);
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 400px;
                width: 100%;
            }
            .login-button{
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #1db954;
                color: white;
                padding: 10px;
                border-radius: 50px;
                text-decoration: none;
                font-weight: bold;
                transition: background-color 0.3s;
            }
            .login-button:hover{
                background-color: #1aa34a;
            }
            .login-button img{
                margin-right: 10px;
                filter: brightness(0) invert(1);
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <a href="<?= $authUrl ?>" class="login-button">
                <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg" alt="Spotify Logo" width="20">Entrar com o Spotify
            </a>
        </div>
    </body>
</html>