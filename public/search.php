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
    $query = $_GET['query'] ?? '';
    $results = [];
    if($query){
        $results = $spotify->search($query, ['limit' => 50]);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body{
                font-family: 'Montserrat', sans-serif;
                background: #1f2937;
                color: white;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 20px;
            }
            .card{
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                padding: 20px;
                width: 100%;
                max-width: 1000px;
                margin-top: 20px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .track{
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }
            .track img{
                border-radius: 10px;
                width: 50px;
                height: 50px;
            }
            .play-button{
                background: #1db954;
                color: white;
                padding: 10px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .play-button:hover{
                background: #1ed760;
            }
            .play-button svg{
                width: 24px;
                height: 24px;
            }
            .view-more-button{
                background: #1db954;
                color: white;
                padding: 10px 20px;
                border-radius: 25px;
                text-decoration: none;
                transition: background-color 0.3s;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                margin-top: 20px;
            }
            .view-more-button:hover{
                background: #1ed760;
            }
            .center-container{
                display: flex;
                justify-content: center;
            }
        </style>
    </head>
    <body>
        <?php include 'navbar.php'; ?>
        <div class="container mx-auto px-4 py-8 mt-16 center-container">
            <div class="card">
                <h2 class="text-2xl font-bold mb-4">Search Results for "<?= htmlspecialchars($query) ?>"</h2>
                <?php if (!empty($results)): ?>
                <?php if (isset($results['tracks']['items']) && is_array($results['tracks']['items'])): ?>
                <h3 class="text-xl font-bold mb-2">Tracks</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="tracks-container">
                    <?php foreach (array_slice($results['tracks']['items'], 0, 10) as $track): ?>
                    <div class="track bg-gray-900 p-4 rounded-lg shadow-md flex items-center">
                        <?php if (isset($track['album']['images'][0]['url'])): ?>
                        <img src="<?= htmlspecialchars($track['album']['images'][0]['url']) ?>" alt="Track Image">
                        <?php endif; ?>
                        <div class="ml-4 flex flex-col">
                            <p class="font-bold text-lg"><?= htmlspecialchars($track['name']) ?></p>
                            <p class="text-sm text-gray-400"><?= htmlspecialchars($track['artists'][0]['name']) ?></p>
                        </div>
                        <button class="play-button" onclick="playTrack('<?= htmlspecialchars($track['uri']) ?>')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.44 3.694A1 1 0 017 14.06V9.94a1 1 0 011.312-.946l6.44 3.694a1 1 0 010 1.686z" />
                            </svg>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($results['tracks']['items']) > 10): ?>
                <div class="flex justify-center">
                    <button id="view-more-button" class="view-more-button">View More</button>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <?php else: ?>
                <p>No results found.</p>
                <?php endif; ?>
            </div>
        </div>
        <script>
            const tracks = <?= json_encode($results['tracks']['items']) ?>;
            let currentIndex = 10;
            function playTrack(trackUri){
                fetch('play.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ uri: trackUri })
                }).then(response => response.json())
                .then(data => {
                    if(data.success){
                        alert('Track is playing!');
                    }else{
                        alert('Failed to play track.');
                    }
                });
            }
            document.getElementById('view-more-button').addEventListener('click', () => {
                const container = document.getElementById('tracks-container');
                for(let i = currentIndex; i < currentIndex + 10 && i < tracks.length; i++){
                    const track = tracks[i];
                    const trackElement = document.createElement('div');
                    trackElement.classList.add('track', 'bg-gray-900', 'p-4', 'rounded-lg', 'shadow-md', 'flex', 'items-center');
                    trackElement.innerHTML = `
                        ${track.album.images[0] ? `<img src="${track.album.images[0].url}" alt="Track Image" class="w-24 h-24 object-cover rounded-lg">` : ''}
                        <div class="ml-4 flex flex-col">
                        <p class="font-bold text-lg">${track.name}</p>
                        <p class="text-sm text-gray-400">${track.artists[0].name}</p>
                        </div>
                        <button class="play-button" onclick="playTrack('${track.uri}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.44 3.694A1 1 0 017 14.06V9.94a1 1 0 011.312-.946l6.44 3.694a1 1 0 010 1.686z" />
                        </svg>
                        </button>
                    `;
                    container.appendChild(trackElement);
                }
                currentIndex += 10;
                if(currentIndex >= tracks.length){
                    document.getElementById('view-more-button').style.display = 'none';
                }
            });
        </script>
    </body>
</html>