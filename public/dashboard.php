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
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body{
                font-family: 'Montserrat', sans-serif;
                background: linear-gradient(135deg, #1db954, #191414);
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                color: white;
            }
            .dashboard-container{
                background: rgba(0, 0, 0, 0.7);
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 500px;
                width: 100%;
            }
            .profile-picture{
                border-radius: 50%;
                margin-bottom: 20px;
            }
            .logout-button{
                display: inline-block;
                background-color: #ff4b5c;
                color: white;
                padding: 10px 20px;
                border-radius: 50px;
                text-decoration: none;
                font-weight: bold;
                transition: background-color 0.3s;
            }
            .logout-button:hover{
                background-color: #e04353;
            }
        </style>
    </head>
    <body>
        <div class="dashboard-container">
            <?php if (isset($userData['images']) && !empty($userData['images'])): ?>
            <img src="<?= $userData['images'][0]['url'] ?>" alt="Profile Picture" class="profile-picture" width="100">
            <?php endif; ?>
            <h1 class="text-3xl font-bold mb-4">Bem-vindo, <?= htmlspecialchars($userData['display_name']) ?></h1>
            <p class="mb-2"><strong>E-mail:</strong> <?= htmlspecialchars($userData['email']) ?></p>
            <p class="mb-4"><strong>País:</strong> <?= htmlspecialchars($userData['country']) ?></p>
            <a href="logout.php" class="logout-button">Sair</a>
        </div>
    </body>
</html>