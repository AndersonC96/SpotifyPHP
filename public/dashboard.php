<?php
    require '../vendor/autoload.php';
    require '../src/SpotifyAuth.php';
    require '../src/SpotifyAPI.php';
    require '../src/config.php';
    session_start();
    if(!isset($_SESSION['access_token'])){
        header('Location: index.php');
        exit();
    }
    $accessToken = $_SESSION['access_token'];
    $spotify = new SpotifyAPI($accessToken);
    $userData = $spotify->getUserData();
    $playlists = $spotify->getUserPlaylists();
    $recentTracks = $spotify->getRecentlyPlayedTracks();
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
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: flex-start;
                padding: 20px;
                color: white;
            }
            .container{
                display: flex;
                flex-direction: column;
                gap: 20px;
                max-width: 1200px;
                width: 100%;
            }
            .card{
                background: rgba(0, 0, 0, 0.7); /* Translucent black */
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            .playlist, .track{
                background: rgba(255, 255, 255, 0.1);
                padding: 10px;
                border-radius: 5px;
                margin: 10px 0;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .playlist img, .track img{
                border-radius: 5px;
            }
            .play-button{
                background-color: #1db954;
                color: white;
                padding: 5px 10px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                transition: background-color 0.3s;
            }
            .play-button:hover{
                background-color: #1aa34a;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <?php if (isset($userData['images']) && !empty($userData['images'])): ?>
                <img src="<?= htmlspecialchars($userData['images'][0]['url']) ?>" alt="Profile Picture" class="profile-picture" width="100">
                <?php endif; ?>
                <h1 class="text-3xl font-bold mb-4">Bem-vindo, <?= isset($userData['display_name']) ? htmlspecialchars($userData['display_name']) : 'User' ?></h1>
                <p class="mb-2"><strong>E-mail:</strong> <?= isset($userData['email']) ? htmlspecialchars($userData['email']) : 'Not provided' ?></p>
                <p class="mb-4"><strong>País:</strong> <?= isset($userData['country']) ? htmlspecialchars($userData['country']) : 'Not provided' ?></p>
                <a href="logout.php" class="logout-button">Sair</a>
            </div>
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Suas Playlists</h2>
                <?php if (isset($playlists['items']) && is_array($playlists['items'])): ?>
                <?php foreach ($playlists['items'] as $playlist): ?>
                <div class="playlist">
                    <div class="flex items-center">
                        <?php if (isset($playlist['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($playlist['images'][0]['url']) ?>" alt="Playlist Image" width="50">
                        <?php endif; ?>
                        <p class="ml-4"><?= htmlspecialchars($playlist['name']) ?></p>
                    </div>
                    <a href="<?= htmlspecialchars($playlist['external_urls']['spotify']) ?>" target="_blank" class="play-button">Visualizar</a>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Nenhuma playlist encontrada.</p>
                <?php endif; ?>
            </div>
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Nenhuma faixa tocada recentemente encontrada</h2>
                <?php if (isset($recentTracks['items']) && is_array($recentTracks['items'])): ?>
                <?php foreach ($recentTracks['items'] as $item): ?>
                <div class="track">
                    <div class="flex items-center">
                        <?php if (isset($item['track']['album']['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($item['track']['album']['images'][0]['url']) ?>" alt="Track Image" width="50">
                        <?php endif; ?>
                        <p class="ml-4"><?= htmlspecialchars($item['track']['name']) ?> by <?= htmlspecialchars($item['track']['artists'][0]['name']) ?></p>
                    </div>
                    <a href="#" class="play-button" onclick="playTrack('<?= htmlspecialchars($item['track']['uri']) ?>')">Play</a>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Nenhuma faixa tocada recentemente encontrada.</p>
                <?php endif; ?>
            </div>
        </div>
        <script>
            function playTrack(trackUri){
                fetch('play.php',{
                    method: 'POST',
                    headers:{
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ uri: trackUri })
                }).then(response => response.json())
                .then(data =>{
                    if (data.success){
                        alert('Faixa está tocando!');
                    }else{
                        alert('Falha ao reproduzir a faixa.');
                    }
                });
            }
        </script>
    </body>
</html>