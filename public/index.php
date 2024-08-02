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
        <title>Spotify Auth</title>
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    </head>
    <body class="flex items-center justify-center h-screen bg-gray-900">
        <div class="text-center">
            <h1 class="text-white text-4xl mb-4">Login with Spotify</h1>
            <a href="<?= $authUrl ?>" class="bg-green-500 text-white px-4 py-2 rounded">Login</a>
        </div>
    </body>
</html>