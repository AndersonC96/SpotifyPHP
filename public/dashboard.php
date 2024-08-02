<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    require '../src/config.php';
    session_start();
    if(!isset($_SESSION['access_token'])){
        header('Location: index.php');
        exit();
    }
    $accessToken = $_SESSION['access_token'];
    function getUserData($accessToken){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/me");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken"
        ]);
        $result = curl_exec($ch);
        if(curl_errno($ch)){
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result, true);
    }
    $userData = getUserData($accessToken);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Spotify Dashboard</title>
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    </head>
    <body class="bg-gray-900 text-white">
        <div class="container mx-auto p-4">
            <h1 class="text-4xl mb-4">Welcome, <?= htmlspecialchars($userData['display_name']) ?></h1>
            <p>Email: <?= htmlspecialchars($userData['email']) ?></p>
            <p>Country: <?= htmlspecialchars($userData['country']) ?></p>
        </div>
    </body>
</html>